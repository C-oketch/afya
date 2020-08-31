<?php
namespace App\Http\Controllers;

use App\Http\Models\NhifUser;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Doctor;
use Carbon\Carbon;
use Auth;
use App\Patient;
use App\Facility;
use PDF;
use Storage;
use Hash;

define('WEIGHT', "weight");
define('HEIGHT', "height");
define('TEMPERATURE', "temperature");
define('BLOOD_PRESSURE', "blood_pressure");
define('FASTING_SUGARS', "fasting_sugars");
define('BEFORE_MEAL_SUGARS', "before_meal_sugars");
define('POST_PRONDIAL_SUGARS', "post_prondial_sugars");

class BPatientController extends Controller
{

  public function authenticate(Request $request) {
      $phone = $request->input("phone");
      $pin = $request->input("pin");
      $data;
      $phone = "254" . substr($phone, -9);

//Include weight of patient in the data
      //Check from database
      $patient=DB::table('afya_users')->where('msisdn',$phone)->first();
      if(count($patient) > 0 && Hash::check($pin,$patient->pin)) {

        $nextkin=DB::table('kin_details')
        ->join('kin','kin.id','=','kin_details.relation')
        ->select('kin_details.kin_name','kin_details.phone_of_kin',
          'kin.relation')->where('kin_details.afya_user_id',$patient->id)->first();

          $report = DB::table('self_report')->where("afyauser_id", $patient->id)->first();
          $weight = "0";
          if(count($report) > 0) {
              $weight = $report->weight;
          }
          $constName = "N/A";
          $const = DB::table("constituency")->where("id", $patient->constituency)->first();
          if(count($const) > 0) {
              $constName = $const->Constituency;
          }
          
        $data = array(
          'id' => $patient->id,
          'firstName' => $patient->firstname,
          'secondName' => $patient->secondName,
          'pNumber' => $patient->msisdn,
          'bloodType' => $patient->blood_type,
          'email' => $patient->email,
          'gender' => $patient->gender,
          'age' => $patient->age,
          'status' => $patient->status,
          'nationalId' => $patient->nationalId,
          'has_nhif' => NhifUser::where("afyapepe_user", $patient->id)->exists(),
          'county' => $patient->pob,
          'constituency' => $constName,
          'kin' => $nextkin,
        'nhif_user_type' => NhifUser::where("afyapepe_user", $patient->id)->first()['type'],
          'weight' => $weight, // use real weight
          'auth' => true
        );
      }else {
        $data = array(
          'auth' => false
        );
      }

      return json_encode($data);

  }

  public function signUp(Request $request) {
    $results = array();
    $jsonString = $request->input("json");
    $data = json_decode($jsonString);
    $fName = $data->fName;
    $sName = $data->sName;
    $gender = $data->gender;
    $phone = $data->phone;
    $doctor = $data->doctor;
    $date = $data->date;
    $pin = $data->pin;
    $phone = "254" . substr($phone, -9);

    if(DB::table("afya_users")->where('msisdn', $phone)->exists()) {
      $results['status'] = false;
      $results['message'] = "Phone number exists";
    }else {

      $pin = bcrypt($pin);

      $insertData = array(
        'msisdn' => $phone,
        'firstname' => $fName,
        'secondName' => $sName,
        'gender' => $gender,
        'doctor' => $doctor,
        'has_smartphone' => 1,
        'dob' => $date,
        'pin' => $pin,
      );

      DB::table("afya_users")->insert($insertData);

      $results['status'] = true;
      $results['message'] = "Sign up Successful";

    }

    return json_encode($results);
  }
    
    public function getDoctors(Request $request) {
        $patient = $request->input("patient");
        $doctors = DB::table('doctors','users.id','=','doctors.user_id');
        
        if($patient != null) {
            $doctors = $doctors->join('afya_users','afya_users.doctor','=','doctors.user_id')
                ->where('afya_users.id', $patient);
        }
        
        $doctors = $doctors->select('doctors.id', 'doctors.name', 'doctors.address'
            ,'doctors.qualifications', 'doctors.speciality', 'doctors.subspeciality')->get();
        return json_encode($doctors);
    }

  public function updateSteps(Request $request) {
    $steps = $request->input("steps");
    $user = $request->input("user");
  }

  public function insertSms(Request $request) {
    return json_encode($request->input("mpesa"));
  }

