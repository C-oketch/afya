<?php
namespace App\Http\Controllers;

use DB;

define("GOOGLE_API_KEY", "AAAAUs4K5BM:APA91bGpMq9ljzkD67jcZ12x9shRZnm5gVRzFJC9cNBBmfrIZwA_62J3VMlpMVQB5b3h8Vpa6mNnDyJX3bk_W5IBRfzoA41wzheCxHbqmSRjiRsyLwEYzAu69KLyCAM0syxgn5uW47HK");

use Illuminate\Http\Request;

class AfyaMobileMessaging extends Controller {

  public function getUsers(Request $request) {
    $user = $request->input("user");
    $chatRoom;
    if(!DB::table("chat_rooms")->where("user_id", $user)->exists()) {
      DB::table("chat_rooms")->insert(["user_id" => $user]);
    }

    $room = DB::table("chat_rooms")->where("user_id", $user)->first();
    $chatRoom = $room->room_id;

    $results = array();
    $appointments = DB::table("appointments")->where("afya_user_id", $user)->groupby("doc_id")->get();
    if(count($appointments) > 0) {
      foreach ($appointments as $appointment) {
          $doctor = DB::table("doctors")->where("doctors.id", $appointment->doc_id)
              ->first();
          if($doctor) {
            $message = "";
            $time = "";
            $d = array(
              "user_id" => $appointment->doc_id,
              'chat_room_id'=> $chatRoom,
              'is_read' => 1
            );
            $messageCount = DB::table("chat_messages")->where($d)->count();
            $room = 0;
            if(DB::table("chat_rooms")->where("user_id", $appointment->doc_id)->exists()) {
              $room = DB::table("chat_rooms")->where("user_id", $appointment->doc_id)->first()->room_id;
            }
            if($messageCount > 0) {
              $lastMessage = DB::table("chat_messages")->where("user_id", $appointment->doc_id)->orderby("created_at", "desc")->first();
              $time = $lastMessage->created_at;
              $message = $lastMessage->message;
            }
            $data = array(
              'id' => $doctor->id,
              'sender' => $doctor->name,
              'room' => $room,
              'message' => $message,
              'time' => $time,
              'lastSeen' => "12:00",
              'counter' => 0,
              'messageCount' => $messageCount
            );

            array_push($results, $data);
          }
      }
    }

    return json_encode($results);

  }

  public function canChat(Request $request) {
    $user = $request->input("user");
    if(DB::table("chat_rooms")->where("user_id", $user)->exists()) {
      return json_encode(true);
    }else {
      return json_encode(false);
    }
  }

  public function registerUser(Request $request) {
    $token = $request->input("token");
    $user = $request->input("user");
    $type = $request->input("type");

    $data = array(
      'user_id' => $user,
      'gcm_token' => $token
    );

    $existingUser = DB::table("chat_users")->where('user_id', $user)->first();

    if($existingUser) {
      DB::table("chat_users")->where('user_id', $user)->update(['gcm_token' => $token]);
    }else {
      $roomUser = array(
        'user_id' => $user,
         'type' => $type
      );
      DB::table("chat_rooms")->insert($roomUser);
      DB::table("chat_users")->insert($data);
    }

    //add user to chat_users - user id, token, chat_room
    return json_encode($token);
  }

  public function getPreviousChat(Request $request) {
    $user = $request->input("user");
    $receiver = $request->input("receiver");

    $userChatRoomId = 0;
    $receiverChatRoomId = 0;

    $userChatRoom = DB::table("chat_rooms")->where("user_id", $user)->first();
    $receiverChatRoom = DB::table("chat_rooms")->where("user_id", $receiver)->first();

    if($userChatRoom) {
      $userChatRoomId = $userChatRoom->room_id;
    }
    if($receiverChatRoom) {
      $receiverChatRoomId = $receiverChatRoom->room_id;
    }

    $userData = array(
      'user_id' => $user,
      'chat_room_id' => $receiverChatRoomId
    );

    $receiverData = array(
      'user_id' => $receiver,
      'chat_room_id' => $userChatRoomId
    );

    $data = array();
    DB::table("chat_messages")->where($receiverData)->update(['is_read' => 2]);
    $messages = DB::table("chat_messages")->where($userData)->orWhere($receiverData)->where("message", "!=", null)
      ->orderby("created_at", "asc")->get();

      foreach ($messages as $message) {
        array_push($data, array(
          'recipient' => $message->to_id,
          'sender' => $message->user_id,
          'message' => $message->message,
          'time' => $message->created_at,
          'status' => $message->is_read
        ));
      }

    return json_encode($data);
  }

  public function sendMessage(Request $request) {
    // 1 - doc
    // 2 - patient
    $user = $request->input("user");
    $message = $request->input("message");
    $type = $request->input("type");
    $rec = $request->input("rec");
    $url = 'https://fcm.googleapis.com/fcm/send';
    //get recipient token
    // $recChatRoom = 12;

    $chatRoomId = DB::table("chat_rooms")->where('user_id', $rec)->first()->room_id;
    $recToken = DB::table("chat_users")->where('user_id', $rec)->first()->gcm_token;
    $senderRoom = DB::table("chat_rooms")->where('user_id', $user)->first();
    if($senderRoom == null) {
      $roomUser = array(
        'user_id' => $user,
         'type'=>$type
      );
      DB::table("chat_rooms")->insert($roomUser);
      $senderRoom = DB::table("chat_rooms")->where('user_id', $user)->first();
    }
    $senderRoomId = $senderRoom->room_id;

    $userDet = array();
    $userName = "";

    if($type == 1) {
      $userDet = DB::table("doctors")->where('id', $user)->first();
      $userName = $userDet->name;
    }else if($type == 2) {
      $userDet = DB::table("afya_users")->where('id', $user)->first();
      $userName = $userDet->firstname . ' ' . $userDet->secondName;
    }

    $data = array(
      'user_id' => $user,
      'chat_room_id' => $chatRoomId,
      'to_id' => $rec,
      'message' => $message
    );

    DB::table("chat_messages")->insert($data);
    $createdAt = DB::table("chat_messages")->where($data)->orderby("created_at", 'desc')->first()->created_at;
    DB::table("chat_messages")->where(['user_id' => $user, 'chat_room_id' => $chatRoomId])->orderby("created_at", 'desc')->take(1)->update(['is_read' => 1]);

    $fields = array(
            'registration_ids' => array($recToken),
            'data' => array(
              'message' => $message,
              'sender' => $user,
              'receiver' => $rec,
              'room' => $chatRoomId,
              'time' => $createdAt
            )
    );

    $headers = array(
        'Authorization: key=' . GOOGLE_API_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }

    curl_close($ch);

    return json_encode(true);

  }


}


?>
