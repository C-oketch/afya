<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Patient;
use App\Druglist;
use App\Test;
use App\TestDetails;
use Carbon\Carbon;
use Auth;
class TestController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $facid = DB::table('facility_test')
      ->Join('facilities', 'facility_test.facilitycode', '=', 'facilities.FacilityCode')
      ->select('facility_test.*','facilities.FacilityName','facilities.Type')
      ->where('facility_test.user_id', '=', Auth::user()->id)->first();

      $dialledpatients = DB::table('afyamessages')
      ->Join('afya_users', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
			->select('afya_users.*')
      ->where('afyamessages.test_center_code', '=',$facid->facilitycode)
      ->whereNull('afyamessages.status')
      ->groupBy('afya_users.id')
      ->get();
// dd($dialledpatients);
return view('test.home')->with('facid',$facid)->with('dialledpatients',$dialledpatients);
}



public function testdetails($id){

  $pdetails = DB::table('patient_test')
  ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
 ->select('appointments.*','doctors.name as docname','patient_test_details.appointment_id as appid',
  'patient_test_details.id as ptd_id','patient_test.id as ptid','facilities.FacilityName')
  ->where('patient_test.id', '=',$id)
  ->first();

     $alternative= DB::table('patient_test')
    ->leftJoin('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
    ->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
    ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
    ->select('doctors.name as docname','patient_test.afya_user_id','patient_test.dependant_id',
    'patient_test_details.id as ptd_id','patient_test.id as ptid','facilities.FacilityName','patient_test.id as ptid')
    ->where('patient_test.id', '=',$id)
    ->first();

$tsts = DB::table('patient_test')
    ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
    ->leftJoin('icd10_option', 'patient_test_details.conditional_diag_id', '=', 'icd10_option.id')
    ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
    ->Join('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
    ->Join('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
    ->Join('payments', 'tests.id', '=', 'payments.lab_id')
 ->select('tests.name as tname','test_subcategories.name as tsname','icd10_option.name as dname','patient_test_details.created_at as date',
    'patient_test_details.id as patTdid','test_categories.name as tcname','patient_test_details.testmore',
    'patient_test_details.transfer','patient_test_details.tests_reccommended','patient_test.id as ptid','patient_test_details.done')

    ->where([    ['patient_test.id', '=',$id],
                ['payments.status', '=',1],
                ['payments.patient_test_id', '=',$id],
                  ['patient_test_details.deleted', '=',0],
                  ])
    ->get();
return view('test.pdetails')->with('tsts',$tsts)->with('pdetails',$pdetails)->with('alternative',$alternative);
}
public function labinvoices($id){

$fac = DB::table('facility_test')->select('facilitycode')->where('user_id', '=',Auth::user()->id)->first();
  $pdetails = DB::table('patient_test')
   ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
   ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
   ->leftJoin('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
   ->leftJoin('doctors', 'appointments.doc_id', '=', 'doctors.id')
   ->select('appointments.*','doctors.name as docname','patient_test_details.appointment_id as appid',
  'patient_test_details.id as ptd_id','patient_test.id as ptid','facilities.FacilityName')
  ->where('patient_test.id', '=',$id)
  ->first();

  $alternative = DB::table('patient_test')
   ->leftJoin('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
   ->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
   ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
   ->select('doctors.name as docname','patient_test_details.id as ptd_id','patient_test.id as ptid',
   'patient_test.afya_user_id','patient_test.dependant_id as persontreated','facilities.FacilityName')
  ->where('patient_test.id', '=',$id)
  ->first();

$tsts = DB::table('patient_test')
    ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
    ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
    ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
    ->leftJoin('test_price', 'tests.id', '=', 'test_price.tests_id')
  ->select('tests.name as tname','test_subcategories.name as tsname','test_price.id as tp_Id',
  'patient_test_details.testmore','test_price.amount','tests.id as testId')

    ->where([  ['patient_test.id', '=',$id],
               ['test_price.facility_id', '=',$fac->facilitycode],
               ['patient_test_details.done', '=',0],
               ['patient_test_details.deleted', '=',0],
             ])
  ->get();
    $cost = DB::table('patient_test')
        // ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
        ->leftJoin('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
        ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
        ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
        ->leftJoin('test_price', 'tests.id', '=', 'test_price.tests_id')
        ->select('test_price.amount',DB::raw('SUM(test_price.amount) as total_cost'))

        ->where([
                      ['patient_test.id', '=',$id],
                      ['patient_test_details.done', '=',0],
                      ['patient_test_details.deleted', '=',0],

                     ])
        ->first();
return view('test.labinvoice')->with('tsts',$tsts)->with('pdetails',$pdetails)->with('cost',$cost)->with('alternative',$alternative);
}

public function labinvoicepay(Request $request){


      $testId=$request->testId;
      $ptid=$request->ptid;
$fac = DB::table('facility_test')->select('facilitycode')->where('user_id', '=',Auth::user()->id)->first();
$facility=$fac->facilitycode;
$tsts = DB::table('tests')
    ->leftJoin('test_price', 'tests.id', '=', 'test_price.tests_id')
    ->select('tests.id as testId','tests.name','test_price.id as tpId','test_price.amount','test_price.availability')
    ->where([  ['tests.id', '=',$testId],['test_price.facility_id', '=',$facility], ])
    ->first();
    $tpId=$tsts->tpId;
    $discount = DB::table('lab_test_discount')
        ->select('reason','amount')
        ->where([  ['test_price_id', '=',$tpId],['facility_id', '=',$facility], ['status', '=',1],])
        ->get();
return view('test.labinvoicepay')->with('tsts',$tsts)->with('ptid',$ptid)->with('discount',$discount);
}

public function radydetails($id){
$pdetails = DB::table('patient_test')
  ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
 ->select('appointments.*','doctors.name as docname','radiology_test_details.appointment_id as appid',
  'radiology_test_details.id as ptd_id','patient_test.id as ptid')
  ->where('patient_test.id', '=',$id)
  ->first();

  $alternative = DB::table('patient_test')
   ->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
   ->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
   ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
   ->select('doctors.name as docname','radiology_test_details.id as ptd_id','patient_test.id as ptid',
   'patient_test.afya_user_id','patient_test.dependant_id as persontreated')
  ->where('patient_test.id', '=',$id)
  ->first();

$tsts = DB::table('patient_test')
    ->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
    ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
    ->select('radiology_test_details.created_at as date','radiology_test_details.test',
    'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
    'radiology_test_details.id as patTdid','test_categories.name as tcname','patient_test.id as ptid')
    ->where('patient_test.id', '=',$id)
    ->get();


return view('test.prdetails')->with('tsts',$tsts)->with('pdetails',$pdetails)->with('alternative',$alternative);
}

public function radyinvoice($id){
$pdetails = DB::table('patient_test')
  ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
 ->select('appointments.*','doctors.name as docname','radiology_test_details.appointment_id as appid',
  'radiology_test_details.id as ptd_id','patient_test.id as ptid')
  ->where('patient_test.id', '=',$id)
  ->first();

  $alternative = DB::table('patient_test')
    ->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
    ->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
   ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
   ->select('doctors.name as docname','radiology_test_details.appointment_id as appid',
    'radiology_test_details.id as ptd_id','patient_test.*','patient_test.id as ptid','patient_test.dependant_id as persontreated')
    ->where('patient_test.id', '=',$id)
    ->first();

$tsts = DB::table('patient_test')
    // ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
    ->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
    ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
   ->select('radiology_test_details.created_at as date','radiology_test_details.test',
    'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
    'radiology_test_details.id as patTdid','test_categories.name as tcname')

    ->where([
                  ['patient_test.id', '=',$id],
                  ['radiology_test_details.done', '!=',2],

                 ])
    ->get();


return view('test.prinvoice')->with('tsts',$tsts)->with('pdetails',$pdetails)->with('alternative',$alternative);
}



public function radydetaild($id){
$pdetails = DB::table('patient_test')
  ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
 ->select('appointments.*','doctors.name as docname','radiology_test_details.appointment_id as appid',
  'radiology_test_details.id as ptd_id','patient_test.id as ptid')
  ->where('patient_test.id', '=',$id)
  ->first();
$tsts = DB::table('patient_test')
    ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
    ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
    ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
    ->select('radiology_test_details.created_at as date','radiology_test_details.test',
    'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
    'radiology_test_details.id as patTdid','test_categories.name as tcname')

    ->where([  ['patient_test.id', '=',$id],
               ['radiology_test_details.done', '=',2],
                     ])
         ->get();
return view('test.prdetaildone')->with('tsts',$tsts)->with('pdetails',$pdetails);
}



    public function testSales(){
        return view('test.testsales');

    }
public function testAnalytics(){
  return view('test.testanalytics');

}

public function transfertest(Request $request)
{
$user_id =Auth::user()->id;
$now = Carbon::now();
$facility_to =$request->facility_to;
$facility_from =$request->facility_from;
$ptid=$request->ptid;
$ptdId=$request->ptdId;
$specimen =$request->specimen;

 DB::table('tests_transfers')->insert([
   'facility_from' => $facility_from,
   'facility_to' => $facility_to,
   'specimen_no' => $specimen,
   'user_id' => $user_id,
   'created_at' => $now,
   'updated_at' => $now,
]);
DB::table('patient_test_details')
  ->where('id',$ptdId)
  ->update([
   'specimen_no'  => $specimen,
   'transfer'  =>'Y',
 ]);
return redirect()->action('TestController@testdetails', ['id' => $ptid]);
 }

public function testResult(Request $request)
{
$now = Carbon::now();

  $test1 =$request->testrangesId;
  $testv =$request->test_value;
  $ptd_id =$request->ptd_id;

  $ptid = $request->ptid;
  $facility = $request->facility;
  $test_id = $request->test_id;

  if($testv){
   $pttids=DB::table('test_results')
->where([ ['patient_test','=',$ptid  ],
         ['test_results.ptd_id', '=',$ptd_id],
         ['test_results.test_ranges_id', '=',$test1],])
  ->first();

if (is_null($pttids)) {
    $testRslt = DB::table('test_results')->insert([
       'ptd_id' => $ptd_id,
       'patient_test' => $ptid,
       'test_ranges_id' => $test1,
       'value' => $testv,
      'tests_id' => $test_id,
   ]);
 }
 }


 $query11 = DB::table('test_groups')
         ->select(DB::raw('count(id) as idt'))
         ->where('main_test', '=', $test_id)
 ->first();

 $count11 = $query11->idt;
 $count12 = '';
if($count11 >1){ $count12 =$count11;}else{$count12 =1;}
 $query22 = DB::table('test_results')
         ->select(DB::raw('count(id) as idp'))
         ->where([ ['patient_test','=',$ptid],
                  ['ptd_id', '=',$ptd_id],
                  ['tests_id', '=',$test_id],
                 ])
         ->first();
 $count22 = $query22->idp;

 if($count12 == $count22)
 {

   $tsts1 = DB::table('patient_test_details')
 ->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
 ->Join('appointments', 'patient_test_details.appointment_id', '=', 'appointments.id')
 ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
   ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
   ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
   ->select('doctors.name as docname','tests.id as tests_id','tests.name as tname','test_categories.name as category','test_subcategories.id as subcatid',
   'test_subcategories.name as sub_category','patient_test_details.*','appointments.persontreated','appointments.afya_user_id','patient_test.id as ptid')
   ->where('patient_test_details.id', '=',$ptd_id)
   ->first();
   $alternative = DB::table('patient_test')
  ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
  ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
  ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
   ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
   ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
   ->select('doctors.name as docname','tests.id as tests_id','tests.name as tname','test_categories.name as category','test_subcategories.id as subcatid',
   'test_subcategories.name as sub_category','patient_test_details.*','patient_test.dependant_id as persontreated','patient_test.afya_user_id','patient_test.id as ptid')
  ->where('patient_test_details.id', '=',$ptd_id)
   ->first();
   return view('test.report2')->with('tsts1',$tsts1)->with('alternative', $alternative);
 }else {
  return redirect()->action('TestController@actions', ['id' => $ptd_id]);

   }
}
public function testResult3(Request $request)
{
$now = Carbon::now();
  $units=$request->units;
  $test1 =$request->tests_id;
  $test2 =$request->value;
  $ptd_id =$request->ptd_id;
  $appid = $request->appointment_id;
  $com = $request->comments;
  $com2= $request->comments2;
  $facility= $request->facility;
  if($test1){
$pttids=DB::table('test_results')
->where([ ['appointment_id','=',$appid],
         ['test_results.ptd_id', '=',$ptd_id],
         ['test_results.test_ranges_id', '=',$test1],])
  ->first();

if (is_null($pttids)) {
    $testRslt = DB::table('test_results')->insert([
       'ptd_id' => $ptd_id,
       'appointment_id' => $appid,
       'tests_id' => $test1,
       'value' => $test2,
       'units' => $units,
       'status' => 1,
   ]);
 }
 }

 if($com){
   DB::table('patient_test_details')
     ->where('id',$ptd_id)
     ->update(['done'  =>1,
      'results'  => $com,
      'note'  => $com2,
      'facility_done'  => $facility,
      'updated_at'  => $now,
    ]);

    $tsts = DB::table('patient_test_details')->where('id', '=', $ptd_id)->first();
    $ptid=$tsts->patient_test_id;
    $appid=$tsts->appointment_id;

    $tsts11 = DB::table('patient_test_details')
    ->where([ ['patient_test_id', '=', $ptid],
             ['appointment_id', '=', $appid],
            ['done', '=', '0'], ])
    ->first();
 if($tsts11){
     DB::table('patient_test')
                ->where('id', $ptid)
               ->update(
                 ['test_status' => 2, 'updated_at'=> $now]
               );
 }else{
   DB::table('patient_test')
              ->where('id', $ptid)
             ->update(
               ['test_status' => 1, 'updated_at'=> $now]
             );
 }
  }
return redirect()->route('patientTests',$ptid);

}

public function testResult4(Request $request)
{
$now = Carbon::now();
  $units=$request->units;
  $test1 =$request->test;
  $test2 =$request->value;
  $ptd_id =$request->ptd_id;
  $appid = $request->appointment_id;
  $com = $request->comments;
  $com2= $request->comments2;
  $facility= $request->facility;


    $testRslt = DB::table('test_results')->insert([
       'ptd_id' => $ptd_id,
       'appointment_id' => $appid,
       'result_name' => $test1,
       'value' => $test2,
       'comments' => $com,
       'notes' => $com2,
       'units' =>$units,

   ]);
   return redirect()->action('TestController@actions', ['id' => $ptd_id]);


}
public function testResult5(Request $request)
{
$now = Carbon::now();
  $ptd_id =$request->ptd_id;
  $appid = $request->appointment_id;
$facility= $request->facility;


   DB::table('patient_test_details')
     ->where('id',$ptd_id)
     ->update(['done'  =>1,
      'facility_done'  => $facility,
      'updated_at'  => $now,
    ]);

    $tsts = DB::table('patient_test_details')->where('id', '=', $ptd_id)->first();
    $ptid=$tsts->patient_test_id;
    $appid=$tsts->appointment_id;

    $tsts11 = DB::table('patient_test_details')
    ->where([ ['patient_test_id', '=', $ptid],
             ['appointment_id', '=', $appid],
            ['done', '=', '0'], ])
    ->first();
 if($tsts11){
     DB::table('patient_test')
                ->where('id', $ptid)
               ->update(
                 ['test_status' => 2, 'updated_at'=> $now]
               );
 }else{
   DB::table('patient_test')
              ->where('id', $ptid)
             ->update(
               ['test_status' => 1, 'updated_at'=> $now]
             );
 }

return redirect()->route('patientTests',$ptid);

}
public function ctest(Request $request)
{
$now = Carbon::now();
  $ptd_id =$request->ptd_id;
  $appid = $request->appointment_id;
  $test =$request->test;
  $value =$request->value;
  $units =$request->units;
  $comment =$request->comments;
  $comment2 =$request->comments2;
  $reason =$request->reason;
  $ptid=$request->ptid;


$testRslt6 = DB::table('test_results')->insert([
   'ptd_id' => $ptd_id,
   'appointment_id' => $appid,
   'result_name' => $test,
   'value' => $value,
   'units' => $units,
   'comments' => $comment,
   'notes' => $comment2,
   'reason' => $reason,
]);
return redirect()->action('TestController@testdetails', ['id' => $ptid]);

//return redirect()->route('patientTests',$ptid);
}
public function testreport(Request $request)
{
$now = Carbon::now();

  $com1 =$request->comments;
  $com2 =$request->comments2;
  $ptd_id =$request->ptd_id;
  $ptid =$request->ptid;
  $facility =$request->facility;
if($com1){
  DB::table('patient_test_details')
    ->where('id',$ptd_id)
    ->update(['done'  =>1,
     'results'  => $com1,
     'note'  => $com2,
     'facility_done'  => $facility,
    'updated_at'  => $now,
   ]);
   $tsts11 = DB::table('patient_test_details')
   ->leftJoin('tests_transfers', 'patient_test_details.specimen_no', '=', 'tests_transfers.specimen_no')
   ->where('patient_test_details.id', '=', $ptd_id)
   ->select('patient_test_details.transfer','tests_transfers.facility_from')
   ->first();
   $facility_from=$tsts11->facility_from;
   $transfer=$tsts11->transfer;
if($transfer =='Y'){
  $facility =$facility_from;
}


// Check if all test are done if not set status to 2 if yes 1
   $tsts11 = DB::table('patient_test_details')
   ->where([ ['patient_test_id', '=', $ptid],
            ['done', '=', '0'],
            ['deleted', '=', '0'],])
   ->first();

if($tsts11){
    DB::table('patient_test')
               ->where('id', $ptid)
              ->update(
                ['test_status' => 2, 'updated_at'=> $now]
              );
}else{
  DB::table('patient_test')
             ->where('id', $ptid)
            ->update(
              ['test_status' => 1, 'updated_at'=> $now]
            );
}

$pappoint = DB::table('patient_test')
->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
->select('patient_test.afya_user_id as direct_user','appointments.afya_user_id as doctor_user','patient_test.appointment_id')
->where('patient_test.id', '=', $ptid)->first();

if($pappoint->direct_user === NULL){ $afya_user_id=$pappoint->doctor_user;}else{$afya_user_id=$pappoint->direct_user;}

$msgs = DB::table('afya_users')
->Join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
->select('afyamessages.*')
->where([  ['afyamessages.test_center_code', '=',$facility],
           ['afya_users.id', '=',$afya_user_id],
])
->whereNull('afyamessages.status')
->first();
$msgsid=$msgs->id;
$afymss = DB::table('patient_test')->where('id', '=', $ptid)->first();

if($afymss->test_status == 1){
  DB::table('afyamessages')
             ->where('id', $msgsid)
            ->update(
              ['status' => 1, 'updated_at'=> $now]
            );
if($pappoint->appointment_id)  {
  DB::table('appointments')
                  ->where('id', $pappoint->appointment_id)
                  ->update(
                        ['p_status' => 14, 'updated_at'=> $now]
                      );
}
  if($transfer =='Y'){
    return redirect()->action('TestController2@transfered');
} else{
    return redirect()->action('TestController@index');
  }
}else{

  if($transfer =='Y'){
    return redirect()->action('TestController2@transfered');
} else{
    return redirect()->action('TestController@testdetails', ['id' => $ptid]);
  }

}
}
}
public function actions($id)
{
$facid = DB::table('facility_test')->where('user_id', '=', Auth::user()->id)->first();
$specimen=$facid->facilitycode.''.$id;
  DB::table('patient_test_details')
    ->where('id',$id)
    ->update(['specimen_no'  => $specimen,]);

$tsts1 = DB::table('patient_test_details')
->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
->Join('appointments', 'patient_test_details.appointment_id', '=', 'appointments.id')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
->select('doctors.name as docname','tests.id as tests_id','tests.name as tname','test_categories.name as category','test_subcategories.id as subcatid',
'test_subcategories.name as sub_category','patient_test_details.*','appointments.persontreated','appointments.afya_user_id',
'patient_test.id as ptid')
->where('patient_test_details.id', '=',$id)
->first();


$alternative = DB::table('patient_test_details')
->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
->select('doctors.name as docname','tests.id as tests_id','tests.name as tname','test_categories.name as category','test_subcategories.id as subcatid',
'test_subcategories.name as sub_category','patient_test_details.*','patient_test.dependant_id as persontreated','patient_test.afya_user_id',
'patient_test.id as ptid')
->where('patient_test_details.id', '=',$id)
->first();


return view('test.action')->with('tsts1',$tsts1)->with('alternative',$alternative);
  }

  public function actionstrans($id)
  {

  $tsts1 = DB::table('patient_test_details')
  ->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
  ->Join('appointments', 'patient_test_details.appointment_id', '=', 'appointments.id')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
  ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
  ->select('doctors.name as docname','tests.id as tests_id','tests.name as tname','test_categories.name as category','test_subcategories.id as subcatid',
  'test_subcategories.name as sub_category','patient_test_details.*','appointments.persontreated','appointments.afya_user_id',
  'patient_test.id as ptid')
  ->where('patient_test_details.id', '=',$id)
  ->first();


  $alternative = DB::table('patient_test_details')
  ->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
  ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
  ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
  ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
  ->select('doctors.name as docname','tests.id as tests_id','tests.name as tname','test_categories.name as category','test_subcategories.id as subcatid',
  'test_subcategories.name as sub_category','patient_test_details.*','patient_test.dependant_id as persontreated','patient_test.afya_user_id',
  'patient_test.id as ptid')
  ->where('patient_test_details.id', '=',$id)
  ->first();


  return view('test.action')->with('tsts1',$tsts1)->with('alternative',$alternative);
    }


        public function testtransfer($id)
        {
        $tsts1 = DB::table('patient_test_details')
        ->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
        ->Join('appointments', 'patient_test_details.appointment_id', '=', 'appointments.id')
        ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
        ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
        ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
        ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
        ->select('doctors.name as docname','tests.id as tests_id','tests.name as tname','test_categories.name as category','test_subcategories.id as subcatid',
        'test_subcategories.name as sub_category','patient_test_details.*','appointments.persontreated','appointments.afya_user_id',
        'patient_test.id as ptid')
        ->where('patient_test_details.id', '=',$id)
        ->first();


        $alternative = DB::table('patient_test_details')
        ->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
        ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
        ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
        ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
        ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
        ->select('doctors.name as docname','tests.id as tests_id','tests.name as tname','test_categories.name as category','test_subcategories.id as subcatid',
        'test_subcategories.name as sub_category','patient_test_details.*','patient_test.dependant_id as persontreated','patient_test.afya_user_id',
        'patient_test.id as ptid')
        ->where('patient_test_details.id', '=',$id)
        ->first();


        return view('test.testtransfer')->with('tsts1',$tsts1)->with('alternative',$alternative);
                }
        public function actionxray($id)
        {

          $tsts1 = DB::table('radiology_test_details')
          ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
         ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
         ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
          ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
         ->Join('xray', 'radiology_test_details.test', '=', 'xray.id')
         ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
         ->select('appointments.*','appointments.persontreated','test_categories.name as category',
         'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
         'xray.name as tstname','patient_test.id as ptId')
          ->where('radiology_test_details.id', '=',$id)
          ->first();


        $alternative1 = DB::table('radiology_test_details')
       ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
       ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
        ->Join('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
       ->Join('xray', 'radiology_test_details.test', '=', 'xray.id')
       ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
       ->select('patient_test.dependant_id as persontreated','patient_test.afya_user_id','test_categories.name as category',
       'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
       'xray.name as tstname','patient_test.id as ptId')
        ->where('radiology_test_details.id', '=',$id)
        ->first();
       return view('test.actionxray')->with('tsts1',$tsts1)->with('alternative1',$alternative1);
        }
        public function actionmri($id)
        {

          $tsts1 = DB::table('radiology_test_details')
          ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
         ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
         ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
          ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
         ->Join('mri_tests', 'radiology_test_details.test', '=', 'mri_tests.id')
         ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
         ->select('appointments.*','appointments.persontreated','test_categories.name as category',
         'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
         'mri_tests.name as tstname','patient_test.id as ptId')
          ->where('radiology_test_details.id', '=',$id)
          ->first();



          $alternative1 = DB::table('radiology_test_details')
         ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
         ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
          ->Join('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
         ->Join('mri_tests', 'radiology_test_details.test', '=', 'mri_tests.id')
         ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
         ->select('patient_test.dependant_id as persontreated','patient_test.afya_user_id','test_categories.name as category',
         'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
         'mri_tests.name as tstname','patient_test.id as ptId')
          ->where('radiology_test_details.id', '=',$id)
          ->first();
       return view('test.actionmri')->with('tsts1',$tsts1)->with('alternative1',$alternative1);
        }
        public function actionultra($id)
        {
          $tsts1 = DB::table('radiology_test_details')
          ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
         ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
         ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
          ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
         ->Join('ultrasound', 'radiology_test_details.test', '=', 'ultrasound.id')
         ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
         ->select('appointments.*','appointments.persontreated','test_categories.name as category',
         'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
         'ultrasound.name as tstname','patient_test.id as ptId')
          ->where('radiology_test_details.id', '=',$id)
          ->first();

          $alternative1 = DB::table('radiology_test_details')
                    ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
                    ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
                     ->Join('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
                    ->Join('ultrasound', 'radiology_test_details.test', '=', 'ultrasound.id')
                    ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
                    ->select('patient_test.dependant_id as persontreated','patient_test.afya_user_id','test_categories.name as category',
                    'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
                    'ultrasound.name as tstname','patient_test.id as ptId')
                     ->where('radiology_test_details.id', '=',$id)
                     ->first();
       return view('test.actionultra')->with('tsts1',$tsts1)->with('alternative1',$alternative1);
        }
        public function actionct($id)
        {

          $tsts1 = DB::table('radiology_test_details')
          ->Join('appointments', 'radiology_test_details.appointment_id', '=', 'appointments.id')
         ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
         ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
          ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
         ->Join('ct_scan', 'radiology_test_details.test', '=', 'ct_scan.id')
         ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
         ->select('appointments.*','appointments.persontreated','test_categories.name as category',
         'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
         'ct_scan.name as tstname','patient_test.id as ptId')
          ->where('radiology_test_details.id', '=',$id)
          ->first();

         $alternative1 = DB::table('radiology_test_details')
                   ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
                   ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
                    ->Join('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
                   ->Join('ct_scan', 'radiology_test_details.test', '=', 'ct_scan.id')
                   ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
                   ->select('patient_test.dependant_id as persontreated','patient_test.afya_user_id','test_categories.name as category',
                   'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
                   'ct_scan.name as tstname','patient_test.id as ptId')
                    ->where('radiology_test_details.id', '=',$id)
                    ->first();
       return view('test.actionct')->with('tsts1',$tsts1)->with('alternative1',$alternative1);
        }
        public function grapherxray($id)
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
         'xray.name as tstname','xray.technique','xray.id as xrayid','patient_test.id as ptId')
          ->where('radiology_test_details.id', '=',$id)
          ->first();

          $alternative1 = DB::table('radiology_test_details')
                  ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
                  ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
                   ->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
                  ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
                  ->Join('xray', 'radiology_test_details.test', '=', 'xray.id')
                  ->select('patient_test.dependant_id as persontreated','patient_test.afya_user_id','test_categories.name as category',
                  'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
                  'xray.name as tstname','patient_test.id as ptId','xray.id as xrayid','xray.technique')
                   ->where('radiology_test_details.id', '=',$id)
                   ->first();
       return view('test.xrayreport')->with('tsts1',$tsts1)->with('id',$id)->with('alternative1',$alternative1);
        }
        public function graphermri($id)
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
         'mri_tests.name as tstname','mri_tests.technique','mri_tests.id as mriid','patient_test.id as ptId')
          ->where('radiology_test_details.id', '=',$id)
          ->first();

          $alternative1 = DB::table('radiology_test_details')
                  ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
                  ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
                   ->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
                  ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
                  ->Join('mri_tests', 'radiology_test_details.test', '=', 'mri_tests.id')
                  ->select('patient_test.dependant_id as persontreated','patient_test.afya_user_id','test_categories.name as category',
                  'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
                  'mri_tests.name as tstname','patient_test.id as ptId','mri_tests.id as mriid','mri_tests.technique')
                   ->where('radiology_test_details.id', '=',$id)
                   ->first();
       return view('test.mrireport')->with('tsts1',$tsts1)->with('id',$id)->with('alternative1',$alternative1);
        }
        public function grapherct($id)
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
         'ct_scan.name as tstname','ct_scan.technique','ct_scan.id as ctid','patient_test.id as ptId')
          ->where('radiology_test_details.id', '=',$id)
          ->first();

          $alternative1 = DB::table('radiology_test_details')
                  ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
                  ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
                   ->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
                  ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
                  ->Join('ct_scan', 'radiology_test_details.test', '=', 'ct_scan.id')
                  ->select('patient_test.dependant_id as persontreated','patient_test.afya_user_id','test_categories.name as category',
                  'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
                  'ct_scan.name as tstname','patient_test.id as ptId','ct_scan.id as ctid','ct_scan.technique')
                   ->where('radiology_test_details.id', '=',$id)
                   ->first();
       return view('test.ctreport')->with('tsts1',$tsts1)->with('id',$id)->with('alternative1',$alternative1);
        }
        public function grapherultra($id)
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
         'ultrasound.name as tstname','ultrasound.technique','ultrasound.id as ultraid','patient_test.id as ptId')
          ->where('radiology_test_details.id', '=',$id)
          ->first();

          $alternative1 = DB::table('radiology_test_details')
                  ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
                  ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
                   ->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
                  ->Join('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
                  ->Join('ultrasound', 'radiology_test_details.test', '=', 'ultrasound.id')
                  ->select('patient_test.dependant_id as persontreated','patient_test.afya_user_id','test_categories.name as category',
                  'radiology_test_details.*','radiology_test_details.id as rtdid','doctors.name as docname',
                  'ultrasound.name as tstname','patient_test.id as ptId','ultrasound.id as ultraid','ultrasound.technique')
                   ->where('radiology_test_details.id', '=',$id)
                   ->first();

       return view('test.ultrareport')->with('tsts1',$tsts1)->with('id',$id)->with('alternative1',$alternative1);
        }

public function testupdate(Request $request){
  $now = Carbon::now();
  $test1 =$request->test_rid;
  $value =$request->value;
  $ptd_id= $request->ptd_id;
if($test1){
  DB::table('test_results')
    ->where('id', $test1)
    ->update(
      ['value' => $value , 'updated_at'=> $now]  );
    }
    $tsts1 = DB::table('patient_test_details')
    ->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
    ->Join('appointments', 'patient_test_details.appointment_id', '=', 'appointments.id')
    ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
    ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
    ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
    ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
    ->select('doctors.name as docname','tests.id as tests_id','tests.name as tname','test_categories.name as category','test_subcategories.id as subcatid',
    'test_subcategories.name as sub_category','patient_test_details.*','appointments.persontreated','appointments.afya_user_id',
    'patient_test.id as ptid')
    ->where('patient_test_details.id', '=',$ptd_id)
    ->first();


    $alternative = DB::table('patient_test_details')
    ->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
    ->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
    ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
    ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
    ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
    ->select('doctors.name as docname','tests.id as tests_id','tests.name as tname','test_categories.name as category','test_subcategories.id as subcatid',
    'test_subcategories.name as sub_category','patient_test_details.*','patient_test.dependant_id as persontreated','patient_test.afya_user_id',
    'patient_test.id as ptid')
    ->where('patient_test_details.id', '=',$ptd_id)
    ->first();

  return view('test.report2')->with('tsts1',$tsts1)->with('alternative',$alternative);

}

function Strength(){
 $Strength = DB::table('strength')
 ->get();
return $Strength;
}
function RouteM(){
 $routem = DB::table('route')
 ->get();
return $routem;
}
function Frequency(){
 $frequency = DB::table('frequency')
 ->get();
return $frequency;
}
  public function TestListdetails(){
    $testsd = DB::table('test_details')
    ->get();
   return $testsd;
}

public function fdrugs(Request $request)
 {
     $term = trim($request->q);
  if (empty($term)) {
       return \Response::json([]);
     }
   $drugs = Druglist::search($term)->limit(50)->get();
     $formatted_drugs = [];
      foreach ($drugs as $drug) {
         $formatted_drugs[] = ['id' => $drug->id, 'text' => $drug->drugname];
     }
 return \Response::json($formatted_drugs);
 }
 function TDetails(){

   $TDetails = DB::table('facility_test')
   ->leftJoin('facilities', 'facility_test.facilitycode', '=', 'facilities.FacilityCode')
   ->where('facility_test.user_id', '=', Auth::user()->id)->get();
  return $TDetails;
}

function testesd(){

$facid = DB::table('facility_test')->where('user_id', '=', Auth::user()->id)->first();

$tsts = DB::table('patient_test')
->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
->Join('patient_test_details', 'patient_test.appointment_id', '=', 'patient_test_details.appointment_id')
->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->select('afya_users.*','patient_test.id as tid','patient_test.created_at as date',
'patient_test.test_status','doctors.name as doc','facilities.FacilityName as fac',
'appointments.persontreated',
'dependant.firstName as depname','dependant.secondName as depname2',
'dependant.gender as depgender','dependant.dob as depdob')
->where([
           ['patient_test_details.done', '=',1],
           ['patient_test_details.deleted', '=',0],
           ['patient_test_details.facility_done', '=',$facid->facilitycode],
         ])
        //  ['afyamessages.test_center_code', '=',$facid->facilitycode],

->groupBy('appointments.id')
->get();

$alternative = DB::table('afya_users')
->Join('patient_test', 'patient_test.afya_user_id', '=', 'afya_users.id')
->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
->leftJoin('dependant', 'patient_test.dependant_id', '=', 'dependant.id')
->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
->select('afya_users.*','patient_test.id as tid','patient_test_details.created_at as date',
'patient_test.test_status','doctors.name as doc','facilities.FacilityName as fac',
'patient_test.dependant_id as persontreated',
'dependant.firstName as depname','dependant.secondName as depname2',
'dependant.gender as depgender','dependant.dob as depdob')
->where([
           ['patient_test_details.done', '=',1],
           ['patient_test_details.deleted', '=',0],
           ['patient_test_details.facility_done', '=',$facid->facilitycode],
         ])

->groupBy('patient_test.id')
->get();
  return view('test.homedone')->with('tsts',$tsts)->with('alternative',$alternative);
}
function testesdR(){

  $facid = DB::table('facility_test')->where('user_id', '=', Auth::user()->id)->first();
  return view('test.homedonerad')->with('facid',$facid);
}
public function testsdone($id){

  $pdetails = DB::table('patient_test')
  ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->leftJoin('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
 ->select('appointments.*','doctors.name as docname','patient_test_details.appointment_id as appid',
  'patient_test_details.id as ptd_id','patient_test.id as ptid')
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
    'patient_test_details.id as patTdid','test_categories.name as tcname','patient_test_details.testmore',
    'patient_test_details.tests_reccommended','appointments.id as AppId')

    ->where([
                  ['patient_test.id', '=',$id],
                  ['patient_test_details.done', '=',1],
                  ['patient_test_details.deleted', '=',0],

                 ])
    ->get();
return view('test.pdetailsdone')->with('tsts',$tsts)->with('pdetails',$pdetails);
}
public function viewtest($id)
{
$tsts1 = DB::table('patient_test_details')
->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
->Join('appointments', 'patient_test_details.appointment_id', '=', 'appointments.id')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
 ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
  ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
  ->select('doctors.name as docname','tests.id as tests_id','tests.name','test_categories.name as category','test_subcategories.id as subcatid',
  'test_subcategories.name as sub_category','patient_test_details.*','appointments.persontreated','appointments.afya_user_id')
  ->where('patient_test_details.id', '=',$id)
  ->first();
   return view('test.actiondone')->with('tsts1',$tsts1);
}
public function Finito($id)
{
  $fac = DB::table('facility_test')->select('facilitycode')->where('user_id', '=',Auth::user()->id)->first();
  $facility=$fac->facilitycode;
  $msgs = DB::table('afya_users')
  ->Join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
  ->select('afyamessages.*')
  ->where([  ['afyamessages.test_center_code', '=',$facility],
             ['afya_users.id', '=',$id],
  ])
  ->whereNull('afyamessages.status')
  ->first();
  $msgsid=$msgs->id;
$now = Carbon::now();
    DB::table('afyamessages')
               ->where('id', $msgsid)
              ->update(['status' => 1, 'updated_at'=> $now]  );

      return redirect()->action('TestController@index');

}

}