  public function sendMessage(Request $request) {
    $user = $request->input("user");
    $message = $request->input('message');

    try {
        if($request->hasFile('file')){
            $photo = $request->file;
            $photo->move("files", uniqid());
            $reply = 'File Uploaded';
        }else {
            $reply = 'File Not Found';
        }
    }catch (Exception $e){
        $reply = $e;
    }

    return json_encode($reply);
  }

  public function sendTextMessage(Request $request) {
    $user = $request->input("user");
    $message = $request->input('message');

    return json_encode($message);
  }

  public function makeVisit(Request $request) {
     $facility = $request->input("facility");
     $pin = $request->input("pin");
     $data;
     if($pin == "4444") {
       $data = true;
     }else {
       $data = false;
     }

     return json_encode($data);

  }

  public function getNotifications() {
    //Include doctors message
    //Include reminders(check ups .....)
  }

  public function getAppointments(Request $request) {
      $date = $request->input('date');
    $data = array();
      $user = $request->input("user");
    $appointments=DB::table('appointments')->where('afya_user_id',$user);
      
      if($date != null || $date != "") {
        $appointments = $appointments->where('appointment_date', $date);
      }
      
      $appointments = $appointments->get();
      
      foreach($appointments as $appointment) {
          $doctor = DB::table("doctors")->where("id", $appointment->doc_id)->first();
      array_push($data, array(
           "doctor" => $doctor->name,
           "title" => $doctor->speciality,
           "time" => $appointment->appointment_time,
          "visit_type" => $appointment->visit_type,
           "id" => $appointment->id,
           "appointment_date" => $appointment->appointment_date,
       ));
    }
    return json_encode($data);
  }
    
    public function setAppointment(Request $request) {
        $jsonString = $request->input("appointment");
        $data = json_decode($jsonString);
        
        $details = array(
            'appointment_time' => $data->time,
            'symptoms' => $data->syms,
            'appointment_date' => $data->appointment_date,
            'afya_user_id' => $data->afyauser_id,
            'visit_type' => $data->visit_type,
            'persontreated' => $data->persontreated,
            'doc_id' => $data->doctor,
        );
    
        DB::table('appointments')->insert($details);
        
    }

  public function getCurrentAppointment(Request $request)
  {
      $user = $request->input("user");
      $id = $request->input("id");
      $appointment=DB::table('appointments')->where('afya_user_id',$user)->where('id', $id)->first();
      $doctor = DB::table("doctors")->where("id", $appointment->doc_id)->first();
      
    $data = array(
      "doctor" => $doctor->name,
       "title" => $doctor->speciality,
       "visit_type" => $appointment->visit_type,
       "time" => $appointment->appointment_time,
       "id" => $appointment->id,
       "appointment_date" => $appointment->appointment_date,
    );

    return json_encode($data);

  }

  public function getAppointment()
  {
    # code...
    //details of one appointment - uses appointment ID
  }

  public function getFacilities()
  {
    # code...
  }
    
  public function getTotalExpenditure(Request $request) {
    $patient = $request->input('patient');
    $payments = DB::table("appointments")->Join('payments', 'payments.appointment_id','=', 'appointments.id')
      ->where('appointments.afya_user_id', $patient)
      ->sum('payments.amount');
    
    return $payments;
  }
  
  public function getExpenditure(Request $request) {
    $type = $request->input('type');
    $patient = $request->input('patient');
    
    $payments = DB::table("appointments")->Join('payments', 'payments.appointment_id','=', 'appointments.id')
      ->Join('payments_categories', 'payments_categories.id', '=', 'payments.payments_category_id')
      ->Join('facilities', 'payments.facility','=', 'facilities.FacilityCode')
      ->where('appointments.afya_user_id', $patient)
      ->where('payments_categories.id', $type)
      ->select('payments_categories.category_name as type', 'payments.created_at as date', 'payments.amount', 'facilities.FacilityName as facility')
      ->get();
  
    return json_encode($payments);
    
  }
  
