<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Patienttest;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;
use App\Smokinghistory;
use App\Alcoholhistory;
class TestsaveDocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function store(Request $request)
     {

          $appointment=$request->appointment_id;
          $test_id=$request->test_id;
          $docnote=$request->docnote;

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


     return redirect()->action('PatientTestController@testdata', ['id' =>  $appointment]);

           }
           public function destroytest($id)
           {
             $pttd=DB::table('patient_test_details')
             ->where('id',$id)
             ->first();

             DB::table("patient_test_details")->where('id',$id)->update(array('deleted'=>1));

       return redirect()->action('PatientTestController@testdata', ['id' => $pttd->appointment_id]);

       }




public function otherimagingPost(Request $request)
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
     ->update(['p_status' => 11,]);
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
return redirect()->action('PatientTestController@testesImage',[$appointment]);

}

public function Otherremove(Request $request)
{
  $now = Carbon::now();
  $test=$request->test;
  $cat_id=$request->cat_id;
  $appointment =$request->appointment;
  $id1 = Auth::user()->id;
  DB::table("radiology_test_details")->where('id',$test)
  ->update(['deleted' => 1,'deleted_by' =>$id1,'updated_at' =>$now,]);
  return redirect()->action('PatientTestController@testesImage',[$appointment]);

}


public function mriPost(Request $request)
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
->update(['p_status' => 11,]);
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
return redirect()->action('PatientTestController@testdatamri',[$appointment]);

}

public function mriTestremove(Request $request)
{
$now = Carbon::now();
$test=$request->test;
$cat_id=$request->cat_id;
$appointment =$request->appointment;
$id1 = Auth::user()->id;
DB::table("radiology_test_details")->where('id',$test)
->update(['deleted' => 1,'deleted_by' =>$id1,'updated_at' =>$now,]);
return redirect()->action('PatientTestController@testdatamri',[$appointment]);

}




public function ctTest(Request $request)
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
->update(['p_status' => 11,]);
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
return redirect()->action('PatientTestController@testsImaging',[$appointment]);

}

public function ctTestremove(Request $request)
{
$now = Carbon::now();
$test=$request->test;
$cat_id=$request->cat_id;
$appointment =$request->appointment;
$id1 = Auth::user()->id;
DB::table("radiology_test_details")->where('id',$test)
->update(['deleted' => 1,'deleted_by' =>$id1,'updated_at' =>$now,]);

return redirect()->action('PatientTestController@testsImaging',[$appointment]);

}


public function ultraTest(Request $request)
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
->update(['p_status' => 11,]);
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
return redirect()->action('PatientTestController@testdataultra',[$appointment]);

}

public function ultraTestremove(Request $request)
{
$now = Carbon::now();
$test=$request->test;
$cat_id=$request->cat_id;
$appointment =$request->appointment;
$id1 = Auth::user()->id;
DB::table("radiology_test_details")->where('id',$test)
->update(['deleted' => 1,'deleted_by' =>$id1,'updated_at' =>$now,]);

return redirect()->action('PatientTestController@testdataultra',[$appointment]);

}


public function xrayTest(Request $request)
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
->update(['p_status' => 11,]);
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
return redirect()->action('PatientTestController@testdataxray',[$appointment]);

}

public function xrayTestremove(Request $request)
{
$now = Carbon::now();
$test=$request->test;
$cat_id=$request->cat_id;
$appointment =$request->appointment;
$id1 = Auth::user()->id;
DB::table("radiology_test_details")->where('id',$test)
->update(['deleted' => 1,'deleted_by' =>$id1,'updated_at' =>$now,]);

return redirect()->action('PatientTestController@testdataxray',[$appointment]);

}

public function imagingdestroytest($id)
{
$pttd=DB::table('radiology_test_details')
->where('id',$id)
->first();
DB::table("radiology_test_details")->where('id',$id)
->update(['deleted' =>1]);
return redirect()->action('PatientTestController@test_all', ['id' => $pttd->appointment_id]);
}

