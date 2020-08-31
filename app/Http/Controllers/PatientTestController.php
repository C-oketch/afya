<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Patienttest;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;

class PatientTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

public function alltestdata($id)
{

  $pdetails=DB::table('appointments')
  ->leftjoin('triage_details','appointments.id','=','triage_details.appointment_id')
  ->leftjoin('triage_infants','appointments.id','=','triage_infants.appointment_id')
->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
->leftjoin('dependant','appointments.persontreated','=','dependant.id')
->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition',
    'triage_details.lmp as almp','triage_details.pregnant as apregnant','triage_infants.lmp as dlmp','triage_infants.pregnant as dpregnant')
  ->where('appointments.id',$id)
  ->first();


  $appdetails=DB::table('appointments')->where('id','=',$id)->first();
  $afyaId =$appdetails->afya_user_id;
  $data['user']=DB::table('afya_users')->where('id',$afyaId)->first();


      $data['path']=DB::table('facility_doctor')
      ->join('facilities','facility_doctor.facilitycode', '=', 'facilities.FacilityCode')
      ->select('facilities.payment','facility_doctor.facilitycode')
      ->where('facility_doctor.user_id',Auth::user()->id)
      ->first();



  return view('doctor.tests.alltest',$data)->with('pdetails',$pdetails)->with('appdetails',$appdetails);
}




    public function testdata($id)
    {

      $data['patientD']=DB::table('appointments')
      ->leftjoin('triage_details','appointments.id','=','triage_details.appointment_id')
      ->leftjoin('triage_infants','appointments.id','=','triage_infants.appointment_id')
      ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
      ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
      ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
        'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
        'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition',
        'triage_details.lmp as almp','triage_details.pregnant as apregnant','triage_infants.lmp as dlmp','triage_infants.pregnant as dpregnant')
      ->where('appointments.id',$id)
      ->get();

$exist = DB::table('test_price')
       ->join('facility_doctor','test_price.facility_id','=','facility_doctor.facilitycode')
       ->select('test_price.id')
       ->where('facility_doctor.user_id', Auth::user()->id)
      ->first();