  public function selfReport(Request $request)
  {
     $type = $request->input('type');
     $value = $request->input('value');
     $user = $request->input('user');
     $reports=DB::table('self_report')
     ->select('temperature','weight','height','nutrition', 'bp','fasting_sugars', 'before_meal_sugars', 'postprondrial_sugars', 'afyauser_id')
     ->where('afyauser_id', $user)
     ->orderby("created_at", "desc")
     ->first();
        
    $data = array(
      'temperature' => 24,
      'weight' => 65,
      'blood_pressure' => 121,
      'height' => 174,
      'fasting_sugars' => 160,
      'post_prondial' => 123,
      'before_meal' => 145,
      'nutrition' => 'N/A'
    );
    
    return json_encode($data);
    
//    DB::table("self_report")->insert($arrInsert);
      
//     $arrInsert = array();
//     if(count($reports) > 0) {
//          $arrInsert['temperature'] = $reports->temperature;
//          $arrInsert['weight'] = $reports->weight;
//          $arrInsert['bp'] = $reports->bp;
//          // $arraInsert['height'] = $reports->height;
//          $arrInsert['fasting_sugars'] = $reports->fasting_sugars;
//          $arrInsert['before_meal_sugars'] = $reports->before_meal_sugars;
//          $arrInsert['postprondrial_sugars'] = $reports->postprondrial_sugars;
//          $arrInsert['afyauser_id'] = $reports->afyauser_id;
//        switch ($type) {
//           case WEIGHT:
//           $arrInsert['weight'] = $value;
//                break;
//           case HEIGHT:
//           $arrInsert['height'] = $value;
//                break;
//           case TEMPERATURE:
//           $arrInsert['temperature'] = $value;
//                break;
//           case BLOOD_PRESSURE:
//           $arrInsert['bp'] = $value;
//                break;
//           case FASTING_SUGARS:
//           $arrInsert['fasting_sugars'] = $value;
//                break;
//           case BEFORE_MEAL_SUGARS:
//           $arrInsert['before_meal_sugars'] = $value;
//                break;
//           case POST_PRONDIAL_SUGARS:
//           $arrInsert['postprondrial_sugars'] = $value;
//              break;
//       }
//     }else {
//       switch ($type) {
//         case WEIGHT:
//         $arrInsert['weight'] = $value;
//         $arrInsert['afyauser_id'] = $user;
//              break;
//         case HEIGHT:
//         $arrInsert['weight'] = $value;
//         $arrInsert['afyauser_id'] = $user;
//              break;
//         case TEMPERATURE:
//         $arrInsert['temperature'] = $value;
//         $arrInsert['afyauser_id'] = $user;
//              break;
//         case BLOOD_PRESSURE:
//         $arrInsert['bp'] = $value;
//         $arrInsert['afyauser_id'] = $user;
//              break;
//         case FASTING_SUGARS:
//         $arrInsert['fasting_sugars'] = $value;
//         $arrInsert['afyauser_id'] = $user;
//              break;
//         case BEFORE_MEAL_SUGARS:
//         $arrInsert['before_meal_sugars'] = $value;
//         $arrInsert['afyauser_id'] = $user;
//              break;
//         case POST_PRONDIAL_SUGARS:
//         $arrInsert['postprondrial_sugars'] = $value;
//         $arrInsert['afyauser_id'] = $user;
//              break;
//       }
//     }
    
  }
  
  public function setAccess(Request $request) {
    $json = $request->input("access");
    $access = json_decode($json);
    
    DB::table("record_accesses")->insert([
      'doctor' => $access->doctor,
      'patient' => $access->patient,
      'period_start' => $access->period_start,
      'period_end' => $access->period_end,
      'state' => 1
    ]);
    
    $new = DB::table("record_accesses")->orderby("created_at", "desc")->first();
    
    return json_encode($new);
    
  }
  
  public function updateAccess(Request $request) {
    $access = $request->input("access");
    
    $getAccess = DB::table("record_accesses")->where("id", "=", $access)->first();
    $state = $getAccess->state;
    
    DB::table("record_accesses")->where("id", "=", $access)->update([
      'state' => 1 - $state
    ]);
    
  }
  
  public function getAccesses(Request $request) {
    $patient = $request->input("patient");
    $accesses = DB::table("record_accesses")->join("doctors", "doctors.id", "=", "record_accesses.doctor")->where('patient', '=', $patient)
      ->select("record_accesses.doctor", "record_accesses.period_end", "record_accesses.period_start", "doctors.name as doctor_name", "record_accesses.state", "record_accesses.id")
      ->get();
    return json_encode($accesses);
  }

  public function getDependents(Request $request)
  {
      $data = array();
      for ($i = 0; $i < 5; $i++) {
        array_push($data, array(
          'dob' => "12-12-17",
          'gender' => "Male",
          'name' => "Edward",
          'pob' => "Kenya",
          'relationship' => "Brother"
        ));
      }
      return json_encode($data);
  }

