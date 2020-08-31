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
     ->update(['status' => 1,'p_status' => 11,]);

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
