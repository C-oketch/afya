<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Hash;
use Carbon\Carbon;

//200 - success
//201 - email dne
//202 - password wrong

class MDoctorsController extends Controller
{

    public function doctorinfo(Request $request) {

      $mail = $request->input("email");
      $password = $request->input("password");

        $data = array();

        $docdata=DB::table('users')->where([['email',$mail]])->first();
        
        if($docdata == null) {
            $data = array(
                'status' => 201,
                'message' => 'User does not exist');
        }else {
            $hashed = $docdata->password;
            $userId = $docdata->id;
            if(Hash::check($password,$hashed)) {
                if($docdata->role == 'Doctor') {
                    $docdetails=DB::table('users')
//                    ->join('facility_doctor','users.id','=','facility_doctor.user_id')
                    ->join('doctors','users.id','=','doctors.user_id')
                    ->select('doctors.id','users.email', 'doctors.name','doctors.regdate','doctors.regno', 'doctors.address'
                    ,'doctors.qualifications', 'doctors.speciality', 'doctors.subspeciality')
                    ->where('users.id',$userId)
                    ->first();

                    $data = array(
                    'status' => 200,
                    'message' => 'Successfully Authenticated',
                    'id' => $docdetails->id,
                    'name' => $docdetails->name,
                    'email' => $docdetails->email,
                    'password' => $hashed,
                    'regno' => $docdetails->regno,
                    'address' => $docdetails->address,
                    'regdate' => $docdetails->regdate,
                    'qualifications' => $docdetails->qualifications,
                    'speciality' => $docdetails->speciality,
                    'subspeciality' => $docdetails->subspeciality,
                    );
                }else {
                    $data = array(
                        'status' => 203,
                        'message' => 'User role does not match'
                    );
                }
            }else {
                $data = array(
                    'status' => 202,
                    'message' => 'Wrong password'
                );
            }
        }
    return json_encode($data);

}

public function todayPatient(Request $request)
{
  $id = $request->input("doctor");
$today = Carbon::today();
$data = array();
$afyaUsers=DB::table('appointments')
 ->join('afya_users','appointments.afya_user_id','=','afya_users.id')
 ->select('appointments.id as appid','afya_users.id as afyaId','afya_users.firstname','afya_users.secondName','afya_users.gender','afya_users.dob', 'afya_users.created_at')
  ->where([['appointments.doc_id',$id],
           ['appointments.persontreated','Self'],
           ['appointments.status','=',1],

         ])

        //  ->where([['appointments.doc_id',$id],
        //           ['appointments.created_at','>=',$today],
        //           ['appointments.persontreated','Self'],
        //           ['appointments.status','=',3],
        //         ])
  ->get();

  foreach ($afyaUsers as $user) {
    $gender;
    if($user->gender == 1) {
      $gender = "Male";
    }else if($user->gender == 2) {
      $gender = "Female";
    }
    // $now = new DateTime(new Date("Y-m-d"));
    // $dob = new DateTime();
    $dateString = $user->dob;
    $age = "Not set";
    if($dateString != null) {
      $age = round((time()-strtotime($dateString))/(3600*24*365.25));
    }

    // $age = $dob->diff($now);

    array_push($data, array(
      'id' => $user->afyaId,
      'gender' => $gender,
      'name' => $user->firstname . ' ' . $user->secondName,
      'age' => $age,
      'date' => $user->created_at
    ));
  }

// $data['afyaUser'] = $afyaUser;
// $dependant=DB::table('appointments')
// ->join('dependant','appointments.persontreated','=','dependant.id')
// ->select('appointments.id as appid','dependant.id as depid','dependant.firstName','dependant.secondName','dependant.gender','dependant.dob')
// ->where([['appointments.doc_id',$id],
// ])
// ->where([['appointments.doc_id',$id],
//          ['appointments.created_at','>=',$today],
//          ['appointments.status','=',3],
//        ])

//
// ->get();
//
// $data['dependant'] = $dependant;

return json_encode($data);
}

public function getPatient($id)
{


$details=DB::table('appointments')
->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
->leftjoin('dependant','appointments.persontreated','=','dependant.id')
->select('appointments.id as appid','appointments.persontreated','afya_users.id as afyaId','afya_users.firstname','afya_users.secondName','afya_users.gender','afya_users.dob',
'dependant.id as depId','dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender','dependant.dob as depdob',
'appointments.created_at','appointments.time_patient_seen')
->where('appointments.id',$id)
->first();

if($details->persontreated=='Self'){

    $name=$details->firstname. ' ' .$details->secondName;
    $gender=$details->gender == 1 ? "Male" : "Female";
    $dob=$details->dob;
    $interval = date_diff(date_create(), date_create($dob));
    $age= $interval->format(" %Y Year, %M Months, %d Days Old");
  }else{
    $name=$details->dep1name. ' ' .$details->dep2name;
    $gender=$details->depgender == 1 ? "Male" : "Female";
    $dob=$details->depdob;
    $interval = date_diff(date_create(), date_create($dob));
    $age= $interval->format(" %Y Year, %M Months, %d Days Old");
  }
  $interval2 = date_diff(date_create($details->time_patient_seen), date_create($details->created_at));
  $diff= $interval2->format('%h')." Hours ".$interval->format('%i')." Minutes";

$data;
  $bio = array(
      'name' => $name,
      'gender' => $gender,
      'age' => $age,
      'waitingTime' =>$diff,
    );
$data['bio'] = $bio;

return json_encode($data);
}

public function messages($id)
{
// $self_report_id = 2;
$dmsgs=DB::table('msgs_by_patient')
->select('msg')
->where('self_report_id',$id)
->first();

return json_encode($dmsgs);
}

public function getFee(Request $request) {

  $doctorId = $request->input("doctor");
  // Doctor's fee -> after a visit by a patient
  //format
  // [{'type' : 'type', 'amount': 12}]
  $Docfee=DB::table('appointments')
  ->join('payments','appointments.id','=','payments.appointment_id')
  ->join('payments_categories','payments.payments_category_id','=','payments_categories.id')
  ->select('payments_categories.category_name','payments.amount', 'payments.created_at')
  ->where('appointments.doc_id', $doctorId)
  ->get();
return json_encode($Docfee);

}
public function getVisits(Request $request) {

  $patient = $request->input("patient");
  $doctor = $request->input("doctor");
  //Single patient visits
  //format
  // [{'arrival_time' : '12:00', 'depart_time' : '12:00', 'average' : '120'}]
  //average wait time is in terms of minutes
  $data = array();
  $details=DB::table('appointments')
  ->join('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->where('appointments.afya_user_id', $patient)
  ->where('appointments.doc_id', $doctor)
  ->select('appointments.created_at','appointments.updated_at')
  ->get();

  foreach ($details as $detail) {
    $arrival_time=$detail->created_at;
    $depart_time=$detail->updated_at;
    $interval2 = date_diff(date_create($detail->updated_at), date_create($detail->created_at));
    $diff= $interval2->format('%h')." Hours ".$interval2->format('%i')." Minutes";
    array_push($data,  array(
        'arrival_time' => $arrival_time,
        'depart_time' => $depart_time,
        'waiting_time' =>$diff
    ));
  }

  return json_encode($data);

}
public function getReport(Request $request) {
  $doctor = $request->input("doctor");
  $patient = $request->input("patient");

  $reports=DB::table('self_report')
  ->select('temperature','weight','bp','fasting_sugars', 'before_meal_sugars', 'postprondrial_sugars', 'created_at as date')
  ->where([['afyauser_id',$patient],['doc_id',$doctor],])
  ->orderby("created_at", "desc")
  ->take(2)
  ->get();
  $data = array();
  $prevReport = null;
  $currentReport = null;

  if(count($reports) == 2) {
    $prevReport = $reports[1];
    $currentReport = $reports[0];
    $data = $this->processReports($prevReport, $currentReport);
  }else if($reports == 1) {
    $currentReport = $reports[0];
    $data = $this->processReports(null, $currentReport);
  }

  return json_encode($data);
}

public function processReports($prevReport = null, $currentReport) {
  $data = array();
  $record = array();
  if($prevReport == null) {
    $record['name'] = 'Temperature';
    $record['value'] = $currentReport->temperature;
    $record['prevValue'] = "0";
    $record['status'] = 2;
    array_push($data, $record);
    $record['name'] = 'Weight';
    $record['value'] = $currentReport->weight;
    $record['prevValue'] = "0";
    $record['status'] = 2;
    array_push($data, $record);
    $record['name'] = 'BP';
    $record['value'] = $currentReport->bp;
    $record['prevValue'] = "0";
    $record['status'] = 2;
    array_push($data, $record);
    $record['name'] = 'Fasting Sugars';
    $record['value'] = $currentReport->fasting_sugars;
    $record['prevValue'] = "0";
    $record['status'] = 2;
    array_push($data, $record);
    $record['name'] = 'Before Meal Sugars';
    $record['value'] = $currentReport->before_meal_sugars;
    $record['prevValue'] = "0";
    $record['status'] = 2;
    array_push($data, $record);
    $record['name'] = 'Postprandial Sugars';
    $record['value'] = $currentReport->postprondrial_sugars;
    $record['prevValue'] = "0";
    $record['status'] = 2;
    array_push($data, $record);
  }else {
    $record['name'] = 'Temperature';
    $record['value'] = $currentReport->temperature;
    $record['prevValue'] = $prevReport->temperature;
    $record['status'] = $this->getVitalStatus($currentReport->temperature, $prevReport->temperature);
    array_push($data, $record);
    $record['name'] = 'Weight';
    $record['value'] = $currentReport->weight;
    $record['prevValue'] = $prevReport->weight;
    $record['status'] = $this->getVitalStatus($currentReport->weight, $prevReport->weight);
    array_push($data, $record);
    $record['name'] = 'BP';
    $record['value'] = $currentReport->bp;
    $record['prevValue'] = $prevReport->bp;
    $record['status'] = $this->getVitalStatus($currentReport->bp, $prevReport->bp);
    array_push($data, $record);
    $record['name'] = 'Fasting Sugars';
    $record['value'] = $currentReport->fasting_sugars;
    $record['prevValue'] = $prevReport->fasting_sugars;
    $record['status'] = $this->getVitalStatus($currentReport->fasting_sugars, $prevReport->fasting_sugars);
    array_push($data, $record);
    $record['name'] = 'Before Meal';
    $record['value'] = $currentReport->before_meal_sugars;
    $record['prevValue'] = $prevReport->before_meal_sugars;
    $record['status'] = $this->getVitalStatus($currentReport->before_meal_sugars, $prevReport->before_meal_sugars);
    array_push($data, $record);
    $record['name'] = 'Postprandial Sugars';
    $record['value'] = $currentReport->postprondrial_sugars;
    $record['prevValue'] = $prevReport->postprondrial_sugars;
    $record['status'] = $this->getVitalStatus($currentReport->postprondrial_sugars, $prevReport->postprondrial_sugars);
    array_push($data, $record);
  }

  return $data;

}

public function getVitalStatus($value1, $value2) {
  $data = 2;
  if($value1 > $value2) {
    $data = 1;
  }else if($value1 < $value2) {
    $data = 0;
  }else {
    $data = 2;
  }
  return $data;
}


public function updateDoctor(Request $request) {
  $data = $request->input("doctor");
  $doc = json_decode($data);


  //keys -> name, regdate, regno, address, speciality, subspeciality
  ///// I have excluded qualifications.
  $id = $doc->id;
  $name = $doc->name;
  $email = $doc->email;
  $qualifications = $doc->qualifications;
  $address = $doc->address;
  $speciality = $doc->speciality;
  $subspeciality = $doc->subspeciality;

  $details = array(
      'name' =>$name,
      'address' =>$address,
      'speciality' =>$speciality,
      'qualifications' =>$qualifications,
      'subspeciality' =>$subspeciality,
  );

  DB::table('doctors')->where('id', $id)
  ->update($details);
  DB::table('users')->where('id', $id)
  ->update(['email'=>$email]);

}


public function getMessages() {
  //Eddie - I will implement this
}

public function getAppointments(Request $request) {
  $doctor = $request->input("doctor");
  $data = array();
  $appointments = DB::table("appointments")->where("doc_id", $doctor)->orderby("created_at", "desc")->get();

  foreach ($appointments as $appointment) {
    $patient = DB::table("afya_users")->where("id", $appointment->afya_user_id)->first();
    array_push($data, array(
      'time' => $appointment->appointment_date,
      'patient' => $patient->firstname . ' ' . $patient->secondName
    ));
  }

    return json_encode($data);

}

public function makeAppointment(Request $request) {
  $doctor =  $request->input("doctor");
  $patient =  $request->input("patient");
  $date =  $request->input("date");

  DB::table("appointments")->insert(
      [
        'appointment_date' => $date,
        'afya_user_id' => $patient,
        'doc_id' => $doctor
      ]
  );

}








}
