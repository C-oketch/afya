<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Patienttest;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;

class PatientTestController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function xrayreports($id)
     {
        $tsts1 = DB::table('radiology_test_details')
        ->Join('xray', 'radiology_test_details.test', '=', 'xray.id')
      ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
      ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('radiology_test_details.*','xray.name','facilities.FacilityName','doctors.name as docname')
        ->where('radiology_test_details.id', '=',$id)
        ->first();

        $patientD=DB::table('appointments')
      ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
        ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
        ->select('appointments.*','afya_users.id as afya_id','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
        'facilities.set_up','patient_admitted.condition')
        ->where('appointments.id',$tsts1->appointment_id)
        ->first();

        $cur_app=DB::table('appointments')
        ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
        ->select('appointments.id')
        ->where('appointments.afya_user_id',$patientD->afya_id)
        ->orderBy('appointments.id','desc')
        ->first();

    return view('doctor.tests.reportxray')->with('tsts1',$tsts1)->with('patientD',$patientD)->with('cur_app',$cur_app);
     }

     public function ctreports($id)
     {
        $tsts1 = DB::table('radiology_test_details')
        ->Join('ct_scan', 'radiology_test_details.test', '=', 'ct_scan.id')
      ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
      ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('radiology_test_details.*','ct_scan.name','facilities.FacilityName','doctors.name as docname')
        ->where('radiology_test_details.id', '=',$id)
        ->first();

        $patientD=DB::table('appointments')
      ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
        ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
        ->select('appointments.*','afya_users.id as afya_id','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
        'facilities.set_up','patient_admitted.condition')
        ->where('appointments.id',$tsts1->appointment_id)
        ->first();
        $cur_app=DB::table('appointments')
        ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
        ->select('appointments.id')
        ->where('appointments.afya_user_id',$patientD->afya_id)
        ->orderBy('appointments.id','desc')
        ->first();


    return view('doctor.tests.reportct')->with('tsts1',$tsts1)->with('patientD',$patientD)->with('cur_app',$cur_app);
     }

public function otherReport($id)
{

$tsts1 = DB::table('radiology_test_details')
 ->Join('other_tests', 'radiology_test_details.test', '=', 'other_tests.id')
 ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
 ->leftJoin('doctors', 'appointments.doc_id', '=', 'doctors.id')
 ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->select('radiology_test_details.*','other_tests.name','facilities.FacilityName','doctors.name as docname')
  ->where('radiology_test_details.id', '=',$id)
  ->first();

  $patientD=DB::table('appointments')
->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
  'facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$tsts1->appointment_id)
  ->first();

$cur_app=DB::table('appointments')
->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('appointments.id')
->where('appointments.afya_user_id',$patientD->afya_user_id)
->orderBy('appointments.id','desc')
->first();

return view('doctor.tests.otherReport')->with('tsts1',$tsts1)->with('patientD',$patientD)->with('cur_app',$cur_app);
}