if($exist){
      $data['tests'] = DB::table('tests')
             ->Join('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
             ->Join('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
             ->join('test_price','tests.id','=','test_price.tests_id')
             ->join('facility_doctor','test_price.facility_id','=','facility_doctor.facilitycode')
             ->select('tests.id as testId','tests.name as tname','test_subcategories.name as subname',
             'test_categories.name as cname')
             ->where('facility_doctor.user_id', Auth::user()->id)
            ->get();
}else{
$data['tests'] = DB::table('tests')
 ->Join('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
 ->Join('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
 // ->join('test_price','tests.id','=','test_price.tests_id')
 // ->join('facility_doctor','test_price.facility_id','=','facility_doctor.facilitycode')
 ->select('tests.id as testId','tests.name as tname','test_subcategories.name as subname',
 'test_categories.name as cname')
 // ->where('facility_doctor.user_id', Auth::user()->id)
->get();
}
  return view('doctor.tests.test',$data);
}

public function test_all($id)
    {
  $pdetails=DB::table('appointments')
      ->leftjoin('triage_details','appointments.id','=','triage_details.appointment_id')
      ->leftjoin('triage_infants','appointments.id','=','triage_infants.appointment_id')
      ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
      ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
      ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
        'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
        'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition',
        'triage_details.lmp as almp','triage_details.pregnant as apregnant','triage_infants.lmp as dlmp','triage_infants.pregnant as dpregnant')
      ->where('appointments.id',$id)
      ->first();



      $data['tstdone'] = DB::table('patient_test')
      ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
      ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
      ->leftJoin('facilities', 'patient_test_details.facility_done', '=', 'facilities.id')
      ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
      ->leftJoin('patientNotes', 'patient_test_details.id', '=', 'patientNotes.ptd_id')
      ->select('patient_test_details.id as ptdid','patient_test_details.*','facilities.*','tests.name','patientNotes.note')
      // ->Where('appointments.id', '=',$id)
      ->where('patient_test_details.deleted', '=',0)
      ->orderBy('patient_test_details.created_at', 'desc')
      ->get();

    $data['mri']= DB::table('patient_test')
        ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
        ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
        ->Join('mri_tests', 'radiology_test_details.test', '=', 'mri_tests.id')
       ->select('radiology_test_details.*','mri_tests.name as tname')
       ->where([['radiology_test_details.test_cat_id', '=',11],
       ['radiology_test_details.deleted', '=',0],])
        ->orderBy('radiology_test_details.created_at', 'desc')
        ->get();

        $data['ct_scan']= DB::table('patient_test')
        ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
        ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
        ->Join('ct_scan', 'radiology_test_details.test', '=', 'ct_scan.id')
       ->select('radiology_test_details.*','ct_scan.name as tname')
       ->where([['radiology_test_details.test_cat_id', '=',9],
     ['radiology_test_details.deleted', '=',0],])
        ->orderBy('radiology_test_details.created_at', 'desc')
        ->get();

        $data['ultrasound'] = DB::table('patient_test')
        ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
        ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
        ->Join('ultrasound', 'radiology_test_details.test', '=', 'ultrasound.id')
       ->select('radiology_test_details.*','ultrasound.name as tname')
       ->where([['radiology_test_details.test_cat_id', '=',12],
     ['radiology_test_details.deleted', '=',0],])
        ->orderBy('radiology_test_details.created_at', 'desc')
        ->get();

        $data['xray']  = DB::table('patient_test')
        ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
        ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
        ->Join('xray', 'radiology_test_details.test', '=', 'xray.id')
       ->select('radiology_test_details.*','xray.name as tname')
       ->where([['radiology_test_details.test_cat_id', '=',10],
     ['radiology_test_details.deleted', '=',0],])
        ->orderBy('radiology_test_details.created_at', 'desc')
        ->get();

        $data['otherimaging']  = DB::table('radiology_test_details')
        ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
        ->Join('other_tests', 'radiology_test_details.test', '=', 'other_tests.id')
       ->select('radiology_test_details.*','other_tests.name as tname')
       ->where([['radiology_test_details.test_cat_id', '=',13],
      ['radiology_test_details.deleted', '=',0],])
        ->orderBy('radiology_test_details.created_at', 'desc')
        ->get();

        $data['cardiac']  = DB::table('patient_test_details_c')
        ->Join('patient_test', 'patient_test_details_c.patient_test_id', '=', 'patient_test.id')
        ->Join('tests_cardiac', 'patient_test_details_c.tests_reccommended', '=', 'tests_cardiac.id')
        ->select('patient_test_details_c.*','tests_cardiac.name as tname')
        ->where('patient_test_details_c.deleted', '=',0)
        ->orderBy('patient_test_details_c.created_at', 'desc')
        ->get();

        $data['neurology']  = DB::table('patient_test_details_n')
        ->Join('patient_test', 'patient_test_details_n.patient_test_id', '=', 'patient_test.id')
        ->Join('tests_neurology', 'patient_test_details_n.tests_reccommended', '=', 'tests_neurology.id')
        ->select('patient_test_details_n.*','tests_neurology.name as tname')
        ->where('patient_test_details_n.deleted', '=',0)
        ->orderBy('patient_test_details_n.created_at', 'desc')
        ->get();
        $data['procedure']  = DB::table('patient_procedure_details')
        ->Join('patient_test', 'patient_procedure_details.patient_test_id', '=', 'patient_test.id')
        ->Join('procedures', 'patient_procedure_details.procedure_id', '=', 'procedures.id')
        ->select('patient_procedure_details.*','procedures.name as tname')
        ->where('patient_procedure_details.deleted', '=',0)
        ->orderBy('patient_procedure_details.created_at', 'desc')
        ->get();

      return view('doctor.tests.test_all',$data)->with('pdetails',$pdetails);
}

public function testsImaging($id)
{

  $data['patientD']=DB::table('appointments')
  ->leftjoin('triage_details','appointments.id','=','triage_details.appointment_id')
  ->leftjoin('triage_infants','appointments.id','=','triage_infants.appointment_id')
->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
->leftjoin('dependant','appointments.persontreated','=','dependant.id')
->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition',
    'triage_details.lmp as almp','triage_details.pregnant as apregnant','triage_infants.lmp as dlmp','triage_infants.pregnant as dpregnant')
  ->where('appointments.id',$id)
  ->get();

  $exist = DB::table('test_prices_ct_scan')
  ->join('facility_doctor','test_prices_ct_scan.facility_id','=','facility_doctor.facilitycode')
  ->where('facility_doctor.user_id', Auth::user()->id)
  ->select('test_prices_ct_scan.id')
  ->first();
if($exist){
  $data['cttests'] = DB::table('ct_scan')
  ->join('test_prices_ct_scan','ct_scan.id','=','test_prices_ct_scan.ct_scan_id')
  ->join('facility_doctor','test_prices_ct_scan.facility_id','=','facility_doctor.facilitycode')
  ->where('facility_doctor.user_id', Auth::user()->id)
  ->select('ct_scan.*')
  ->get();
}else{
  $data['cttests'] = DB::table('ct_scan')->get();
}

  return view('doctor.tests.imgtest',$data);
}

public function testdatamri($id)
{

$data['patientD']=DB::table('appointments')
->leftjoin('triage_details','appointments.id','=','triage_details.appointment_id')
->leftjoin('triage_infants','appointments.id','=','triage_infants.appointment_id')
->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
->leftjoin('dependant','appointments.persontreated','=','dependant.id')
->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition',
'triage_details.lmp as almp','triage_details.pregnant as apregnant','triage_infants.lmp as dlmp','triage_infants.pregnant as dpregnant')
->where('appointments.id',$id)
->get();

$exist = DB::table('test_prices_mri')
->join('facility_doctor','test_prices_mri.facility_id','=','facility_doctor.facilitycode')
->select('test_prices_mri.id')
->where('facility_doctor.user_id', Auth::user()->id)
->first();
if($exist){
$data['cttests'] = DB::table('mri_tests')
->join('test_prices_mri','mri_tests.id','=','test_prices_mri.mri_id')
->join('facility_doctor','test_prices_mri.facility_id','=','facility_doctor.facilitycode')
->select('mri_tests.*')
->where('facility_doctor.user_id', Auth::user()->id)
->get();
}else{
$data['cttests'] = DB::table('mri_tests')->get();
}



return view('doctor.tests.imgmri',$data);
}

