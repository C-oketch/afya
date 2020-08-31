<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Patient;
use App\Druglist;
use App\Test;
use App\TestDetails;
use App\Document;
use Carbon\Carbon;
use Auth;

class TestController2 extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

public function fileUpload(Request $request) {
  $now = Carbon::now();
    $this->validate($request, [
        'image' => 'required',
        'radiology_td_id' => 'required',

    ]);
    $ptid=$request->patient_test_id;
    $id=$request->radiology_td_id;
    $user_id=$request->user_id;

    $document = new Document($request->input()) ;

     if($file = $request->hasFile('image')) {

        $files = $request->file('image') ;
        foreach ($files as $file) {


        $fileName = $file->getClientOriginalName() ;
        $destinationPath = public_path().'/images/' ;
        $file->move($destinationPath,$fileName);

        DB::table('radiology_images')->insert(['radiology_td_id'=>$id,
            'image'=>$fileName,
            'user_id'=>$user_id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);

    }
    }
    DB::table('radiology_test_details')
                     ->where('id',$id)
                     ->update(['done'  =>1,
                      'updated_at'  => $now,
                    ]);


return redirect()->action('TestController@radydetails', ['id' => $ptid]);
  }

  public function fileUploads(Request $request) {
    $now = Carbon::now();
    $this->validate($request, [
        'image' => 'required',
        'radiology_td_id' => 'required',

    ]);
    $ptid=$request->patient_test_id;
    $id=$request->radiology_td_id;
    $user_id=$request->user_id;

    $document = new Document($request->input()) ;

     if($file = $request->hasFile('image')) {

        $files = $request->file('image') ;
        foreach ($files as $file) {


        $fileName = $file->getClientOriginalName() ;
        $destinationPath = public_path().'/images/' ;
        $file->move($destinationPath,$fileName);

        DB::table('radiology_images')->insert([
            'radiology_td_id'=>$id,
            'image'=>$fileName,
            'user_id'=>$user_id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);

    }
    }
    DB::table('radiology_test_details')
                     ->where('id',$id)
                     ->update(['done'  =>1,
                      'updated_at'  => $now,
                    ]);

return redirect()->action('TestController@radydetails', ['id' => $ptid]);

  }
  public function fileUploade(Request $request) {
    $now = Carbon::now();
    $this->validate($request, [
        'image' => 'required',
        'radiology_td_id' => 'required',

    ]);
    $ptid=$request->patient_test_id;
    $id=$request->radiology_td_id;
    $user_id=$request->user_id;

    $document = new Document($request->input()) ;

     if($file = $request->hasFile('image')) {

        $files = $request->file('image') ;
        foreach ($files as $file) {


        $fileName = $file->getClientOriginalName() ;
        $destinationPath = public_path().'/images/' ;
        $file->move($destinationPath,$fileName);

        DB::table('radiology_images')->insert(['radiology_td_id'=>$id,
            'image'=>$fileName,
            'user_id'=>$user_id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);

    }
    }
    DB::table('radiology_test_details')
                     ->where('id',$id)
                     ->update(['done'  =>1,
                      'updated_at'  => $now,
                    ]);
return redirect()->action('TestController@radydetails', ['id' => $ptid]);

  }

   public function fileUploady(Request $request) {
     $now = Carbon::now();
    $this->validate($request, [
        'image' => 'required',
        'radiology_td_id' => 'required',
]);
    $ptid=$request->patient_test_id;
    $id=$request->radiology_td_id;
    $user_id=$request->user_id;
    $document = new Document($request->input()) ;

     if($file = $request->hasFile('image')) {

        $files = $request->file('image') ;

        foreach ($files as $file) {


        $fileName = $file->getClientOriginalName() ;
        $destinationPath = public_path().'/images/' ;
        $file->move($destinationPath,$fileName);
  DB::table('radiology_images')->insert(['radiology_td_id'=>$id,
            'image'=>$fileName,
            'user_id'=>$user_id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);

    }
    }
    DB::table('radiology_test_details')
                     ->where('id',$id)
                     ->update(['done'  =>1,
                      'updated_at'  => $now,
                    ]);
return redirect()->action('TestController@radydetails', ['id' => $ptid]);

  }




    public function xrayfindings(Request $request)
    {
    $now = Carbon::now();

      $findingsId =$request->findingsId;
      $r_td_id =$request->radiology_td_id;
      $result =$request->result;
$findingsRslt = DB::table('radiology_test_result')->insert([
           'radiology_td_id' => $r_td_id,
           'findings_id' => $findingsId,
           'results' => $result,
           'created_at' => $now,
                   ]);
return redirect()->action('TestController@grapherxray', ['id' => $r_td_id]);
}
public function mrifindings(Request $request)
{
$now = Carbon::now();

  $findingsId =$request->findingsId;
  $r_td_id =$request->radiology_td_id;
  $result =$request->result;
$findingsRslt = DB::table('radiology_test_result')->insert([
       'radiology_td_id' => $r_td_id,
       'findings_id' => $findingsId,
       'results' => $result,
       'created_at' => $now,
               ]);
return redirect()->action('TestController@graphermri', ['id' => $r_td_id]);
}
public function ultrafindings(Request $request)
{
$now = Carbon::now();

  $findingsId =$request->findingsId;
  $r_td_id =$request->radiology_td_id;
  $result =$request->result;
$findingsRslt = DB::table('radiology_test_result')->insert([
       'radiology_td_id' => $r_td_id,
       'findings_id' => $findingsId,
       'results' => $result,
       'created_at' => $now,
               ]);
return redirect()->action('TestController@grapherultra', ['id' => $r_td_id]);
}
public function ctfindings(Request $request)
{
$now = Carbon::now();

  $findingsId =$request->findingsId;
  $r_td_id =$request->radiology_td_id;
  $result =$request->result;
$findingsRslt = DB::table('radiology_test_result')->insert([
       'radiology_td_id' => $r_td_id,
       'findings_id' => $findingsId,
       'results' => $result,
       'created_at' => $now,
               ]);
return redirect()->action('TestController@grapherct', ['id' => $r_td_id]);
}



public function imagingreports(Request $request)
{
$now = Carbon::now();
  $user_id =$request->user_id;
  $technique =$request->technique;
  $r_td_id =$request->radiology_td_id;
  $impression =$request->impression;
  $ptid =$request->patient_test_id;
  $afya_user_id =$request->afya_user_id;
DB::table('radiology_test_details')
                 ->where('id',$r_td_id)
                 ->update(['done'  =>2,
                  'technique'  => $technique,
                  'conclusion'  => $impression,
                  'user_id'=>$user_id,
                  'created_at'  => $now,
                  'updated_at'  => $now,
     ]);

     $query11 = DB::table('radiology_test_details')
              ->where([['patient_test_id', '=', $ptid], ['done','!=',2],])
               ->first();

if (is_null($query11)) {


$afyamessageId = DB::table('afya_users')
->Join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
->select('afyamessages.id')
->where('afya_users.id', '=',$afya_user_id)
->whereNull('afyamessages.status')
->first();

$afsmsId=$afyamessageId->id;
DB::table('afyamessages')
                 ->where('id',$afsmsId)
                 ->update(['status'  =>1,
                  'updated_at'  => $now,   ]);

return redirect()->action('TestController@index');

}else{
  return redirect()->action('TestController@radydetails', ['id' => $ptid]);

}


}

public function donexray($id)
{
  $tsts1 = DB::table('radiology_test_details')
  ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
  ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
  ->Join('xray', 'radiology_test_details.test', '=', 'xray.id')
  ->select('appointments.*','appointments.persontreated','test_categories.name as category',
  'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
  'xray.name as tstname','xray.technique','xray.id as xrayid')
  ->where('radiology_test_details.id', '=',$id)
  ->first();
  return view('test.donexray')->with('tsts1',$tsts1)->with('id',$id);
}

public function donect($id)
{
  $tsts1 = DB::table('radiology_test_details')
           ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
          ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
          ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
           ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
          ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
          ->Join('ct_scan', 'radiology_test_details.test', '=', 'ct_scan.id')
       ->select('appointments.*','appointments.persontreated','test_categories.name as category',
          'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
          'ct_scan.name as tstname','ct_scan.technique','ct_scan.id as ctid')
           ->where('radiology_test_details.id', '=',$id)
           ->first();
return view('test.donect')->with('tsts1',$tsts1)->with('id',$id);
}

public function donemri($id)
{
  $tsts1 = DB::table('radiology_test_details')
           ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
          ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
          ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
           ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
          ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
          ->Join('mri_tests', 'radiology_test_details.test', '=', 'mri_tests.id')
       ->select('appointments.*','appointments.persontreated','test_categories.name as category',
          'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
          'mri_tests.name as tstname','mri_tests.technique','mri_tests.id as mriid')
           ->where('radiology_test_details.id', '=',$id)
           ->first();
return view('test.donemri')->with('tsts1',$tsts1)->with('id',$id);
}

public function doneultra($id)
{
  $tsts1 = DB::table('radiology_test_details')
           ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
          ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
          ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
           ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
          ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
          ->Join('ultrasound', 'radiology_test_details.test', '=', 'ultrasound.id')
       ->select('appointments.*','appointments.persontreated','test_categories.name as category',
          'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
          'ultrasound.name as tstname','ultrasound.technique','ultrasound.id as ultraid')
           ->where('radiology_test_details.id', '=',$id)
           ->first();
return view('test.doneultra')->with('tsts1',$tsts1)->with('id',$id);
}
//ADD Patient Procedures
public function payment(Request $request)
  {

    $testId=$request->testId;
    $amount=$request->amount;
    $mode=$request->paym;
    $ptid=$request->ptid;


  $proc = DB::table('payments')->insert([
         'patient_test_id'=>$ptid,
         'lab_id'=>$testId,
         'amount'=>$amount,
         'mode'=>$mode,
         'status'=>1,
         ]);
     return redirect()->action('TestController@labinvoices', ['id' => $ptid]);

  }

    public function radypayment(Request $request)
      {

        $testId=$request->testId;
        $appId=$request->appId;
        $amount=$request->amount;
        $mode=$request->mode;
        $ptid=$request->ptid;


      $proc = DB::table('payments')->insert([
            'appointment_id'=>$appId,
             'imaging_id'=>$testId,
             'patient_test_id'=>$ptid,
             'amount'=>$amount,
             'mode'=>$mode,
             'status'=>1,
             ]);

return redirect()->action('TestController@radyinvoice', ['id' => $ptid]);
    }
    public function testreg($id){

    $data['facid']= DB::table('facility_test')->where('user_id', '=', Auth::user()->id)->first();
$data['patients']= DB::table('afya_users')->where('afya_users.id','=',$id)->first();

$data['dialledpatients']=  DB::table('afya_users')
		  ->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
      ->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
			->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
			->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
			->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
			->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
			->select('afya_users.*','patient_test.id as ptid','patient_test.created_at as date',
			'patient_test.test_status','doctors.name as doc','facilities.FacilityName as fac',
			'appointments.persontreated',
			'dependant.firstName as depname','dependant.secondName as depname2',
			'dependant.gender as depgender','dependant.dob as depdob','patient_test_details.tests_reccommended')
      ->where([['patient_test.test_status', '!=',1],['afya_users.id','=',$id],])
      ->groupBy('patient_test.id')
      ->get();
$data['alternative']= DB::table('afya_users')
      ->Join('patient_test', 'afya_users.id', '=', 'patient_test.afya_user_id')
			->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
			->leftJoin('dependant', 'patient_test.dependant_id', '=', 'dependant.id')
			->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
			->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
			->select('afya_users.*','patient_test.id as ptid','patient_test.created_at as date',
			'patient_test.test_status','doctors.name as doc','facilities.FacilityName as fac',
			'patient_test.dependant_id as persontreated',
			'dependant.firstName as depname','dependant.secondName as depname2',
			'dependant.gender as depgender','dependant.dob as depdob','patient_test_details.tests_reccommended')
      ->where([['patient_test.test_status', '!=',1],['afya_users.id','=',$id],])
      ->groupBy('patient_test.id')
      ->get();

      return view('test.testreg',$data);
    }

    public function patientslct($id){

      return view('test.select')->with('id',$id);
    }

public function pinformation($id){
  $info1=DB::table('afya_users')->where('id',$id)->first();
$data['info'] =DB::table('afya_users')->where('id',$id)->first();
$data['tstatus']=2;
$data['pt_id']='';
$data['facid'] = DB::table('facility_test')
->Join('facilities', 'facility_test.facilitycode', '=', 'facilities.FacilityCode')
->Select('facility_test.*','facilities.FacilityName')
->where('user_id', '=', Auth::user()->id)->first();
if($info1->dob)
   {
  return view('test.addtest',$data);
      }else{
      return view('test.pinfo',$data);
      }
    }

    public function updatepat(Request $request)
      {

        $afyaId=$request->afya_user_id;
        $nhif=$request->nhif;
        $nationalId=$request->nationalId;
        $dob=$request->dob;

        DB::table('afya_users')
                         ->where('id',$afyaId)
                         ->update(['dob'  =>$dob,
                          'nhif'  => $nhif,
                          'nationalId'  => $nationalId,
                        ]);

return redirect()->action('TestController2@pinformation', ['id' => $afyaId]);
    }

    public function postpat(Request $request)
      {
        $afyaId=$request->afyaId;
        $facility=$request->facility;
        $doc=$request->doc;

if($facility){
$insertedId = DB::table('patient_test')->insertGetId([
        'facility_from'=>$facility,
        'afya_user_id'=>$afyaId,
        'dependant_id'=>'Self',
        'doc_id'=>$doc,
        'test_status'=>0,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
      ]);

}
  return redirect()->action('TestController2@pinformation', ['id' => $afyaId]);

      }


      public function postPtest(Request $request)
        {
          $today = Carbon::today();

          $afyaId=$request->afyaId;
          $facility=$request->facility;
          $doc=$request->doc;


      DB::table('patient_test')->insert([
          'facility_from'=>$facility,
          'afya_user_id'=>$afyaId,
          'dependant_id'=>'Self',
          'doc_id'=>$doc,
          'test_status'=>0,
          'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
          'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);

    return redirect()->action('TestController2@pinformation', ['id' => $afyaId]);
        }

public function testadd(Request $request)
  {
    $today = Carbon::today();
    $afyaId=$request->afyaId;
    $testId=$request->testId;
    $docnote=$request->docnote;
    $pattid=$request->patient_test_id;
    $user_id = Auth::user()->id;
if ($pattid) {
$ptid = $pattid;
}else {
$patid = DB::table('patient_test')
->where([ ['test_status', '=',0],['created_at','>=',$today],['afya_user_id', '=',$afyaId],  ])
->first();
if($patid){
  $ptid =$patid->id;
}else{

    $ptid=DB::table('patient_test')->insertGetId([
        'afya_user_id'=>$afyaId,
        'dependant_id'=>'Self',
        'test_status'=>0,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

      ]);
      }
      }
$ptd_id = DB::table('patient_test_details')->insertGetId([
    'patient_test_id'=>$ptid,
   'tests_reccommended'=>$testId,
   'done'=>0,
   'added_by'=>$user_id,
   'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
  // Inserting patientNotes tests
if ($docnote) {
$patientNotes = DB::table('patientNotes')->insert([
   'note' => $docnote,
   'target' => 'Test',
   'ptd_id' => $ptd_id,
    ]);
}
if ($pattid) {
return redirect()->action('TestController2@add_Test', ['id' => $pattid]);
}else{
  return redirect()->action('TestController2@pinformation', ['id' => $afyaId]);

}
  }


  public function selectDependant($id){
  return view('test.dependant')->with('id',$id);
  }
  public function addDependents($id){
    return view('test.adddependant')->with('id',$id);
  }
  public function createDependent(Request $request){
      $id=$request->id;
      $first=$request->first;
      $second=$request->second;
      $gender=$request->gender;
      $blood=$request->blood;
      $pob=$request->pob;
      $dob=$request->dob;

      $relation=$request->relationship;
      $school=$request->school;

      $newDate = date("Y-m-d", strtotime($dob));

      $parent=DB::table('afya_users')->where('id',$id)->first();
      $name=$parent->firstname." ".$parent->secondName;
      $parentgender=$parent->gender;
      $phone=$parent->msisdn;

     $dependant_id= DB::table('dependant')->insertGetId(
      ['firstName' => $first,
      'secondName'=> $second,
      'gender'=>$gender,
      'blood_type'=>$blood,
      'dob'=>$newDate,
      'pob'=>$pob,
       'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
      ]
  );


  DB::table('dependant_parent')->insert(
    ['relationship'=>$relation,
    'dependant_id'=>$dependant_id,
    'afya_user_id'=>$id,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);


     $end = Carbon::parse($dob);
        $now = Carbon::now();
        $length = $end->diffInDays($now);
  if ($length <=1825) {
  $vaccines=DB::table('vaccine')->get();
    foreach ($vaccines as $vaccine) {
    $MyDateCarbon = \Carbon\Carbon::parse($dob);
    $MyDateCarbon->addDays($vaccine->age);
    DB::table('dependant_vaccination')->insert(
    [
    'dependent_id'=>$dependant_id,
    'vaccine_id'=>$vaccine->id,
    'date_guideline'=>$MyDateCarbon,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
  );
  }
  }
return redirect()->action('TestController2@selectDependant', [$id]);
  }

  public function testsshow($id){
    $info =DB::table('afya_users')
    ->Join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
    ->select('afya_users.*','afyamessages.id as afyamId')
    ->where('afya_users.id',$id)
    ->whereNull('afyamessages.status')
    ->first();

    $facid = DB::table('facility_test')
    ->Join('facilities', 'facility_test.facilitycode', '=', 'facilities.FacilityCode')
    ->Select('facility_test.*','facilities.FacilityName')
    ->where('user_id', '=', Auth::user()->id)->first();

  	$tets = DB::table('patient_test')
      ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
      ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
      ->select('patient_test_details.*','tests.name')
      ->where([ ['patient_test_details.done', '=',0],
                ['patient_test_details.deleted', '=',0],
                ['patient_test.afya_user_id', '=',$id],
                ])
      ->get();

      $alternativetets = DB::table('afya_users')
      ->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
      ->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
      ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
      ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
      ->select('patient_test_details.*','tests.name')
      ->where([ ['patient_test_details.done', '=',0],
                  ['patient_test_details.deleted', '=',0],
                  ['afya_users.id', '=',$id],
                  ['patient_test_details.added_by', '=',Auth::user()->id],
                  ])
        ->get();
        return view('test.show')->with('tets',$tets)->with('info',$info)->with('facid',$facid)->with('alternativetets',$alternativetets);
}

public function destroytests($id)
{

  $afyad =DB::table('patient_test_details')
  ->Join('patient_test', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
  ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
  ->select('patient_test.afya_user_id','afya_users.id')
    ->where('patient_test_details.id',$id)
   ->first();


   if($afyad->afya_user_id){ $afyaId=$afyad->afya_user_id; }else{$afyaId=$afyad->id;}
     $now = Carbon::now();
DB::table("patient_test_details")->where('id',$id)
                 ->update(['deleted'  =>1,
                  'updated_at'  => $now,
                ]);
return redirect()->action('TestController2@testsshow', [$afyaId]);

}
//dependant
public function depinformation($id){
  $info =DB::table('dependant')
  ->Join('dependant_parent', 'dependant.id', '=', 'dependant_parent.dependant_id')
  ->select('dependant.*','dependant.id as depId','dependant_parent.afya_user_id as afyaId')
  ->where('dependant.id',$id)
  ->first();

  $facid = DB::table('facility_test')
  ->where('user_id', '=', Auth::user()->id)->first();

  $tsts = DB::table('test_categories')
  ->Join('test_subcategories', 'test_categories.id', '=', 'test_subcategories.categories_id')
  ->Join('tests', 'test_subcategories.id', '=', 'tests.sub_categories_id')
  ->Join('test_ranges', 'tests.id', '=', 'test_ranges.tests_id')
  ->select('test_categories.name as cat','test_subcategories.name as subcat','tests.id as testId',
  'tests.name as testname','test_ranges.id as trId')
  ->where('test_ranges.facility_id', '=',$facid->facilitycode)
  ->orderBy('tests.name', 'asc')
  ->get();

if($info->dob) {
    return view('test.depaddtest')->with('info',$info)->with('tsts',$tsts);
  }else{
  return view('test.deppinfo')->with('info',$info);
  }
}
public function postpatdep(Request $request)
  {
    $afyaId=$request->afyaId;
    $depId=$request->depId;
    $facility=$request->facility;
    $doc=$request->doc;


DB::table('patient_test')->insert([
    'facility_from'=>$facility,
    'afya_user_id'=>$afyaId,
    'dependant_id'=>$depId,
    'doc_id'=>$doc,
    'test_status'=>0,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);

return redirect()->action('TestController2@depinformation', ['id' => $depId]);
  }
  public function testadddep(Request $request)
    {
      $today = Carbon::today();
      $afyaId=$request->afyaId;
      $depId=$request->depId;
      $testId=$request->testId;

      $patid = DB::table('patient_test')
        ->where([ ['test_status', '=',0],
                  ['created_at','>=',$today],
                  ['dependant_id', '=',$depId],  ])
        ->first();
  if($patid){
    $ptid =$patid->id;
  }else{

      $ptid=DB::table('patient_test')->insertGetId([
          'afya_user_id'=>$afyaId,
          'dependant_id'=>$depId,
          'test_status'=>0,
          'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
          'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

        ]);
        }
  DB::table('patient_test_details')->insert([
      'patient_test_id'=>$ptid,
     'tests_reccommended'=>$testId,
     'done'=>0,
     'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);

  return redirect()->action('TestController2@depinformation', ['id' => $depId]);
    }
    public function testsdepshow($id){
      $info =DB::table('dependant')
      ->where('id',$id)
      ->first();

    	$tets = DB::table('patient_test')
        ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
        ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
        ->select('patient_test_details.*','tests.name')
        ->where([ ['patient_test_details.done', '=',0],
                  ['patient_test_details.deleted', '=',0],
                  ['patient_test.dependant_id', '=',$id],
                  ])
        ->get();
          return view('test.depshow')->with('tets',$tets)->with('info',$info);
  }


  public function addmri($id){
    $today = Carbon::today();
     $Mtests = DB::table('patient_test')
    ->leftJoin('afya_users', 'patient_test.afya_user_id', '=', 'afya_users.id')
    ->leftJoin('dependant', 'patient_test.dependant_id', '=', 'dependant.id')
    ->select('afya_users.*','afya_users.id as afya_user_id','patient_test.id as ptid',
    'patient_test.dependant_id as dependant_id','dependant.firstName as depname1','dependant.secondName as depname2',
    'dependant.gender as depgender','dependant.dob as depdob')
    ->where([ ['afya_users.id', '=',$id],
              ['patient_test.test_status', '=',0],
          ['patient_test.created_at','>=',$today],
                  ])
      ->first();
        return view('test.tst.mri')->with('Mtests',$Mtests);
}

public function addultra($id){
  $today = Carbon::today();
   $ultra = DB::table('patient_test')
  ->leftJoin('afya_users', 'patient_test.afya_user_id', '=', 'afya_users.id')
  ->leftJoin('dependant', 'patient_test.dependant_id', '=', 'dependant.id')
  ->select('afya_users.*','afya_users.id as afya_user_id','patient_test.id as ptid',
  'patient_test.dependant_id as dependant_id','dependant.firstName as depname1','dependant.secondName as depname2',
  'dependant.gender as depgender','dependant.dob as depdob')
  ->where([ ['afya_users.id', '=',$id],
            ['patient_test.test_status', '=',0],
        ['patient_test.created_at','>=',$today],
                ])
    ->first();
      return view('test.tst.ultrasound')->with('ultra',$ultra);
}

public function addct($id){
  $today = Carbon::today();
   $ctscan = DB::table('patient_test')
  ->leftJoin('afya_users', 'patient_test.afya_user_id', '=', 'afya_users.id')
  ->leftJoin('dependant', 'patient_test.dependant_id', '=', 'dependant.id')
  ->select('afya_users.*','afya_users.id as afya_user_id','patient_test.id as ptid',
  'patient_test.dependant_id as dependant_id','dependant.firstName as depname1','dependant.secondName as depname2',
  'dependant.gender as depgender','dependant.dob as depdob')
  ->where([ ['afya_users.id', '=',$id],
            ['patient_test.test_status', '=',0],
        ['patient_test.created_at','>=',$today],
                ])
    ->first();
      return view('test.tst.ctscan')->with('ctscan',$ctscan);
}
public function addxray($id){
  $today = Carbon::today();
   $xray = DB::table('patient_test')
  ->leftJoin('afya_users', 'patient_test.afya_user_id', '=', 'afya_users.id')
  ->leftJoin('dependant', 'patient_test.dependant_id', '=', 'dependant.id')
  ->select('afya_users.*','afya_users.id as afya_user_id','patient_test.id as ptid',
  'patient_test.dependant_id as dependant_id','dependant.firstName as depname1','dependant.secondName as depname2',
  'dependant.gender as depgender','dependant.dob as depdob')
  ->where([ ['afya_users.id', '=',$id],
            ['patient_test.test_status', '=',0],
        ['patient_test.created_at','>=',$today],
                ])
    ->first();
      return view('test.tst.xray')->with('xray',$xray);
}



public function donexraydoc($id)
{
  $tsts1 = DB::table('radiology_test_details')
  ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
  ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
  ->Join('xray', 'radiology_test_details.test', '=', 'xray.id')
  ->select('appointments.*','appointments.persontreated','test_categories.name as category',
  'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
  'xray.name as tstname','xray.technique','xray.id as xrayid','facilities.FacilityName',
  'radiology_test_details.user_id','patient_test.id as ptid')
  ->where('radiology_test_details.id', '=',$id)
  ->first();

  $rdlgist = DB::table('facility_test')
  ->Join('facilities', 'facility_test.facilitycode', '=', 'facilities.FacilityCode')
  ->select('facility_test.firstname','facility_test.secondname','facilities.FacilityName')
      ->where(  'facility_test.user_id', '=',$tsts1->user_id)
      ->first();
  return view('doctor.done.donexray')->with('tsts1',$tsts1)->with('rdlgist',$rdlgist);
}

public function donectdoc($id)
{
  $tsts1 = DB::table('radiology_test_details')
           ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
          ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
         ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
           ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
          ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
          ->Join('ct_scan', 'radiology_test_details.test', '=', 'ct_scan.id')
       ->select('appointments.*','appointments.persontreated','test_categories.name as category',
          'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
          'ct_scan.name as tstname','ct_scan.technique','ct_scan.id as ctid','facilities.FacilityName',
          'radiology_test_details.user_id','patient_test.id as ptid')
           ->where('radiology_test_details.id', '=',$id)
           ->first();

           $rdlgist = DB::table('facility_test')
           ->Join('facilities', 'facility_test.facilitycode', '=', 'facilities.FacilityCode')
           ->select('facility_test.firstname','facility_test.secondname','facilities.FacilityName')
               ->where(  'facility_test.user_id', '=',$tsts1->user_id)
               ->first();
return view('doctor.done.donect')->with('tsts1',$tsts1)->with('rdlgist',$rdlgist);
}

public function donemridoc($id)
{
  $tsts1 = DB::table('radiology_test_details')
           ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
          ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
       ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
           ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
          ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
          ->Join('mri_tests', 'radiology_test_details.test', '=', 'mri_tests.id')
       ->select('appointments.*','appointments.persontreated','test_categories.name as category',
          'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
          'mri_tests.name as tstname','mri_tests.technique','mri_tests.id as mriid','facilities.FacilityName',
          'radiology_test_details.user_id','patient_test.id as ptid')
           ->where('radiology_test_details.id', '=',$id)
           ->first();

           $rdlgist = DB::table('facility_test')
           ->Join('facilities', 'facility_test.facilitycode', '=', 'facilities.FacilityCode')
           ->select('facility_test.firstname','facility_test.secondname','facilities.FacilityName')
               ->where(  'facility_test.user_id', '=',$tsts1->user_id)
               ->first();
return view('doctor.done.donemri')->with('tsts1',$tsts1)->with('rdlgist',$rdlgist);
}

public function doneultradoc($id)
{
  $tsts1 = DB::table('radiology_test_details')
           ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
          ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
            ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
           ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
          ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
          ->Join('ultrasound', 'radiology_test_details.test', '=', 'ultrasound.id')
       ->select('appointments.*','appointments.persontreated','test_categories.name as category',
          'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
          'ultrasound.name as tstname','ultrasound.technique','ultrasound.id as ultraid','facilities.FacilityName',
          'radiology_test_details.user_id','patient_test.id as ptid')
           ->where('radiology_test_details.id', '=',$id)
           ->first();

$rdlgist = DB::table('facility_test')
->Join('facilities', 'facility_test.facilitycode', '=', 'facilities.FacilityCode')
->select('facility_test.firstname','facility_test.secondname','facilities.FacilityName')
    ->where(  'facility_test.user_id', '=',$tsts1->user_id)
    ->first();


return view('doctor.done.doneultra')->with('tsts1',$tsts1)->with('rdlgist',$rdlgist);
}

public function doneotherdoc($id)
{
  $tsts1 = DB::table('radiology_test_details')
           ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
          ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
            ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
           ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
          ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
          ->Join('other_tests', 'radiology_test_details.test', '=', 'other_tests.id')
       ->select('appointments.*','appointments.persontreated','appointments.id as appid','test_categories.name as category',
          'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
          'other_tests.name as tstname','other_tests.technique','other_tests.id as ultraid','facilities.FacilityName',
          'radiology_test_details.user_id','patient_test.id as ptid')
           ->where('radiology_test_details.id', '=',$id)
           ->first();

$rdlgist = DB::table('facility_test')
->Join('facilities', 'facility_test.facilitycode', '=', 'facilities.FacilityCode')
->select('facility_test.firstname','facility_test.secondname','facilities.FacilityName')
    ->where(  'facility_test.user_id', '=',$tsts1->user_id)
    ->first();


return view('doctor.done.doneother')->with('tsts1',$tsts1)->with('rdlgist',$rdlgist);
}


public function viewtest($id)
{
$tsts1 = DB::table('patient_test_details')
->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
  ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
  ->select('doctors.name as docname','tests.id as tests_id','tests.name','test_categories.name as category',
  'test_subcategories.id as subcatid','test_subcategories.name as sub_category','patient_test_details.*','appointments.id as appid',
  'appointments.persontreated','appointments.afya_user_id','facilities.FacilityName','patient_test.id as ptid')
  ->where('patient_test_details.id', '=',$id)
  ->first();
   return view('doctor.done.viewtest')->with('tsts1',$tsts1);
}
public function view_test($id)
{
$tsts1 = DB::table('patient_test_details')
->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
  ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
  ->select('doctors.name as docname','tests.id as tests_id','tests.name','test_categories.name as category',
  'test_subcategories.id as subcatid','test_subcategories.name as sub_category','patient_test_details.*','appointments.id as appid',
  'appointments.persontreated','appointments.afya_user_id','facilities.FacilityName','patient_test.id as ptid')
  ->where('patient_test_details.id', '=',$id)
  ->first();
   return view('doctor.done.view_test')->with('tsts1',$tsts1);
}

public function transfered()
{
$facid = DB::table('facility_test')->where('user_id', '=', Auth::user()->id)->first();
$fac=$facid->facilitycode;

$tsts1 = DB::table('tests_transfers')
->Join('patient_test_details', 'tests_transfers.specimen_no', '=', 'patient_test_details.specimen_no')
->Join('facilities', 'tests_transfers.facility_from', '=', 'facilities.FacilityCode')
->select('patient_test_details.id as patTdid','facilities.FacilityName','tests_transfers.specimen_no','tests_transfers.created_at')
->where([['patient_test_details.done', '=',0],['tests_transfers.facility_to', '=',$fac],])
->get();
   return view('test.transfered')->with('tsts1',$tsts1);
}
// public function add_Test($id){
//
// $data['info'] =DB::table('patient_test')
// ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
// ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
// ->Select('afya_users.*','patient_test.id as ptid')
// ->where('patient_test.id',$id)->first();
//
// $data['facid'] = DB::table('facility_test')
// ->Join('facilities', 'facility_test.facilitycode', '=', 'facilities.FacilityCode')
// ->Select('facility_test.*','facilities.FacilityName')
// ->where('user_id', '=', Auth::user()->id)->first();
// $data['tstatus']=1;
// $data['pt_id'] =$id;
//   return view('test.addtest',$data)->with('info',$info)->with('facid',$facid)->with('tstatus',$tstatus);
//
//     }


}
//end of file
