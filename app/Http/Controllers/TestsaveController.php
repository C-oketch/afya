<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Patienttest;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;

class TestsaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function generalExamination(Request $request)
    {
            $appointment=$request->appointment_id;
            $g_examination=$request->g_examination;
            $cvs =$request->cvs;
            $rs=$request->rs;
            $pa=$request->pa;
            $cns=$request->cns;
            $mss=$request->mss;
            $peripheries=$request->peripheries;

$now = Carbon::now();
$ge = DB::table('general_examination')->where('appointment_id',$appointment)->first();
if($ge){

        $patienttd = DB::table('general_examination')->where('appointment_id',$appointment)->update([
                 'g_examination' => $g_examination,
                 'cvs' => $cvs,
                 'rs' => $rs,
                 'pa' => $pa,
                 'cns' => $cns,
                 'mss' => $mss,
                 'peripheries' => $peripheries,
                 'updated_at' => $now,
              ]);
}else{

        $patienttd = DB::table('general_examination')->insert([
                 'appointment_id' => $appointment,
                 'g_examination' => $g_examination,
                 'cvs' => $cvs,
                 'rs' => $rs,
                 'pa' => $pa,
                 'cns' => $cns,
                 'mss' => $mss,
                 'peripheries' => $peripheries,
                 'created_at' => $now,
                 'updated_at' => $now,
              ]);
}

    return redirect()->action('PatientController@impression', ['id' =>  $appointment]);
}



  public function imagingPost(Request $request)
      {
$now = Carbon::now();
          $appointment=$request->appointment;
          $test=$request->test;
          $clinical=$request->clinical;
          $cat_id=$request->cat_id;
          $target=$request->target;

$pttids= Patienttest::where('appointment_id',$appointment)
        ->first();
if (is_null($pttids)) {
      $PatientTest = Patienttest ::create([
        'appointment_id' => $appointment,
        'test_status' => 0,
        'created_at' =>$now,
        'updated_at' => $now,
      ]);
          $ptid = $PatientTest->id;
           } else {
           // Already test exist - just get the id
            $ptid =$pttids->id;
            DB::table('patient_test')->where('id', $ptid)
            ->update(['test_status' => 0,]);
           }

     DB::table('appointments')->where('id', $appointment)
           ->update(['status' => 1,'p_status' => 11,]);
$Uid1 = Auth::user()->id;
$now = Carbon::now();
$imagingId = DB::table('radiology_test_details')->insertGetId([
                       'patient_test_id' => $ptid,
                       'appointment_id' => $appointment,
                       'clinicalinfo' => $clinical,
                       'test_cat_id' => $cat_id,
                       'target' => $target,
                       'test' => $test,
                       'done' => 0,
                       'user_id' =>$Uid1,
                       'confirm' => 'N',
                       'created_at' => $now,
                    ]);
      // $afyaId = DB::table("appointments")->where('id',$appointment)->select('afya_user_id')->first();
return redirect()->action('privateController@showUsertest',[$appointment]);
  }

  public function Radremove(Request $request)
  {
    $now = Carbon::now();
    $test=$request->test;
    $cat_id=$request->cat_id;
    $appointment =$request->appointment;
    $id1 = Auth::user()->id;
    DB::table("radiology_test_details")->where('id',$test)
    ->update(['deleted' => 1,'deleted_by' =>$id1,'updated_at' =>$now,]);



return redirect()->action('privateController@showUsertest',[$appointment]);

}
public function labremove(Request $request)
{
  $now = Carbon::now();
  $test=$request->ptd_id;
  $appointment =$request->appointment_id;
  $id1 = Auth::user()->id;

  DB::table("patient_test_details")->where('id',$test)
  ->update(['deleted' => 1,'deleted_by' =>$id1,'updated_at' =>$now,]);

  // $afyaId = DB::table("appointments")->where('id',$appointment)->select('afya_user_id')->first();
return redirect()->action('privateController@showUsertest',[$appointment]);

}



public function radiologytests(Request $request)
{


    $test=$request->test;
    $patient_test_id=$request->ptid;
    $clinical=$request->clinical;
    $cat_id=$request->cat_id;
    $target=$request->target;
    $dep=$request->dependant;
    $afya=$request->afya_user;



$pttids= Patienttest::where('id',$patient_test_id)
  ->first();
if (is_null($pttids)) {
$PatientTest = Patienttest ::create([
  'test_status' => 0,
  'afya_user_id' =>$afya,
  'dependant_id'=>$dep,

]);
    $ptid = $PatientTest->id;
     } else {
     // Already test exist - just get the id
      $ptid =$pttids->id;
      DB::table('patient_test')->where('id', $ptid)
      ->update(['test_status' => 0,]);
     }


$now = Carbon::now();
$imaging = DB::table('radiology_test_details')->insert([
                 'patient_test_id' => $ptid,
                 'clinicalinfo' => $clinical,
                 'test_cat_id' => $cat_id,
                 'target' => $target,
                 'test' => $test,
                 'done' => 0,
                 'confirm' => 'N',
                 'created_at' => $now,
              ]);
if($cat_id==9){
$data = DB::table('ct_scan')->Where('id',$test)->first();
}elseif($cat_id==11){
$data = DB::table('mri_tests')->Where('id',$test)->first();
}elseif($cat_id==12){
$data = DB::table('ultrasound')->Where('id',$test)->first();
}elseif($cat_id==10){
$data = DB::table('xray')->Where('id',$test)->first();
}
return response()->json($data);
}

public function storeRegLab(Request $request)
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
return redirect()->action('privateController@showUsertest',[$appointment]);
  }


  public function patientreview(Request $request)
{
      $appointment=$request->appointment_id;
      $note=$request->rev_note;

$now = Carbon::now();
$pr = DB::table('patient_review')->where([['appointment_id',$appointment]])->first();
if($pr){
$prid=$pr->id;
  $patienttd = DB::table('patient_review')->where('id',$prid)->update([
           'notes' => $note,
           'updated_at' => $now,
        ]);
}else{

  $patienttd = DB::table('patient_review')->insert([
           'appointment_id' => $appointment,
            'notes' => $note,
            'created_at' => $now,
           'updated_at' => $now,
        ]);
}

return redirect()->action('PatientController@patreview', ['id' =>  $appointment]);
}
}