public function labtestReport($id)
{
  $tsts1 = DB::table('patient_test_details')
  ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->Join('appointments', 'patient_test_details.appointment_id', '=', 'appointments.id')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->select('patient_test_details.*','tests.name','facilities.FacilityName','doctors.name as docname')
    ->where('patient_test_details.id', $id)
    ->first();


  $patientD=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.id as afya_id','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','patient_admitted.condition','facilities.set_up')
  ->where('appointments.id',$tsts1->appointment_id)
  ->first();
  $cur_app=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->select('appointments.id')
  ->where('appointments.afya_user_id',$patientD->afya_id)
  ->orderBy('appointments.id','desc')
  ->first();

  return view('doctor.tests.reportlab')->with('tsts1',$tsts1)->with('patientD',$patientD)->with('cur_app',$cur_app);
}


     public function mrireports($id)
     {
        $tsts1 = DB::table('radiology_test_details')
        ->Join('mri_tests', 'radiology_test_details.test', '=', 'mri_tests.id')
      ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
      ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('radiology_test_details.*','mri_tests.name','facilities.FacilityName','doctors.name as docname')
        ->where('radiology_test_details.id', '=',$id)
        ->first();

        $patientD=DB::table('appointments')
      ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
        ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
        ->select('appointments.*','afya_users.id as afya_id','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
        'facilities.set_up','patient_admitted.condition')
        ->where('appointments.id',$tsts1->appointment_id)
        ->first();
        $cur_app=DB::table('appointments')
        ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
        ->select('appointments.id')
        ->where('appointments.afya_user_id',$patientD->afya_id)
        ->orderBy('appointments.id','desc')
        ->first();

    return view('doctor.tests.reportmri')->with('tsts1',$tsts1)->with('patientD',$patientD)->with('cur_app',$cur_app);
     }

     public function ultrareports($id)
     {

  $tsts1 = DB::table('radiology_test_details')
      ->Join('ultrasound', 'radiology_test_details.test', '=', 'ultrasound.id')
    ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
    ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
    ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
    ->select('radiology_test_details.*','ultrasound.name','facilities.FacilityName','doctors.name as docname')
      ->where('radiology_test_details.id', '=',$id)
      ->first();

  $patientD=DB::table('appointments')
    ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
    ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
      ->select('appointments.*','afya_users.id as afya_id','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
      'facilities.set_up','patient_admitted.condition')
      ->where('appointments.id',$tsts1->appointment_id)
      ->first();

      $cur_app=DB::table('appointments')
      ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
      ->select('appointments.id')
      ->where('appointments.afya_user_id',$patientD->afya_id)
      ->orderBy('appointments.id','desc')
      ->first();

return view('doctor.tests.reportultra')->with('tsts1',$tsts1)->with('patientD',$patientD)->with('cur_app',$cur_app);
     }

     public function testdetails($id)
     {

    $pdetails = DB::table('patient_test')
    ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
    ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
    ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
    ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
    ->select('appointments.persontreated','appointments.afya_user_id','appointments.id as appId',
    'doctors.name as docname','facilities.FacilityName','patient_admitted.condition')
    ->where('patient_test.id', '=',$id)
    ->first();

  $tsts = DB::table('patient_test')
  ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->leftJoin('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
  ->leftJoin('icd10_option', 'patient_test_details.conditional_diag_id', '=', 'icd10_option.id')
  ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
  ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
  ->select('tests.name as tname','test_subcategories.name as tsname','icd10_option.name as dname','patient_test_details.created_at as date',
  'patient_test_details.id as patTdid','test_categories.name as tcname','patient_test_details.done',
  'patient_test_details.tests_reccommended','appointments.id as AppId')
  ->where('patient_test.id', '=',$id)
  ->get();

           $rady = DB::table('patient_test')
               ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
               ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
               ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
               ->select('radiology_test_details.created_at as date','radiology_test_details.test',
               'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
               'radiology_test_details.id as patTdid','test_categories.name as tcname')
                ->where('patient_test.id', '=',$id)
                ->get();
       return view('doctor.tests.tstdetails')->with('tsts',$tsts)->with('pdetails',$pdetails)->with('rady',$rady);
     }

     public function otherResult(Request $request)
     {
     $appointment=$request->appointment_id;
     $rtdid =$request->rtdid;
     $notes =$request->note;
     $technique =$request->technique;
     $u_id = Auth::user()->id;
    $cur_app =$request->cur_appointment_id;
     if ($notes)  {

       $radyexist = DB::table('radiology_test_result')
           ->select('id')
            ->where('radiology_td_id', '=',$rtdid)
            ->first();
if($radyexist){
  DB::table('radiology_test_result')
  ->where('radiology_td_id',$rtdid)
  ->update([
      'results' => $notes,
      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
}else{
  DB::table('radiology_test_result')->insert(
    [
      'radiology_td_id' => $rtdid,
      'results' => $notes,
      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
}


     DB::table('radiology_test_details')
           ->where('id',$rtdid)
           ->update([
          'appointment_id'=> $cur_app,
          'technique' => $technique,
           'done' => 1,
           'conclusion'=>$notes,
           'status'=> 1,
           'result_by'=>$u_id,
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
         ]);
     }


     return redirect()->action('PatientTestController2@otherReport',[$rtdid]);
     }

     public function otherupload(Request $request)
     {
     $cur_app=$request->cur_appointment_id;
     $rtdid =$request->rtdid;
     $u_id = Auth::user()->id;
     // $files = $request->image;
     $files = $request->file('image');

     if($files) {
        foreach ($files as $file) {
          // $file2 = Input::file('marige');
          $destinationPath = public_path().'/uploads/radilogy/';
          $filename2 = str_random(6).'_'.$file->getClientOriginalName();
          $uploadSuccess = $file->move($destinationPath, $filename2);
          $filename22 ='uploads/radilogy/'.$filename2;

DB::table('radiology_images')->insert([
            'user_id'=>$u_id,
            'radiology_td_id'=>$rtdid,
            'image'=>$filename22,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);
}
}

DB::table('radiology_test_details')
      ->where('id',$rtdid)
      ->update([
        'appointment_id'=> $cur_app,
      'done' => 1,
      'status'=> 1,
      'result_by'=>$u_id,
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
    return redirect()->action('PatientTestController2@otherReport',[$rtdid]);
     }

     public function Removeotherupload($id)
     {

   $app = DB::table('radiology_test_details')
       ->join('radiology_images','radiology_test_details.id', '=', 'radiology_images.radiology_td_id')
       ->select('radiology_test_details.appointment_id','radiology_test_details.id','radiology_images.image')
       ->where('radiology_images.id',$id)->first();
$appointment =$app->appointment_id;
$rtdid = $app->id;
$file= $app->image;

      $filename = public_path().'/'.$file;
      \File::delete($filename);

  DB::table("radiology_images")->where('id', $id)->delete();


  return redirect()->action('PatientTestController2@otherReport',[$rtdid]);
     }



     public function mriResult(Request $request)
     {
     $appointment=$request->appointment_id;
     $rtdid =$request->rtdid;
     $notes =$request->note;
     $technique =$request->technique;
     $u_id = Auth::user()->id;
     $cur_app =$request->cur_appointment_id;
     if ($notes)  {

$radyexist = DB::table('radiology_test_result')
->select('id')
->where('radiology_td_id', '=',$rtdid)
->first();

if($radyexist){
  DB::table('radiology_test_result')
  ->where('radiology_td_id',$rtdid)
  ->update([
      'results' => $notes,
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
}else{
       DB::table('radiology_test_result')->insert(
         [
           'radiology_td_id' => $rtdid,
           'results' => $notes,
           'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
         ]);
}

     DB::table('radiology_test_details')
           ->where('id',$rtdid)
           ->update([
          'appointment_id'=> $cur_app,
           'technique' => $technique,
           'done' => 1,
           'conclusion'=>$notes,
           'status'=> 1,
           'result_by'=>$u_id,
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
         ]);
     }
     return redirect()->action('PatientTestController2@mrireports',[$rtdid]);
     }

     public function ultraResult(Request $request)
     {
     $cur_app =$request->cur_appointment_id;
     $appointment=$request->appointment_id;
     $rtdid =$request->rtdid;
     $notes =$request->note;
     $technique =$request->technique;
     $u_id = Auth::user()->id;
     if ($notes)  {

       $radyexist = DB::table('radiology_test_result')
           ->select('id')
            ->where('radiology_td_id', '=',$rtdid)
            ->first();

            if($radyexist){

                DB::table('radiology_test_result')
                ->where('radiology_td_id',$rtdid)
                ->update([
                    'results' => $notes,
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                  ]);
            }else{
              DB::table('radiology_test_result')->insert(
                [
                  'radiology_td_id' => $rtdid,
                  'results' => $notes,
                  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);
            }

     DB::table('radiology_test_details')
           ->where('id',$rtdid)
           ->update([
           'appointment_id' =>$cur_app,
           'technique' => $technique,
           'done' => 1,
           'conclusion'=>$notes,
           'status'=> 1,
           'result_by'=>$u_id,
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
         ]);
     }
     return redirect()->action('PatientTestController2@ultrareports',[$rtdid]);
     }

     public function ctResult(Request $request)
     {
     $appointment=$request->appointment_id;
     $rtdid =$request->rtdid;
     $notes =$request->note;
     $technique =$request->technique;
     $u_id = Auth::user()->id;
     $cur_app =$request->cur_appointment_id;

     if ($notes)  {
       $radyexist = DB::table('radiology_test_result')
           ->select('id')
            ->where('radiology_td_id', '=',$rtdid)
            ->first();

            if($radyexist){
              DB::table('radiology_test_result')
              ->where('radiology_td_id',$rtdid)
              ->update([
                  'results' => $notes,
                  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);
            }else{
       DB::table('radiology_test_result')->insert(
         [
           'radiology_td_id' => $rtdid,
           'results' => $notes,
           'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
         ]);
}
   DB::table('radiology_test_details')
           ->where('id',$rtdid)
           ->update([
           'appointment_id' => $cur_app,
           'technique' => $technique,
           'done' => 1,
           'conclusion'=>$notes,
           'status'=> 1,
           'result_by'=>$u_id,
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
         ]);
     }
     return redirect()->action('PatientTestController2@ctreports',[$rtdid]);
     }

     public function xrayResult(Request $request)
     {
    $cur_app =$request->cur_appointment_id;
     $appointment=$request->appointment_id;
     $rtdid =$request->rtdid;
     $notes =$request->note;
     $technique =$request->technique;
     $u_id = Auth::user()->id;
     if ($notes)  {
       $radyexist = DB::table('radiology_test_result')
           ->select('id')
            ->where('radiology_td_id', '=',$rtdid)
            ->first();

            if($radyexist){
              DB::table('radiology_test_result')
              ->where('radiology_td_id',$rtdid)
              ->update([
                  'results' => $notes,
                  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);
            }else{
   DB::table('radiology_test_result')->insert(
         [
           'radiology_td_id' => $rtdid,
           'results' => $notes,
           'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
         ]);
}

     DB::table('radiology_test_details')
           ->where('id',$rtdid)
           ->update([
          'appointment_id' =>$cur_app,
          'technique' => $technique,
           'done' => 1,
           'conclusion'=>$notes,
           'status'=> 1,
           'result_by'=>$u_id,
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
         ]);
     }


     return redirect()->action('PatientTestController2@xrayreports',[$rtdid]);

     }
     public function labResult(Request $request)
     {
     $appointment=$request->appointment;
     $ptdid =$request->ptdid;
     $cur_app =$request->cur_appointment_id;
     $notes =$request->note;
     $test =$request->test;

     $u_id = Auth::user()->id;

     if ($notes)  {
       $labexist = DB::table('test_results')
           ->select('id')
            ->where('ptd_id', '=',$ptdid)
            ->first();
       if($labexist){
         DB::table('test_results')
         ->where('ptd_id',$ptdid)
         ->update([
             'value'=>$notes,
             'status'=>1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
       }else{
         DB::table('test_results')->insert([
             'ptd_id' => $ptdid,
             'value'=>$notes,
             'status'=>1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
       }


     DB::table('patient_test_details')
           ->where('id',$ptdid)
           ->update([
           'appointment_id'=> $cur_app,
           'done' => 1,
           'status'=> 1,
           'user_id'=>$u_id,
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
         ]);
     }
     return redirect()->action('PatientTestController2@labtestReport',[$ptdid]);

     }

     public function savetests(Request $request)
     {
       $appointment=$request->appointment;
  $Uid1 = Auth::user()->id;
   $pttids= Patienttest::where('appointment_id',$appointment)
    ->first();

       if (is_null($pttids)) {
  $PatientTest = Patienttest ::create([
    'appointment_id' => $appointment,
    'test_status' => 0,
  ]);
      $ptid = $PatientTest->id;
      // Already test exist - just get the id
       } else {

        $ptid =$pttids->id;
        DB::table('patient_test')->where('id', $ptid)
        ->update(['test_status' => 0,]);
       }

       DB::table('appointments')->where('id', $appointment)
       ->update(['status' => 1,'p_status' => 11,]);




       // Inserting Lab Tests
       $lab_id=$request->lab;
       if($lab_id){
         foreach($lab_id as $key =>$lab) {
           $patient_td = DB::table('patient_test_details')->insert([
             'patient_test_id' => $ptid,
             'appointment_id' => $appointment,
             'req_appointment_id' => $appointment,
             'tests_reccommended' => $lab,
             'done' => 0,
             'user_id' =>$Uid1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
         }
       }
       // Inserting Cardiac Tests
       $cardiac_id=$request->cardiac;
       if($cardiac_id){
         foreach($cardiac_id as $key =>$card) {
           $patient_td = DB::table('patient_test_details_c')->insert([
             'patient_test_id' => $ptid,
             'appointment_id' => $appointment,
             'tests_reccommended' => $card,
             'done' => 0,
             'user_id' =>$Uid1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
         }
       }
       // Inserting neurology Tests
       $neurology_id=$request->neurology;
       if($neurology_id){
         foreach($neurology_id as $key =>$neuro) {
           $patient_td = DB::table('patient_test_details_n')->insert([
             'patient_test_id' => $ptid,
             'appointment_id' => $appointment,
             'tests_reccommended' => $neuro,
             'done' => 0,
             'user_id' =>$Uid1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
         }
       }
       // Inserting Procedure neurology  Tests
       $pneurology_id=$request->pneurology;
       if($pneurology_id){
         foreach($pneurology_id as $key =>$pneuro) {
           $patient_td = DB::table('patient_procedure_details')->insert([
             'patient_test_id' => $ptid,
             'appointment_id' => $appointment,
             'procedure_id' => $pneuro,
             'done' => 0,
             'user_id' =>$Uid1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
         }
       }
       // Inserting Procedure cardiac Tests
       $pcardiac_id=$request->pcardiac;
       if($pcardiac_id){
         foreach($pcardiac_id as $key =>$pcard) {
           $patient_td = DB::table('patient_procedure_details')->insert([
             'patient_test_id' => $ptid,
             'appointment_id' => $appointment,
             'procedure_id' => $pcard,
             'done' => 0,
             'user_id' =>$Uid1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
         }
       }

       // Inserting Xray Tests
       $xray_id=$request->xray;
       if($xray_id){
         foreach($xray_id as $key =>$xray) {
           $patient_td = DB::table('radiology_test_details')->insert([
             'patient_test_id' => $ptid,
             'appointment_id' => $appointment,
             'test' => $xray,
             'test_cat_id' => 10,
             'done' => 0,
             'user_id' =>$Uid1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
         }
       }

       // Inserting mri Tests
       $mri_id=$request->mri;
       if($mri_id){
         foreach($mri_id as $key =>$mri) {
           $patient_td = DB::table('radiology_test_details')->insert([
             'patient_test_id' => $ptid,
             'appointment_id' => $appointment,
             'test' => $mri,
             'test_cat_id' => 11,
             'done' => 0,
             'user_id' =>$Uid1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
         }
       }

       // Inserting ultra Tests
       $ultra_id=$request->ultra;
       if($ultra_id){
         foreach($ultra_id as $key =>$ultra) {
           $patient_td = DB::table('radiology_test_details')->insert([
             'patient_test_id' => $ptid,
             'appointment_id' => $appointment,
             'test' => $ultra,
             'test_cat_id' => 12,
             'done' => 0,
             'user_id' =>$Uid1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
         }
       }

       // Inserting ctscan Tests
       $ctscan_id=$request->ctscan;
       if($ctscan_id){
         foreach($ctscan_id as $key =>$ctscan) {
           $patient_td = DB::table('radiology_test_details')->insert([
             'patient_test_id' => $ptid,
             'appointment_id' => $appointment,
             'test' => $ctscan,
             'test_cat_id' => 9,
             'done' => 0,
             'user_id' =>$Uid1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
         }
       }
       // Inserting othert Tests
       $othert_id=$request->othert;
       if($othert_id){
         foreach($othert_id as $key =>$othert) {
           $patient_td = DB::table('radiology_test_details')->insert([
             'patient_test_id' => $ptid,
             'appointment_id' => $appointment,
             'test' => $othert,
             'test_cat_id' => 13,
             'done' => 0,
             'user_id' =>$Uid1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
         }
       }
   return redirect()->action('PatientTestController@alltestdata',[$appointment]);
 }
 public function Radremove(Request $request)
 {
   $now = Carbon::now();
   $test=$request->test;
   $appointment =$request->appointment;
   $id1 = Auth::user()->id;

   DB::table("radiology_test_details")->where('id',$test)
   ->update(['deleted' => 1,'deleted_by' =>$id1,'updated_at' =>$now,]);

   return redirect()->action('PatientTestController@alltestdata',[$appointment]);

}
public function storeRegLab(Request $request)
{

     $appointment=$request->appointment_id;
     $test_id=$request->test_id;
     $docnote=$request->docnote;
$Uid1 = Auth::user()->id;
 $pttids= Patienttest::where('appointment_id',$appointment)
  ->first();

     if (is_null($pttids)) {
$PatientTest = Patienttest ::create([
  'appointment_id' => $appointment,
  'test_status' => 0,
]);
    $ptid = $PatientTest->id;
     } else {
     // Already test exist - just get the id
      $ptid =$pttids->id;
      DB::table('patient_test')->where('id', $ptid)
      ->update(['test_status' => 0,]);
     }
     DB::table('appointments')->where('id', $appointment)
     ->update(['p_status' => 11,]);

     // Inserting  tests
$patient_td = DB::table('patient_test_details')->insertGetId([
                  'patient_test_id' => $ptid,
                  'appointment_id' => $appointment,
                  'tests_reccommended' => $test_id,
                  'done' => 0,
                   'user_id' =>$Uid1,
               ]);
   // Inserting patientNotes tests
if ($docnote) {
$patientNotes = DB::table('patientNotes')->insert([
    'appointment_id' => $appointment,
    'note' => $docnote,
    'target' => 'Test',
    'ptd_id' => $patient_td,
     ]);
}
// $afyaId = DB::table("appointments")->where('id',$appointment)->select('afya_user_id')->first();
return redirect()->action('PatientTestController@alltestdata',[$appointment]);
  }

  public function labremove(Request $request)
  {
    $now = Carbon::now();
    $test=$request->ptd_id;
    $appointment =$request->appointment_id;
    $id1 = Auth::user()->id;

    DB::table("patient_test_details")->where('id',$test)
    ->update(['deleted' => 1,'deleted_by' =>$id1,'updated_at' =>$now,]);

    return redirect()->action('PatientTestController@alltestdata',[$appointment]);

  }

  public function mriupload(Request $request)
  {
  $appointment=$request->appointment_id;
  $rtdid =$request->rtdid;
  $u_id = Auth::user()->id;
  $cur_app =$request->cur_appointment_id;
  $files = $request->file('image');

  if($files) {
     foreach ($files as $file) {
       // $file2 = Input::file('marige');
       $destinationPath = public_path().'/uploads/radilogy/';
       $filename2 = str_random(6).'_'.$file->getClientOriginalName();
       $uploadSuccess = $file->move($destinationPath, $filename2);
       $filename22 ='uploads/radilogy/'.$filename2;

DB::table('radiology_images')->insert([
         'user_id'=>$u_id,
         'radiology_td_id'=>$rtdid,
         'image'=>$filename22,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]);
}
}

DB::table('radiology_test_details')
   ->where('id',$rtdid)
   ->update([
   'appointment_id' =>$cur_app,
   'done' => 1,
   'status'=> 1,
   'result_by'=>$u_id,
   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
 ]);
 return redirect()->action('PatientTestController2@mrireports',[$rtdid]);
  }

  public function Removemriupload($id)
  {

$app = DB::table('radiology_test_details')
    ->join('radiology_images','radiology_test_details.id', '=', 'radiology_images.radiology_td_id')
    ->select('radiology_test_details.appointment_id','radiology_test_details.id','radiology_images.image')
    ->where('radiology_images.id',$id)->first();
$appointment =$app->appointment_id;
$rtdid = $app->id;
$file= $app->image;

      $filename = public_path().'/'.$file;
      \File::delete($filename);
DB::table("radiology_images")->where('id', $id)->delete();


return redirect()->action('PatientTestController2@mrireports',[$rtdid]);
  }

  public function ctupload(Request $request)
  {
  $appointment=$request->appointment_id;
  $rtdid =$request->rtdid;
  $u_id = Auth::user()->id;
  $cur_app =$request->cur_appointment_id;

  $files = $request->file('image');

  if($files) {
     foreach ($files as $file) {
       // $file2 = Input::file('marige');
       $destinationPath = public_path().'/uploads/radilogy/';
       $filename2 = str_random(6).'_'.$file->getClientOriginalName();
       $uploadSuccess = $file->move($destinationPath, $filename2);
       $filename22 ='uploads/radilogy/'.$filename2;

DB::table('radiology_images')->insert([
         'user_id'=>$u_id,
         'radiology_td_id'=>$rtdid,
         'image'=>$filename22,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]);
}
}

DB::table('radiology_test_details')
   ->where('id',$rtdid)
   ->update([
  'appointment_id' =>$cur_app,
   'done' => 1,
   'status'=> 1,
   'result_by'=>$u_id,
   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
 ]);
 return redirect()->action('PatientTestController2@ctreports',[$rtdid]);
  }

  public function Removectupload($id)
  {

$app = DB::table('radiology_test_details')
    ->join('radiology_images','radiology_test_details.id', '=', 'radiology_images.radiology_td_id')
    ->select('radiology_test_details.appointment_id','radiology_test_details.id','radiology_images.image')
    ->where('radiology_images.id',$id)->first();
$appointment =$app->appointment_id;
$rtdid = $app->id;
$file= $app->image;

      $filename = public_path().'/'.$file;
      \File::delete($filename);
DB::table("radiology_images")->where('id', $id)->delete();


return redirect()->action('PatientTestController2@ctreports',[$rtdid]);
  }


  public function xrayupload(Request $request)
  {
  $appointment=$request->cur_appointment_id;
  $rtdid =$request->rtdid;
  $u_id = Auth::user()->id;
  // $files = $request->image;
  $files = $request->file('image');

  if($files) {
     foreach ($files as $file) {
       // $file2 = Input::file('marige');
       $destinationPath = public_path().'/uploads/radilogy/';
       $filename2 = str_random(6).'_'.$file->getClientOriginalName();
       $uploadSuccess = $file->move($destinationPath, $filename2);
       $filename22 ='uploads/radilogy/'.$filename2;

DB::table('radiology_images')->insert([
         'user_id'=>$u_id,
         'radiology_td_id'=>$rtdid,
         'image'=>$filename22,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]);
}
}

DB::table('radiology_test_details')
   ->where('id',$rtdid)
   ->update([
   'appointment_id'=> $appointment,
   'done' => 1,
   'status'=> 1,
   'result_by'=>$u_id,
   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
 ]);
  return redirect()->action('PatientTestController2@xrayreports',[$rtdid]);
  }

  public function Removexrayupload($id)
  {

$app = DB::table('radiology_test_details')
    ->join('radiology_images','radiology_test_details.id', '=', 'radiology_images.radiology_td_id')
    ->select('radiology_test_details.appointment_id','radiology_test_details.id','radiology_images.image')
    ->where('radiology_images.id',$id)->first();
$appointment =$app->appointment_id;
$rtdid = $app->id;
$file= $app->image;

      $filename = public_path().'/'.$file;
      \File::delete($filename);
DB::table("radiology_images")->where('id', $id)->delete();


  return redirect()->action('PatientTestController2@xrayreports',[$rtdid]);
  }
  public function ultraupload(Request $request)
  {
  $cur_app =$request->cur_appointment_id;
  $appointment=$request->appointment_id;
  $rtdid =$request->rtdid;
  $u_id = Auth::user()->id;
  // $files = $request->image;
  $files = $request->file('image');

  if($files) {
     foreach ($files as $file) {
       // $file2 = Input::file('marige');
       $destinationPath = public_path().'/uploads/radilogy/';
       $filename2 = str_random(6).'_'.$file->getClientOriginalName();
       $uploadSuccess = $file->move($destinationPath, $filename2);
       $filename22 ='uploads/radilogy/'.$filename2;

DB::table('radiology_images')->insert([
         'user_id'=>$u_id,
         'radiology_td_id'=>$rtdid,
         'image'=>$filename22,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]);
}
}

DB::table('radiology_test_details')
   ->where('id',$rtdid)
   ->update([
   'appointment_id' => $cur_app,
   'done' => 1,
   'status'=> 1,
   'result_by'=>$u_id,
   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
 ]);
  return redirect()->action('PatientTestController2@ultrareports',[$rtdid]);
  }

  public function Removeultraupload($id)
  {

$app = DB::table('radiology_test_details')
    ->join('radiology_images','radiology_test_details.id', '=', 'radiology_images.radiology_td_id')
    ->select('radiology_test_details.appointment_id','radiology_test_details.id','radiology_images.image')
    ->where('radiology_images.id',$id)->first();
$appointment =$app->appointment_id;
$rtdid = $app->id;
$file= $app->image;

      $filename = public_path().'/'.$file;
      \File::delete($filename);
DB::table("radiology_images")->where('id', $id)->delete();


  return redirect()->action('PatientTestController2@ultrareports',[$rtdid]);
  }

  public function labupload(Request $request)
  {
  $appointment=$request->appointment_id;
  $ptdid =$request->ptdid;
  $u_id = Auth::user()->id;
  // $files = $request->image;
  $files = $request->file('image');
  $cur_app =$request->cur_appointment_id;

  if($files) {
     foreach ($files as $file) {
       // $file2 = Input::file('marige');
       $destinationPath = public_path().'/uploads/lab/';
       $filename2 = str_random(6).'_'.$file->getClientOriginalName();
       $uploadSuccess = $file->move($destinationPath, $filename2);
       $filename22 ='uploads/lab/'.$filename2;

DB::table('lab_images')->insert([
         'user_id'=>$u_id,
         'patient_td_id'=>$ptdid,
         'image'=>$filename22,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]);
}
}

DB::table('patient_test_details')
   ->where('id',$ptdid)
   ->update([
    'appointment_id'=> $cur_app,
   'done' => 1,
   'status'=> 1,
   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
 ]);
 return redirect()->action('PatientTestController2@labtestReport',[$ptdid]);
  }

  public function Removelabupload($id)
  {

$app = DB::table('patient_test_details')
    ->join('lab_images','patient_test_details.id', '=', 'lab_images.patient_td_id')
    ->select('patient_test_details.appointment_id','patient_test_details.id','lab_images.image')
    ->where('lab_images.id',$id)->first();
$appointment =$app->appointment_id;
$ptdid = $app->id;
$file= $app->image;

      $filename = public_path().'/'.$file;
      \File::delete($filename);

DB::table("lab_images")->where('id', $id)->delete();


return redirect()->action('PatientTestController2@labtestReport',[$ptdid]);
  }

  public function cardiacReport($id)
  {
  $tsts1 = DB::table('patient_test_details_c')
  ->Join('tests_cardiac', 'patient_test_details_c.tests_reccommended', '=', 'tests_cardiac.id')
  ->Join('appointments', 'patient_test_details_c.appointment_id', '=', 'appointments.id')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->select('patient_test_details_c.*','tests_cardiac.name','facilities.FacilityName','doctors.name as docname')
  ->where('patient_test_details_c.id', '=',$id)
  ->first();

  $patientD=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.id as afya_id','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
  'facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$tsts1->appointment_id)
  ->first();

  $cur_app=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->select('appointments.id')
  ->where('appointments.afya_user_id',$patientD->afya_id)
  ->orderBy('appointments.id','desc')
  ->first();

  return view('doctor.tests.reportcardiac')->with('tsts1',$tsts1)->with('patientD',$patientD)->with('cur_app',$cur_app);
  }
  public function cardiacResult(Request $request)
  {
  $cur_app =$request->cur_appointment_id;
  $appointment=$request->appointment_id;
  $rtdid =$request->rtdid;
  $notes =$request->note;
  $u_id = Auth::user()->id;
  if ($notes)  {

  DB::table('patient_test_details_c')
        ->where('id',$rtdid)
        ->update([
        'appointment_id' => $cur_app,
        'results' => $notes,
        'done' => 1,
        'status'=> 1,
        'result_by'=>$u_id,
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
      ]);
  }
  return redirect()->action('PatientTestController2@cardiacReport',[$rtdid]);
  }
  public function cardiacupload(Request $request)
  {
  $cur_app =$request->cur_appointment_id;
  $appointment=$request->appointment_id;
  $rtdid =$request->rtdid;
  $u_id = Auth::user()->id;
  // $files = $request->image;
  $files = $request->file('image');

  if($files) {
     foreach ($files as $file) {
       // $file2 = Input::file('marige');
       $destinationPath = public_path().'/uploads/cardiac/';
       $filename2 = str_random(6).'_'.$file->getClientOriginalName();
       $uploadSuccess = $file->move($destinationPath, $filename2);
       $filename22 ='uploads/cardiac/'.$filename2;

  DB::table('cardiac_images')->insert([
         'user_id'=>$u_id,
         'cardiac_td_id'=>$rtdid,
         'image'=>$filename22,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]);
  }
  }

  DB::table('patient_test_details_c')
   ->where('id',$rtdid)
   ->update([
  'appointment_id' =>$cur_app,
   'done' => 1,
   'status'=> 1,
   'result_by'=>$u_id,
   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
  return redirect()->action('PatientTestController2@cardiacReport',[$rtdid]);
  }
  public function neurologyReport($id)
  {
  $tsts1 = DB::table('patient_test_details_n')
  ->Join('tests_neurology', 'patient_test_details_n.tests_reccommended', '=', 'tests_neurology.id')
  ->Join('appointments', 'patient_test_details_n.appointment_id', '=', 'appointments.id')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->select('patient_test_details_n.*','tests_neurology.name','facilities.FacilityName','doctors.name as docname')
  ->where('patient_test_details_n.id', '=',$id)
  ->first();

  $patientD=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.id as afya_id','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
  'facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$tsts1->appointment_id)
  ->first();

  $cur_app=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->select('appointments.id')
  ->where('appointments.afya_user_id',$patientD->afya_id)
  ->orderBy('appointments.id','desc')
  ->first();

return view('doctor.tests.reportneurology')->with('tsts1',$tsts1)->with('patientD',$patientD)->with('cur_app',$cur_app);
  }
  public function neurologyResult(Request $request)
  {
  $cur_app =$request->cur_appointment_id;
  $appointment=$request->appointment_id;
  $rtdid =$request->rtdid;
  $notes =$request->note;
  $u_id = Auth::user()->id;
  if ($notes)  {
  DB::table('patient_test_details_n')
        ->where('id',$rtdid)
        ->update([
        'appointment_id' =>$cur_app,
        'results' => $notes,
        'done' => 1,
        'status'=> 1,
        'result_by'=>$u_id,
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
      ]);
  }
  return redirect()->action('PatientTestController2@neurologyReport',[$rtdid]);
  }
  public function neurologyupload(Request $request)
  {
  $appointment=$request->cur_appointment_id;
  $rtdid =$request->rtdid;
  $u_id = Auth::user()->id;
  // $files = $request->image;
  $files = $request->file('image');

  if($files) {
     foreach ($files as $file) {
       // $file2 = Input::file('marige');
       $destinationPath = public_path().'/uploads/neurology/';
       $filename2 = str_random(6).'_'.$file->getClientOriginalName();
       $uploadSuccess = $file->move($destinationPath, $filename2);
       $filename22 ='uploads/neurology/'.$filename2;

  DB::table('neurology_images')->insert([
         'user_id'=>$u_id,
         'cardiac_td_id'=>$rtdid,
         'image'=>$filename22,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]);
  }
  }

  DB::table('patient_test_details_n')
   ->where('id',$rtdid)
   ->update([
   'appointment_id' =>$appointment,
   'done' => 1,
   'status'=> 1,
   'result_by'=>$u_id,
   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
  return redirect()->action('PatientTestController2@neurologyReport',[$rtdid]);
  }
  public function procedureReport($id)
  {
  $tsts1 = DB::table('patient_procedure_details')
  ->Join('procedures', 'patient_procedure_details.procedure_id', '=', 'procedures.id')
  ->Join('appointments', 'patient_procedure_details.appointment_id', '=', 'appointments.id')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->select('patient_procedure_details.*','procedures.name','facilities.FacilityName','doctors.name as docname')
  ->where('patient_procedure_details.id', '=',$id)
  ->first();

  $patientD=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.id as afya_id','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
  'facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$tsts1->appointment_id)
  ->first();
  $cur_app=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->select('appointments.id')
  ->where('appointments.afya_user_id',$patientD->afya_id)
  ->orderBy('appointments.id','desc')
  ->first();

  return view('doctor.tests.reportprocedure')->with('tsts1',$tsts1)->with('patientD',$patientD)->with('cur_app',$cur_app);
  }
  public function procedureResult(Request $request)
  {
    $cur_app =$request->cur_appointment_id;
  $appointment=$request->appointment_id;
  $rtdid =$request->rtdid;
  $notes =$request->note;
  $u_id = Auth::user()->id;
  if ($notes)  {
  DB::table('patient_procedure_details')
        ->where('id',$rtdid)
        ->update([
        'appointment_id' =>$cur_app,
        'results' => $notes,
        'done' => 1,
        'status'=> 1,
        'result_by'=>$u_id,
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
      ]);
  }
  return redirect()->action('PatientTestController2@procedureReport',[$rtdid]);
  }
  public function procedureupload(Request $request)
  {
  $appointment=$request->cur_appointment_id;
  $rtdid =$request->rtdid;
  $u_id = Auth::user()->id;
  // $files = $request->image;
  $files = $request->file('image');

  if($files) {
     foreach ($files as $file) {
       // $file2 = Input::file('marige');
       $destinationPath = public_path().'/uploads/procedure/';
       $filename2 = str_random(6).'_'.$file->getClientOriginalName();
       $uploadSuccess = $file->move($destinationPath, $filename2);
       $filename22 ='uploads/procedure/'.$filename2;

  DB::table('procedure_images')->insert([
         'user_id'=>$u_id,
         'procedure_td_id'=>$rtdid,
         'image'=>$filename22,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]);
  }
  }

  DB::table('patient_procedure_details')
   ->where('id',$rtdid)
   ->update([
  'appointment_id' =>$appointment,
   'done' => 1,
   'status'=> 1,
   'result_by'=>$u_id,
   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
  return redirect()->action('PatientTestController2@procedureReport',[$rtdid]);
  }
}
