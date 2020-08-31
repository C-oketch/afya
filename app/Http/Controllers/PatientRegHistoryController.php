<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Smokinghistory;
use App\Alcoholhistory;
use App\Medicalhistory;
use App\Surgicalprocedures;
use App\Medhistory;
use App\Druglist;


class PatientRegHistoryController extends Controller
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

    }
//     public function RegUpHist($id)
//     {
//       $today = Carbon::today();
//       $today = $today->toDateString();
// $facilitycode=DB::table('facility_registrar')->where('user_id', Auth::id())->first();
// $data['patient'] = DB::table('afya_users')
// ->leftjoin('appointments','afya_users.id','=','appointments.afya_user_id')
// ->select('afya_users.*','appointments.id as app_id')
// ->where('afya_users.id',$id)
// ->orderBy('appointments.id' ,'Desc')
// ->first();
//
// $data['vaccines'] = DB::table('vaccine')->get();
//
// $data['vaccines'] = DB::table('vaccine')->get();
// $data['smoking']=Smokinghistory::where('afya_user_id','=',$id)->first();
// $data['alcohol']=Alcoholhistory::where('afya_user_id','=',$id)->first();
// $data['medical']=Medicalhistory::where('afya_user_id','=',$afyaid)->first();
// $data['drugs']=Druglist::all();

    // return view('registrar.histdata.reghistdata',$data);
    // }


    public function show($id)
    {
      $today = Carbon::today();
      $today = $today->toDateString();
$facilitycode=DB::table('facility_nurse')->where('user_id', Auth::id())->first();

$data['patient'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('appointments.id as appid','afya_users.*')
->where([['appointments.status','=',1],['appointments.facility_id',$facilitycode->facilitycode],
['afya_users.id',$id],])
->whereDate('appointments.created_at','=',$today)->first();

$data['vaccines'] = DB::table('vaccine')->get();
    $data['smoking']=Smokinghistory::where('afya_user_id','=',$id)->first();
    $data['alcohol']=Alcoholhistory::where('afya_user_id','=',$id)->first();
    $data['medical']=Medicalhistory::where('afya_user_id','=',$id)->first();
    $data['drugs']=Druglist::all();

    return view('nurse.procedures',$data);
    }


    public function store(Request $request)
    {
      $id=$request->afya_user_id;
      $smoking_id=$request->smoking_id;
      $alcohol_id=$request->alcohol_id;
      $medical_id =$request->medical_id;
      $name_of_surgery =$request->name_of_surgery;
      $drug_id =$request->drug_id;
      $appid=$request->appid;
      $chronics=$request->chronic;

      if($smoking_id) {
      $smokinghistory=Smokinghistory::find($smoking_id);
      $smokinghistory->update($request->all());
  }else{     Smokinghistory::create($request->all());    }

if($alcohol_id) {
      $alcoholhistory=Alcoholhistory::find($alcohol_id);
      $alcoholhistory->update($request->all());

  }else{ Alcoholhistory::create($request->all());  }

  if($medical_id) {
    $medicalhistory=Medicalhistory::find($medical_id);
    $medicalhistory->update($request->all());

    }else{ Medicalhistory::create($request->all());  }

if($name_of_surgery) {
Surgicalprocedures::create($request->all());
}


$med_date=$request->med_date;
$dosage=$request->dosage;
if($drug_id) {

DB::table('self_reported_medication')->insert([
'afya_user_id'=>$id,
'drug_id'=>$drug_id,
'dosage'=>$dosage,
'med_date'=>$med_date,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);

}





if($chronics){
foreach($chronics as $key ) {
DB::table('patient_diagnosis')->insert([
'afya_user_id'=>$id,
'appointment_id'=>$appid,
'disease_id'=>$key,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
}
}

$drugs=$request->drugs;
if($drugs){
foreach($drugs as $key =>$drug) {
DB::table('afya_users_allergy')->insert([
'afya_user_id'=>$id,
'allergies_type_id'=>$drug,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
}
}
$foods=$request->foods;
if($foods){
foreach($foods as $key) {
DB::table('afya_users_allergy')->insert([
'afya_user_id'=>$id,
'allergies_type_id'=>$key,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
}
}
$latexs=$request->latexs;
if($latexs){
foreach($latexs as $key) {
DB::table('afya_users_allergy')->insert([
'afya_user_id'=>$id,
'allergies_type_id'=>$key,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
}
}
$molds=$request->molds;
if($molds){
foreach($molds as $key) {
DB::table('afya_users_allergy')->insert([
'afya_user_id'=>$id,

'allergies_type_id'=>$key,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
}
}
$pets=$request->pets;
if($pets)
{
foreach($pets as $key) {
DB::table('afya_users_allergy')->insert([
'afya_user_id'=>$id,
'allergies_type_id'=>$key,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
}
}

$pollens=$request->pollens;
if($pollens) {
foreach($pollens as $key) {
DB::table('afya_users_allergy')->insert([
'afya_user_id'=>$id,
'allergies_type_id'=>$key,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
}
}
$insects=$request->insects;
if($insects){
foreach($insects as $key) {
DB::table('afya_users_allergy')->insert([
'afya_user_id'=>$id,
'allergies_type_id'=>$key,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
}
}
$disease_name=$request->disease_name;
$vac_name=$request->vac_name;
$vac_date=$request->vac_date;
if($disease_name){

DB::table('vaccination')->insert([
'userId'=>$id,
'diseaseId'=>$disease_name,
'vaccine_name'=>$vac_name,
'Yes'=>'yes',
'yesdate'=>$vac_date,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);

}
return redirect()->action('NurseController@show',[$id]);

    }





        public function Reg_store(Request $request)
        {
          $id=$request->afya_user_id;
          $smoking_id=$request->smoking_id;
          $alcohol_id=$request->alcohol_id;
          $medical_id =$request->medical_id;
          $name_of_surgery =$request->name_of_surgery;
          $drug_id =$request->drug_id;
          $chronics=$request->chronic;

          if($smoking_id) {
          $smokinghistory=Smokinghistory::find($smoking_id);
          $smokinghistory->update($request->all());
      }else{     Smokinghistory::create($request->all());    }

    if($alcohol_id) {
          $alcoholhistory=Alcoholhistory::find($alcohol_id);
          $alcoholhistory->update($request->all());

      }else{ Alcoholhistory::create($request->all());  }

      if($medical_id) {
        $medicalhistory=Medicalhistory::find($medical_id);
        $medicalhistory->update($request->all());

        }else{ Medicalhistory::create($request->all());  }

    if($name_of_surgery) {
    Surgicalprocedures::create($request->all());
    }

    $med_date=$request->med_date;
    if($drug_id) {

    foreach($drug_id as $key =>$drugi) {
    DB::table('self_reported_medication')->insert([
    'afya_user_id'=>$id,
    'drug_id'=>$drug,
    'med_date'=>$med_date,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }






    if($chronics){
    foreach($chronics as $key ) {
    DB::table('patient_diagnosis')->insert([
    'afya_user_id'=>$id,
    'disease_id'=>$key,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }

    $drugs=$request->drugs;
    if($drugs){
    foreach($drugs as $key =>$drug) {
    DB::table('afya_users_allergy')->insert([
    'afya_user_id'=>$id,
    'allergies_type_id'=>$drug,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
    $foods=$request->foods;
    if($foods){
    foreach($foods as $key) {
    DB::table('afya_users_allergy')->insert([
    'afya_user_id'=>$id,
    'allergies_type_id'=>$key,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
    $latexs=$request->latexs;
    if($latexs){
    foreach($latexs as $key) {
    DB::table('afya_users_allergy')->insert([
    'afya_user_id'=>$id,
    'allergies_type_id'=>$key,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
    $molds=$request->molds;
    if($molds){
    foreach($molds as $key) {
    DB::table('afya_users_allergy')->insert([
    'afya_user_id'=>$id,

    'allergies_type_id'=>$key,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
    $pets=$request->pets;
    if($pets)
    {
    foreach($pets as $key) {
    DB::table('afya_users_allergy')->insert([
    'afya_user_id'=>$id,
    'allergies_type_id'=>$key,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }

    $pollens=$request->pollens;
    if($pollens) {
    foreach($pollens as $key) {
    DB::table('afya_users_allergy')->insert([
    'afya_user_id'=>$id,
    'allergies_type_id'=>$key,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
    $insects=$request->insects;
    if($insects){
    foreach($insects as $key) {
    DB::table('afya_users_allergy')->insert([
    'afya_user_id'=>$id,
    'allergies_type_id'=>$key,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
    $disease_name=$request->disease_name;
    $vac_name=$request->vac_name;
    $vac_date=$request->vac_date;
    if($disease_name){

    DB::table('vaccination')->insert([
    'userId'=>$id,
    'diseaseId'=>$disease_name,
    'vaccine_name'=>$vac_name,
    'Yes'=>'yes',
    'yesdate'=>$vac_date,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);

    }
    return redirect()->action('privateController@histdata',[$id]);

        }

        public function histdetails($id)
        {
$facilitycode=DB::table('facility_doctor')->where('user_id', Auth::id())->first();
$patient = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as app_id')
->where('appointments.id',$id)->first();
$afyaid = $patient->id;


$data['vaccines'] = DB::table('vaccine')->get();
$data['smoking']=Smokinghistory::where('afya_user_id','=',$afyaid)->first();
$data['alcohol']=Alcoholhistory::where('afya_user_id','=',$afyaid)->first();
$data['medical']=Medicalhistory::where('afya_user_id','=',$afyaid)->first();
$data['drugs']=Druglist::all();

return view('registrar.histdata.reghistdata',$data)->with('patient',$patient);
        }

        public function histmedical($id)
        {

  $facilitycode=DB::table('facility_doctor')->where('user_id', Auth::id())->first();
  $patient = DB::table('appointments')
  ->join('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->select('afya_users.*','appointments.id as app_id')
  ->where('appointments.id',$id)->first();
  $afyaid = $patient->id;
  $data['medical']=Medicalhistory::where('afya_user_id','=',$afyaid)->first();

  return view('registrar.histdata.medicalh',$data)->with('patient',$patient);
        }

        public function surghistdata($id)
        {
  $facilitycode=DB::table('facility_doctor')->where('user_id', Auth::id())->first();
  $patient = DB::table('appointments')
  ->join('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->select('afya_users.*','appointments.id as app_id')
  ->where('appointments.id',$id)->first();

  return view('registrar.histdata.surgical')->with('patient',$patient);
        }

public function chronichistdata($id)
{
$facilitycode=DB::table('facility_doctor')->where('user_id', Auth::id())->first();
$patient = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as app_id')
->where('appointments.id',$id)->first();

return view('registrar.histdata.chronic')->with('patient',$patient);
}

public function medhistdata($id)
{
$facilitycode=DB::table('facility_doctor')->where('user_id', Auth::id())->first();
$patient = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as app_id')
->where('appointments.id',$id)->first();

return view('registrar.histdata.mediccine')->with('patient',$patient);
}
public function allergyhistdata($id)
{
$facilitycode=DB::table('facility_doctor')->where('user_id', Auth::id())->first();
$patient = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as app_id')
->where('appointments.id',$id)->first();

return view('registrar.histdata.allergy')->with('patient',$patient);
}
public function abnorhistdata($id)
{
$facilitycode=DB::table('facility_doctor')->where('user_id', Auth::id())->first();
$patient = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as app_id')
->where('appointments.id',$id)->first();

return view('registrar.histdata.functions')->with('patient',$patient);
}

public function vacchistdata($id)
{
$facilitycode=DB::table('facility_doctor')->where('user_id', Auth::id())->first();
$patient = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
->select('afya_users.*','appointments.id as appid','patient_admitted.condition')
->where('appointments.id',$id)->first();

return view('registrar.histdata.vaccine')->with('patient',$patient);
}


public function Doc_smoking(Request $request)
{
  $id=$request->afya_user_id;
  $smoking_id=$request->smoking_id;
  $alcohol_id=$request->alcohol_id;
  $appid=$request->appointment_id;

  if($smoking_id) {
  $smokinghistory=Smokinghistory::find($smoking_id);
  $smokinghistory->update($request->all());
}else{     Smokinghistory::create($request->all());    }

if($alcohol_id) {
  $alcoholhistory=Alcoholhistory::find($alcohol_id);
  $alcoholhistory->update($request->all());

}else{ Alcoholhistory::create($request->all());  }

return redirect()->action('PatientRegHistoryController@histmedical',[$appid]);


}

public function Doc_medical(Request $request)
{
  // $id=$request->afya_user_id;
$appId = $request->appId;
    $input = $request->members;

    DB::table('self_reported_medical_history')->insert($input);

return redirect()->action('PatientRegHistoryController@surghistdata',[$appId]);


}
public function Doc_surgical(Request $request)
{
  $appid=$request->appointment_id;
  $input = $request->members;
DB::table('self_reported_surgical_procedures')->insert($input);

return redirect()->action('PatientRegHistoryController@chronichistdata',[$appid]);
}

public function Doc_chronic(Request $request)
{
  $appid=$request->appointment_id;
  $input = $request->members;
DB::table('patient_diagnosis')->insert($input);

return redirect()->action('PatientRegHistoryController@medhistdata',[$appid]);
}


public function Doc_drug(Request $request)
{

  $appid=$request->appointment_id;
  $input = $request->members;
DB::table('self_reported_medication')->insert($input);

return redirect()->action('PatientRegHistoryController@allergyhistdata',[$appid]);
}

public function Doc_allergy(Request $request)
{

  $appid=$request->appointment_id;
  $input = $request->members;
DB::table('afya_users_allergy')->insert($input);

return redirect()->action('PatientRegHistoryController@vacchistdata',[$appid]);
}

public function Doc_vaccine(Request $request)
{
  $appid=$request->appointment_id;
  $input = $request->members;
DB::table('vaccination')->insert($input);
  return redirect()->action('PatientRegHistoryController@abnorhistdata',[$appid]);
}

public function Doc_abnormal(Request $request)
{

  $appid=$request->appointment_id;
  $input = $request->members;
DB::table('patient_abnormalities')->insert($input);
  return redirect()->action('PatientRegHistoryController@abnorhistdata',[$appid]);

}

}
