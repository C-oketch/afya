<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Auth;
use Carbon\Carbon;
use App\Observation;
use App\Symptom;
use App\Chief;
use App\Smokinghistory;
use App\Alcoholhistory;
use App\Medicalhistory;
use App\Surgicalprocedures;
use App\Medhistory;
use App\Druglist;

class privateController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
 $today = Carbon::today();
  $today = date('Y-m-d');
  $facilitycode=DB::table('facility_doctor')
  ->leftJoin('facilities', 'facility_doctor.facilitycode', '=', 'facilities.FacilityCode')
  ->select('facility_doctor.facilitycode','facilities.FacilityName','facilities.Type','facility_doctor.doctor_id')
  ->where('user_id', Auth::user()->id)->first();

  $patients = DB::table('appointments as app')
  ->leftJoin('afya_users as par', 'app.afya_user_id', '=', 'par.id')
  ->leftjoin('dependant as dep','app.persontreated','=','dep.id')
  ->select('par.id as parid','par.firstname as first','par.secondName as second','par.file_no as fileno','par.gender as gender','par.dob as dob','dep.id as depid','dep.firstName as dfirst','dep.secondName as dsecond','dep.dob as ddob',
  'dep.gender as dgender','app.created_at as created_at','app.id as appid','app.persontreated as persontreated','app.last_app_id','app.visit_type')
  ->where('app.status','=',1)
  ->where('app.doc_id','=',$facilitycode->doctor_id)
  // ->where('app.created_at','>=',$today)
  ->whereDate('app.created_at','=',$today)
  ->where('app.facility_id',$facilitycode->facilitycode)
  ->get();
  $patients2 = DB::table('appointments')
  ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->select('afya_users.id as parid','afya_users.firstname as first','afya_users.secondName as second','afya_users.file_no as fileno','afya_users.gender as gender','afya_users.dob as dob',
  'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob',
  'dependant.gender as dgender','appointments.created_at as created_at','appointments.id as appid','appointments.persontreated as persontreated','appointments.last_app_id','appointments.visit_type')
  ->where('appointments.status','=',2)
  ->where('appointments.doc_id','=',$facilitycode->doctor_id)
  ->whereDate('appointments.created_at','=',$today)
  ->where('appointments.facility_id',$facilitycode->facilitycode)
  ->get();

  return view('private.index')->with('patients',$patients)->with('patients2',$patients2)->with('facilitycode',$facilitycode);
}



public function PendingPatient()
{

  $facilitycode=DB::table('facility_doctor')
  ->leftJoin('facilities', 'facility_doctor.facilitycode', '=', 'facilities.FacilityCode')
  ->select('facility_doctor.facilitycode','facilities.FacilityName','facilities.Type','facility_doctor.doctor_id')
  ->where('user_id', Auth::user()->id)->first();

  $patients = DB::table('appointments as app')
  ->leftJoin('afya_users as par', 'app.afya_user_id', '=', 'par.id')
  ->leftjoin('dependant as dep','app.persontreated','=','dep.id')
  ->select('par.id as parid','par.firstname as first','par.secondName as second','par.file_no as fileno','par.gender as gender','par.dob as dob','dep.id as depid','dep.firstName as dfirst','dep.secondName as dsecond','dep.dob as ddob',
  'dep.gender as dgender','app.created_at as created_at','app.id as appid','app.persontreated as persontreated','app.last_app_id','app.visit_type')
  ->where('app.status','=',1)
  ->where('app.doc_id','=',$facilitycode->doctor_id)
  ->where('app.facility_id',$facilitycode->facilitycode)
  ->get();

  $patients2 = DB::table('appointments')
  ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->select('afya_users.id as parid','afya_users.firstname as first','afya_users.secondName as second','afya_users.file_no as fileno','afya_users.gender as gender','afya_users.dob as dob',
  'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob',
  'dependant.gender as dgender','appointments.created_at as created_at','appointments.id as appid','appointments.persontreated as persontreated','appointments.last_app_id','appointments.visit_type')
  ->where('appointments.status','=',2)
  ->where('appointments.doc_id','=',$facilitycode->doctor_id)
  ->where('appointments.facility_id',$facilitycode->facilitycode)
  ->get();

  return view('private.pendingpatient')->with('patients',$patients)->with('patients2',$patients2)->with('facilitycode',$facilitycode);
}

public function privatepatient()
{
  //  $today = Carbon::today();
  $facilitycode=DB::table('facility_doctor')->where('user_id', Auth::user()->id)->first();
  $patients = DB::table('appointments as app')
  ->Join('afya_users as par', 'app.afya_user_id', '=', 'par.id')
  ->leftjoin('dependant as dep','app.persontreated','=','dep.id')
  ->select('par.id as parid','par.firstname as first','par.secondName as second','par.gender as gender','par.dob as dob','dep.id as depid','dep.firstName as dfirst','dep.secondName as dsecond','dep.dob as ddob',
  'dep.gender as dgender','app.id as appid','app.created_at as created_at','app.persontreated as persontreated')
  ->where('app.status','=',2)

  ->where('app.facility_id',$facilitycode->facilitycode)
  ->get();

  return view('private.patients')->with('patients',$patients);
}