public function testdataultra($id)
{

$data['patientD']=DB::table('appointments')
->leftjoin('triage_details','appointments.id','=','triage_details.appointment_id')
->leftjoin('triage_infants','appointments.id','=','triage_infants.appointment_id')
->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
->leftjoin('dependant','appointments.persontreated','=','dependant.id')
->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition',
'triage_details.lmp as almp','triage_details.pregnant as apregnant','triage_infants.lmp as dlmp','triage_infants.pregnant as dpregnant')
->where('appointments.id',$id)
->get();


$cexist = DB::table('test_prices_ultrasound')
->join('facility_doctor','test_prices_ultrasound.facility_id','=','facility_doctor.facilitycode')
->where('facility_doctor.user_id', Auth::user()->id)
->select('test_prices_ultrasound.id')
->get();
if($cexist){
$data['cttests'] = DB::table('ultrasound')
->join('test_prices_ultrasound','ultrasound.id','=','test_prices_ultrasound.ultrasound_id')
->join('facility_doctor','test_prices_ultrasound.facility_id','=','facility_doctor.facilitycode')
->where('facility_doctor.user_id', Auth::user()->id)
->select('ultrasound.*')
->get();
}else{
$data['cttests'] = DB::table('ultrasound')->get();
}
return view('doctor.tests.imgultra',$data);
}

public function testdataxray($id)
{

$data['patientD']=DB::table('appointments')
->leftjoin('triage_details','appointments.id','=','triage_details.appointment_id')
->leftjoin('triage_infants','appointments.id','=','triage_infants.appointment_id')
->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
->leftjoin('dependant','appointments.persontreated','=','dependant.id')
->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition',
'triage_details.lmp as almp','triage_details.pregnant as apregnant','triage_infants.lmp as dlmp','triage_infants.pregnant as dpregnant')
->where('appointments.id',$id)
->get();



$exist = DB::table('test_prices_xray')
->join('facility_doctor','test_prices_xray.facility_id','=','facility_doctor.facilitycode')
->where('facility_doctor.user_id', Auth::user()->id)
->select('test_prices_xray.id')
->get();
if($exist){
$data['cttests'] = DB::table('xray')
->join('test_prices_xray','xray.id','=','test_prices_xray.xray_id')
->join('facility_doctor','test_prices_xray.facility_id','=','facility_doctor.facilitycode')
->where('facility_doctor.user_id', Auth::user()->id)
->select('xray.*')
->get();
}else{
$data['cttests'] = DB::table('xray')->get();
}

return view('doctor.tests.imgxray',$data);
}