  public function allergies(Request $request){
    $patient = $request->input("user");
     $data;
    //  $user=DB::table('users')->where('email', $request->email)->first();
    //  $patient=DB::table('afya_users')->where('users_id',$user->id)->first();
    $patient=DB::table('afya_users')->where('id',$patient)->first();
    $allergies=DB::table('afya_users_allergy')  ->Join('allergies_type','allergies_type.id','=','afya_users_allergy.allergies_type_id')
  ->Join('allergies','allergies.id','=','allergies_type.allergies_id')
  ->Select('allergies_type.name','allergies.name as Allergy','afya_users_allergy.created_at')
  ->Where('afya_users_allergy.afya_user_id','=',$patient->id)
  ->get();

  $data['allergies']= $allergies;
   return json_encode($allergies);
  }

 public function vaccination(Request $request){
   $user = $request->input("user");
   $data;
   $results = array();
    //  $user=DB::table('users')->where('email', $request->email)->first();
    //  $patient=DB::table('afya_users')->where('users_id',$user->id)->first();
    //  $vaccines=DB::table('vaccination')->
    //  join('vaccine','vaccine.id','=','vaccination.diseaseId')->
    //  select('vaccine.*','vaccination.*')
    //  ->where('vaccination.userId',$patient->id)
    //  ->where('vaccination.yes','=','yes')->
    //  Orderby('yesdate','desc')->get();

     $vaccines=DB::table('vaccination')->
     join('vaccine','vaccine.id','=','vaccination.diseaseId')->
     select('vaccine.*','vaccination.*')
     ->where('vaccination.userId',$user)
     ->where('vaccination.yes','=','yes')->
     Orderby('yesdate','desc')->get();

     foreach($vaccines as $vaccine) {
       $data = array(
         'antigen' => $vaccine->antigen,
         'name' => $vaccine->vaccine_name,
         'location' => 'Judes Huruma Community Health Services',
         'date' => $vaccine->Created_at
       );
       array_push($results, $data);
    }

   return json_encode($results);

 }

 public function triages(Request $request){
   $data;
      // $user=DB::table('users')->where('email', $request->email)->first();
      // $patient=DB::table('afya_users')->where('users_id',$user->id)->first();
       $patient=DB::table('afya_users')->where('id',$this->id)->first();

   $triages=DB::table('triage_details')->join('appointments','appointments.id','=','triage_details.appointment_id')
                       ->select('triage_details.*')->where('appointments.afya_user_id',$patient->id)->Orderby('triage_details.updated_at','desc')->get();


    $data['triages'] =$triages;

   return json_encode($triages);

 }


public function tests(Request $request){
  $user = $request->input("user");
$data = array();
$tests=DB::table('appointments')
 ->join('patient_test','appointments.id','=','patient_test.appointment_id')
 ->join('doctors','appointments.doc_id','=','doctors.id')
 ->join('patient_test_details','patient_test.id','=','patient_test_details.patient_test_id')
 ->join('tests','tests.id','=','patient_test_details.tests_reccommended')
 ->join('test_subcategories','tests.sub_categories_id','=','test_subcategories.id')
->select('patient_test_details.created_at','tests.name as tname','test_subcategories.name as subname',
     'doctors.name as docname','patient_test_details.done')
->where('appointments.afya_user_id',$user)
 ->get();

   foreach ($tests as $test) {
  $results = array(
      'date' => $test->created_at,
      'type' => $test->subname,
      'test' =>  $test->tname,
      'doctor' =>$test->docname,
      'status' => $test->done == 0 ? "Not Done" : "Done"
    );
       array_push($data, $results);
   }
  return response()->json($data);

 }

 public function selfReports(Request $request) {
   $patient = $request->input("patient");

//   $reports=DB::table('self_report')
//   ->select('temperature','weight','bp','fasting_sugars', 'before_meal_sugars', 'postprondrial_sugars', 'created_at as date')
//   ->where('afyauser_id', $patient)
//   ->orderby("created_at", "desc")
//   ->take(2)
//   ->get();
//   $data = array();
//   $prevReport = null;
//   $currentReport = null;
//   $docModule = new MDoctorsController();
//
//   if(count($reports) == 2) {
//     $prevReport = $reports[1];
//     $currentReport = $reports[0];
//     $data = $docModule->processReports($prevReport, $currentReport);
//   }else if(count($reports) == 1) {
//     $currentReport = $reports[0];
//     $data = $docModule->processReports(null, $currentReport);
//   }
   $data = array(
      'temperature' => 24,
      'weight' => 65,
      'blood_pressure' => 121,
      'height' => 174,
      'fasting_sugars' => 160,
      'post_prondial' => 123,
      'before_meal' => 145,
      'nutrition' => 'N/A'
    );
    
   return json_encode($data);
 }

