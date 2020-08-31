<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Doctor;
use Carbon\Carbon;
use Auth;
use App\Patient;
use App\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class DoctorController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
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
    $doc= DB::table('facility_doctor')
    ->Join('facilities', 'facility_doctor.facilitycode', '=', 'facilities.FacilityCode')
    ->Join('doctors', 'facility_doctor.doctor_id', '=', 'doctors.id')
    ->where('facility_doctor.user_id', '=', Auth::user()->id)
    ->select('doctors.name','doctors.speciality','facilities.FacilityName','facilities.Type','facility_doctor.doctor_id','facility_doctor.facilitycode')
    ->first();
    $doctor_id =$doc->doctor_id;
    $facility_id= $doc->facilitycode;

    $youngest= DB::table('afya_users')
    ->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
    ->where([['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
    ->whereNotNull('afya_users.dob')
    ->select('afya_users.dob','afya_users.firstname','afya_users.secondName')
    ->orderby('afya_users.dob', 'DESC')
    ->first();
    
    $oldest= DB::table('afya_users')
    ->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
    ->where([['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
    ->whereNotNull('afya_users.dob')
    ->select('afya_users.dob','afya_users.firstname','afya_users.secondName')
    ->orderby('afya_users.dob', 'ASC')
    ->first();

    return view('doctor.dashboard')->with('doc',$doc)->with('oldest',$oldest)->with('youngest',$youngest);

  }
  public function doctorpatient()

  {

    $today = Carbon::today();
    $doc_id = DB::table('facility_doctor')
    ->select('doctor_id')->where('user_id', Auth::user()->id)
    ->first();

    if(is_null($doc_id)){
      return "invalid doctor account";
    }
    $doctor_id=$doc_id->doctor_id;

    $patients = DB::table('appointments')
    ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
    ->leftJoin('triage_details', 'appointments.id', '=', 'triage_details.appointment_id')
    ->leftJoin('triage_infants', 'appointments.id', '=', 'triage_infants.appointment_id')
    ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
    ->leftJoin('constituency', 'afya_users.constituency', '=', 'constituency.id')
    ->select('afya_users.*','triage_details.*','appointments.id as appid',
    'appointments.created_at','appointments.facility_id','constituency.Constituency',
    'appointments.persontreated', 'appointments.visit_type','appointments.last_app_id',
    'triage_infants.weight as Infweight','triage_infants.height as Infheight','triage_infants.temperature as Inftemp',
    'triage_infants.chief_compliant as Infcompliant','triage_infants.systolic_bp as Infsysto','triage_infants.diastolic_bp as Infdiasto',
    'triage_infants.observation as Infobservation','triage_infants.symptoms as Infsymptoms','triage_infants.nurse_notes as Infnotes',
    'dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender','dependant.blood_type as Infblood_type',
    'dependant.dob as Infdob','dependant.pob as Infpob'
    )

    ->where([      ['appointments.created_at','>=',$today],
    ['appointments.status', '=', 2],
    ['appointments.doc_id', '=',$doctor_id],
  ])

  ->get();

  return view('doctor.newPatients')->with('patients',$patients);
}
public function pending(){
  $today = Carbon::today();
  $doc_id = DB::table('facility_doctor')
  ->select('doctor_id')->where('user_id', Auth::user()->id)
  ->first();

  $doctor_id=$doc_id->doctor_id;
  $patients = DB::table('appointments')
  ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
  ->leftJoin('triage_details', 'appointments.last_app_id', '=', 'triage_details.appointment_id')
  ->leftJoin('triage_infants', 'appointments.last_app_id', '=', 'triage_infants.appointment_id')
  ->leftJoin('dependant', 'triage_infants.dependant_id', '=', 'dependant.id')
  ->leftJoin('constituency', 'afya_users.constituency', '=', 'constituency.id')
  ->select('afya_users.*','triage_details.*','appointments.id as appid',
  'appointments.created_at','appointments.facility_id','constituency.Constituency',
  'appointments.persontreated', 'appointments.appointment_made','appointments.last_app_id',
  'triage_infants.weight as Infweight','triage_infants.height as Infheight','triage_infants.temperature as Inftemp',
  'triage_infants.chief_compliant as Infcompliant','triage_infants.systolic_bp as Infsysto','triage_infants.diastolic_bp as Infdiasto',
  'triage_infants.observation as Infobservation','triage_infants.symptoms as Infsymptoms','triage_infants.nurse_notes as Infnotes',
  'dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender','dependant.blood_type as Infblood_type',
  'dependant.dob as Infdob','dependant.pob as Infpob'
  )

  ->where([
    ['appointments.p_status', '=', 11],
    ['appointments.status', '=', 2],
    ['appointments.doc_id', '=',$doctor_id],
  ])
  ->orwhere([ ['appointments.created_at','>=',$today],
  ['appointments.p_status', '=', 11],
  ['appointments.status', '=', 2],
  ['appointments.doc_id', '=',$doctor_id],
])

->get();
return view('doctor.pendingPatients')->with('patients',$patients);
}
public function dependant()

{
  $today = Carbon::today();

  $patients = DB::table('appointments')
  ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
  ->leftJoin('dependant', 'dependant.id', '=', 'dependant_parent.dependant_id')
  ->leftJoin('facility_doctor', 'appointments.doc_id', '=', 'facility_doctor.doctor_id')
  ->leftJoin('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->leftJoin('triage_infants', 'appointments.id', '=', 'triage_infants.appointment_id')
  ->leftJoin('afya_users', 'dependant_parent.afya_user_id', '=', 'afya_users.id')
  ->leftJoin('constituency', 'afya_users.constituency', '=', 'constituency.id')
  ->select('triage_infants.*','dependant.*','appointments.*','appointments.id as appid',
  'afya_users.firstname','afya_users.secondName as ndName','afya_users.constituency','constituency.Constituency')
  ->where([
    ['appointments.created_at','>=',$today],
    ['appointments.status', '=', 2],
    ['facility_doctor.user_id', '=',Auth::user()->id],
  ])
  ->get();

  return view('doctor.newdependant')->with('patients',$patients);
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
  return view('doctor.create');
}


public function Calendar(){
  return view('doctor.calendar');
}

/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)

{
  $this->validate($request, [
    'name' => 'required',
    'user_id' => 'required',
    'regno' => 'required|unique:doctors,RegNo',
    'address' => 'required',
    'phone' => 'required',
    'residence' => 'required',
    'speciality' => 'required'
  ]);

  Doctor::create($request->all());


  return redirect()->route('doctor.index')->with('success','User created successfully');

}

/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/

public function Admitted()
{
  $today = Carbon::today();
  $patients = DB::table('appointments')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
  ->leftJoin('facility_doctor', 'appointments.doc_id', '=', 'facility_doctor.doctor_id')
  ->leftJoin('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->leftJoin('triage_details', 'appointments.id', '=', 'triage_details.appointment_id')
  ->leftJoin('triage_infants', 'appointments.id', '=', 'triage_infants.appointment_id')
  ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
  ->leftJoin('constituency', 'afya_users.constituency', '=', 'constituency.id')
  ->leftJoin('facilities', 'patient_admitted.facility', '=', 'facilities.id')

  ->select('afya_users.*','triage_details.*','appointments.id as appid','patient_admitted.date_admitted',
  'facilities.FacilityName','appointments.created_at','appointments.facility_id','constituency.Constituency',
  'appointments.persontreated','triage_infants.chief_compliant as Infcompliant',
  'dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender','dependant.dob as Infdob')
  ->where([
    ['appointments.status', '=', 4],
    ['patient_admitted.condition', '=','Admitted'],
    ['facility_doctor.user_id', '=',Auth::user()->id],
  ])
  // ->where([
  //                 ['appointments.created_at','>=',$today],
  //                 ['appointments.status', '=', 2],
  //                 ['patient_admitted.condition', '=','Admitted'],
  //                 ['facility_doctor.user_id', '=',Auth::user()->id],
  //                ])
  ->get();


  return view('doctor.patientadmitted')->with('patients',$patients);
}



public function fees()
{
  $today = Carbon::today();
  $dat =$today->toDateString();

  $date = Carbon::now();
  $endweek= $date->endOfWeek();
  $datw =$endweek->toDateString();

  $startmonth=$date->startOfMonth();
  $datmm =$startmonth->toDateString();
  $endmonth= $date->endOfMonth();
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
    ['appointments.facility_id', '=', $facility->facilitycode],
  ])
  ->whereDate('payments.created_at','=',$dat)
  ->groupBy('payments.appointment_id','payments.payments_category_id')
  ->get();

  $data['wekexp1']=DB::table('payments')
  ->join('appointments','appointments.id','=','payments.appointment_id')
  ->where('appointments.facility_id', '=', $facility->facilitycode)
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
    ['appointments.facility_id', '=', $facility->facilitycode],
  ])

  ->groupBy('payments.appointment_id','payments.payments_category_id')
  ->get();

  $data['wekexp2']=DB::table('payments')
  ->join('appointments','appointments.id','=','payments.appointment_id')
  ->where([  ['appointments.facility_id', '=', $facility->facilitycode],
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
])
->groupBy('payments.appointment_id','payments.payments_category_id')
->get();


return view('doctor.yourfees',$data)->with('fees',$fees)->with('facility',$facility);
}

public function selfReporting()
{
  $today = Carbon::today();
  $doc_id = DB::table('facility_doctor')
  ->select('doctor_id')->where('user_id', Auth::user()->id)
  ->first();

  $doctor_id=$doc_id->doctor_id;
  $patients = DB::table('self_report')
  ->leftJoin('afya_users', 'self_report.afyauser_id', '=', 'afya_users.id')
  ->leftJoin('dependant', 'self_report.dependents', '=', 'dependant.id')
  ->leftJoin('constituency', 'afya_users.constituency', '=', 'constituency.id')
  ->select('dependant.id as depId','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
  'dependant.dob as Infdob','self_report.*','self_report.created_at as srpdate',
  'afya_users.id as afyaId','afya_users.firstname','afya_users.secondName','afya_users.gender','afya_users.dob','constituency.Constituency')

  ->where([ ['self_report.status','=',NULL],
  ['self_report.doc_id', '=',$doctor_id],  ])
  ->get();

  return view('doctor.selfReporting')->with('patients',$patients);
}


public function slfrprtngHist()
{
  $doc_id = DB::table('facility_doctor')
  ->select('doctor_id')->where('user_id', Auth::user()->id)
  ->first();

  $doctor_id=$doc_id->doctor_id;
  $patients = DB::table('self_report')
  ->leftJoin('afya_users', 'self_report.afyauser_id', '=', 'afya_users.id')
  ->leftJoin('dependant', 'self_report.dependents', '=', 'dependant.id')
  ->leftJoin('constituency', 'afya_users.constituency', '=', 'constituency.id')
  ->select('dependant.id as depId','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
  'dependant.dob as Infdob','self_report.*','self_report.created_at as srpdate',
  'afya_users.id as afyaId','afya_users.firstname','afya_users.secondName','afya_users.gender','afya_users.dob','constituency.Constituency')

  ->where([
    ['self_report.doc_id', '=',$doctor_id],  ])
    ->get();

    return view('doctor.selfhistory')->with('patients',$patients);
  }


  function DocDetails(){

    $uid = Auth::user()->id;
    $DocDetails = DB::table('facility_doctor')
    ->Join('doctors', 'facility_doctor.doctor_id', '=', 'doctors.id')
    ->Join('facilities', 'facility_doctor.facilitycode', '=', 'facilities.FacilityCode')
    ->where('facility_doctor.user_id', '=', Auth::user()->id)->get();
    return $DocDetails;
  }

  public function afyauselfreport($id){

    $patients = DB::table('self_report')
    ->Join('afya_users', 'self_report.afyauser_id', '=', 'afya_users.id')
    ->leftJoin('self_report_target', 'afya_users.id', '=', 'self_report_target.afyauser_id')
    ->select('self_report.*','self_report.created_at as srpdate','afya_users.id as afyaId',
    'afya_users.firstname','afya_users.secondName','afya_users.gender','afya_users.dob')
    ->where([   ['self_report.id', '=',$id], ])
    ->first();

    $patientstarget = DB::table('self_report')
    ->Join('afya_users', 'self_report.afyauser_id', '=', 'afya_users.id')
    ->Join('self_report_target', 'afya_users.id', '=', 'self_report_target.afyauser_id')
    ->select('self_report_target.temperature as temptrgt','self_report_target.weight as weighttrgt',
    'self_report_target.bp as bptrgt','self_report_target.fasting_sugars as fstrgt',
    'self_report_target.before_meal_sugars as bmstrgt','self_report_target.postprondrial_sugars as ppstrgt')
    ->where([   ['self_report.id', '=',$id],['self_report_target.dependents', '=','Self'], ])
    ->first();
    $ptHafya = DB::table('self_report')->select('afyauser_id')->where('self_report.id', '=',$id)->first();
    $patH = DB::table('self_report')
    ->select('self_report.*')
    ->where([['self_report.afyauser_id', '=',$ptHafya->afyauser_id],['dependents', '=','Self'],])
    ->get();

    DB::table('self_report')->where('id',$id)->update(
      ['status' => 1,
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
    );
    return view('doctor.selfReporting2')->with('patients',$patients)->with('patH',$patH)->with('patientstarget',$patientstarget);

  }

  function depselfreport($id){

    $patients = DB::table('self_report')
    ->Join('dependant', 'self_report.dependents', '=', 'dependant.id')
    ->select('dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
    'dependant.dob as Infdob','self_report.*','self_report.created_at as srpdate')
    ->where('self_report.id', '=',$id)
    ->first();

    $patH = DB::table('self_report')->select('self_report.*')
    ->where('self_report.id', '=',$id)
    ->get();

    DB::table('self_report')->where('id',$id)->update(
      ['status' => 1, 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);

    return view('doctor.selfReportingdep')->with('patients',$patients)->with('patH',$patH);
  }

  public function followup()
  {
    $today = Carbon::today();
    $facilitycode=DB::table('facility_doctor')->where('user_id', Auth::user()->id)->first();
    $patients = DB::table('appointments as app')
    ->Join('afya_users as par', 'app.afya_user_id', '=', 'par.id')
    ->leftjoin('dependant as dep','app.persontreated','=','dep.id')
    ->select('par.id as parid','par.firstname as first','par.secondName as second','par.gender as gender','par.dob as dob','dep.id as depid','dep.firstName as dfirst','dep.secondName as dsecond','dep.dob as ddob',
    'dep.gender as dgender','app.id as appid','app.created_at as created_at','app.persontreated as persontreated','app.last_app_id')
    ->where('app.status','=',2)
    ->where('app.status','!=',0)
    ->where('app.created_at','>=',$today)
    ->where('app.facility_id',$facilitycode->facilitycode)
    ->get();
    return view('doctor.followup')->with('patients',$patients);
  }

  public function selftargetafyauser(Request $request)

  {
    $temp=$request->temp;
    $bp=$request->bp;
    $weight=$request->weight;
    $fasting=$request->fasting;
    $beforemeal=$request->beforemeal;
    $postprondrial=$request->postprondrial;
    $afya_user_id=$request->afya_user_id;

    DB::table('self_report_target')->insert([
      'afyauser_id'=>$afya_user_id,
      'dependents'=>'Self',
      'temperature'=>$temp,
      'weight'=>$weight,
      'bp'=>$bp,
      'fasting_sugars'=>$fasting,
      'before_meal_sugars'=>$beforemeal,
      'postprondrial_sugars'=>$postprondrial,

      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);

      return redirect()->action('DoctorController@afyauselfreport', [$afya_user_id]);
    }
    public function selftargetupdt(Request $request){
      $temp=$request->temps;
      $bp=$request->bps;
      $weight=$request->weights;
      $fasting=$request->fastings;
      $beforemeal=$request->beforemeals;
      $postprondrial=$request->postprondrials;
      $afya_user_id=$request->afya_user_id;


      DB::table('self_report_target')->where('afyauser_id',$afya_user_id)->update([
        'afyauser_id'=>$afya_user_id,
        'dependents'=>'Self',
        'temperature'=>$temp,
        'weight'=>$weight,
        'bp'=>$bp,
        'fasting_sugars'=>$fasting,
        'before_meal_sugars'=>$beforemeal,
        'postprondrial_sugars'=>$postprondrial,
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
      ]);
      return redirect()->action('DoctorController@afyauselfreport', [$afya_user_id]);
    }


    public function changePassword()
    {
      return view('doctor.change_password');
    }

    public function newPassword(Request $request)
    {
      $id = Auth::id();
      $input = $request->all();
      $user = User::find(auth()->user()->id);

      $validator = Validator::make($request->all(), [
        'new_password'=>'min:6',
        'confirm_password'=>'same:new_password',
      ]);

      $validator->after(function($validator) use($input,$user) {
        if(!Hash::check($input['current_password'], $user->password))
        {
          $validator->errors()->add('current_password', 'current password is incorrect');
        }
      });

      if ($validator->fails())
      {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      else
      {
        $this->validate($request,[
          'new_password'=>'min:6',
          'confirm_password'=>'same:new_password',
        ]);

        DB::table('users')->where('id', '=', $id)->update(['password' => bcrypt($input['new_password']),'updated_at' => Carbon::now()]);

        $new_message = 'Password changed successfully';
        return view('doctor.change_password')->with('new_message',$new_message);
      }
    }

    public function visitDetails($id)
    {
      $data['ptdetails']= DB::table('triage_details')->where('appointment_id',$id)->first();
      $data['user'] = DB::table('appointments')
      ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
      ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
      ->select('afya_users.id as afyaId','afya_users.firstname','afya_users.secondName','afya_users.dob','afya_users.gender','appointments.persontreated',
      'dependant.firstName as name1','dependant.secondName as name2','dependant.dob as depdob','dependant.gender as depgender','appointments.id as appid')
      ->where('appointments.id', '=',$id)->first();

      $data['tstdone'] = DB::table('appointments')
      ->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
      ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('facilities.FacilityName','doctors.name as docname','patient_test.created_at',
      'patient_test.test_status','patient_test.id as ptid')
      ->where('appointments.id', '=',$id)
      ->orderBy('created_at', 'desc')
      ->get();


      $data['tsts'] = DB::table('appointments')

      ->leftJoin('patient_test', 'patient_test.appointment_id', '=', 'appointments.id')
      ->leftJoin('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
      ->leftJoin('icd10_option', 'patient_test_details.conditional_diag_id', '=', 'icd10_option.id')
      ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
      ->leftJoin('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
      ->leftJoin('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
      ->select('tests.name as tname','test_subcategories.name as tsname','icd10_option.name as dname','patient_test_details.created_at as date',
      'patient_test_details.id as patTdid','test_categories.name as tcname','patient_test_details.done',
      'patient_test_details.tests_reccommended','appointments.id as AppId')
      ->where('appointments.id', '=',$id)
      ->get();

      $data['rady'] = DB::table('patient_test')
      ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
      ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
      ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
      ->select('radiology_test_details.created_at as date','radiology_test_details.test',
      'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
      'radiology_test_details.id as patTdid','test_categories.name as tcname')
      ->where('appointments.id', '=',$id)
      ->get();



      $data['prescriptions'] =DB::table('prescriptions')
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
      ->where('prescriptions.appointment_id',$id)
      ->get();

      $data['diagnosis'] = DB::table('appointments')
      ->Join('patient_diagnosis', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
      ->Join('icd10_option', 'patient_diagnosis.disease_id', '=', 'icd10_option.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('icd10_option.name','patient_diagnosis.date_diagnosed','facilities.FacilityName')
      ->where('appointments.id', '=',$id)
      ->orderBy('appointments.id', 'desc')
      ->get();

      $data['procedures'] = DB::table('appointments')
      ->Join('patient_procedure', 'appointments.id', '=', 'patient_procedure.appointment_id')
      ->Join('procedures', 'patient_procedure.procedure_id', '=', 'procedures.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('procedures.description','patient_procedure.procedure_date','patient_procedure.notes','facilities.FacilityName')
      ->where('appointments.id', '=',$id)
      ->orderBy('appointments.id', 'desc')
      ->get();

      return view('doctor.visit_details',$data);
    }

    public function medica_report($id)
    {
      $data['ptdetails']= DB::table('triage_details')->where('appointment_id',$id)->first();

      $user = DB::table('appointments')
      ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
      ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->select('afya_users.id as afyaId','afya_users.firstname','afya_users.secondName','afya_users.dob','afya_users.gender','afya_users.occupation',
      'afya_users.age','appointments.persontreated','appointments.id as appid','afya_users.id as afyaId','patient_admitted.condition')
      ->where('appointments.id', '=',$id)->first();


      $data['summary'] = DB::table('patient_summary')->select('notes')->where('appointment_id', '=',$id)->first();
      $data['cmeds'] = DB::table('current_medication')->select('drugs')->where('appointment_id', '=',$id)->get();
      $data['mcds'] = DB::table('self_reported_medical_history')->select('name','status')->where('afya_user_id', '=',$user->afyaId)->get();
      $data['allergies'] = DB::table('afya_users_allergy')->select('allergies','status')->where('afya_user_id', '=',$user->afyaId)->get();
      $data['systemic'] = DB::table('patient_systemic')->Join('systematic', 'patient_systemic.systemic_id', '=', 'systematic.id')
      ->select('systematic.name','patient_systemic.description')->where('appointment_id', '=',$id)->get();

      $data['ge'] = DB::table('general_examination')->where('appointment_id', '=',$id)->first();

      $data['tsts'] = DB::table('appointments')
      ->Join('patient_test', 'patient_test.appointment_id', '=', 'appointments.id')
      ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
      ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
      ->leftJoin('test_results', 'patient_test_details.id', '=', 'test_results.id')
      ->select('tests.name as tname','test_results.value','patient_test_details.id as ptdid')
      ->where([['appointments.id', '=',$id],['patient_test_details.deleted', '=',0]])
      ->get();

      $data['tstsshw'] = DB::table('appointments')
      ->Join('patient_test', 'patient_test.appointment_id', '=', 'appointments.id')
      ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
      ->select('patient_test_details.tests_reccommended')
      ->where([['appointments.id', '=',$id],['patient_test_details.deleted', '=',0]])
      ->first();

      $data['rady'] = DB::table('patient_test')
      ->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
      ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
      ->select('radiology_test_details.created_at as date','radiology_test_details.test',
      'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
      'radiology_test_details.id as patTdid','test_categories.name as tcname')
      ->where([['radiology_test_details.appointment_id', '=',$id],['radiology_test_details.deleted', '=',0]])
      ->get();

      $data['radyshw'] = DB::table('patient_test')
      ->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
      ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
      ->select('radiology_test_details.test')
      ->where([['radiology_test_details.appointment_id', '=',$id],['radiology_test_details.deleted', '=',0]])
      ->first();

      $data['prescriptions'] =DB::table('prescriptions')
      ->join('prescription_details','prescriptions.id','=','prescription_details.presc_id')
      ->select('prescription_details.drug_id')
      ->where([['prescriptions.appointment_id',$id],['prescription_details.deleted',0],])
      ->get();

      $data['reccomendations'] =DB::table('patient_recommendation')->select('notes')
      ->where('appointment_id',$id)->get();

      $data['Referral'] =DB::table('patient_transfer')->select('facility_to','doc_to','note')
      ->where('appointment_id',$id)->first();

      $data['diagnosis'] = DB::table('patient_diagnosis')
      ->select('disease_id')
      ->where('appointment_id', '=',$id)
      ->orderBy('appointment_id', 'desc')
      ->get();

$data['prevdiagnosis'] = DB::table('patient_diagnosis')
->select('disease_id')
->where('afya_user_id', '=',$user->afyaId)
->where('appointment_id', '<>',$id)
->orderBy('appointment_id', 'desc')
->get();
      $data['procedures'] = DB::table('appointments')
      ->Join('patient_procedure_details', 'appointments.id', '=', 'patient_procedure_details.appointment_id')
      ->Join('procedures', 'patient_procedure_details.procedure_id', '=', 'procedures.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('procedures.name','patient_procedure_details.updated_at as procedure_date',
      'patient_procedure_details.results','facilities.FacilityName')
      ->where([['appointments.id', '=',$id],['patient_procedure_details.deleted', '=',0]])
      ->orderBy('appointments.id', 'desc')
      ->get();

      $data['cardiac'] = DB::table('appointments')
      ->Join('patient_test_details_c', 'appointments.id', '=', 'patient_test_details_c.appointment_id')
      ->Join('tests_cardiac', 'patient_test_details_c.tests_reccommended', '=', 'tests_cardiac.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('tests_cardiac.name','patient_test_details_c.updated_at as procedure_date',
      'patient_test_details_c.results','facilities.FacilityName')
      ->where([['appointments.id', '=',$id],['patient_test_details_c.deleted', '=',0]])
      ->orderBy('appointments.id', 'desc')
      ->get();

      $data['neurology'] = DB::table('appointments')
      ->Join('patient_test_details_n', 'appointments.id', '=', 'patient_test_details_n.appointment_id')
      ->Join('tests_neurology', 'patient_test_details_n.tests_reccommended', '=', 'tests_neurology.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('tests_neurology.name','patient_test_details_n.updated_at as procedure_date',
      'patient_test_details_n.results','facilities.FacilityName')
      ->where([['appointments.id', '=',$id],['patient_test_details_n.deleted', '=',0]])
      ->orderBy('appointments.id', 'desc')
      ->get();

      $data['doct']= DB::table('appointments')
      ->leftJoin('doctors', 'appointments.doc_id', '=', 'doctors.id')
      ->leftJoin('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('doctors.name','facilities.FacilityName','appointments.created_at','appointments.updated_at')
      ->where('appointments.id', '=',$id)
      ->first();
      $data['fsummary'] = DB::table('family_summary')->where([['afya_user_id',$user->afyaId],['family_members',"Father"]])->first();
      $data['msummary'] = DB::table('family_summary')->where([['afya_user_id',$user->afyaId],['family_members',"Mother"]])->first();
      $data['bsummary'] = DB::table('family_summary')->where([['afya_user_id',$user->afyaId],['family_members',"Brother"]])->first();
      $data['ssummary'] = DB::table('family_summary')->where([['afya_user_id',$user->afyaId],['family_members',"Sister"]])->first();
      $data['family_planning'] = DB::table('family_planning')->where([['afya_user_id',$user->afyaId]])->first();
      $data['smoking'] = DB::table('smoking_history')->where([['afya_user_id',$user->afyaId]])->first();
      $data['alcohol'] = DB::table('alcohol_drug_history')->where([['afya_user_id',$user->afyaId]])->first();
      $data['cur_app'] = DB::table('appointments')->where([['afya_user_id',$user->afyaId]])
      ->select('id')->orderBy('id','Desc')->first();


      return view('doctor.medica_report',$data)->with('user',$user);
    }

    public function medica_report2($id)
    {
      $data['ptdetails']= DB::table('triage_details')->where('appointment_id',$id)->first();

      $user = DB::table('appointments')
      ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
      ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->select('afya_users.id as afyaId','afya_users.firstname','afya_users.secondName','afya_users.dob','afya_users.gender','afya_users.occupation',
      'afya_users.age','appointments.persontreated','appointments.id as appid','afya_users.id as afyaId','patient_admitted.condition')
      ->where('appointments.id', '=',$id)->first();


      $data['summary'] = DB::table('patient_summary')->select('notes')->where('appointment_id', '=',$id)->first();
      $data['cmeds'] = DB::table('current_medication')->select('drugs')->where('appointment_id', '=',$id)->get();
      $data['mcds'] = DB::table('self_reported_medical_history')->select('name','status')->where('afya_user_id', '=',$user->afyaId)->get();
      $data['allergies'] = DB::table('afya_users_allergy')->select('allergies','status')->where('afya_user_id', '=',$user->afyaId)->get();
      $data['systemic'] = DB::table('patient_systemic')->Join('systematic', 'patient_systemic.systemic_id', '=', 'systematic.id')
      ->select('systematic.name','patient_systemic.description')->where('appointment_id', '=',$id)->get();
      $data['fsummary'] = DB::table('family_summary')->where([['afya_user_id',$user->afyaId],['family_members',"Father"]])->first();
      $data['msummary'] = DB::table('family_summary')->where([['afya_user_id',$user->afyaId],['family_members',"Mother"]])->first();
      $data['bsummary'] = DB::table('family_summary')->where([['afya_user_id',$user->afyaId],['family_members',"Brother"]])->first();
      $data['ssummary'] = DB::table('family_summary')->where([['afya_user_id',$user->afyaId],['family_members',"Sister"]])->first();

      $data['family_planning'] = DB::table('family_planning')->where([['afya_user_id',$user->afyaId]])->first();



      $data['ge'] = DB::table('general_examination')->where('appointment_id', '=',$id)->first();

      $data['tsts'] = DB::table('appointments')
      ->Join('patient_test', 'patient_test.appointment_id', '=', 'appointments.id')
      ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
      ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
      ->leftJoin('test_results', 'patient_test_details.id', '=', 'test_results.id')
      ->select('tests.name as tname','test_results.value','patient_test_details.id as ptdid')
      ->where('appointments.id', '=',$id)
      ->get();

      $data['tstsshw'] = DB::table('appointments')
      ->Join('patient_test', 'patient_test.appointment_id', '=', 'appointments.id')
      ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
      ->select('patient_test_details.tests_reccommended')
      ->where('appointments.id', '=',$id)
      ->first();

      $data['rady'] = DB::table('patient_test')
      ->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
      ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
      ->select('radiology_test_details.created_at as date','radiology_test_details.test',
      'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
      'radiology_test_details.id as patTdid','test_categories.name as tcname')
      ->where('patient_test.appointment_id', '=',$id)
      ->get();
      $data['radyshw'] = DB::table('patient_test')
      ->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
      ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
      ->select('radiology_test_details.test')
      ->where('patient_test.appointment_id', '=',$id)
      ->first();


      $data['prescriptions'] =DB::table('prescriptions')
      ->join('prescription_details','prescriptions.id','=','prescription_details.presc_id')
      ->select('prescription_details.drug_id')
      ->where([['prescriptions.appointment_id',$id],['prescription_details.deleted',0],])
      ->get();
      $data['reccomendations'] =DB::table('patient_recommendation')->select('notes')
      ->where('appointment_id',$id)->get();

      $data['Referral'] =DB::table('patient_transfer')->select('facility_to','doc_to','note')
      ->where('appointment_id',$id)->first();

      $data['diagnosis'] = DB::table('patient_diagnosis')
      ->select('disease_id')
      ->where('appointment_id', '=',$id)
      ->orderBy('appointment_id', 'desc')
      ->get();

      $data['procedures'] = DB::table('appointments')
      ->Join('patient_procedure', 'appointments.id', '=', 'patient_procedure.appointment_id')
      ->Join('procedures', 'patient_procedure.procedure_id', '=', 'procedures.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('procedures.description','patient_procedure.procedure_date','patient_procedure.notes','facilities.FacilityName')
      ->where('appointments.id', '=',$id)
      ->orderBy('appointments.id', 'desc')
      ->get();

      $data['doct']= DB::table('appointments')
      ->leftJoin('doctors', 'appointments.doc_id', '=', 'doctors.id')
      ->leftJoin('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('doctors.name','facilities.FacilityName','appointments.created_at','appointments.updated_at')
      ->where('appointments.id', '=',$id)
      ->first();

      return view('doctor.medica_report2',$data)->with('user',$user);
    }

    public function slideshow($id)
    {
      $data['appointments'] = DB::table('appointments')
      ->select('id','created_at','updated_at')->where('afya_user_id', '=',$id)
      ->orderBy('id','Desc')->get();

      $data['appoint'] = DB::table('appointments')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->select('appointments.id','appointments.afya_user_id','patient_admitted.condition')
      ->orderBy('appointments.id','Desc')
      ->where('afya_user_id', '=',$id)->first();

      return view('doctor.slideshow',$data);
    }

    public function slideshow2($id)
    {
      $data['appointments'] = DB::table('appointments')
      ->select('id','created_at','updated_at')->where('afya_user_id', '=',$id)->orderBy('id','Desc')->get();
      $data['appoint'] = DB::table('appointments')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->select('appointments.id','appointments.afya_user_id','patient_admitted.condition')
      ->orderBy('appointments.id','Desc')
      ->where('afya_user_id', '=',$id)->first();

      return view('doctor.slideshow2',$data);
    }

    public function edithistory($id)
    {
      $data['ptdetails']= DB::table('triage_details')->where('appointment_id',$id)->first();

      $data['user'] = DB::table('appointments')
      ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
      ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->select('afya_users.firstname','afya_users.secondName','afya_users.dob','afya_users.gender','afya_users.occupation',
      'afya_users.age','appointments.persontreated','appointments.id as appid','afya_users.id as afyaId','patient_admitted.condition')
      ->where('appointments.id', '=',$id)->first();

      $data['ge'] = DB::table('general_examination')->where('appointment_id', '=',$id)->first();
      $data['impression'] = DB::table('impression')->where('appointment_id', '=',$id)->get();
      $data['psummary'] = DB::table('patient_summary')->where('appointment_id',$id)->first();
      $data['cmed'] = DB::table('current_medication')->where('appointment_id',$id)->get();

      $data['diagnosis'] = DB::table('patient_diagnosis')
      ->select('disease_id','id')
      ->where('appointment_id', '=',$id)
      ->orderBy('appointment_id', 'desc')
      ->get();

      return view('doctor.edithistory',$data);
    }
    public function edithistory2($id)
    {
      $data['ptdetails']= DB::table('triage_details')->where('appointment_id',$id)->first();

      $data['user'] = DB::table('appointments')
      ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
      ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->select('afya_users.firstname','afya_users.secondName','afya_users.dob','afya_users.gender','afya_users.occupation',
      'afya_users.age','appointments.persontreated','appointments.id as appid','afya_users.id as afyaId','patient_admitted.condition')
      ->where('appointments.id', '=',$id)->first();

      $data['impression'] = DB::table('impression')->where('appointment_id', '=',$id)->get();
      $data['psummary'] = DB::table('patient_summary')->where('appointment_id',$id)->first();
      $data['cmed'] = DB::table('current_medication')->where('appointment_id',$id)->get();
      $data['diagnosis'] = DB::table('patient_diagnosis')
      ->select('disease_id','id')->where('appointment_id', '=',$id)
      ->orderBy('appointment_id', 'desc')->get();

      return view('doctor.edithistory2',$data);
    }

    public function  imp_delete($impid,$appid){
      $res=DB::table('impression')->where('id',$impid)->delete();
      return redirect()->action('DoctorController@edithistory', [$appid]);
    }

    public function  diag_delete($diagid,$appid){
      $res=DB::table('patient_diagnosis')->where('id',$diagid)->delete();
      return redirect()->action('DoctorController@edithistory', [$appid]);
    }

    public function  cm_delete($cmid,$appid){
      $res=DB::table('current_medication')->where('id',$cmid)->delete();
      return redirect()->action('DoctorController@edithistory', [$appid]);
    }



    public function  imp2_delete($impid,$appid){
      $res=DB::table('impression')->where('id',$impid)->delete();
      return redirect()->action('DoctorController@edithistory2', [$appid]);
    }

    public function  diag2_delete($diagid,$appid){
      $res=DB::table('patient_diagnosis')->where('id',$diagid)->delete();
      return redirect()->action('DoctorController@edithistory2', [$appid]);
    }

    public function  cm2_delete($cmid,$appid){
      $res=DB::table('current_medication')->where('id',$cmid)->delete();
      return redirect()->action('DoctorController@edithistory2', [$appid]);
    }

  }