public function testesImage($id)
{

$data['patientD']=DB::table('appointments')
->leftjoin('triage_details','appointments.id','=','triage_details.appointment_id')
->leftjoin('triage_infants','appointments.id','=','triage_infants.appointment_id')
->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
->leftjoin('dependant','appointments.persontreated','=','dependant.id')
->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition',
'triage_details.lmp as almp','triage_details.pregnant as apregnant','triage_infants.lmp as dlmp','triage_infants.pregnant as dpregnant')
->where('appointments.id',$id)
->get();

$exist = DB::table('other_tests')
->join('test_prices_other','other_tests.id','=','test_prices_other.other_id')
->join('facility_doctor','test_prices_other.facility_id','=','facility_doctor.facilitycode')
->where('facility_doctor.user_id', Auth::user()->id)
->select('other_tests.id')
->first();
if($exist){
 $data['cttests'] = DB::table('other_tests')
->join('test_prices_other','other_tests.id','=','test_prices_other.other_id')
->join('facility_doctor','test_prices_other.facility_id','=','facility_doctor.facilitycode')
->where('facility_doctor.user_id', Auth::user()->id)
->select('other_tests.*')
->get();
}else{
$data['cttests'] = DB::table('other_tests')->get();
}

return view('doctor.tests.testesImage',$data);
}

    public function destroytest($id)
    {
      $pttd=DB::table('patient_test_details')
      ->where('id',$id)
      ->first();

      DB::table("patient_test_details")->where('id',$id)->update(array('deleted'=>1));

return redirect()->action('PatientTestController@test_all', ['id' => $pttd->appointment_id]);

}

public function diagnosesconf(Request $request)
{
 $appointment=$request->appointment_id;
 $pat_details_id = $request->pat_details_id;

  $patientD=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','patient_admitted.condition','facilities.set_up')
  ->where('appointments.id',$appointment)
  ->get();

  $patientT=DB::table('patient_test_details')
  ->select('patient_test_details.id as ptdid','patient_test_details.tests_reccommended as ptest',
  'patient_test_details.results','patient_test_details.note','patient_test_details.patient_test_id as ptid')
  ->where('patient_test_details.id', $pat_details_id)
  ->first();

  return view('doctor.diagnosisconfirm')->with('patientD',$patientD)->with('patientT',$patientT);
}




public function discharges($id)
{

  $patientD=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
 ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->get();
  return view('doctor.discharge')->with('patientD',$patientD);
}

public function admit($id)
{

  $pdetails=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->first();


  return view('doctor.admit')->with('pdetails',$pdetails);


}


public function transfer($id)
{
  $patientD=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->get();

  return view('doctor.transfer')->with('patientD',$patientD);


}
public function disdiagnosis($id)
{
  $patientD=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->get();
  return view('doctor.disdiagnosis')->with('patientD',$patientD);
}

public function disprescription($id)
{
  $patientD=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->get();

  $Pdiagnosis=DB::table('patient_diagnosis')
  ->leftjoin('icd10_option','patient_diagnosis.disease_id','=','icd10_option.id')
  ->leftjoin('severity','patient_diagnosis.severity','=','severity.id')
  ->select('icd10_option.name','patient_diagnosis.level','severity.name as severity','icd10_option.id')

  ->where([
                ['patient_diagnosis.appointment_id',$id],
                ['patient_diagnosis.state', '=', 'Discharge'],

               ])
  ->get();

  return view('doctor.disprescription')->with('patientD',$patientD)->with('Pdiagnosis',$Pdiagnosis);
}

  public function Testconfirm(Request $request){
          $appid = $request->appid;
          $ptdid = $request->ptdid;

          $appointy = DB::table('appointments')->where('id', $appid)  ->first();
   if($appointy->last_app_id){$appid2=$appointy->last_app_id;}else{$appid2=$appid;}

          DB::table('patient_test_details')->where('id', $ptdid)
          ->update(['confirm' =>'Y']);

          // $appid = DB::table('patient_test_details')->where('id', $ptdid)
          // ->first();

          $tNY = DB::table('patient_test_details')
          ->where([['appointment_id','=', $appid2],
          ['confirm','=', 'N'],])
          ->first();
        if ($tNY){

        return redirect()->route('alltestes',$appid);
        // return redirect()->action('PatientTestController@alltestdatal', ['id' => $appid]);

        }else{
        return redirect()->route('medicines',$appid);
       }


      }




}