 public function admits(Request $request){
   $user = $request->input("user");
    $data;
    $results = array();
      //  $user=DB::table('users')->where('email', $request->email)->first();
      //  $patient=DB::table('afya_users')->where('users_id',$user->id)->first();

    $admits=DB::table('patient_admitted')
    ->join('appointments','appointments.id','=','patient_admitted.appointment_id')
    ->join('prescriptions','prescriptions.appointment_id','=','appointments.id')
    ->join('prescription_details','prescription_details.presc_id','=','prescriptions.id')
    ->Join('icd10_option','icd10_option.id','=','prescription_details.diagnosis')
    ->Join('triage_details','triage_details.appointment_id','=','appointments.id')
    ->select('patient_admitted.*','icd10_option.name as name','triage_details.chief_compliant as triage')
    ->where('appointments.afya_user_id',$user)
    ->get();

    foreach($admits as $admit) {
      $data = array(
        'admitted' => $admit->date_admitted,
        'discharged' => $admit->date_discharged,
        'triage' => $admit->triage,
        'name' => $admit->name,
        'condition' => $admit->condition
      );
      array_push($data, $results);
     }

return json_encode($results);
 }

 public function expenditures(Request $request){
    $data = array();
    $user = $request->input("user");

   $expenditures = DB::table('payments')
   ->join('appointments', 'appointments.id', '=', 'payments.appointment_id')
   ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
   ->join('facilities', 'facilities.FacilityCode', '=', 'appointments.facility_id')
   ->select('afya_users.*', 'facilities.*', 'payments.*')
   ->where('afya_users.id', '=', $user)
   ->get();

    foreach ($expenditures as $expenditure) {
      array_push($data, array(
        'date' => $expenditure->created_at,
        'facility' => $expenditure->FacilityName,
        'amount' => $expenditure->amount,
        'patient' => $expenditure->firstname . " " . $expenditure->secondName
      ));
    }

    return json_encode($data);

 }

   //$expenditures=DB::table('consultation_fees')->where('afyauser_id',$patient->id)->get();
public function patientHistory(Request $request)
{
  $data;
  $results  = array();
  $user = $request->input("user");

   $triages=DB::table('triage_details')
   ->join('appointments','appointments.id','=','triage_details.appointment_id')
   ->select('triage_details.*')
   ->where('appointments.afya_user_id',$user)
   ->Orderby('triage_details.updated_at','desc')
   ->get();

   foreach($triages as $triage) {

     $data = array(
       'date' => $triage->updated_at,
       'weight' => $triage->current_weight,
       'height' => $triage->current_height,
       'bmi' => $triage->current_weight/($triage->current_height*$triage->current_height),
       'temperature' => $triage->temperature,
       'sbp' => $triage->systolic_bp,
       'dbp' => $triage->diastolic_bp,
       'complaint' => $triage->chief_compliant
     );
     array_push($data, $results);
 }

   return json_encode($results);
}

public function patientPrescriptions(Request $request)
{
  $user = $request->input("user");
$data;
$results  = array();

$prescs=DB::table('prescription_details')
->Join('icd10_option','icd10_option.id','=','prescription_details.diagnosis')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->join('prescriptions','prescriptions.id','=','prescription_details.presc_id')
->join('appointments','appointments.id','=','prescriptions.appointment_id')
->select('prescription_details.*','icd10_option.name as name','druglists.drugname as drugname','appointments.doc_id as doc')
->where('appointments.afya_user_id',$user)
->get();

foreach($prescs as $presc) {
$doc=DB::table('doctors')->where('id',$presc->doc)->first();
$data = array(
'date' => $presc->created_at,
'diagnosis' => $presc->name,
'state' => $presc->state,
'drug' => $presc->drugname,
'doctor' => $doc->name
);

array_push($results, $data);

}

return json_encode($results);

}
    
    //pin reset

