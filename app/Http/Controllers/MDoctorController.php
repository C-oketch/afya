<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Hash;
use Carbon\Carbon;

class MDoctorsController extends Controller
{

    public function doctorinfo(Request $request)
    {

      $mail = $request->input("email");
      $password = $request->input("password");

$data = array();

$docdata=DB::table('users')
      ->where([['email',$mail]])
       ->first();
  $hashed = $docdata->password;
  $userId = $docdata->id;

  if(Hash::check($password,$hashed))
  {
    $docdetails=DB::table('users')
    ->join('facility_doctor','users.id','=','facility_doctor.user_id')
    ->join('doctors','facility_doctor.doctor_id','=','doctors.id')
    ->select('doctors.id','users.email', 'doctors.name','doctors.regdate','doctors.regno', 'doctors.address'
    ,'doctors.qualifications', 'doctors.speciality', 'doctors.subspeciality')
    ->where('users.id',$userId)
    ->first();

    $data = array(
      'status' => true,
      'id' => $docdetails->id,
      'name' => $docdetails->name,
      'email' => $docdetails->email,
      'regno' => $docdetails->regno,
      'address' => $docdetails->address,
      'regdate' => $docdetails->regdate,
      'qualifications' => $docdetails->qualifications,
      'speciality' => $docdetails->speciality,
      'subspeciality' => $docdetails->subspeciality,
  );
}else {
$data = array(
        'status' => false,
  );
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
  $doctor = 2590;
  $patient = 1;
  //self report for a specific patient
  // [{'temp', 'weight', 'bp', 'fasting_sugars', 'bm_sugars', 'post_prondial'}]
  $selfrprt=DB::table('self_report')
  ->select('temperature','weight','bp','fasting_sugars', 'before_meal_sugars', 'postprondrial_sugars')
  ->where([['afyauser_id',$patient],['doc_id',$doctor],])
  ->first();

return json_encode($selfrprt);
}


public function updateDoctor() {
  // $data = $request->input();
  //keys -> name, regdate, regno, address, speciality, subspeciality
  ///// I have excluded qualifications.
$id=$request->id;
$name=$request->name;
$regdate=$request->regdate;
$regno=$request->regno;
$address=$request->address;
$speciality=$request->speciality;
$subspeciality=$request->subspeciality;

  DB::table('doctors')->where('id', $id)
  ->update([
  'name' =>$name,
  'regdate' =>$regdate,
  'regno' =>$regno,
  'address' =>$address,
  'speciality' =>$speciality,
  'subspeciality' =>$subspeciality,
]);

}


public function getMessages() {
  //Eddie - I will implement this
}








}
