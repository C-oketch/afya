<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Doctor;
use Carbon\Carbon;
use Auth;
use App\Patient;
use App\Facility;
use App\Smokinghistory;
use App\Alcoholhistory;
use PDF;
class PatientController extends Controller
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
      $id = Auth::id();
      $patient=DB::table('afya_users')->where('users_id',$id)->first();
      $credentials=DB::table('users')->where('id',$id)->first();

      $kin = DB::table('kin_details')->where('afya_user_id',$patient->id)->first();

      if (is_null($kin)){
        $nextkin='';
      }else{
      $nextkin=DB::table('kin_details')
      ->join('kin','kin.id','=','kin_details.relation')
      ->select('kin_details.kin_name','kin_details.phone_of_kin',
        'kin.relation')->where('kin_details.afya_user_id',$patient->id)->first();
      }
        return view('patient.home')->with('patient',$patient)->with('credentials',$credentials)->with('nextkin',$nextkin);
    }
    public function patientAllergies(){
      $id = Auth::id();
      $patient=DB::table('afya_users')->where('users_id',$id)->first();


      return view('patient.patientallery')->with('patient',$patient);
    }

    public function getDependant(){
       $id = Auth::id();
            $patient=DB::table('afya_users')->where('users_id',$id)->first();
      return view('patient.patientdependants')->with('patient',$patient);
    }

  public function Expenditure(){
    $id = Auth::id();
      $patient=DB::table('afya_users')->where('users_id',$id)->first();

    return view('patient.expenditure')->with('patient',$patient);
  }
    public function patientAppointment(){
      return view('patient.appointment');
    }
    public function patientCalendar(){
      return view('patient.calendar');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function showpatient($id)
     {
       $patientdetails = DB::table('appointments')
       ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
       ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
       ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
       ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
       ->select('appointments.*','afya_users.*','appointments.id as appid',
         'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
         'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
       ->where('appointments.id',$id)
       ->get();
return view('doctor.show')->with('patientdetails',$patientdetails);
}

public function history($id)
{
  $pdetails=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
   ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->join('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','afya_users.dob','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->first();


  return view('doctor.history')->with('pdetails',$pdetails);
}

public function P_history($id)
{
  $pdetails=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
   ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->join('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','afya_users.dob','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->first();
  return view('doctor.history2')->with('pdetails',$pdetails);
}

public function P_history2($id)
{
  $pdetails=DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
   ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->join('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','afya_users.dob','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->first();
  return view('doctor.history22')->with('pdetails',$pdetails);
}

public function examination($id)
{
  $pdetails = DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->select('appointments.*','afya_users.dob','afya_users.firstname','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->first();
  return view('doctor.examination')->with('pdetails',$pdetails);
}

public function patreview($id)
{
  $pdetails = DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->select('appointments.*','afya_users.dob','afya_users.firstname','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->first();

  $data['revs'] = DB::table('appointments')
  ->join('patient_review','appointments.id','=','patient_review.appointment_id')
  ->select('patient_review.notes','patient_review.created_at')
  ->where('appointments.id',$id)
  ->orderby('patient_review.created_at','Desc')
  ->get();
  $data['revstoday'] = DB::table('appointments')
  ->join('patient_diagnosis','appointments.afya_user_id','=','patient_diagnosis.afya_user_id')
  ->join('patient_review','appointments.id','=','patient_review.appointment_id')
  ->select('patient_diagnosis.disease_id as condition','patient_diagnosis.id','patient_review.notes','patient_review.created_at')
  ->where('appointments.id',$id)
  ->orderby('patient_review.created_at','Desc')
  ->first();
  $data['diagnosis'] = DB::table('appointments')
  ->join('patient_diagnosis','appointments.afya_user_id','=','patient_diagnosis.afya_user_id')
  ->select('patient_diagnosis.disease_id as condition','patient_diagnosis.id')
  ->where('appointments.id',$id)
  ->orderby('patient_diagnosis.id','Desc')
  ->get();

  return view('doctor.patreview',$data)->with('pdetails',$pdetails);
}

public function patsamury($id)
{
  $pdetails = DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->select('appointments.*','afya_users.id as afyaId','afya_users.dob','afya_users.firstname','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->first();

  $data['psummary'] = DB::table('patient_summary')->where('appointment_id',$id)->first();
  $data['drugs'] = DB::table('current_medication')->where('appointment_id',$id)->get();
  $data['cmed'] = DB::table('current_medication')->where('appointment_id',$id)->get();
  $data['medh'] = DB::table('patient_diagnosis')->where('afya_user_id',$pdetails->afyaId)->get();
  $data['allergies'] = DB::table('afya_users_allergy')->where('afya_user_id',$pdetails->afyaId)->get();
  $data['fsummary'] = DB::table('family_summary')->where([['afya_user_id',$pdetails->afyaId],['family_members',"Father"]])->first();
  $data['msummary'] = DB::table('family_summary')->where([['afya_user_id',$pdetails->afyaId],['family_members',"Mother"]])->first();
  $data['bsummary'] = DB::table('family_summary')->where([['afya_user_id',$pdetails->afyaId],['family_members',"Brother"]])->first();
  $data['ssummary'] = DB::table('family_summary')->where([['afya_user_id',$pdetails->afyaId],['family_members',"Sister"]])->first();
  $data['smoking']=Smokinghistory::where('afya_user_id','=',$pdetails->afyaId)->first();
  $data['alcohol']=Alcoholhistory::where('afya_user_id','=',$pdetails->afyaId)->first();


  return view('doctor.patsamury',$data)->with('pdetails',$pdetails);
}

public function impression($id)
 {

  $pdetails = DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->select('appointments.*','afya_users.dob','afya_users.firstname','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->first();


  return view('doctor.impression')->with('pdetails',$pdetails);
}

public function impedit($id)
 {
   $imp= DB::table('impression')->where('id',$id)->first();
$appid = $imp->appointment_id;
   $pdetails = DB::table('appointments')
   ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
   ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
   ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
   ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
   ->select('appointments.*','afya_users.dob','afya_users.firstname','afya_users.secondName','afya_users.gender',
     'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
     'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
   ->where('appointments.id',$appid)
   ->first();


   return view('doctor.impression_edit')->with('pdetails',$pdetails)->with('imp',$imp);
 }

 public function impremove($id)
  {
$appid_id = DB::table('impression')->select('appointment_id')->where('id',$id)->first();
$appid = $appid_id->appointment_id;
DB::table("impression")->where('id',$id)->delete();

      return redirect()->action('PatientController@impression', [$appid]);
  }




public function facilitiesList(){
  $facilityList = Facility::lists('FacilityCode', 'FacilityName');

return  compact('facilityList');
}

public function receipts($id)
{


  $category_id = DB::table('payments_categories')
  ->where('payments_categories.category_name', '=', 'Consultation')
  ->first();
  $cat_id = $category_id->id;

  $person = DB::table('appointments')
  ->join('payments', 'payments.appointment_id', '=', 'appointments.id')
  ->select('appointments.persontreated')
  ->where('payments.id', '=', $id)
  ->first();
  $person_treated = $person->persontreated;

  if($person_treated == 'Self')
  {
    $expenditures = DB::table('payments')
    ->join('appointments', 'appointments.id', '=', 'payments.appointment_id')
    ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
    ->join('facilities', 'facilities.FacilityCode', '=', 'appointments.facility_id')
    ->select('afya_users.firstname as fname', 'afya_users.secondName as sname', 'afya_users.email', 'afya_users.msisdn',
    'facilities.*', 'payments.amount', 'payments.created_at')
    ->where('payments.id', '=', $id)
    ->first();

    $dy=$expenditures->created_at;
    $dys=date("d-M-Y", strtotime( $dy));
    $last = $id;
    $last ++;

// $expenditures=DB::table('consultation_fees')
// ->join('facilities','facilities.FacilityCode','=','consultation_fees.facility')
// ->where('consultation_fees.id',$id)
// ->select('consultation_fees.*','facilities.*')
// ->first();


    $number = sprintf('%07d', $last);

  }
  else
  {
    $expenditures = DB::table('payments')
    ->join('appointments', 'appointments.id', '=', 'payments.appointment_id')
    ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
    ->join('facilities', 'facilities.FacilityCode', '=', 'appointments.facility_id')
    ->join('dependant', 'dependant.id', '=', 'appointments.persontreated')
    ->select('afya_users.firstName as fname', 'afya_users.secondName as sname', 'afya_users.email', 'afya_users.msisdn',
    'facilities.*', 'payments.amount', 'payments.created_at')
    ->where('payments.id', '=', $id)
    ->first();

    $dy=$expenditures->created_at;
    $dys=date("d-M-Y", strtotime( $dy));
    $last = $id;
    $last ++;

    $number = sprintf('%07d', $last);

  }

return view('receipts.patient')->with('expenditures',$expenditures)->with('dys',$dys)->with('number',$number);



}

public function selfReporting(){
$id = Auth::id();


  return view('patient.selfreport')->with('id',$id);
}

public function self($id){

//   $afyauserId = DB::table('afya_users')->Select('id')->where('users_id', '=', $id)->first();
$afyaId=$id;
  $selfs=DB::table('self_report')->where([['afyauser_id',$id],['dependents','=','Self']])
  ->orderby('created_at','DESC')->get();

  $patientstarget=DB::table('self_report_target')
  ->select('temperature as temptrgt','weight as weighttrgt','bp as bptrgt','fasting_sugars as fstrgt',
  'before_meal_sugars as bmstrgt','postprondrial_sugars as ppstrgt')
   ->where([['afyauser_id',$id],['dependents','=','Self']])
  ->First();

  return view('patient.self')->with('selfs',$selfs)->with('afyaId',$afyaId)->with('patientstarget',$patientstarget);
}

public function dependant($id){


  return view('patient.dependant')->with('id',$id);
}

public function addselfreport($id){

  return view('patient.addselfreport')->with('id',$id);
}

public function createselfreport(Request $request){
  $id=$request->id;
  $temperature=$request->temperature;
  $weight=$request->weight;
  $bp=$request->bp;
  $fasting_sugars=$request->fasting_sugars;
  $before_meals_sugars=$request->before_meals_sugars;
  $postprondrial_sugars=$request->postprondrial_sugars;

  DB::table('self_report')->insert([
    'afyauser_id'=>$id,
    'temperature'=>$temperature,
    'weight'=>$weight,
    'bp'=>$bp,
    'fasting_sugars'=>$fasting_sugars,
    'before_meal_sugars'=>$before_meals_sugars,
    'postprondrial_sugars'=>$postprondrial_sugars,
    'dependents'=>'Self',
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);


  return redirect()->action('PatientController@self',['id'=> $id]);
}

public function dependantself($id){

  $data['dependant']=DB::table('dependant')->where('id',$id)->first();
  $data['selfs']=DB::table('self_report')->where('dependents',$id)->orderby('created_at','DESC')->get();
  $data['id']=$id;

  return view('patient.dependantself')->with('data',$data);
}

public function depAddselfreport($id){
   $data['dependant']=DB::table('dependant')->where('id',$id)->first();
  $data['id']=$id;

  return view('patient.depaddselfreport')->with('data',$data);
}

public function createdepselfreport(Request $request){


  $id=$request->id;
  $temperature=$request->temperature;
  $difficulty_breathing=$request->difficulty_breathing;
  $diarrhoea=$request->diarrhoea;
  $vomiting=$request->vomiting;
  $feeding_difficult=$request->feeding_difficult;
  $convulsion=$request->convulsion;
  $fits=$request->fits;
  $murmur=$request->murmur;
  $grunting=$request->grunting;
  $crackles=$request->crackles;
  $cry=$request->cry;
  $irritable=$request->irritable;
  $tone=$request->tone;

  $user_id=Auth::id();
  $afyaUser=DB::table('afya_users')->where('users_id',$user_id)->first();
  $userid=$afyaUser->id;

   DB::table('self_report')->insert([
    'afyauser_id'=>$userid,
    'temperature'=>$temperature,
    'dependents'=>$id,
    'irritable'=>$irritable,
    'reduced_movement'=>$tone,
    'difficulty_breathing'=>$difficulty_breathing,
    'diarrhoea'=>$diarrhoea,
    'vomiting'=>$vomiting,
    'difficult_feeding'=>$feeding_difficult,
    'convulsion'=>$convulsion,
    'partial_focalfits'=>$fits,
    'murmur'=>$murmur,
    'grunting'=>$grunting,
    'crackles'=>$crackles,
    'cry'=>$cry,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);


  return redirect()->action('PatientController@dependantself',['id'=> $id]);

}

public function patientDetails($id){

  $patient=DB::table('afya_users')->where('id',$id)->first();

  $kin = DB::table('kin_details')->where('afya_user_id',$id)->first();

  if (is_null($kin)){
    $nextkin='';
  }else{
  $nextkin=DB::table('kin_details')
  ->join('kin','kin.id','=','kin_details.relation')
  ->select('kin_details.kin_name','kin_details.phone_of_kin','kin_details.id',
    'kin.relation','kin.id as kinid')->where('kin_details.afya_user_id',$id)->first();
  }

  return view('patient.nextkin')->with('patient',$patient)->with('nextkin',$nextkin);
}
public function store(Request $request)
{

  // $this->validate($request,[
  //   'afyaphone' => 'regex:/^2547[0-9]{8}/|unique:afya_users,msisdn',
  //   'nationalId' => 'unique:afya_users,nationalId',
  // ]);

$afId=$request->afya_user_id;
  $dob=$request->dob;
  $phone=$request->afyaphone;
  $nationalId =$request->nationalId;
  $nhif =$request->nhif;
  $bloodtype =$request->bloodtype;
  $email =$request->email;
  $pob =$request->pob;
  $constituency =$request->constituency;

  $kname =$request->kin_name;
  $kid =$request->nextrelid;
  $krelt =$request->relationship;
  $kphone =$request->kin_phone;

 DB::table('afya_users')->where('id',$afId)->update([
  'msisdn' => $phone,
  'nationalId'=> $nationalId,
  'nhif'=> $nhif,
  'blood_type'=> $bloodtype,
  'email'=> $email,
  'dob'=> $dob,
  'pob'=> $pob,
  'constituency'=> $constituency,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]);
if($kid){
DB::table('kin_details')->where('id',$kid)->update(
 ['kin_name' => $kname,
 'relation'=>$krelt,
 'phone_of_kin' => $kphone,
 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
);
}else{
  DB::table('kin_details')->insert(
    [
    'kin_name' => $kname,
    'relation'=>$krelt,
    'phone_of_kin' => $kphone,
    'afya_user_id' => $afId,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
}

return redirect()->action('PatientController@index');

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
  return view('patient.testdetails')->with('tsts',$tsts)->with('pdetails',$pdetails)->with('rady',$rady);
}
public function viewtest($id)
{
$tsts1 = DB::table('patient_test_details')
->Join('patient_test', 'patient_test_details.patient_test_id', '=', 'patient_test.id')
->Join('appointments', 'patient_test_details.appointment_id', '=', 'appointments.id')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
 ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
  ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
  ->select('doctors.name as docname','tests.id as tests_id','tests.name','test_categories.name as category',
  'test_subcategories.id as subcatid','test_subcategories.name as sub_category','patient_test_details.*',
  'appointments.persontreated','appointments.afya_user_id','facilities.FacilityName','patient_test.id as ptid')
  ->where('patient_test_details.id', '=',$id)
  ->first();
   return view('patient.viewtest')->with('tsts1',$tsts1);
}
public function prescdetails($id)
  {
$prescriptions =DB::table('prescriptions')
       ->join('prescription_details','prescriptions.id','=','prescription_details.presc_id')
       ->join('druglists','prescription_details.drug_id','=','druglists.id')
       ->leftjoin('prescription_filled_status','prescription_details.id','=','prescription_filled_status.presc_details_id')
       ->leftjoin('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
       ->leftjoin('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
->select('druglists.drugname','prescriptions.created_at','prescription_filled_status.substitute_presc_id',
      'prescription_filled_status.start_date','prescription_filled_status.end_date','prescription_filled_status.dose_given','prescription_filled_status.quantity',
      'prescription_details.strength','prescription_details.routes','prescription_details.frequency','prescription_details.strength_unit',
      'substitute_presc_details.strength as substrength','substitute_presc_details.routes as subroutes',
      'substitute_presc_details.frequency as subfrequency','substitute_presc_details.strength_unit as substrength_unit','substitute_presc_details.drug_id as subdrug_id',
      'pharmacy.name as pharmacy')
      ->where('prescriptions.id',$id)
       ->get();

    $usedetails=DB::table('prescriptions')
          ->join('appointments','prescriptions.appointment_id','=','appointments.id')
          ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
          ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
          ->select('appointments.id as appid','appointments.persontreated','appointments.afya_user_id','facilities.FacilityName',
          'doctors.name as docname','prescriptions.created_at')
          ->where('prescriptions.id',$id)
          ->first();
return view('patient.prscdetails')->with('prescriptions',$prescriptions)->with('usedetails',$usedetails);
}

public function credentials($id)
{
  $user=DB::table('users')
  ->join('afya_users','users.id','=','afya_users.users_id')
  ->select('users.*','afya_users.firstname','afya_users.secondName')
  ->where('users.id',$id)->first();

return view('patient.credentials')->with('user',$user);
}

public function Upcredentiials(Request $request)
{
$name=$request->username;
$email=$request->email;
$password=$request->password;
$id=$request->user_id;

DB::table('users')->where('id',$id)->update(
 [         'name' => $name,
           'email' => $email,
           'password' => bcrypt($password),
 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
);

return redirect()->action('PatientController@index');
}

public function nhif()
{
  $id = Auth::id();
  $patient=DB::table('afya_users')->where('users_id',$id)->first();

return view('patient.nhif')->with('patient',$patient);
}

public function patappointments()
{
  $id = Auth::id();
  $patient=DB::table('afya_users')->where('users_id',$id)->first();

return view('patient.appointment')->with('patient',$patient);
}

public function alldoctors(Request $request)
{
  $columns = array(
                             0 =>'id',
                             1 =>'name',
                             2=> 'speciality',
                             3=> 'address',
                             4=> 'id',
                         );

         $totalData = Doctor::count();

         $totalFiltered = $totalData;

         $limit = $request->input('length');
         $start = $request->input('start');
         $order = $columns[$request->input('order.0.column')];
         $dir = $request->input('order.0.dir');

         if(empty($request->input('search.value')))
         {
             $posts = Doctor::offset($start)
                          ->limit($limit)
                          ->orderBy($order,$dir)
                          ->get();
         }
         else {
             $search = $request->input('search.value');

             $posts =  Doctor::where('id','LIKE',"%{$search}%")
                             ->orWhere('title', 'LIKE',"%{$search}%")
                             ->offset($start)
                             ->limit($limit)
                             ->orderBy($order,$dir)
                             ->get();

             $totalFiltered = Doctor::where('id','LIKE',"%{$search}%")
                              ->orWhere('title', 'LIKE',"%{$search}%")
                              ->count();
         }

         $data = array();
         if(!empty($posts))
         {
             foreach ($posts as $post)
             {
                 $show =  route('posts.show',$post->id);
                 $edit =  route('posts.edit',$post->id);

                 $nestedData['id'] = $post->id;
                 $nestedData['name'] = $post->name;
                 $nestedData['speciality'] = substr(strip_tags($post->speciality),0,50)."...";
                 $nestedData['address'] = $post->address;
                 $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                           &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                 $data[] = $nestedData;

             }
         }

         $json_data = array(
                     "draw"            => intval($request->input('draw')),
                     "recordsTotal"    => intval($totalData),
                     "recordsFiltered" => intval($totalFiltered),
                     "data"            => $data
                     );

         echo json_encode($json_data);
}

public function diagedit($id)
 {
   $diag= DB::table('patient_diagnosis')->where('id',$id)->first();
$appid = $diag->appointment_id;

   $pdetails = DB::table('appointments')
   ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
   ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
   ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
   ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
   ->select('appointments.*','afya_users.dob','afya_users.firstname','afya_users.secondName','afya_users.gender',
     'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
     'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
   ->where('appointments.id',$appid)
   ->first();


   return view('doctor.diagnosis_edit')->with('pdetails',$pdetails)->with('diag',$diag);
 }

 public function diagremove($id)
  {
$appid_id = DB::table('patient_diagnosis')->select('appointment_id')->where('id',$id)->first();
$appid = $appid_id->appointment_id;
DB::table("patient_diagnosis")->where('id',$id)->delete();

      return redirect()->action('PrescriptionController@Diagnosis', [$appid]);
  }


}