public function privadmitted()
{
  $today = Carbon::today()->toDateString();
  $facility = DB::table('facility_doctor')->select('facilitycode', 'doctor_id')->where('user_id', Auth::id())->first();
  $patients = DB::table('appointments')
            ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
            // ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
            ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
            ->select('afya_users.*','patient_admitted.date_admitted')
            ->where([

              ['patient_admitted.condition', '=','Admitted'],
              ['appointments.facility_id',$facility->facilitycode],
              ['appointments.doc_id', '=',$facility->doctor_id],
            ])
            ->get();

  return view('private.admitted')->with('patients',$patients);
}
public function selectChoice($id){


  return view('registrar.select')->with('id',$id);
}
public function showUser(Request $request){


  $ptreated=$request->treated;
  $id=$request->afya_user_id;
  $dep_id=$request->dependant_id;
  $visit=$request->visit;
  $doc_id =$request->doc_id;

    if($ptreated=='Self'){ $persontreated = 'Self'; }else{ $persontreated = $dep_id;  }
    if($visit =='Review'){ $status = 1; }else{ $status =0;  }


$today = date('Y-m-d');

$path=DB::table('facility_registrar')
->join('facilities','facility_registrar.facilitycode', '=', 'facilities.FacilityCode')
->select('facilities.payment','facility_registrar.facilitycode')
->where('facility_registrar.user_id',Auth::user()->id)->first();

$pathos=DB::table('appointments')->select('id')
->whereDate('created_at','=',$today)
->where([['facility_id',$path->facilitycode],['afya_user_id','=',$id]])
->first();

if($pathos){
$appointment= $pathos->id;
}else{

$appointment_id = DB::table('appointments')->insertGetId([
    'doc_id'=>$doc_id,
    'facility_id'=>$path->facilitycode,
    'status'=>$status,
    'afya_user_id'=>$id,
    'persontreated'=>$persontreated,
    'visit_type'=>$visit,
    'created_by_users_id' => Auth::user()->id,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);
$appointment= $appointment_id;
}
  $data['user']=DB::table('afya_users')->where('id',$id)->first();
  $data['kin']=DB::table('kin_details')
  ->Join('kin','kin_details.relation','=','kin.id')
  ->select('kin_details.*', 'kin.relation')
  ->where('kin_details.afya_user_id',$id)
  ->first();

  $data['insurance']=DB::table('afyauser_insurance')
  ->Join('insurance_companies','afyauser_insurance.ins_co_id','=','insurance_companies.id')
  ->select('insurance_companies.company_name','afyauser_insurance.policy_no')
   ->where('afyauser_insurance.afya_user_id',$id)->get();

if($path->payment == 'A'){
return view('registrar.shows_st',$data)->with('path',$path)->with('appointment',$appointment);
}elseif($path->payment == 'B'){
  return view('registrar.shows',$data)->with('path',$path)->with('appointment',$appointment);
}
return view('registrar.shows',$data)->with('path',$path)->with('appointment',$appointment);
}

public function showUser2($id){

$appointment= $id;
$afyaUser=DB::table('appointments')->where('id',$id)->first();

$afyaid= $afyaUser->afya_user_id;

$today = date('Y-m-d');

$path=DB::table('facility_registrar')
->join('facilities','facility_registrar.facilitycode', '=', 'facilities.FacilityCode')
->select('facilities.payment','facility_registrar.facilitycode')
->where('facility_registrar.user_id',Auth::user()->id)->first();


  $data['user']=DB::table('afya_users')->where('id',$afyaid)->first();
  $data['kin']=DB::table('kin_details')
  ->Join('kin','kin_details.relation','=','kin.id')
  ->select('kin_details.*', 'kin.relation')
  ->where('kin_details.afya_user_id',$afyaid)
  ->first();

  $data['insurance']=DB::table('afyauser_insurance')
  ->Join('insurance_companies','afyauser_insurance.ins_co_id','=','insurance_companies.id')
  ->select('insurance_companies.company_name','afyauser_insurance.policy_no')
   ->where('afyauser_insurance.afya_user_id',$afyaid)->get();

if($path->payment == 'A'){
return view('registrar.shows_st',$data)->with('path',$path)->with('appointment',$appointment);
}elseif($path->payment == 'B'){
  return view('registrar.shows',$data)->with('path',$path)->with('appointment',$appointment);
}
return view('registrar.shows',$data)->with('path',$path)->with('appointment',$appointment);
}

public function showUser3($id){

$today = date('Y-m-d');
$appointment2=DB::table('appointments')
->where('afya_user_id', '=', $id)
->orderBy('created_at', 'desc')
->first();
$appointment=$appointment2->id;
$path=DB::table('facility_registrar')
->join('facilities','facility_registrar.facilitycode', '=', 'facilities.FacilityCode')
->select('facilities.payment','facility_registrar.facilitycode')
->where('facility_registrar.user_id',Auth::user()->id)->first();


  $data['user']=DB::table('afya_users')->where('id',$id)->first();
  $data['kin']=DB::table('kin_details')
  ->Join('kin','kin_details.relation','=','kin.id')
  ->select('kin_details.*', 'kin.relation')
  ->where('kin_details.afya_user_id',$id)
  ->first();

  $data['insurance']=DB::table('afyauser_insurance')
  ->Join('insurance_companies','afyauser_insurance.ins_co_id','=','insurance_companies.id')
  ->select('insurance_companies.company_name','afyauser_insurance.policy_no')
   ->where('afyauser_insurance.afya_user_id',$id)->get();


return view('registrar.shows',$data)->with('path',$path)->with('appointment',$appointment);
}


public function showUserApp($id){

$today = date('Y-m-d');
$path=DB::table('facility_registrar')
->join('facilities','facility_registrar.facilitycode', '=', 'facilities.FacilityCode')
->select('facilities.payment','facility_registrar.facilitycode')->where('facility_registrar.user_id',Auth::user()->id)->first();

$appdetails2=DB::table('appointments')->where([['id','=',$id],])->first();
$afya_user_id =$appdetails2->afya_user_id;

DB::table('appointments')->where('id',$id)->update([
'status'=>8,
'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]);


$appointment_id = DB::table('appointments')->insertGetId([
    'facility_id'=>$path->facilitycode,
    'status'=>0,
    'afya_user_id'=>$afya_user_id,
    'persontreated'=>'Self',
    'last_app_id'=>$id,
    'created_by_users_id' => Auth::user()->id,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);

  $appointment= $appointment_id;


$data['user']=DB::table('afya_users')->where('id',$afya_user_id)->first();
$data['kin']=DB::table('kin_details')
->Join('kin','kin_details.relation','=','kin.id')
->select('kin_details.*', 'kin.relation')
->where('kin_details.afya_user_id',$afya_user_id)
->first();

$data['insurance']=DB::table('afyauser_insurance')
->Join('insurance_companies','afyauser_insurance.ins_co_id','=','insurance_companies.id')
->select('insurance_companies.company_name','afyauser_insurance.policy_no')
 ->where('afyauser_insurance.afya_user_id',$afya_user_id)->get();

if($path->payment == 'A'){
return view('registrar.shows_st',$data)->with('path',$path)->with('appointment',$appointment);
}elseif($path->payment == 'B'){
return view('registrar.shows',$data)->with('path',$path)->with('appointment',$appointment);

}
}

public function showUsertest($id){

$appdetails=DB::table('appointments')->where('id','=',$id)->first();
$afyaId =$appdetails->afya_user_id;
$data['user']=DB::table('afya_users')->where('id',$afyaId)->first();
$path=DB::table('facility_registrar')
->join('facilities','facility_registrar.facilitycode', '=', 'facilities.FacilityCode')
->select('facilities.payment','facility_registrar.facilitycode')->where('facility_registrar.user_id',Auth::user()->id)->first();

return view('registrar.private.test.tests_ng',$data)->with('path',$path)->with('appdetails',$appdetails);
}
public function showUserpay($id){
$u_id = Auth::user()->id;
$facility = DB::table('facility_registrar')
         ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
         ->select('facilities.*','facility_registrar.facilitycode')
         ->where('user_id', $u_id)
         ->first();

$user=DB::table('appointments')
->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
->select('afya_users.*','appointments.id as appid')
->where('appointments.id',$id)->first();

$data['tsts'] =  DB::table('appointments')
->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
->select('radiology_test_details.test','radiology_test_details.test_cat_id','patient_test.id as ptid',
'radiology_test_details.id as patTdid','appointments.id as AppId')
->where([['appointments.afya_user_id', '=',$user->id],['radiology_test_details.deleted', '=', 0],])
->get();

$data['tstslab'] = DB::table('appointments')
->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
->leftJoin('test_price', 'tests.id', '=', 'test_price.tests_id')
->select('tests.name as tname','patient_test_details.id as patTdid','appointments.id as AppId',
'patient_test.id as ptid','test_price.id as tp_id')
->where([['appointments.afya_user_id', '=',$user->id],['test_price.facility_id',$facility->facilitycode],
['patient_test_details.deleted', '=',0]])
->get();

$data['cardiac'] = DB::table('appointments')
->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
->Join('patient_test_details_c', 'patient_test.id', '=', 'patient_test_details_c.patient_test_id')
->Join('tests_cardiac', 'patient_test_details_c.tests_reccommended', '=', 'tests_cardiac.id')
->leftJoin('testprice_cardiac', 'tests_cardiac.id', '=', 'testprice_cardiac.tests_id')
->select('tests_cardiac.name as tname','patient_test_details_c.id as patTdid','appointments.id as AppId',
'patient_test.id as ptid','testprice_cardiac.id as tp_id')
->where([['appointments.afya_user_id', '=',$user->id],['testprice_cardiac.facility_id',$facility->facilitycode],
['patient_test_details_c.deleted', '=',0]])
->get();

$data['neurology'] = DB::table('appointments')
->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
->Join('patient_test_details_n', 'patient_test.id', '=', 'patient_test_details_n.patient_test_id')
->Join('tests_neurology', 'patient_test_details_n.tests_reccommended', '=', 'tests_neurology.id')
->leftJoin('testprice_neurology', 'tests_neurology.id', '=', 'testprice_neurology.tests_id')
->select('tests_neurology.name as tname','patient_test_details_n.id as patTdid','appointments.id as AppId',
'patient_test.id as ptid','testprice_neurology.id as tp_id')
->where([['appointments.afya_user_id', '=',$user->id],['testprice_neurology.facility_id',$facility->facilitycode],
['patient_test_details_n.deleted', '=',0]])
->get();

$data['procedure'] = DB::table('appointments')
->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
->Join('patient_procedure_details', 'patient_test.id', '=', 'patient_procedure_details.patient_test_id')
->Join('procedures', 'patient_procedure_details.procedure_id', '=', 'procedures.id')
->leftJoin('procedure_prices', 'procedures.id', '=', 'procedure_prices.procedure_id')
->select('procedures.name as tname','patient_procedure_details.id as patTdid','appointments.id as AppId',
'patient_test.id as ptid','procedure_prices.id as tp_id')
->where([['appointments.afya_user_id', '=',$user->id],['procedure_prices.facility_id',$facility->facilitycode],
['patient_procedure_details.deleted', '=',0]])
->get();

$data['cnst'] = DB::table('consultation_fees')
    ->select('old_consultation_fee', 'new_consultation_fee','medical_report_fee')
    ->where('facility_code',$facility->facilitycode)->first();



return view('registrar.private.test.pay_ng',$data)->with('facility',$facility)->with('user',$user);
}



public function registrarNextkin(Request $request){
  $phone=$request->phone;
  $name=$request->kin_name;
  $relationship=$request->relationship;
  $id=$request->id;
  $postal = $request->postal;

  DB::table('kin_details')->insert(
    ['kin_name' => $name,
    'relation' => $relationship,
    'phone_of_kin'=> $phone,
    'postal'=>$postal,
    'afya_user_id'=>$id,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
  );
  return redirect()->action('privateController@showUser',[$id]);
}

public function updateKin($id){

  $user=DB::table('kin_details')
  ->join('afya_users','kin_details.afya_user_id', '=', 'afya_users.id')
  ->select('afya_users.*')->where('kin_details.id',$id)->first();

  return view('registrar.update')->with('id',$id)->with('user',$user);
}

public function registrarUpdatekin(Request $request){
  $phone=$request->phone;
  $name=$request->kin_name;
  $relationship=$request->relationship;
  $id=$request->id;
  $userid=$request->userid;
  $postal = $request->postal;

  DB::table('kin_details')->where('id',$id)->update(
    ['kin_name' => $name,
    'relation' => $relationship,
    'phone_of_kin'=> $phone,
    'postal'=> $postal,
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
  );
  return redirect()->action('privateController@showUser',[$userid]);

}

public function updateUsers(Request $request){
  $id=$request->id;
  $idno=$request->idno;
  $db=$request->date;
  $pob=$request->place;
  $email=$request->email;
  $constituency=$request->constituency;

  $blood=$request->blood_type;

  if($request->is_nhif == 'Yes')
  {
    $nhif=$request->nhif;
  }
  else
  {
    $nhif = 'N/A';
  }


  DB::table('afya_users')->where('id',$id)->
  update([
    'age'=> date_diff(date_create($db), date_create('now'))->y,
    'dob' => $db,
    'pob' => $pob,
    'nhif'=>$nhif,
    'nationalId'=>$idno,
    'email'=>$email,
    'blood_type'=>$blood,
    'constituency' =>$constituency,
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);

    return redirect()->action('privateController@showUser',[$id]);

  }

  public function edit_patient($id){

    $data['insurance']=DB::table('afyauser_insurance')
    ->Join('insurance_companies','afyauser_insurance.ins_co_id','=','insurance_companies.id')
    ->select('insurance_companies.company_name','afyauser_insurance.policy_no')
     ->where('afyauser_insurance.afya_user_id',$id)->get();

    return view('registrar.edit_patient_registrar',$data)->with('id',$id);
  }

  public function RegupdateUsers(Request $request){

    $id=$request->afya_user_id;
    $first=$request->first;
    $second=$request->second;
    $pob=$request->pob;
    $gender=$request->gender;
    $dob=$request->dob;
    $marital=$request->marital;
    $bloodtype=$request->bloodtype;
    $occupation=$request->occupation;
    $constituency=$request->constituency;
    $nhif=$request->nhif;
    $nationalId=$request->nationalId;
    $kra=$request->kra;

    $ins_company = $request->insurance_company;
    $policy = $request->policy_no;


    $phone=$request->phone;
    $email=$request->email;
    $paddress=$request->paddress;
    $code=$request->code;
    $town=$request->town;
    $smartphone = $request->smartphone;

    $kin_phone=$request->phone_of_kin;
    $kin_name=$request->kin_name;
    $relation=$request->relation;
    $kin_postal=$request->kin_postal;

    DB::table('afya_users')->where('id',$id)
    ->update([
      'age'=> date_diff(date_create($dob), date_create('now'))->y,
      'msisdn' => $phone,
      'firstname'=>$first,
      'secondName' => $second,
      'gender'=>$gender,
      'nationalId'=> $nationalId,
      'nhif'=> $nhif,
      'blood_type'=> $bloodtype,
      'email'=> $email,
      'dob'=> $dob,
      'pob'=> $pob,
      'postal_address'=>$paddress,
      'postal_code'=>$code ,
      'town'=>$town,
      'marital'=>$marital,
      'occupation'=>$occupation,
      'kra_pin'=>$kra,
      'created_by'=> Auth::user()->id,
      'constituency'=> $constituency,
      'has_smartphone'=>$smartphone,
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);

    if($policy){
      $insrexist = DB::table('afyauser_insurance')->select('id')
      ->where([['afya_user_id', $id],['ins_co_id', $ins_company],['policy_no', $policy]])->first();
    if($insrexist){
    $insurance_Id =$insrexist->id;
    }else{
      $insurance= DB::table('afyauser_insurance')->insertGetId(  [
        'afya_user_id' => $id,
        'ins_co_id'=> $ins_company,
        'policy_no'=>$policy,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
      ]);

    }
    }
    $kidetails = DB::table('kin_details')->where('afya_user_id', '=',$id)->first();

    if($kidetails){
      DB::table('kin_details')->where('afya_user_id',$id)
      ->update([
        'kin_name' => $kin_name,
        'relation' => $relation,
        'phone_of_kin'=> $kin_phone,
        'postal'=> $kin_postal,
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
      }else{
        DB::table('kin_details')->insert(
          [
            'kin_name' => $kin_name,
            'relation' => $relation,
            'phone_of_kin'=> $kin_phone,
            'afya_user_id'=>$id,
            'postal'=> $kin_postal,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);
        }

        return redirect()->action('privateController@showUser3',[$id]);

      }
      public function histdata($id)
      {
        $today = Carbon::today();
        $today = $today->toDateString();
        $facilitycode=DB::table('facility_registrar')->where('user_id', Auth::id())->first();

        $data['user'] = DB::table('afya_users')->where('afya_users.id',$id)->first();



        return view('registrar.histdata.histdata_registrar',$data);

      }


      public function update_patient(Request $request){
        $id=$request->id;
        $email=$request->email;
        $constituency=$request->constituency;
        DB::table('afya_users')
        ->where('id',$id)
        ->update([
          'email'=>$email,
          'constituency' => $constituency,
          'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);

        return redirect()->action('privateController@showUser',['id'=> $id]);
      }

      public function consultationFees(Request $request){

        $id = $request->id;
        $visit = $request->visit;
        $facility = $request->facility;
        $appointment_id =$request->appointment;
        $today = date('Y-m-d');

        $doctorId = DB::table('facility_doctor')
        ->where([['facilitycode', '=', $facility],])
        ->first();
        $doctor_Id = $doctorId->doctor_id;

        DB::table('appointments')
        ->where('id',$appointment_id)
        ->update([
          'status'=>1,
          'facility_id'=>$facility,
          'persontreated'=>'Self',
          'visit_type'=>$visit,
          'doc_id'=>$doctor_Id,
          'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
          'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);



        $phone = DB::Table('afya_users')->where('id',$id)->select('msisdn')  ->first();

        //Get afyamessage id
        $message_id = DB::table('appointments')
        ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
        ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
        ->select('afyamessages.id')
        ->where('appointments.id', '=', $appointment_id)
        ->where('afyamessages.msisdn',$phone->msisdn)
        ->whereNull('afyamessages.status')
        ->whereDate('afyamessages.created_at','=',$today)
        ->first();
        if($message_id){
          DB::table('afyamessages')->where('id',$message_id->id)
          ->update([        'status' => 1,
          'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);
      }
      return redirect()->action('RegistrarController@index');
    }


    public function selectDependant($id){


      return view('private.showdependants')->with('id',$id);
    }

    public function addDependents($id){

      return view('private.addDependents')->with('id',$id);
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
      'phone'=>$phone,
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

      return redirect()->action('privateController@selectDependant', [$id]);

    }


    public function Dependentconsultationfee(Request $request)
    {
      $path;
      $appointment_id =''; //To be used in getting message_id

      $facilitycode = DB::table('facility_registrar')
      ->where('user_id', Auth::user()->id)
      ->first();

      $today = date('Y-m-d');
      $id = $request->id;
      $type = $request->type;
      $afyauser = $request->afya_user;
      $mode = $request->mode;
      $amount = $request->amount;
      $user = $request->afya_user;
      $cat_id = $request->cat_id;

      if($type == 'Yes')
      {
        $visit_type = 'paid';
      }
      else
      {
        if($request->no_payment_reason == 'triage')
        {
          $visit_type = 'follow up with triage';
        }
        elseif($request->no_payment_reason == 'no_triage')
        {
          $visit_type = 'follow up without triage';
        }
        else
        {
          $visit_type = 'free';
        }
      }

      $last = DB::table('appointments')
      ->where('afya_user_id', '=', $user)
      ->orderBy('created_at', 'desc')
      ->first();

      if(! is_null($last))
      {
        $last_app_id = $last->id;
      }



      if($type == 'No')
      {

        $amount  = 'None';
        $path = $request->no_payment_reason;

        if($path == 'free')
        {

          $appointment_id = DB::table('appointments')->insertGetId([
            'status'=>1,
            'facility_id'=>$facilitycode->facilitycode,
            'afya_user_id'=>$user,
            'persontreated'=>$id,
            'visit_type'=>$visit_type,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);

          DB::table('payments')->insert([
            'payments_category_id'=>$cat_id,
            'appointment_id'=>$appointment_id,
            'amount'=> $amount,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);

        }

        elseif($path == 'triage')
        {
          $appointment_id = DB::table('appointments')->insertGetId([
            'status'=>1,
            'facility_id'=>$facilitycode->facilitycode,
            'afya_user_id'=>$user,
            'persontreated'=>$id,
            'visit_type'=>$visit_type,
            'last_app_id'=>$last_app_id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);

          DB::table('appointments')
          ->where('id', '=', $last_app_id)
          ->update(['status' => 8]);

          DB::table('payments')->insert([
            'payments_category_id'=>$cat_id,
            'appointment_id'=>$appointment_id,
            'amount'=> $amount,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);

        }

        elseif($path == 'no_triage')
        {
          $appointment_id = DB::table('appointments')->insertGetId([
            'status'=>1,
            'facility_id'=>$facilitycode->facilitycode,
            'afya_user_id'=>$user,
            'persontreated'=>$id,
            'visit_type'=>$visit_type,
            'last_app_id'=>$last_app_id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);

          DB::table('appointments')
          ->where('id', '=', $last_app_id)
          ->update(['status' => 8]);

          DB::table('payments')->insert([
            'payments_category_id'=>$cat_id,
            'appointment_id'=>$appointment_id,
            'amount'=> $amount,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);

        }


      }
      else
      {
        $amount = $amount;

        $appointment_id = DB::table('appointments')->insertGetId([
          'status'=>1,
          'facility_id'=>$facilitycode->facilitycode,
          'afya_user_id'=>$user,
          'persontreated'=>$id,
          'visit_type'=>$visit_type,
          'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
          'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);


        DB::table('payments')->insert([
          'payments_category_id'=>$cat_id,
          'appointment_id'=>$appointment_id,
          'amount'=> $amount,
          'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
          'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);

      }

      $phone = DB::Table('afya_users')
      ->where('id',$user)
      ->select('msisdn')
      ->first();

      return redirect()->action('RegistrarController@index');

    }


    public function Fees(){
      $today = Carbon::today();
      $dat =$today->toDateString();

      $date1 = Carbon::now();
      $date2 = Carbon::now();
      $date3= Carbon::now();
      $endweek= $date1->endOfWeek();
      $datw =$endweek->toDateString();

      $startmonth=$date2->startOfMonth();
      $datmm =$startmonth->toDateString();
      $endmonth= $date3->endOfMonth();
      $datm =$endmonth->toDateString();

      // dd($datm);

      $category_id = DB::table('payments_categories')
      ->where('payments_categories.category_name', '=', 'Consultation fee')
      ->first();
      $cat_id = $category_id->id;

      $facility=DB::table('facility_doctor')->where('user_id', Auth::user()->id)->first();

      $data['feesdaily']=DB::table('payments')
      ->leftJoin('payments_categories', 'payments.payments_category_id', '=','payments_categories.id' )
      ->leftJoin('appointments', 'appointments.id', '=','payments.appointment_id' )
      ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
      ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
      ->select('payments_categories.id as paycatid','payments_categories.category_name','afya_users.*','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
      'dependant.dob as Infdob','payments.amount','payments.id as payment_id','payments.mode','payments.created_at as paydate','appointments.persontreated',
      'appointments.id AS app_id')
      ->where([
        ['payments.amount', '<>', 'None'],
        ['appointments.doc_id', '=', $facility->doctor_id],
        ['appointments.facility_id', '=', $facility->facilitycode],
      ])
      ->whereDate('payments.created_at','=',$dat)
      ->groupBy('payments.appointment_id','payments.payments_category_id')
      ->get();

      $data['wekexp1']=DB::table('payments')
      ->join('appointments','appointments.id','=','payments.appointment_id')
      ->where([['appointments.facility_id', '=', $facility->facilitycode], ['appointments.doc_id', '=', $facility->doctor_id],])
      ->whereDate('payments.created_at','=',$dat)
      ->sum('amount');

      $data['feesmonth'] = DB::table('payments')
      ->Join('payments_categories', 'payments.payments_category_id', '=','payments_categories.id' )
      ->Join('appointments', 'appointments.id', '=','payments.appointment_id' )
      ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
      ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
      ->select('payments_categories.id as paycatid','payments_categories.category_name','afya_users.*','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
      'dependant.dob as Infdob','payments.amount','payments.id as payment_id','payments.mode','payments.created_at as paydate','appointments.persontreated',
      'appointments.id AS app_id')

      ->where([
        ['payments.amount', '<>', 'None'],
        ['payments.created_at','>=',$datmm],
        ['payments.created_at','<=',$datm],
        ['appointments.doc_id', '=', $facility->doctor_id],
        ['appointments.facility_id', '=', $facility->facilitycode],
      ])

      ->groupBy('payments.appointment_id','payments.payments_category_id')
      ->get();

      $data['wekexp2']=DB::table('payments')
      ->join('appointments','appointments.id','=','payments.appointment_id')
      ->where([  ['appointments.facility_id', '=', $facility->facilitycode],  ['appointments.doc_id', '=', $facility->doctor_id],
      ['payments.created_at','>=',$datmm],
      ['payments.created_at','<=',$datm],
    ])
    ->sum('amount');

    $fees = DB::table('payments')
    ->Join('payments_categories', 'payments.payments_category_id', '=','payments_categories.id' )
    ->Join('appointments', 'appointments.id', '=','payments.appointment_id' )
    ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
    ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
    ->select('payments_categories.id as paycatid','payments_categories.category_name','afya_users.*','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
    'dependant.dob as Infdob','payments.amount','payments.id as payment_id','payments.mode','payments.created_at as paydate','appointments.persontreated',
    'appointments.id AS app_id')
    ->where([
      ['payments.amount', '<>', 'None'],
      ['appointments.facility_id', '=', $facility->facilitycode],
      ['appointments.doc_id', '=', $facility->doctor_id],
    ])
    ->groupBy('payments.appointment_id','payments.payments_category_id')
    ->get();

    $data['wekexp']=DB::table('payments')
    ->join('appointments','appointments.id','=','payments.appointment_id')
    ->where([
      ['appointments.doc_id', '=', $facility->doctor_id],
      ['appointments.facility_id', '=', $facility->facilitycode], ])
      ->sum('amount');


      // return view('doctor.yourfees',$data)->with('fees',$fees)->with('facility',$facility);
      return view('private.consultationfees',$data)->with('fees',$fees)->with('facility',$facility);
    }

    public function registrarFees(){
      $today = Carbon::today();
      $dat =$today->toDateString();

      $date1 = Carbon::now();
      $date2 = Carbon::now();
      $date3 = Carbon::now();
      $endweek= $date1->endOfWeek();
      $datw =$endweek->toDateString();

      $startmonth=$date2->startOfMonth();
      $datmm =$startmonth->toDateString();
      $endmonth= $date3->endOfMonth();
      $datm =$endmonth->toDateString();

      // dd($datm);

      $category_id = DB::table('payments_categories')
      ->where('payments_categories.category_name', '=', 'Consultation fee')
      ->first();
      $cat_id = $category_id->id;
      $facility=DB::table('facility_registrar')->where('user_id', Auth::user()->id)->first();

      $data['feesdaily']=DB::table('payments')
      ->leftJoin('appointments', 'appointments.id', '=','payments.appointment_id' )
      ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
      ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
      ->select('afya_users.*','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
      'dependant.dob as Infdob','payments.amount','payments.id as payment_id','payments.mode','payments.created_at as paydate','appointments.persontreated',
      'appointments.id AS app_id')
      ->where([
        ['payments.amount', '<>', 'None'],
        ['appointments.facility_id', '=', $facility->facilitycode],
      ])
      ->whereDate('payments.created_at','=',$dat)
      ->groupBy('payments.appointment_id')
      ->get();

      $data['wekexp1']=DB::table('payments')
      ->join('appointments','appointments.id','=','payments.appointment_id')
      ->where('appointments.facility_id', '=', $facility->facilitycode)
      ->whereDate('payments.created_at','=',$dat)
      ->sum('amount');

      $data['feesmonth'] = DB::table('payments')
      ->Join('appointments', 'appointments.id', '=','payments.appointment_id' )
      ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
      ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
      ->select('afya_users.*','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
      'dependant.dob as Infdob','payments.amount','payments.id as payment_id','payments.mode','payments.created_at as paydate','appointments.persontreated',
      'appointments.id AS app_id')
      ->where([
        ['payments.amount', '<>', 'None'],
        ['payments.created_at','>=',$datmm],
        ['payments.created_at','<=',$datm],
        ['appointments.facility_id', '=', $facility->facilitycode],
      ])
      ->groupBy('payments.appointment_id')
      ->get();

      $data['wekexp2']=DB::table('payments')
      ->join('appointments','appointments.id','=','payments.appointment_id')
      ->where([  ['appointments.facility_id', '=', $facility->facilitycode],
      ['payments.created_at','>=',$datmm],
      ['payments.created_at','<=',$datm],
    ])
    ->sum('amount');

    $fees = DB::table('payments')
    ->Join('appointments', 'appointments.id', '=','payments.appointment_id' )
    ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
    ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
    ->select('afya_users.*','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
    'dependant.dob as Infdob','payments.amount','payments.id as payment_id','payments.mode','payments.created_at as paydate','appointments.persontreated',
    'appointments.id AS app_id')
    ->where([
      ['payments.amount', '<>', 'None'],
      ['appointments.facility_id', '=', $facility->facilitycode],
    ])
    ->groupBy('payments.appointment_id')
    ->get();

    return view('registrar.paid_fees',$data)->with('fees',$fees)->with('facility',$facility);
  }

  public function showReceipt($id)
  {
    $receipt = DB::table('appointments')
    ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
    ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
    ->join('payments', 'payments.appointment_id', '=', 'appointments.id')
    ->join('payments_categories', 'payments_categories.id', '=', 'payments.payments_category_id')
    ->rightJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
    ->join('facility_doctor', 'facility_doctor.doctor_id', '=', 'doctors.id')
    ->join('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
    ->select('afya_users.firstname', 'afya_users.secondName', 'dependant.firstName as dep_fname','dependant.secondName as dep_lname',
    'doctors.name AS doc_name', 'facilities.FacilityName', 'payments_categories.category_name', 'payments.amount', 'appointments.created_at',
    'payments.id AS the_id', 'appointments.persontreated')
    ->where([
      ['facility_doctor.user_id', '=', Auth::id()],
      ['appointments.id', '=', $id],
    ])
    ->first();

    return view('private.receipts')->with('receipt',$receipt)->with('id',$id);
  }

  public function showPaid($id)
  {
    $u_id = Auth::user()->id;
    $fac = DB::table('facility_registrar')
    ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
    ->select('facility_registrar.facilitycode','facilities.FacilityName')
    ->where('user_id', $u_id)->first();
    $facility =$fac->facilitycode;
    $receipt = DB::table('appointments')
             ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
             ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
             ->leftJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
             ->leftjoin('facility_doctor', 'facility_doctor.doctor_id', '=', 'doctors.id')
             ->select('afya_users.id as afyaId','afya_users.firstname', 'afya_users.secondName', 'dependant.firstName as dep_fname','dependant.secondName as dep_lname',
             'doctors.name AS doc_name','appointments.id as appid', 'appointments.persontreated', 'appointments.appointment_date','appointments.created_at as appdate')
             ->where([['appointments.id', '=', $id],])
             ->first();

   $rect = DB::table('payments')
   ->Join('radiology_test_details', 'payments.imaging_id', '=', 'radiology_test_details.id')
   ->select('payments.*','radiology_test_details.test','radiology_test_details.test_cat_id')
                      ->where([
                        ['payments.payments_category_id', '=', 3],
                        ['payments.appointment_id', '=', $id],
                        ['payments.facility', '=', $facility],
                      ])  ->get();

  $data['lab'] = DB::table('payments')
  ->Join('patient_test_details', 'payments.lab_id', '=', 'patient_test_details.id')
  ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->select('tests.name','payments.amount')
   ->where([
                       ['payments.payments_category_id', '=', 2],
                       ['payments.appointment_id', '=', $id],
                       ['payments.facility', '=', $facility],
                     ])  ->get();
 $data['consult'] = DB::table('payments')->select('amount')
 ->where([ ['payments_category_id', '=', 1],
 ['payments.appointment_id', '=', $id],
 ['payments.facility', '=', $facility],])  ->first();

 $data['medfee'] = DB::table('payments')->select('amount')
 ->where([ ['payments_category_id', '=', 4],
 ['payments.appointment_id', '=', $id],
 ['payments.facility', '=', $facility],
 ])  ->first();

 $rectsum = DB::table('payments')
 ->select(DB::raw("SUM(payments.amount) as paidsum"))
 ->where([
                  ['payments.appointment_id', '=', $id],
                  ['payments.facility', '=', $facility],
                ])
                ->first();
return view('registrar.receipt',$data)->with('receipt',$receipt)->with('rect',$rect)->with('rectsum',$rectsum)->with('fac',$fac);
  }
  public function showPaidp($id)
  {
    $receipt = DB::table('appointments')
    ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
    ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
    ->join('payments', 'payments.appointment_id', '=', 'appointments.id')
    ->join('payments_categories', 'payments_categories.id', '=', 'payments.payments_category_id')
    ->leftJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
    ->join('facility_doctor', 'facility_doctor.doctor_id', '=', 'doctors.id')
    ->join('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
    ->join('facility_registrar', 'facility_registrar.facilitycode', '=', 'facilities.FacilityCode')
    ->select('afya_users.firstname', 'afya_users.secondName', 'dependant.firstName as dep_fname','dependant.secondName as dep_lname',
    'doctors.name AS doc_name', 'facilities.FacilityName', 'payments_categories.category_name', 'payments.amount', 'appointments.created_at',
    'payments.id AS the_id', 'appointments.persontreated', 'appointments.appointment_date')
    ->where([
      ['facility_registrar.user_id', '=', Auth::id()],
      ['appointments.id', '=', $id],
    ])
    ->first();

    return view('registrar.receiptp')->with('receipt',$receipt)->with('id',$id);
  }
  public function printReceipt($id)
  {
    $receipt = DB::table('appointments')
    ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
    ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
    ->join('payments', 'payments.appointment_id', '=', 'appointments.id')
    ->join('payments_categories', 'payments_categories.id', '=', 'payments.payments_category_id')
    ->rightJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
    ->join('facility_doctor', 'facility_doctor.doctor_id', '=', 'doctors.id')
    ->join('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
    ->join('facility_registrar', 'facility_registrar.facilitycode', '=', 'facilities.FacilityCode')
    ->select('afya_users.firstname', 'afya_users.secondName', 'dependant.firstName as dep_fname','dependant.secondName as dep_lname',
    'doctors.name AS doc_name', 'facilities.FacilityName', 'payments_categories.category_name', 'payments.amount', 'appointments.created_at',
    'payments.id AS the_id', 'appointments.persontreated')
    ->where([
      ['facility_registrar.user_id', '=', Auth::id()],
      ['appointments.id', '=', $id],
    ])
    ->first();

    return view('registrar.print_receipt')->with('receipt',$receipt);
  }

  public function printReceipt2($id)
  {
    $receipt = DB::table('appointments')
    ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
    ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
    ->join('payments', 'payments.appointment_id', '=', 'appointments.id')
    ->join('payments_categories', 'payments_categories.id', '=', 'payments.payments_category_id')
    ->rightJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
    ->join('facility_doctor', 'facility_doctor.doctor_id', '=', 'doctors.id')
    ->join('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
    ->select('afya_users.firstname', 'afya_users.secondName', 'dependant.firstName as dep_fname','dependant.secondName as dep_lname',
    'doctors.name AS doc_name', 'facilities.FacilityName', 'payments_categories.category_name', 'payments.amount', 'appointments.created_at',
    'payments.id AS the_id', 'appointments.persontreated')
    ->where([
      ['facility_doctor.user_id', '=', Auth::id()],
      ['appointments.id', '=', $id],
    ])
    ->first();

    return view('private.print_receipt')->with('receipt',$receipt);
  }

  public function createDetails(Request $request)

  {
    $id = $request->id;
    $appointment = $request->appointment;
    $weight = $request->weight;
    $heightS = $request->current_height;
    $temperature = $request->temperature;
    $systolic = $request->systolic;
    $diastolic = $request->diastolic;
    $allergies = $request->allergies;
    $chiefcompliant = $request->chiefcompliant;
    $observation = $request->observation;
    $symptoms = $request->symptoms;
    $nurse = $request->nurse;
    $doctor = $request->doctor;
    $lmp = $request->lmp;
    $rbs = $request->rbs;
    $hr = $request->hr;
    $rr = $request->rr;
$pregnant = $request->pregnant;


                  // $appointment=DB::table('appointments')->where('afya_user_id', $id)->where('status',1)->orderBy('created_at', 'desc')->first();

                  DB::table('triage_details')->insert(
                    ['appointment_id' => $appointment,
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
                  DB::table('appointments')->where('id',$appointment)->update([
                    'status'=>2,
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                  ]);


                  return redirect()->route('showPatient', ['id'=> $appointment]);
                }
                /**
                * Show the form for creating a new resource.
                *
                * @return \Illuminate\Http\Response
                */
                public function create()
                {
                  //
                }

                /**
                * Store a newly created resource in storage.
                *
                * @param  \Illuminate\Http\Request  $request
                * @return \Illuminate\Http\Response
                */
                public function store(Request $request)
                {
                  //
                }

                /**
                * Display the specified resource.
                *
                * @param  int  $id
                * @return \Illuminate\Http\Response
                */
                public function show($id)
                {
                  // return view('private.nurse')->with('patient',$patient)->with(['kin'=>$kin]);
                  return redirect()->action('privateController@nurseVitals',['id'=> $id]);

                }

public function nurseVitals($id){

$data['db'] = DB::table('appointments')
->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
->leftjoin('dependant','appointments.persontreated','=','dependant.id')
->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
->select('appointments.*','afya_users.*','afya_users.id as afyaId','appointments.id as appid',
'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
->where('appointments.id',$id)
->first();
return view('private.nursevitals',$data);
}

                public function fobservation(Request $request){
                  $term = trim($request->q);
                  if (empty($term)) {
                    return \Response::json([]);
                  }
                  $drugs = Observation::search($term)->limit(20)->get();
                  $formatted_drugs = [];
                  foreach ($drugs as $drug) {
                    $formatted_drugs[] = ['id' => $drug->name, 'text' => $drug->name];
                  }
                  return \Response::json($formatted_drugs);
                }
                public function fsymptom(Request $request){
                  $term = trim($request->q);
                  if (empty($term)) {
                    return \Response::json([]);
                  }
                  $drugs = Symptom::search($term)->limit(20)->get();
                  $formatted_drugs = [];
                  foreach ($drugs as $drug) {
                    $formatted_drugs[] = ['id' => $drug->name, 'text' => $drug->name];
                  }
                  return \Response::json($formatted_drugs);
                }
                public function fchief(Request $request){
                  $term = trim($request->q);
                  if (empty($term)) {
                    return \Response::json([]);
                  }
                  $drugs = Chief::search($term)->limit(20)->get();
                  $formatted_drugs = [];
                  foreach ($drugs as $drug) {
                    $formatted_drugs[] = ['id' => $drug->name, 'text' => $drug->name];
                  }
                  return \Response::json($formatted_drugs);
                }

                public function vaccinescreate($id){
                  return view('private.vaccine')->with('id',$id);
                }
                public function vaccine(Request $request)
                {


                  $afya_id=$request->afya_user_id;
                  $vaccine_id=$request->vaccine_id;
                  $vaccinename=$request->vaccine_name;

                  DB::table('vaccination')->insert(
                    ['userId' => $afya_id,
                    'diseaseId' => $vaccine_id,
                    'vaccine_name'=> $vaccinename,
                    'Yes'=>'YES',
                    'Created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'yesdate' => \Carbon\Carbon::now()->toDateTimeString()]
                  );

                  //  return Redirect::route('private.show', [$id]);
                  $data =DB::table('vaccine')
                  ->join('vaccination','vaccine.id','=','vaccination.diseaseId')
                  ->select('vaccine.id','vaccine.disease','vaccine.antigen','vaccination.vaccine_name','vaccination.yesdate')
                  ->where('vaccine.id',$vaccine_id)
                  ->first();
                  return response()->json($data);

                }

                public function appointmentsmade(){
                  $today = Carbon::today();
                  $dat =$today->toDateString();

                  $tomorrow= Carbon::tomorrow();
                  $dat2 =$tomorrow->toDateString();
                  // $tomorrow2= $today->addDay(2);
                  // $dat3 =$tomorrow->toDateString();
                  $date1 = Carbon::now();
                  $date2 = Carbon::now();

                  $endweek= $date1->endOfWeek();
                  $datw =$endweek->toDateString();
                  $endmonth= $date2->endOfMonth();
                  $datm =$endmonth->toDateString();

                  $facility = DB::table('facility_doctor')
                  ->join('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
                  ->select('facilities.FacilityCode','facilities.set_up','facilities.FacilityName','facilities.Type','facility_doctor.doctor_id')
                  ->where('facility_doctor.user_id', Auth::user()->id)
                  ->first();
                  $facilitycode = $facility->FacilityCode;
                  $patients = DB::table('appointments')
                  ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
                  ->leftjoin('appointment_notes','appointment_notes.appointment_id','=','appointments.id')
                  ->select('afya_users.id as parid','afya_users.file_no','afya_users.firstname as first','afya_users.secondName as second','afya_users.gender as gender','afya_users.dob as dob',
                  'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob', 'dependant.gender as dgender',
                  'appointments.appointment_time', 'appointments.appointment_date','appointments.id as appid','appointments.persontreated','afya_users.msisdn','appointment_notes.notes')
                  // ->where([['appointments.status',10],])
                  ->whereDate('appointments.appointment_date','=',$dat)

                  ->where([['appointments.facility_id',$facilitycode],['appointments.doc_id','=',$facility->doctor_id]])
                  ->get();

                  $data['patients2'] = DB::table('appointments')
                  ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
                  ->leftjoin('appointment_notes','appointment_notes.appointment_id','=','appointments.id')
                  ->select('afya_users.id as parid','afya_users.file_no','afya_users.firstname as first','afya_users.secondName as second','afya_users.gender as gender','afya_users.dob as dob',
                  'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob', 'dependant.gender as dgender',
                  'appointments.appointment_time', 'appointments.appointment_date','appointments.id as appid','appointments.persontreated','afya_users.msisdn','appointment_notes.notes')
                  ->whereDate('appointments.appointment_date','=',$dat2)

                  ->where([['appointments.facility_id',$facilitycode],['appointments.doc_id','=',$facility->doctor_id]])
                  ->get();
                  $data['patients3'] = DB::table('appointments')
                  ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
                  ->leftjoin('appointment_notes','appointment_notes.appointment_id','=','appointments.id')
                 ->select('afya_users.id as parid','afya_users.file_no','afya_users.firstname as first','afya_users.secondName as second','afya_users.gender as gender','afya_users.dob as dob',
                  'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob', 'dependant.gender as dgender',
                  'appointments.appointment_time', 'appointments.appointment_date','appointments.id as appid','appointments.persontreated','afya_users.msisdn','appointment_notes.notes')
                  ->where([['appointments.appointment_date','>=',$dat],['appointments.appointment_date','<=',$datw],])
                  ->whereNotNull('appointments.appointment_date')
                  ->where([['appointments.facility_id',$facilitycode],['appointments.doc_id','=',$facility->doctor_id]])
                  ->get();
                  $data['patients4'] = DB::table('appointments')
                  ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
                  ->leftjoin('appointment_notes','appointment_notes.appointment_id','=','appointments.id')
                 ->select('afya_users.id as parid','afya_users.file_no','afya_users.firstname as first','afya_users.secondName as second','afya_users.gender as gender','afya_users.dob as dob',
                  'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob', 'dependant.gender as dgender',
                  'appointments.appointment_time', 'appointments.appointment_date','appointments.id as appid','appointments.persontreated','afya_users.msisdn','appointment_notes.notes')
                  ->where([['appointments.appointment_date','>=',$dat],['appointments.appointment_date','<=',$datm],])
                  ->whereNotNull('appointments.appointment_date')
                  ->where([['appointments.facility_id',$facilitycode],['appointments.doc_id','=',$facility->doctor_id]])
                  ->get();
                  return view('private.appmade',$data)->with('patients',$patients)->with('facility',$facility);
                }
                public function appointmentsmadereg(){

                  $today = Carbon::today();
                  $dat =$today->toDateString();
                  $tomorrow= Carbon::tomorrow();
                  $dat2 =$tomorrow->toDateString();
                  // $tomorrow2= $today->addDay(2);
                  // $dat3 =$tomorrow->toDateString();
                  $date1 = Carbon::now();
                  $date2 = Carbon::now();
                  $endweek= $date1->endOfWeek();
                  $datw =$endweek->toDateString();
                  $endmonth= $date2->endOfMonth();
                  $datm =$endmonth->toDateString();

                  $facility = DB::table('facility_registrar')
                  ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
                  ->select('facilities.FacilityCode','facilities.set_up','facilities.FacilityName','facilities.Type')
                  ->where('facility_registrar.user_id', Auth::user()->id)
                  ->first();

                  $facilitycode = $facility->FacilityCode;

                  $patients = DB::table('appointments')
                  ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
                  ->leftJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
                  ->select('afya_users.id as parid','afya_users.file_no','afya_users.firstname as first','afya_users.secondName as second','afya_users.gender as gender','afya_users.dob as dob',
                  'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob', 'dependant.gender as dgender',
                  'appointments.appointment_time', 'appointments.appointment_date','appointments.id as appid','appointments.persontreated','afya_users.msisdn', 'doctors.name AS doc_name')
                  ->whereDate('appointments.appointment_date','=',$dat)
                  ->where('appointments.facility_id',$facilitycode)
                  ->get();

                  $data['patients2'] = DB::table('appointments')
                  ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
                  ->leftJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
                  ->select('afya_users.id as parid','afya_users.file_no','afya_users.firstname as first','afya_users.secondName as second','afya_users.gender as gender','afya_users.dob as dob',
                  'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob', 'dependant.gender as dgender',
                  'appointments.appointment_time', 'appointments.appointment_date','appointments.id as appid','appointments.persontreated','afya_users.msisdn', 'doctors.name AS doc_name')
                  ->where([['appointments.appointment_date','=',$dat2],])
                  ->where('appointments.facility_id',$facilitycode)
                  ->get();

                  $data['patients3'] = DB::table('appointments')
                  ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
                  ->leftJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
                  ->select('afya_users.id as parid','afya_users.file_no','afya_users.firstname as first','afya_users.secondName as second','afya_users.gender as gender','afya_users.dob as dob',
                  'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob', 'dependant.gender as dgender',
                  'appointments.appointment_time', 'appointments.appointment_date','appointments.id as appid','appointments.persontreated','afya_users.msisdn', 'doctors.name AS doc_name')
                  ->where([['appointments.appointment_date','>=',$dat],['appointments.appointment_date','<=',$datw],])
                  ->whereNotNull('appointments.appointment_date')
                  ->where('appointments.facility_id',$facilitycode)
                  ->get();

                  $data['patients4'] = DB::table('appointments')
                  ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
                  ->leftJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
                  ->select('afya_users.id as parid','afya_users.file_no','afya_users.firstname as first','afya_users.secondName as second','afya_users.gender as gender','afya_users.dob as dob',
                  'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob', 'dependant.gender as dgender',
                  'appointments.appointment_time', 'appointments.appointment_date','appointments.id as appid','appointments.persontreated','afya_users.msisdn', 'doctors.name AS doc_name')
                  ->where([['appointments.appointment_date','>=',$dat],['appointments.appointment_date','<=',$datm],])
                  ->whereNotNull('appointments.appointment_date')
                  ->where('appointments.facility_id',$facilitycode)
                  ->get();


                  return view('registrar.private.appointment',$data)->with('patients',$patients)->with('facility',$facility);
                }
                public function showPaidd($id)
                {
                  $u_id = Auth::user()->id;
                  $facility = DB::table('facility_doctor')->select('facilitycode')->where('user_id', $u_id)->first();
                  $facility = $facility->facilitycode;


                  $receipt = DB::table('appointments')
                  ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
                  ->leftJoin('doctors', 'appointments.doc_id', '=', 'doctors.id')
                  ->leftjoin('facility_doctor', 'facility_doctor.doctor_id', '=', 'doctors.id')
                  ->leftjoin('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
                  ->select('afya_users.firstname', 'afya_users.secondName', 'dependant.firstName as dep_fname','dependant.secondName as dep_lname',
                  'doctors.name AS doc_name', 'facilities.FacilityName',  'appointments.created_at',
                  'appointments.persontreated', 'appointments.appointment_date','appointments.appointment_time')
                  ->where([    ['appointments.id', '=', $id],  ])
                  ->first();
                  $receiptcon = DB::table('payments')
                  ->leftjoin('payments_categories', 'payments.payments_category_id', '=', 'payments_categories.id')
                  ->select('payments_categories.category_name', 'payments.amount', 'payments.created_at', 'payments.id AS the_id')
                  ->where([
                    ['payments.facility', '=', $facility ],
                    ['payments.payments_category_id', '=', 1],
                    ['payments.appointment_id', '=', $id],
                  ])
                  ->first();
                  return view('private.con_feesreceipt')->with('receipt',$receipt)->with('id',$id)->with('receiptcon',$receiptcon);
                }
                public function showPaidlab2($id)
                {
                  $u_id = Auth::user()->id;
                  $facility = DB::table('facility_doctor')->select('facilitycode')->where('user_id', $u_id)->first();
                  $facility =$facility->facilitycode;
                  $data['receipt'] = DB::table('appointments')
                  ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
                  ->leftJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
                  ->join('facility_doctor', 'facility_doctor.doctor_id', '=', 'doctors.id')
                  ->join('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
                  ->select('afya_users.firstname', 'afya_users.secondName', 'dependant.firstName as dep_fname','dependant.secondName as dep_lname',
                  'doctors.name AS doc_name', 'facilities.FacilityName',
                  'appointments.id as appid', 'appointments.persontreated', 'appointments.appointment_date')
                  ->where([
                    ['appointments.id', '=', $id],
                  ])
                  ->first();

                  $data['labs'] = DB::table('payments')
                  ->Join('patient_test_details', 'payments.lab_id', '=', 'patient_test_details.id')
                  ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
                  ->select('payments.*','tests.name')

                  ->where([
                    ['payments.payments_category_id', '=', 2],
                    ['payments.appointment_id', '=', $id],
                    ['payments.facility', '=', $facility],
                  ])
                  ->get();
                  $data['labsum'] = DB::table('payments')
                  ->Join('patient_test_details', 'payments.lab_id', '=', 'patient_test_details.id')
                  ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
                  ->select(DB::raw("SUM(payments.amount) as paidsum"))

                  ->where([
                    ['payments.payments_category_id', '=', 2],
                    ['payments.appointment_id', '=', $id],
                    ['payments.facility', '=', $facility],
                  ])
                  ->first();

                  return view('private.labreceipt2',$data);
                }
                public function showPaidrady2($id){
                  $u_id = Auth::user()->id;
                  $fac = DB::table('facility_doctor')
                  ->join('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
                  ->select('facility_doctor.facilitycode','facilities.FacilityName')
                  ->where('facility_doctor.user_id', $u_id)->first();
                  $facility =$fac->facilitycode;


                  $data['receipt'] = DB::table('appointments')
                  ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
                  ->leftJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
                  ->leftjoin('facility_doctor', 'facility_doctor.doctor_id', '=', 'doctors.id')
                  ->select('afya_users.firstname', 'afya_users.secondName', 'dependant.firstName as dep_fname','dependant.secondName as dep_lname',
                  'doctors.name AS doc_name','appointments.id as appid', 'appointments.persontreated', 'appointments.appointment_date')
                  ->where([
                    ['appointments.id', '=', $id],
                  ])
                  ->first();

                  $data['rect'] = DB::table('payments')
                  ->Join('radiology_test_details', 'payments.imaging_id', '=', 'radiology_test_details.id')
                  ->select('payments.*','radiology_test_details.test','radiology_test_details.test_cat_id')
                  ->where([
                    ['payments.payments_category_id', '=', 3],
                    ['payments.appointment_id', '=', $id],
                    ['payments.facility', '=', $facility],
                  ])
                  ->get();
                  $data['lab'] = DB::table('payments')
                  ->Join('patient_test_details', 'payments.lab_id', '=', 'patient_test_details.id')
                  ->Join('icd10_option', 'patient_test_details.tests_reccommended', '=', 'icd10_option.id')
                  ->select('payments.*','icd10_option.name')
                  ->where([
                    ['payments.payments_category_id', '=', 3],
                    ['payments.appointment_id', '=', $id],
                    ['payments.facility', '=', $facility],
                  ])
                  ->get();
                  $data['rectsum'] = DB::table('payments')
                  ->select(DB::raw("SUM(payments.amount) as paidsum"))
                  ->where([
                    ['payments.payments_category_id', '=', 3],
                    ['payments.appointment_id', '=', $id],
                    ['payments.facility', '=', $facility],
                  ])
                  ->first();

                  return view('private.radyreceipt2',$data)->with('fac',$fac);
                }
                public function allPatients()
                {
                  $today = Carbon::today();
                  $dat =$today->toDateString();

                  $date = Carbon::now();
                  $date2 = Carbon::now();
                  $date1 = Carbon::now();
                  $date21 = Carbon::now();
                  $endweek= $date2->endOfWeek();
                  $startwk= $date->startOfWeek();
                  $datws =$startwk->toDateString();
                  $datwe =$endweek->toDateString();

                  $stmonth= $date1->startOfMonth();
                  $endmonth= $date21->endOfMonth();
                  $datme =$endmonth->toDateString();
                  $datms =$stmonth->toDateString();

                  $facility = DB::table('facility_doctor')
                  ->join('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
                  ->select('facility_doctor.doctor_id','facility_doctor.facilitycode','facilities.set_up','facilities.FacilityName','facilities.Type')
                  ->where('facility_doctor.user_id', Auth::user()->id)
                  ->first();

                  $facilitycode =$facility->facilitycode;
                  $doc =$facility->doctor_id;

                  $data['patientsToday'] = DB::table('appointments')
                  ->join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->select('afya_users.*', 'appointments.id as appId')
                  ->where([['appointments.doc_id', $doc],['appointments.facility_id', $facilitycode],['appointments.status', '<>', 0]])
                  ->whereDate('appointments.created_at','=',$dat)
                  ->groupBy('appointments.afya_user_id')
                  ->get();

                  $data['patientswk'] = DB::table('appointments')
                  ->join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->select('afya_users.*', 'appointments.id as appId')
                  ->where([['appointments.doc_id', $doc],['appointments.facility_id', $facilitycode],['appointments.status', '<>', 0]])
                  ->whereDate('appointments.created_at','>=',$datws)
                  ->whereDate('appointments.created_at','<=',$datwe)
                  ->groupBy('appointments.afya_user_id')
                  ->get();

                  $data['patientmonth'] = DB::table('appointments')
                  ->join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                  ->select('afya_users.*', 'appointments.id as appId')
                  ->where([['appointments.doc_id', $doc],['appointments.facility_id', $facilitycode],['appointments.status', '<>', 0]])
                  ->whereDate('appointments.created_at','>=',$datms)
                  ->whereDate('appointments.created_at','<=',$datme)
                  ->groupBy('appointments.afya_user_id')
                  ->get();

                  $data['users'] = DB::table('patient_facility')
                  ->join('appointments', 'patient_facility.afya_user_id', '=', 'appointments.afya_user_id')
                  ->join('afya_users', 'patient_facility.afya_user_id', '=', 'afya_users.id')
                  ->select('afya_users.*')
                  ->distinct('afya_users.id')
                  ->where([['appointments.doc_id', $doc],['patient_facility.facility_id', $facilitycode],])
                  ->get();

                  return view('private.allpatients',$data)->with('facility',$facility);
                }

              }