    public function resetPin(Request $request) {
        $data = array();
        $phone = $request->input('phone');
        $phone = "254" . substr($phone, -9);

          $patient=DB::table('afya_users')->where('msisdn',$phone)->first();
          if(count($patient) > 0) {
              $pin = 2345;
              $patient=DB::table('afya_users')->where('msisdn',$phone)->update([
                  'pin' => bcrypt($pin)
              ]);
              
            $data['code'] = 200;
            $data['message'] = 'We sent you a new pin';
            $data['pin'] = $pin;
          }else {
            $data['code'] = 302;
            $data['message'] = 'Phone number is not registered';
          }
        
        return json_encode($data);
        
    }
    
    public function submitReport(Request $request) {
        $patient = $request->input('patient');
        $vitalsJson = $request->input('vitals');
        $complaintsJson = $request->input('complaints');
        $allergiesJson = $request->input('allergy');
        
        $vitals = json_decode($vitalsJson);
        $complaints = json_decode($complaintsJson);
        $allergies = json_decode($allergiesJson);
        
        $reportId = 12099;
        
        $vitalExist = DB::table("self_reporting_vitals")->where('report_id', $reportId)->exists();
        $allergyExist = DB::table("self_reporting_allergies")->where('report_id', $reportId)->exists();
        $complaintExist = DB::table("self_reporting_complaints")->where('report_id', $reportId)->exists();
        
        while($vitalExist || $allergyExist || $complaintExist) {
            $reportId++;
            $vitalExist = DB::table("self_reporting_vitals")->where('report_id', $reportId)->exists();
            $allergyExist = DB::table("self_reporting_allergies")->where('report_id', $reportId)->exists();
            $complaintExist = DB::table("self_reporting_complaints")->where('report_id', $reportId)->exists();
        }
        
        if(count($vitals) > 0) {
            foreach($vitals as $vital) {
                DB::table("self_reporting_vitals")->insert([
                    'report_id' => $reportId,
                    'user_id' => $patient,
                    'vital' => $vital->id,
                    'value' => $vital->value
                ]);
            }
        
        }
        
        if(count($complaints) > 0) {
            foreach($complaints as $complaint) {
                DB::table("self_reporting_complaints")->insert([
                    'report_id' => $reportId,
                    'user_id' => $patient,
                    'complaint' => $complaint->id
                ]);
            }            
        }
        
        if(count($allergies) > 0) {
            foreach($allergies as $allergy) {
                DB::table("self_reporting_allergies")->insert([
                    'report_id' => $reportId,
                    'user_id' => $patient,
                    'allergy' => $allergy->id
                ]);
            }            
        }
        
        DB::table("self_report_user")->insert([
            'report_id' => $reportId,
            'user_id' => $patient,
        ]);
        
        return "true";
    }
    
    public function getComplaints() {
        $complaints = DB::table('chief_compliant_table')->select('id', 'name')->get();
        return json_encode($complaints);
    }
    
    public function getAllergies() {
        $allergies = DB::table('allergies_type')->select('id', 'name')->get();
        return json_encode($allergies);
    }
    
    public function getReports(Request $request) {
        $patient = $request->input('patient');
        $data = array();
        $allergies;
        $vitals;
        $complaints;
        
        $reports = DB::table('self_report_user')->where("user_id", $patient)->get();
         
        foreach($reports as $report) {
            $reportId = $report->report_id;
            $allergies = DB::table('self_reporting_allergies')->where('report_id', $reportId)->join("allergies_type", "allergies_type.id", "=", "self_reporting_allergies.allergy")->get();
            $vitals = DB::table('self_reporting_vitals')->where('report_id', $reportId)->get();
            $complaints = DB::table('self_reporting_complaints')->join("chief_compliant_table", "chief_compliant_table.id", "=", "self_reporting_complaints.complaint")->where('report_id', $reportId)->get();
            array_push($data, array(
                'date' => $report->created_at,
                'vitals' => $vitals,
                'allergies' => $allergies,
                'complaints' => $complaints
            ));            
        }
        
        return json_encode($data);
        
    }
    
    public function canChat(Request $request) {
        $user = $request->input('patient');
        if(!DB::table("chats")->where('user', '=', $user)->exists()) {
            DB::table("chats")->insert([
                'user' => $user
            ]);            
        }
    }
    
    public function getChats(Request $request) {
        $user = $request->input('user');
        $users = DB::table("chats")->join("afya_users", "afya_users.id", "=", "chats.user")->select("afya_users.firstName as name", "afya_users.id as id")->whereNotIn('afya_users.id', [$user])->get();
        return json_encode($users);
    }
    
  }