public function summPatients(Request $request)
{
  $appointment=$request->appointment_id;
  $afya_user_id =$request->afya_user_id;
  $doc_note =$request->complaints;
  $father =$request->father;
  $mother =$request->mother;
  $brother =$request->brother;
  $sister =$request->sister;
$userId = Auth::user()->id;
  $now = Carbon::now();
       if($doc_note){
         $psummary = DB::table('patient_summary')->where('appointment_id',$appointment)->first();
       if($psummary){
          DB::table('patient_summary')->where('appointment_id',$appointment)->update([
            'notes' => $doc_note,
            'updated_at' => $now,
         ]);
       }else{
        $patienttd = DB::table('patient_summary')->insert([
                 'appointment_id' => $appointment,
                 'notes' => $doc_note,
                 'created_at' => $now,
                 'updated_at' => $now,
              ]);
             }
           }
           if($father){
             $fsummary = DB::table('family_summary')->where([['afya_user_id',$afya_user_id],['family_members','=',"Father"]])->first();
           if($fsummary){
              DB::table('family_summary')->where([['afya_user_id',$afya_user_id],['family_members','=',"Father"]])
              ->update([
                'notes' => $father,
                'user_id' => $userId,
                'updated_at' => $now,    ]);
           }else{
            $patienttd = DB::table('family_summary')->insert([
                     'appointment_id' => $appointment,
                     'afya_user_id' => $afya_user_id,
                     'user_id' => $userId,
                     'family_members' => "Father",
                     'notes' => $father,
                     'created_at' => $now,
                     'updated_at' => $now,
                  ]);
                 }
               }

               if($mother){
                 $msummary = DB::table('family_summary')->where([['afya_user_id',$afya_user_id],['family_members','=',"Mother"]])->first();
               if($msummary){
                  DB::table('family_summary')->where([['afya_user_id',$afya_user_id],['family_members','=',"Mother"]])
                  ->update([
                    'notes' => $mother,
                    'user_id' => $userId,
                    'updated_at' => $now,    ]);
               }else{
                $patienttd = DB::table('family_summary')->insert([
                         'appointment_id' => $appointment,
                         'afya_user_id' => $afya_user_id,
                         'user_id' => $userId,
                         'family_members' => "Mother",
                         'notes' => $mother,
                         'created_at' => $now,
                         'updated_at' => $now,
                      ]);
                     }
                   }


                   if($brother){
                     $bsummary = DB::table('family_summary')->where([['afya_user_id',$afya_user_id],['family_members','=',"Brother"]])->first();
                   if($bsummary){
                      DB::table('family_summary')->where([['afya_user_id',$afya_user_id],['family_members','=',"Brother"]])
                      ->update([
                        'notes' => $brother,
                        'user_id' => $userId,
                        'updated_at' => $now,    ]);
                   }else{
                    $patienttd = DB::table('family_summary')->insert([
                             'appointment_id' => $appointment,
                             'afya_user_id' => $afya_user_id,
                             'user_id' => $userId,
                             'family_members' => "Brother",
                             'notes' => $brother,
                             'created_at' => $now,
                             'updated_at' => $now,
                          ]);
                         }
                       }


                       if($sister){
                         $ssummary = DB::table('family_summary')->where([['afya_user_id',$afya_user_id],['family_members','=',"Sister"]])->first();
                       if($ssummary){
                          DB::table('family_summary')->where([['afya_user_id',$afya_user_id],['family_members','=',"Sister"]])
                          ->update([
                            'notes' => $sister,
                            'user_id' => $userId,
                            'updated_at' => $now,    ]);
                       }else{
                        $patienttd = DB::table('family_summary')->insert([
                                 'appointment_id' => $appointment,
                                 'afya_user_id' => $afya_user_id,
                                 'user_id' => $userId,
                                 'family_members' => "Sister",
                                 'notes' => $sister,
                                 'created_at' => $now,
                                 'updated_at' => $now,
                              ]);
                             }
                           }



                 $drug1 = $request->drugs1;
                 if($drug1){
                 DB::table('current_medication')->insert([
                 'appointment_id' => $appointment,
                 'drugs' => $drug1,
                 'user_id' => $userId,
                 'created_at' => $now,
                 'updated_at' => $now,
                 ]);
                 }
                 $drug2 = $request->drugs2;
                 if($drug2){
                 DB::table('current_medication')->insert([
                 'appointment_id' => $appointment,
                 'drugs' => $drug2,
                 'user_id' => $userId,
                 'created_at' => $now,
                 'updated_at' => $now,
                 ]);
                 }

                 $drug3 = $request->drugs3;
                 if($drug3){
                 DB::table('current_medication')->insert([
                 'appointment_id' => $appointment,
                 'drugs' => $drug3,
                 'user_id' => $userId,
                 'created_at' => $now,
                 'updated_at' => $now,
                 ]);
                 }

                 $drug4 = $request->drugs4;
                 if($drug4){
                 DB::table('current_medication')->insert([
                 'appointment_id' => $appointment,
                 'drugs' => $drug4,
                 'user_id' => $userId,
                 'created_at' => $now,
                 'updated_at' => $now,
                 ]);
                 }

                 $drug5 = $request->drugs5;
                 if($drug5){
                 DB::table('current_medication')->insert([
                 'appointment_id' => $appointment,
                 'drugs' => $drug5,
                 'user_id' => $userId,
                 'created_at' => $now,
                 'updated_at' => $now,
                 ]);
                 }

$name1 = $request->name1;
if($name1){
  DB::table('patient_diagnosis')->insert([
             'appointment_id' => $appointment,
             'afya_user_id' => $afya_user_id,
             'state' =>2,
             'disease_id' => $name1,
             'created_at' => $now,
             'updated_at' => $now,
          ]);
    }
    $name2 = $request->name2;
    if($name2){
      DB::table('patient_diagnosis')->insert([
                 'appointment_id' => $appointment,
                 'afya_user_id' => $afya_user_id,
                 'state' =>2,
                 'disease_id' => $name2,
                 'created_at' => $now,
                 'updated_at' => $now,
              ]);
        }
  $name3 = $request->name3;
  if($name3){
    DB::table('patient_diagnosis')->insert([
               'appointment_id' => $appointment,
               'afya_user_id' => $afya_user_id,
               'state' =>2,
               'disease_id' => $name3,
               'created_at' => $now,
               'updated_at' => $now,
            ]);
      }
      $name4 = $request->name4;
      if($name4){
        DB::table('patient_diagnosis')->insert([
                   'appointment_id' => $appointment,
                   'afya_user_id' => $afya_user_id,
                   'state' =>2,
                   'disease_id' => $name4,
                   'created_at' => $now,
                   'updated_at' => $now,
                ]);
          }
      $name5 = $request->name5;
      if($name5){
        DB::table('patient_diagnosis')->insert([
                   'appointment_id' => $appointment,
                   'afya_user_id' => $afya_user_id,
                   'state' =>2,
                   'disease_id' => $name5,
                   'created_at' => $now,
                   'updated_at' => $now,
                ]);
          }


          $allergies1 = $request->allergies1;
          $status1 = $request->status1;
          if($allergies1){
            DB::table('afya_users_allergy')->insert([
                     'appointment_id' => $appointment,
                      'afya_user_id' => $afya_user_id,
                       'allergies' => $allergies1,
                       'status' => $status1,
                       'created_at' => $now,
                       'updated_at' => $now,
                    ]);
              }
              $allergies2 = $request->allergies2;
              $status2 = $request->status2;
              if($allergies2){
                DB::table('afya_users_allergy')->insert([
                           'afya_user_id' => $afya_user_id,
                           'appointment_id' => $appointment,
                           'allergies' => $allergies2,
                           'status' => $status2,
                           'created_at' => $now,
                           'updated_at' => $now,
                        ]);
                  }
                  $allergies3 = $request->allergies3;
                  $status3 = $request->status3;
                  if($allergies3){
                    DB::table('afya_users_allergy')->insert([
                               'afya_user_id' => $afya_user_id,
                               'appointment_id' => $appointment,

                               'allergies' => $allergies3,
                               'status' => $status3,
                               'created_at' => $now,
                               'updated_at' => $now,
                            ]);
                    }
                    $allergies4 = $request->allergies4;
                    $status4 = $request->status4;
                    if($allergies4){
                      DB::table('afya_users_allergy')->insert([
                                 'afya_user_id' => $afya_user_id,
                                 'appointment_id' => $appointment,
                                 'allergies' => $allergies4,
                                 'status' => $status4,
                                 'created_at' => $now,
                                 'updated_at' => $now,
                              ]);
                      }

          $allergies5 = $request->allergies5;
          $status5 = $request->status5;
          if($allergies5){
            DB::table('afya_users_allergy')->insert([
                       'afya_user_id' => $afya_user_id,
                       'appointment_id' => $appointment,
                       'allergies' => $allergies5,
                       'status' => $status5,
                       'created_at' => $now,
                       'updated_at' => $now,
                    ]);
            }

$bowel =$request->bowel;
$bowel_details =$request->bowel_details;
$urinary =$request->urinary;
$urinary_details =$request->urinary_details;
$sleep =$request->sleep;
$sleep_details =$request->sleep_details;
$appetite =$request->appetite;
$appetite_details =$request->appetite_details;
$bowel_id =$request->bowel_id;
$urinary_id =$request->urinary_id;
$sleep_id =$request->sleep_id;
$appetite_id =$request->appetite_id;

if($bowel){
  if($bowel_id){
    DB::table('patient_systemic')->where('id',$bowel_id)->update([
      'systemic_id' => $bowel,
      'description' => $bowel_details,
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
  }else{

$bowl = DB::table('patient_systemic')->insert([
         'appointment_id' => $appointment,
         'systemic_id' => $bowel,
         'description' => $bowel_details,
         'created_at' => $now,
         'updated_at' => $now,   ]);
}
}
if($urinary){

  if($urinary_id){
    DB::table('patient_systemic')->where('id',$urinary_id)->update([
      'systemic_id' => $urinary,
      'description' => $urinary_details,
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
  }else{
$urin= DB::table('patient_systemic')->insert([
         'appointment_id' => $appointment,
         'systemic_id' => $urinary,
         'description' => $urinary_details,
         'created_at' => $now,
         'updated_at' => $now,   ]);
}
}
if($sleep){
  if($sleep_id){
    DB::table('patient_systemic')->where('id',$sleep_id)->update([
      'systemic_id' => $sleep,
      'description' => $sleep_details,
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
  }else{
$sleep= DB::table('patient_systemic')->insert([
         'appointment_id' => $appointment,
         'systemic_id' => $sleep,
         'description' => $sleep_details,
         'created_at' => $now,
         'updated_at' => $now,   ]);
}
}
if($appetite){
if($appetite_id){
  DB::table('patient_systemic')->where('id',$appetite_id)->update([
    'systemic_id' => $appetite,
    'description' => $appetite_details,
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
}else{
$appet = DB::table('patient_systemic')->insert([
         'appointment_id' => $appointment,
         'systemic_id' => $appetite,
         'description' => $appetite_details,
         'created_at' => $now,
         'updated_at' => $now,
       ]);
}
}



$smoking_id=$request->smoking_id;
$alcohol_id=$request->alcohol_id;

if($smoking_id) {
$smokinghistory=Smokinghistory::find($smoking_id);
$smokinghistory->update($request->all());
}else{     Smokinghistory::create($request->all());    }

if($alcohol_id) {
$alcoholhistory=Alcoholhistory::find($alcohol_id);
$alcoholhistory->update($request->all());

}else{ Alcoholhistory::create($request->all());  }

return redirect()->action('PatientController@examination', ['id' =>  $appointment]);
}

public function trgpost(Request $request)
{
  $appointment = $request->appointment_id;
  $id = $request->id;
  $weight = $request->weight;
  $heightS = $request->current_height;
  $temperature = $request->temperature;
  $systolic = $request->systolic;
  $diastolic = $request->diastolic;

  $lmp = $request->lmp;
  $rbs = $request->rbs;
  $hr = $request->hr;
  $rr = $request->rr;
  $pregnant = $request->pregnant;


$ptriage = DB::table('triage_details')->where('appointment_id',$appointment)->first();
if($ptriage){
  DB::table('triage_details')->where('appointment_id',$appointment)->update([
    'current_weight'=> $weight,
    'current_height'=>$heightS,
    'temperature'=>$temperature,
    'systolic_bp'=>$systolic,
    'diastolic_bp'=>$diastolic,
    'pregnant'=>$pregnant,
    'lmp'=>$lmp,
    'rbs'=>$rbs,
    'hr'=>$hr,
    'rr'=>$rr,
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);

}else{
                DB::table('triage_details')->insert([
                  'appointment_id' => $appointment,
                  'current_weight'=> $weight,
                  'current_height'=>$heightS,
                  'temperature'=>$temperature,
                  'systolic_bp'=>$systolic,
                  'diastolic_bp'=>$diastolic,
                  'pregnant'=>$pregnant,
                  'lmp'=>$lmp,
                  'rbs'=>$rbs,
                  'hr'=>$hr,
                  'rr'=>$rr,
                  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]

                );
              }

$gender = $request->gender;
if($gender == "Female"){
$parity = $request->parity;
$family_planning = $request->famplan;
$userId = Auth::user()->id;
$f_plan = DB::table('family_planning')->where('afya_user_id',$id)->first();
if($f_plan){
DB::table('family_planning')->where('afya_user_id',$id)->update([
'parity'=> $parity,
'family_planning'=>$family_planning,
'created_by' =>$userId,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]);

}else{
DB::table('family_planning')->insert([
  'afya_user_id'=> $id,
  'parity'=> $parity,
  'family_planning'=>$family_planning,
  'created_by' =>$userId,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]

);
}
}

                DB::table('appointments')->where('id',$appointment)->update([
                  'status'=>2,
                ]);


    return redirect()->action('PatientController@showpatient', ['id' =>  $appointment]);
  }

public function ImpressionSave(Request $request)
{
  $appointment=$request->appointment_id;

  $input = $request->members;
DB::table('impression')->insert($input);

return redirect()->action('PatientTestController@alltestdata', ['id' =>  $appointment]);
}

public function ImpressionEdit(Request $request)
{
$doc_note=$request->doc_note;
$impression_id=$request->impression_id;
$appid =$request->appointment_id;

$now = Carbon::now();

$patienttd = DB::table('impression')->where('id',$impression_id)->update([
'notes' => $doc_note,
'updated_at' => $now,
]);

     return redirect()->action('PatientController@impression', [$appid]);
 }

 public function diagnosisEdit(Request $request)
 {
 $diagnosis=$request->diagnosis;
 $diagnosis_id=$request->diagnosis_id;
 $appid =$request->appointment_id;

 $now = Carbon::now();

 $patienttd = DB::table('patient_diagnosis')->where('id',$diagnosis_id)->update([
 'disease_id' => $diagnosis,
 'updated_at' => $now,
 ]);

      return redirect()->action('PrescriptionController@Diagnosis', [$appid]);
  }





public function mrPatients(Request $request)
{

  $appointment=$request->appointment_id;
  $afya_user_id =$request->afya_user_id;
  $med =$request->current_med;
  $doc_note =$request->doc_note;
  $diagnosis =$request->diagnosis;
  $impression =$request->impression;
  $now = Carbon::now();
  $Uid1 = Auth::user()->id;
       if($doc_note){


        $patienttd = DB::table('patient_summary')->where('appointment_id', $appointment)
        ->update([
                 'notes' => $doc_note,
                 'user_id' => $Uid1,
                 'updated_at' => $now,
              ]);
             }
   if($med){
    $medds = DB::table('current_medication')->insert([
             'appointment_id' => $appointment,
             'drugs' => $med,
             'user_id' => $Uid1,
             'created_at' => $now,
             'updated_at' => $now,
          ]);
         }
         if($diagnosis){
          $medds = DB::table('patient_diagnosis')->insert([
                   'appointment_id' => $appointment,
                    'afya_user_id' => $afya_user_id,
                   'disease_id' => $diagnosis,
                   'date_diagnosed' => $now,
                   'created_at' => $now,
                   'updated_at' => $now,
                ]);
               }
// impression
if($impression){
 $imp = DB::table('impression')->insert([
          'appointment_id' => $appointment,
           'notes' => $impression,
          'created_at' => $now,
          'updated_at' => $now,
       ]);
      }
return redirect()->action('DoctorController@edithistory', ['id' =>  $appointment]);
}

public function mrPatients2(Request $request)
{

  $appointment=$request->appointment_id;
  $afya_user_id =$request->afya_user_id;
  $med =$request->current_med;
  $doc_note =$request->doc_note;
  $diagnosis =$request->diagnosis;
  $impression =$request->impression;
  $now = Carbon::now();
  $Uid1 = Auth::user()->id;
       if($doc_note){
         $patienttd = DB::table('patient_summary')->where('appointment_id', $appointment)
         ->update([
                  'notes' => $doc_note,
                  'user_id' => $Uid1,
                  'updated_at' => $now,
               ]);
              }

   if($med){
    $medds = DB::table('current_medication')->insert([
             'appointment_id' => $appointment,
             'drugs' => $med,
             'user_id' => $Uid1,
             'created_at' => $now,
             'updated_at' => $now,
          ]);
         }
         if($diagnosis){
          $medds = DB::table('patient_diagnosis')->insert([
                   'appointment_id' => $appointment,
                    'afya_user_id' => $afya_user_id,
                   'disease_id' => $diagnosis,
                   'date_diagnosed' => $now,
                   'created_at' => $now,
                   'updated_at' => $now,
                ]);
               }
// impression
if($impression){
 $imp = DB::table('impression')->insert([
          'appointment_id' => $appointment,
           'notes' => $impression,
          'created_at' => $now,
          'updated_at' => $now,
       ]);
      }
return redirect()->action('DoctorController@edithistory2', ['id' =>  $appointment]);
}
public function destroycardiac($id)
{
$pttd=DB::table('patient_test_details_c')
->where('id',$id)
->first();
DB::table("patient_test_details_c")->where('id',$id)
->update(['deleted' =>1]);
return redirect()->action('PatientTestController@test_all', ['id' => $pttd->appointment_id]);
}
public function destroyneurology($id)
{
$pttd=DB::table('patient_test_details_n')
->where('id',$id)
->first();
DB::table("patient_test_details_n")->where('id',$id)
->update(['deleted' =>1]);
return redirect()->action('PatientTestController@test_all', ['id' => $pttd->appointment_id]);
}
public function destroyprocedure($id)
{
$pttd=DB::table('patient_procedure_details')
->where('id',$id)
->first();
DB::table("patient_procedure_details")->where('id',$id)
->update(['deleted' =>1]);
return redirect()->action('PatientTestController@test_all', ['id' => $pttd->appointment_id]);
}



}
