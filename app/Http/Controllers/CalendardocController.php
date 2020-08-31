<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Appointment;
use App\Facility;
use App\Facility_doctor;
use App\Afya_user;
use Auth;
use Session;
use DB;

class CalendardocController extends Controller
{

  public function load($id)
  {

     $data['user']=Afya_user::find($id);

     $data['appointments']=DB::table('appointments')
     ->leftjoin('appointment_notes','appointment_notes.appointment_id','=','appointments.id')
     ->select('appointments.*','appointment_notes.id as note_id','appointment_notes.notes')
     ->where('appointments.status','=',0)
    ->where('facility_id','=',Controller::doctor_reg_facility()->FacilityCode)
     ->get();

      $data['appointment']=DB::table('appointments')->where('appointments.status','!=',0)
      ->where('afya_user_id','=',$id)->orderBy('id', 'DESC')->first();


     $data['facility'] = Controller::doctor_reg_facility();
     $data['doctors']=Facility_doctor::select('doctors.*')
        ->where('facilitycode','=',Controller::doctor_reg_facility()->FacilityCode)
        ->join('doctors','doctors.id','=','facility_doctor.doctor_id')
        ->get();

     return view('appointments.calendar2',$data);
  }

  public function store(Request $request)
  {


  $app_id = DB::table('appointments')->insertGetId([
    'afya_user_id'=>$request->afya_user_id,
    'persontreated'=>'Self',
    'appointment_date'=>$request->appointment_date,
    'appointment_time'=>$request->appointment_time,
    'doc_id'=>$request->doc_id,
    'facility_id'=>Controller::doctor_reg_facility()->FacilityCode,
    'created_by_users_id'=>Auth::user()->id
  ]);

  if($request->app_note){
  DB::table('appointment_notes')->insert([
  'appointment_id' =>$app_id,
  'notes' => $request->app_note,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
  }
       if($request->email!=null){
       $subject="Appointment";
      $msg="Your appointment with ".Controller::doctor($request->doc_id)->name." for ".date('d M Y',strtotime($request->appointment_date)). " at ".$request->appointment_time." has been booked. Please avail yourself.
      Thank you!";



      $to=$request->email;
      $from='info@afyapepe.com';
      $from_name="AFyapepe";

      Controller::send_mail($from,$from_name,$to,$subject,$msg);
      }
      // return redirect('calendar');
      return redirect()->action('CalendarController@show',['id'=> $request->afya_user_id]);

  }

  public function update(Request $request,$id)
  {
     $afya_user_id=$request->afya_user_id;
     $note_id=$request->appointment_note_id;
     $doc_not=$request->doc_notes;
$user=DB::table('appointments')->select('afya_user_id')->where('id','=',$id)->first();
$afya_user_id =$user->afya_user_id;

  $appointment=Appointment::find($id);
  $appointment->delete();

DB::table('appointment_notes')->where('appointment_id', $id)->delete();

      $appointment=Appointment::find($id);
      $appointment->update([ 'appointment_date'=>$request->appointment_date,
      'appointment_time'=>$request->appointment_time,
       'doc_id'=>$request->doc_id,
       'created_by_users_id'=>Auth::user()->id]);


  DB::table('appointment_notes')->where('id',$note_id)->update(
      ['notes' => $doc_not,
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
     );
      // return redirect('calendar');
      return redirect()->action('CalendarController@show',['id'=> $afya_user_id]);

  }

    public function destroy($id)
    {
$user=DB::table('appointments')->select('afya_user_id')->where('id','=',$id)->first();


  $appointment=Appointment::find($id);
  $appointment->delete();

DB::table('appointment_notes')->where('appointment_id', $id)->delete();

return redirect()->action('CalendardocController@load',['id'=>$id]);

        // return redirect('calendar');
    }
}
