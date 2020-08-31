<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;

use App\Http\Requests;
use DB;
use Auth;
use Carbon\Carbon;
use App\County;
use PDF;
use App\Payment;
use App\User;
use App\Afya_user;


class RegistrarController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = date('Y-m-d');
        $facility = DB::table('facility_registrar')
                       ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
                       ->select('facility_registrar.facilitycode','facilities.set_up','facilities.FacilityName','facilities.Type')
                       ->where('facility_registrar.user_id', Auth::user()->id)
                       ->first();
        $facilitycode = $facility->facilitycode;
        $setup = $facility->set_up;


        $users = DB::table('afya_users')
              ->join('afyamessages','afya_users.msisdn','=','afyamessages.msisdn')
              ->leftjoin('constituency','afya_users.constituency','=','constituency.id')
              ->leftJoin('county', 'county.id', '=', 'constituency.cont_id')
              ->select('afya_users.*','afyamessages.created_at as created_at','constituency.Constituency','constituency.cont_id',
              'county.county')
              ->where('afyamessages.facilityCode',$facilitycode)
              ->whereDate('afyamessages.created_at','=',$today)
              ->whereNull('afyamessages.status')
              ->distinct()
              ->get();

              $data['usersappointment'] = DB::table('appointments')
                    ->Join('afya_users','appointments.afya_user_id','=','afya_users.id')
                    ->leftjoin('constituency','afya_users.constituency','=','constituency.id')
                    ->leftJoin('county', 'county.id', '=', 'constituency.cont_id')
                    ->select('afya_users.*','appointments.id as appid','appointments.appointment_time','appointments.appointment_date','constituency.Constituency',
                    'county.county')
                    ->where([['appointments.facility_id',$facilitycode],['appointments.status',0]])
                    ->whereDate('appointments.appointment_date','=',$today)
                    ->distinct()
                    ->get();

        return view('registrar.private.index',$data)->with('users',$users)->with('facility',$facility)->with('setup',$setup);
    }
    public function  showUser($id){
$user = DB::table('afya_users')
        ->select('afya_users.*')->where('afya_users.id',$id)
        ->first();

  $userid = Auth::id();
  $registrar = DB::table('facility_registrar')
            ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
            ->select('facilities.FacilityName','facilities.FacilityCode')
            ->where('facility_registrar.user_id',$userid )
            ->first();
  $data['cnst'] = DB::table('consultation_fees')
        ->select('old_consultation_fee', 'new_consultation_fee')
        ->where('facility_code',$registrar->FacilityCode)
        ->first();
$data['insrnc'] = DB::table('afyauser_insurance')
->join('insurance_companies','afyauser_insurance.ins_co_id','=','insurance_companies.id')
->select('afyauser_insurance.policy_no', 'insurance_companies.company_name')
->where('afyauser_insurance.afya_user_id',$id)
->get();

return view('registrar.show',$data)->with('registrar',$registrar)->with('user',$user);

    }

    public function  conReg($id){
$user = DB::table('afya_users')
        ->select('afya_users.*')->where('afya_users.id',$id)
        ->first();
  $userid = Auth::id();
  $registrar = DB::table('facility_registrar')
            ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
            ->select('facilities.FacilityName','facilities.FacilityCode')
            ->where('facility_registrar.user_id',$userid )
            ->first();
  $cnst = DB::table('consultation_fees')
        ->select('old_consultation_fee', 'new_consultation_fee')->where('facility_code',$registrar->FacilityCode)->first();
return view('registrar.Reg_feespay')->with('cnst',$cnst)->with('registrar',$registrar)->with('user',$user);

    }

    public function  pconReg($id){
$data['user'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->select('afya_users.*','appointments.id as appid')->where('appointments.id',$id)
  ->first();

  $userid = Auth::id();
  $registrar = DB::table('facility_registrar')
            ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
            ->select('facilities.FacilityName','facilities.FacilityCode')
            ->where('facility_registrar.user_id',$userid )
            ->first();
  $data['cnst'] = DB::table('consultation_fees')
        ->select('old_consultation_fee', 'new_consultation_fee')->where('facility_code',$registrar->FacilityCode)->first();

return view('registrar.pReg_feespay',$data)->with('registrar',$registrar);
    }

    public function  medicalR($id){

  $data['user'] = DB::table('appointments')
  ->join('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->select('afya_users.*','appointments.id as appid')->where('appointments.id',$id)
  ->first();

   $userid = Auth::id();

  $registrar = DB::table('facility_registrar')
  ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
  ->select('facilities.FacilityName','facilities.FacilityCode')
  ->where('facility_registrar.user_id',$userid )
  ->first();

  $data['cnst'] = DB::table('consultation_fees')
        ->select('medical_report_fee')->where('facility_code',$registrar->FacilityCode)->first();

return view('registrar.medical_feespay',$data)->with('registrar',$registrar);
    }

    public function   getUser(Request $request){

      $id = $request->id;

      $user = DB::table('afya_users')->where('id',$id)->first();

      return view('registrar.show')->with('user',$user);
    }

    public function selectChoice($id){

      return view('registrar.select')->with('id',$id);
    }
    public function creapp($id){
$user=DB::table('afya_users')->where('id',$id)->first();

      return view('registrar.creamp')->with('user',$user);
    }
    public function selectDependant($id)
    {
      return view('registrar.dependants')->with('id',$id);
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

                     $facility = DB::table('facility_registrar')
                                    ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
                                    ->select('facility_registrar.facilitycode','facilities.set_up','facilities.FacilityName','facilities.Type')
                                    ->where('facility_registrar.user_id', Auth::user()->id)
                                    ->first();

                     $facilitycode =$facility->facilitycode;
                     $data['patientsToday'] = DB::table('appointments')
                     ->join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                     ->select('afya_users.*')
                     ->where([['appointments.facility_id', $facilitycode],['appointments.status', '<>', 0]])
                     ->whereDate('appointments.created_at','=',$dat)
                     ->groupBy('appointments.afya_user_id')
                     ->get();

                     $data['patientswk'] = DB::table('appointments')
                     ->join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                     ->select('afya_users.*')
                     ->where([['appointments.facility_id', $facilitycode],['appointments.status', '<>', 0]])
                     ->whereDate('appointments.created_at','>=',$datws)
                     ->whereDate('appointments.created_at','<=',$datwe)
                     ->groupBy('appointments.afya_user_id')
                     ->get();

                     $data['patientmonth'] = DB::table('appointments')
                     ->join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                     ->select('afya_users.*')
                     ->where([['appointments.facility_id', $facilitycode],['appointments.status', '<>', 0]])
                     ->whereDate('appointments.created_at','>=',$datms)
                     ->whereDate('appointments.created_at','<=',$datme)
                     ->groupBy('appointments.afya_user_id')
                     ->get();

                     $data['users'] = DB::table('patient_facility')
                     ->join('afya_users', 'patient_facility.afya_user_id', '=', 'afya_users.id')
                     ->select('afya_users.*')
                     ->where('patient_facility.facility_id', $facilitycode)
                     ->get();
       return view('registrar.allpatients',$data)->with('facility',$facility);
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
      ]  );


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
return redirect()->action('RegistrarController@selectDependant', [$id]);


    }



   public function add_parent(Request $request)
    {
      $this->validate($request,[
        'first' => 'required',
        'second' => 'required',
        'phone' => 'required|regex:/^2547[0-9]{8}/',
        'gender' => 'required',
        'age' => 'date',
        'relationship' => 'required',
      ]);

      $first=$request->first;
      $second=$request->second;
      $gender=$request->gender;
      $age=$request->age;
      $phone=$request->phone;

      $user = DB::table('afya_users')
             ->where('firstname','=',$first)
             ->where('age','=',$age)
             ->where('msisdn','=',$phone)
             ->first();

        if(is_null($user)){

           $id= DB::table('afya_users')->insertGetId([
            'msisdn' => $phone,
            'firstname'=>$first,
            'secondName' => $second,
            'gender'=> $gender,
            'dob'=> $age,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);

        }else{

          $id=$user->id;
        }

            DB::table('dependant_parent')->insert(
            ['relationship'=>$request->relationship,
            'dependant_id'=>$request->dep_id,
            'afya_user_id'=>$id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);

       return redirect('registrar.showdependants/'.$request->user_id);

    }

    public function add_parent2(Request $request)
     {
       $this->validate($request,[
         'first' => 'required',
         'second' => 'required',
         'phone' => 'required|regex:/^2547[0-9]{8}/',
         'gender' => 'required',
         'age' => 'date',
         'relationship' => 'required',
       ]);

       $first=$request->first;
       $second=$request->second;
       $gender=$request->gender;
       $age=$request->age;
       $phone=$request->phone;

       $user=DB::table('afya_users')->where('firstname','=',$first)
                                    ->where('age','=',$age)
                                    ->where('msisdn','=',$phone)
                                    ->first();

         if(is_null($user)){

            $id= DB::table('afya_users')->insertGetId([
             'msisdn' => $phone,
             'firstname'=>$first,
             'secondName' => $second,
             'gender'=> $gender,
             'dob'=> $age,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);

         }else{

           $id=$user->id;
         }

             DB::table('dependant_parent')->insert(
             ['relationship'=>$request->relationship,
             'dependant_id'=>$request->dep_id,
             'afya_user_id'=>$id,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
             ]);

        return redirect('registrar.dependants/'.$request->user_id);

     }


public function addDependents($id){
  return view('registrar.addDependents')->with('id',$id);
}

public function dependantTriage($id){
  $user=DB::table('dependant')
  ->join('dependant_parent','dependant_parent.dependant_id','=','dependant.id')
  ->select('dependant_parent.afya_user_id')
  ->where('dependant.id',$id)
  ->first();
  return view('registrar.dependantTriage')->with('id',$id)->with('user',$user);
}




    public function consultationFee($id){

      return view('registrar.consultationfee',[$id])->with('id',$id);
    }

    public function consultationFees(Request $request){

      $appointment = $request->appointment;
      $id = $request->afya_user_id;
      $facility = $request->facility;
      $choice = $request->choice;
      $account1 = $request->account1;
      $account2 = $request->account2;
      $account3 = $request->account3;

      $insurer = '';
      $policy = '';

      $amount2 = $request->amount2;
      $amount3 = $request->amount3;
      $amount4 = $request->amount4;


      $mpesa1 = $request->transaction_no1;
      $mpesa2 = $request->transaction_no2;
      $mpesa3 = $request->transaction_no3;


      if(isset($mpesa1) && !empty($mpesa1))
      {
        $mpesa = $mpesa1;
      }
      elseif(isset($mpesa2) && !empty($mpesa2))
      {
        $mpesa = $mpesa2;
      }
      elseif(isset($mpesa3) && !empty($mpesa3))
      {
        $mpesa = $mpesa3;
      }
      else
      {
        $mpesa = NULL;
      }


$doc=$request->doc;



      $cat=DB::table('payments_categories')
      ->select('id')
      ->where('category_name','Consultation fee')
      ->first();
      $cat_id = $cat->id;
      $today = date('Y-m-d');
  if($choice == 'free')
  {
    $amount  = 'None';
    $account='None';
  }
  elseif ($choice == 'normal')
  {
    $amount  = $amount2;
    $account= $account1;
  }
  elseif ($choice == 'old')
  {
    $amount  = $amount4;
    $account= $account3;
  }
  elseif ($choice == 'discount')
  {
    $amount  = $amount3;
    $account= $account2;
  }
  else
  {
    $amount = NULL;
    $payment_mode = NULL;
  }


  DB::table('appointments')
  ->where('id',$appointment)
  ->update([
    'status'=>1,
    'facility_id'=>$facility,
    'persontreated'=>'Self',
    'doc_id'=>$doc,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
//Then insert payments which is nill
                  DB::table('payments')->insert([
                  'payments_category_id'=>$cat_id,
                  'appointment_id'=>$appointment,
                  'paid_app_id'=>$appointment,
                  'amount'=> $amount,
                  'mode'=> $account,
                  'status' => 1,
                  'facility' => $facility,
                  'transaction_no' => $mpesa,
                  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);


       $phone = DB::Table('afya_users')->where('id',$id)->select('msisdn')
             ->first();
if($phone){
             //Get afyamessage id
             $message_id = DB::table('appointments')
                         ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
                         ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
                         ->select('afyamessages.id')
                         ->where('appointments.id', '=', $appointment)
                         ->where('afyamessages.msisdn',$phone->msisdn)
                         ->whereDate('afyamessages.created_at','=',$today)
                         ->first();

          if(! is_null($message_id))
         {
             DB::table('afyamessages')
             ->where('id',$message_id->id)
             ->update([
             'status' => 1,
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
             ]);
           }
}

$afya_user = DB::table('appointments')->select('afya_user_id')->where('appointments.id', '=', $appointment)->first();
$afya_user = $afya_user->afya_user_id;

if(isset($request->insurance_company2) && isset($request->policy_no2))
{
  $insurer = $request->insurance_company2;
  $policy = $request->policy_no2;

  DB::table('afya_users')->where('id', '=', $afya_user)->update(['insurance_company_id' => $insurer, 'policy_no' => $policy, 'updated_at' => Carbon::now()]);
}
elseif(isset($request->insurance_company4) && isset($request->policy_no4))
{
  $insurer = $request->insurance_company4;
  $policy = $request->policy_no4;

  DB::table('afya_users')->where('id', '=', $afya_user)->update(['insurance_company_id' => $insurer, 'policy_no' => $policy, 'updated_at' => Carbon::now()]);
}
elseif(isset($request->insurance_company6) && isset($request->policy_no6))
{
  $insurer = $request->insurance_company6;
  $policy = $request->policy_no6;

  DB::table('afya_users')->where('id', '=', $afya_user)->update(['insurance_company_id' => $insurer, 'policy_no' => $policy, 'updated_at' => Carbon::now()]);
}


   return redirect()->action('privateController@showUserpay',['id'=> $appointment]);
}

public function medicalfeep(Request $request){
  $appointment_id =$request->appointment;
  $id=$request->afya_user_id;
  $facility=$request->facility;
  $choice=$request->choice;
  $amount2=$request->amount2;
  $amount3=$request->amount3;
  $amount4=$request->amount4;
  $account1 =$request->account1;
  $account2 =$request->account2;
  $account3 =$request->account3;

  $insurer = '';
  $policy = '';

  $mpesa1 = $request->transaction_no1;
  $mpesa2 = $request->transaction_no2;
  $mpesa3 = $request->transaction_no3;

  if(isset($mpesa1) && !empty($mpesa1))
  {
    $mpesa = $mpesa1;
  }
  elseif(isset($mpesa2) && !empty($mpesa2))
  {
    $mpesa = $mpesa2;
  }
  elseif(isset($mpesa3) && !empty($mpesa3))
  {
    $mpesa = $mpesa3;
  }
  else
  {
    $mpesa = NULL;
  }

$cat_id =4;
  $today = date('Y-m-d');

  if($choice == 'free')
  {
    $amount  = 'None';
    $account='None';

  }
  elseif ($choice == 'normal')
  {
  $amount  = $amount2;
  $account= $account1;
  }
  elseif ($choice == 'old')
  {
  $amount  = $amount4;
  $account= $account3;
  }
  elseif ($choice == 'discount')
  {
  $amount  = $amount3;
  $account= $account2;
  }
  else
  {
    $amount = NULL;
    $payment_mode = NULL;
  }

//Then insert payments which is nill
              DB::table('payments')->insert([
              'payments_category_id'=>$cat_id,
              'appointment_id'=>$appointment_id,
              'paid_app_id'=>$appointment_id,
              'amount'=> $amount,
              'facility'=>$facility,
              'status'=>1,
              'mode'=> $account,
              'transaction_no' => $mpesa,
              'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
              'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);

    DB::table('appointments')->where('id', $appointment_id)
    ->update(['status' => 1,]);

$afya_user = DB::table('appointments')->select('afya_user_id')->where('appointments.id', '=', $appointment_id)->first();
$afya_user = $afya_user->afya_user_id;

if(isset($request->insurance_company2) && isset($request->policy_no2))
{
  $insurer = $request->insurance_company2;
  $policy = $request->policy_no2;

  DB::table('afya_users')->where('id', '=', $afya_user)->update(['insurance_company_id' => $insurer, 'policy_no' => $policy, 'updated_at' => Carbon::now()]);
}
elseif(isset($request->insurance_company4) && isset($request->policy_no4))
{
  $insurer = $request->insurance_company4;
  $policy = $request->policy_no4;

  DB::table('afya_users')->where('id', '=', $afya_user)->update(['insurance_company_id' => $insurer, 'policy_no' => $policy, 'updated_at' => Carbon::now()]);
}
elseif(isset($request->insurance_company6) && isset($request->policy_no6))
{
  $insurer = $request->insurance_company6;
  $policy = $request->policy_no6;

  DB::table('afya_users')->where('id', '=', $afya_user)->update(['insurance_company_id' => $insurer, 'policy_no' => $policy, 'updated_at' => Carbon::now()]);
}


return redirect()->action('privateController@showUserpay',['id'=> $appointment_id]);
}





 public function Dependentconsultationfee(Request $request)
 {
   $path;

  $facilitycode = DB::table('facility_registrar')
                ->where('user_id', Auth::user()->id)
                ->first();

  $today = date('Y-m-d');
  $id=$request->id;
  $type=$request->type;
  $afyauser=$request->afya_user;
//$mode=$request->mode;
  $amount=$request->amount;
  $user=$request->afya_user;
  $cat_id = $request->cat_id;

  $appointment_id ='';
  $today = date('Y-m-d');

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
      'facility_id'=>$facilitycode->facilitycode,
      'afya_user_id'=>$user,
      'status'=>1,
      'persontreated'=>$id,
      'visit_type'=>$visit_type,
      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
     'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
      ]);

      DB::table('payments')->insert([
      'payments_category_id'=>$cat_id,
      'appointment_id'=>$appointment_id,
      'paid_app_id'=>$appointment_id,
      'amount'=> $amount,
      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);

    }

      elseif($path == 'triage')
      {
        $appointment_id = DB::table('appointments')->insertGetId([
        'facility_id'=>$facilitycode->facilitycode,
        'afya_user_id'=>$user,
        'status'=>1,
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
       'paid_app_id'=>$appointment_id,
       'amount'=> $amount,
       'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
       'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
     ]);

    }
    elseif($path == 'no_triage')
    {
      $appointment_id = DB::table('appointments')->insertGetId([
      'facility_id'=>$facilitycode->facilitycode,
      'afya_user_id'=>$user,
      'status'=>1,
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
      'paid_app_id'=>$appointment_id,
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
    'facility_id'=>$facilitycode->facilitycode,
    'afya_user_id'=>$user,
    'status'=>1,
    'persontreated'=>$id,
    'visit_type'=>$visit_type,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);


    DB::table('payments')->insert([
    'payments_category_id'=>$cat_id,
    'appointment_id'=>$appointment_id,
    'paid_app_id'=>$appointment_id,
    'amount'=> $amount,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);

  }



  $phone = DB::Table('afya_users')
        ->where('id',$user)
        ->select('msisdn')
        ->first();

        //Get afyamessage id
        $message_id = DB::table('appointments')
                    ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
                    ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
                    ->select('afyamessages.id')
                    ->where('appointments.id', '=', $appointment_id)
                    ->where('afyamessages.msisdn',$phone->msisdn)
                    ->whereDate('afyamessages.created_at','=',$today)
                    ->first();

        DB::table('afyamessages')
        ->where('id',$message_id->id)
        ->update([
        'status' => 1,
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);

   return redirect()->action('RegistrarController@index');

 }
 public function Fees(){

  $u_id = Auth::user()->id;
 $today = date('Y-m-d');
  $facility1=DB::table('facility_registrar')->where('user_id', $u_id)->first();
  $facility = $facility1->facilitycode;

  $data['patients'] = DB::table('appointments')
                   ->join('afya_users', 'appointments.afya_user_id', '=','afya_users.id' )
                   ->select('appointments.id','appointments.created_at','afya_users.msisdn','afya_users.firstname',
                   'afya_users.secondName','afya_users.gender','afya_users.nationalId')
                   ->where([['appointments.facility_id', '=', $facility],])
                   ->whereNotIn('appointments.id',function ($query){
                     $query->select('appointment_id')
                     ->from('payments')
                     ->where([['payments_category_id', '=', 1],]);

                   })
                   ->get();

       $data['labtest'] = DB::table('patient_test_details')
                 ->join('patient_test', 'patient_test_details.patient_test_id', '=','patient_test.id' )
                 ->join('appointments', 'patient_test.appointment_id', '=','appointments.id' )
                 ->leftJoin('test_price', 'patient_test_details.tests_reccommended', '=', 'test_price.tests_id')
                 ->join('afya_users', 'appointments.afya_user_id', '=','afya_users.id' )
                  ->select('appointments.id','appointments.created_at','afya_users.msisdn','afya_users.firstname',
                 'afya_users.secondName','afya_users.gender','afya_users.nationalId','patient_test_details.id as patTdid')
                 ->where([['appointments.facility_id', '=', $facility],['patient_test_details.deleted', '=', 0],])


       ->whereNotIn('patient_test_details.id', function($query) {
              $query->select('lab_id')
              ->from('payments')
              ->where([['payments_category_id', '=', 2]]);
      })
      ->groupBy('appointments.id')
      ->get();



    $data['rady'] = DB::table('radiology_test_details')
        ->Join('patient_test', 'radiology_test_details.patient_test_id', '=', 'patient_test.id')
      ->join('appointments', 'radiology_test_details.appointment_id', '=','appointments.id' )
      ->join('afya_users', 'appointments.afya_user_id', '=','afya_users.id' )
        ->select('afya_users.*','afya_users.firstname','radiology_test_details.test','radiology_test_details.test_cat_id',
        'radiology_test_details.id as patTdid','appointments.id as appid')
         ->where([['appointments.facility_id', '=',$facility],['radiology_test_details.deleted', '=',0],])

         ->whereNotIn('radiology_test_details.id', function($query) {
                $query->select('payments.imaging_id')
                ->from('payments')
                ->where([['payments_category_id', '=', 3],]);
        })->groupBy('appointments.id')
        ->get();



return view('registrar.private.fees',$data);

 }

 public function payConsultation(Request $request)
 {
   $appointment_id =$request->appointment_id;
   $choice = $request->choice;
   $amount = '';
   $payment_mode = '';
   $insurer = '';
   $policy = '';

   $mpesa1 = $request->transaction_no1;
   $mpesa2 = $request->transaction_no2;
   $mpesa3 = $request->transaction_no3;

   if(isset($mpesa1) && !empty($mpesa1))
   {
     $mpesa = $mpesa1;
   }
   elseif(isset($mpesa2) && !empty($mpesa2))
   {
     $mpesa = $mpesa2;
   }
   elseif(isset($mpesa3) && !empty($mpesa3))
   {
     $mpesa = $mpesa3;
   }
   else
   {
     $mpesa = NULL;
   }

   if($choice == 'free')
   {
     $amount = 'None';
     $payment_mode = 'None';
   }
   elseif($choice == 'normal')
   {
   $amount = $request->amount2;
   $payment_mode = $request->account1;
   }
   elseif($choice == 'old')
    {
      $amount = $request->amount4;
      $payment_mode = $request->account3;
    }
   elseif($choice == 'discount')
   {
     $amount = $request->amount3;
     $payment_mode = $request->account2;
   }
   else
   {
     $amount = NULL;
     $payment_mode = NULL;
   }


   $u_id = Auth::user()->id;
   $facility = DB::table('facility_registrar')->select('facilitycode')->where('user_id', $u_id)->first();

   DB::table('payments')
   ->insert([
     'payments_category_id' => 1,
     'appointment_id' => $appointment_id,
     'mode' => $payment_mode,
     'amount' => $amount,
     'status' => 1,
     'facility' =>$facility->facilitycode,
     'transaction_no' => $mpesa,
     'created_at' => Carbon::now(),
     'updated_at' => Carbon::now()
   ]);

   DB::table('appointments')->where('id', '=', $appointment_id)->update(['status' => 3,'updated_at' => Carbon::now()]);

   $afya_user = DB::table('appointments')->select('afya_user_id')->where('appointments.id', '=', $appointment_id)->first();
   $afya_user = $afya_user->afya_user_id;

   if(isset($request->insurance_company2) && isset($request->policy_no2))
   {
     $insurer = $request->insurance_company2;
     $policy = $request->policy_no2;

     DB::table('afya_users')->where('id', '=', $afya_user)->update(['insurance_company_id' => $insurer, 'policy_no' => $policy, 'updated_at' => Carbon::now()]);
   }
   elseif(isset($request->insurance_company4) && isset($request->policy_no4))
   {
     $insurer = $request->insurance_company4;
     $policy = $request->policy_no4;

     DB::table('afya_users')->where('id', '=', $afya_user)->update(['insurance_company_id' => $insurer, 'policy_no' => $policy, 'updated_at' => Carbon::now()]);
   }
   elseif(isset($request->insurance_company6) && isset($request->policy_no6))
   {
     $insurer = $request->insurance_company6;
     $policy = $request->policy_no6;

     DB::table('afya_users')->where('id', '=', $afya_user)->update(['insurance_company_id' => $insurer, 'policy_no' => $policy, 'updated_at' => Carbon::now()]);
   }

   return redirect()->action('privateController@showPaid', [$appointment_id]);

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

    public function findConstituency(Request $request)
     {
         $term = trim($request->q);
      if (empty($term)) {
           return \Response::json([]);
         }
       $drugs = County::search($term)->limit(20)->get();
         $formatted_drugs = [];
          foreach ($drugs as $drug) {
             $formatted_drugs[] = ['id' => $drug->id, 'text' => $drug->Constituency];
         }
     return \Response::json($formatted_drugs);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return back()->withInput();
      $this->validate($request,[
        'first' => 'required',
        'second' => 'required',
        'phone' => 'regex:/^2547[0-9]{8}/',
        'gender' => 'required',

      ]);

      $first=$request->first;
      $second=$request->second;
      $gender=$request->gender;
      $age=$request->age;
      $phone=$request->phone;
      $nationalId =$request->nationalId;
      $nhif =$request->nhif;
      $bloodtype =$request->bloodtype;
      $email =$request->email;
      $pob =$request->pob;
      $constituency =$request->constituency;
      $fullName= $first.$second;

      $address =$request->paddress;
      $code =$request->code;
      $town =$request->town;
      $marital =$request->marital;
      $krapin =$request->kra;
      $occupation =$request->occupation;
  $ins_company = $request->insurance_company;
  $policy = $request->policy_no;
      $smartphone = $request->smartphone;
      $file_no = $request->file_no;
      $filedate = $request->filedate;
      $age21=$request->age21;

  $u_id = Auth::user()->id;
$fcode=DB::table('facility_registrar')->where('user_id',$u_id)->select('facilitycode')->first();

$usebility=DB::table('afya_users')
->join('patient_facility', 'afya_users.id', '=', 'patient_facility.afya_user_id')
->where([['afya_users.msisdn',$phone],['patient_facility.facility_id',$fcode->facilitycode],])
->select('afya_users.id')->first();
if($usebility){

  $this->validate($request,[
  'phone' => 'regex:/^2547[0-9]{8}/|unique:afya_users,msisdn',

  ]);
 // return back()->withInput();
}else{

  $uexiafyaid=DB::table('afya_users')->where([['.msisdn',$phone],])->select('id')->first();

  if($uexiafyaid){
    $afya_id=$uexiafyaid->id;
    DB::table('patient_facility')->insert([
     'afya_user_id' =>$afya_id,
     'facility_id' => $fcode->facilitycode,
     'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
     'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
   ]);

  }else{
      $user= User::create([
         'name' => $fullName,
         'role' => 'Patient',
         'email' => $phone,
         'password' => bcrypt(123456),
     ]);
$userId = $user->id;
  DB::table('role_user')->insert(['user_id'=>$userId,'role_id'=>8]);
     $afya_id= DB::table('afya_users')->insertGetId([
      'users_id' => $userId,
      'msisdn' => $phone,
      'firstname'=>$first,
      'secondName' => $second,
      'gender'=> $gender,
      'age'=> $age21,
      'file_date'=> $filedate,
      'status'=> 1,
      'nationalId'=> $nationalId,
      'nhif'=> $nhif,
      'blood_type'=> $bloodtype,
      'email'=> $email,
      'dob'=> $age,
      'pob'=> $pob,
      'postal_address'=>$address,
      'postal_code'=>$code ,
      'town'=>$town,
      'marital'=>$marital,
      'occupation'=>$occupation,
      'kra_pin'=>$krapin,
      'created_by'=> $u_id,
      'constituency'=> $constituency,
      'has_smartphone'=>$smartphone,
      'file_no'=>$file_no,
      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);

    if($policy){
      $insrexist = DB::table('afyauser_insurance')->select('id')
      ->where([['afya_user_id', $afya_id],['ins_co_id', $ins_company],['policy_no', $policy]])->first();

    if($insrexist){

    }else{
      $insurance= DB::table('afyauser_insurance')->insertGetId(  [
        'afya_user_id' => $afya_id,
        'ins_co_id'=> $ins_company,
        'policy_no'=>$policy,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
      ]);

    }
    }
    $kin_name= $request->kin_name;
    $relation= $request->relation;
    $phone_of_kin= $request->phone_of_kin;
    $kin_postal = $request->kin_posta;

if($kin_name){
    DB::table('kin_details')->insert([
     'kin_name' => $kin_name,
     'relation' => $relation,
     'phone_of_kin' => $phone_of_kin,
     'postal' => $kin_postal,
     'afya_user_id' => $afya_id,
     'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
     'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
   ]);
 }

 DB::table('patient_facility')->insert([
  'afya_user_id' => $afya_id,
  'facility_id' => $fcode->facilitycode,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]);
}
return redirect()->action('RegistrarController@selectChoice', [$afya_id]);

    // return redirect()->action('PatientRegHistoryController@RegUpHist', [$afya_id]);
}
    }


    public function boarding(Request $request)
    {
      $this->validate($request,[
        'first' => 'required',
        'second' => 'required',
        'phone' => 'regex:/^2547[0-9]{8}/',
        'gender' => 'required',
      ]);

      $first=$request->first;
      $second=$request->second;
      $gender=$request->gender;

      $phone=$request->phone;
      $nationalId =$request->nationalId;

      $fullName= $first.$second;

      $address =$request->paddress;
      $code =$request->code;
      $town =$request->town;


      $occupation =$request->occupation;

      $file_no = $request->file_no;
      $filedate = $request->filedate;
      $age21=$request->age21;

  $u_id = Auth::user()->id;
  $fcode=DB::table('facility_registrar')->where('user_id',$u_id)->select('facilitycode')->first();

  $usebility=DB::table('afya_users')
  ->join('patient_facility', 'afya_users.id', '=', 'patient_facility.afya_user_id')
  ->where([['afya_users.msisdn',$phone],['patient_facility.facility_id',$fcode->facilitycode],])
  ->select('afya_users.id')->first();
  if($usebility){

  $this->validate($request,[
  'phone' => 'regex:/^2547[0-9]{8}/|unique:afya_users,msisdn',

  ]);
  // return back()->withInput();
  }else{

  $uexiafyaid=DB::table('afya_users')->where([['.msisdn',$phone],])->select('id')->first();

  if($uexiafyaid){
    $afya_id=$uexiafyaid->id;
    DB::table('patient_facility')->insert([
     'afya_user_id' =>$afya_id,
     'facility_id' => $fcode->facilitycode,
     'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
     'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
   ]);

  }else{
      $user= User::create([
         'name' => $fullName,
         'role' => 'Patient',
         'email' => $phone,
         'password' => bcrypt(123456),
     ]);
  $userId = $user->id;
  DB::table('role_user')->insert(['user_id'=>$userId,'role_id'=>8]);
     $afya_id= DB::table('afya_users')->insertGetId([
      'users_id' => $userId,
      'msisdn' => $phone,
      'firstname'=>$first,
      'secondName' => $second,
      'gender'=> $gender,
      'age'=> $age21,
      'file_date'=> $filedate,
      'status'=> 1,

      'postal_address'=>$address,
      'postal_code'=>$code ,
      'town'=>$town,

      'occupation'=>$occupation,

      'created_by'=> $u_id,

      'file_no'=>$file_no,
      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
    ]);

    $kin_name= $request->kin_name;
    $phone_of_kin= $request->phone_of_kin;

  if($kin_name){
    DB::table('kin_details')->insert([
     'kin_name' => $kin_name,
     'phone_of_kin' => $phone_of_kin,
     'afya_user_id' => $afya_id,
     'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
     'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
   ]);
  }

  DB::table('patient_facility')->insert([
  'afya_user_id' => $afya_id,
  'facility_id' => $fcode->facilitycode,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
  }
    return redirect()->action('RegistrarController@onboarding');
  }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function edit_nextkin($id){
return view('registrar.edit_nextkin')->with('id',$id);
    }

    public function update_nextkin(Request $request){
      $name=$request->name;
      $phone=$request->phone;
      $user=$request->id;
      $id=$request->user;
      $rel=$request->relationship;


     DB::table('kin_details')->where('id',$user)->update(
      ['kin_name' => $name,
      'relation'=>$rel,
      'phone_of_kin' => $phone,
      'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
  );


 return redirect()->action('RegistrarController@showUser',['id'=> $id]);

    }

    public function updateUsers(Request $request){
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

    return redirect()->action('RegistrarController@showUser',[$id]);

    }

    public function edit_patient($id){

      return view('registrar.edit_patient')->with('id',$id);
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


     return redirect()->action('RegistrarController@showUser',['id'=> $id]);

        }


public function receiptsFees($id){
$u_id = Auth::user()->id;
$facility = DB::table('facility_registrar')
         ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
         ->select('facilities.*','facility_registrar.facilitycode')
         ->where('user_id', $u_id)
         ->first();

  $fee = DB::table('payments')
        ->join('appointments','appointments.id','=','payments.appointment_id')
        ->leftjoin('doctors','appointments.doc_id','=','doctors.id')
        ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
        ->select('payments.created_at','payments.amount','afya_users.*','doctors.name as docname', 'doctors.id as doc_id')
        ->where([
          ['payments.amount', '<>', 'None'],
          ['appointments.facility_id', '=', $facility->facilitycode],
          ['payments.id', '=', $id],
        ])
        ->orderBy('payments.created_at','desc')
        ->first();


    $dy=$fee->created_at; $dys=date("d-M-Y", strtotime( $dy));
    $last = $id;
$last ++;

$doc=DB::table('doctors')->where("id","=",$fee->doc_id)->first();


$number = sprintf('%07d', $last);

return view('receipts.consulationfees')->with('facility',$facility)->with('fee',$fee)->with('dys',$dys)->with('number',$number)->with('doc',$doc);
}

public function registerPatient(){

return view('registrar.new_patient');
}
public function onboarding(){

return view('registrar.onboarding');
}

public function feespay($id){

$user = DB::table('appointments')
        ->join('afya_users','appointments.afya_user_id','=','afya_users.id')
        ->select('afya_users.*','appointments.facility_id')
        ->where('appointments.id',$id)
        ->first();

  $userid = Auth::id();

  $registrar = DB::table('facility_registrar')
            ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
            ->select('facilities.FacilityName', 'facilities.FacilityCode')
            ->where('facility_registrar.user_id',$userid )
            ->first();

  $cnst = DB::table('consultation_fees')
        ->select('old_consultation_fee', 'new_consultation_fee')->where('facility_code',$user->facility_id)->first();

return view('registrar.feespay')->with('cnst',$cnst)->with('registrar',$registrar)->with('user',$user)->with('id',$id);
}

public function feespaytest($id){
$u_id = Auth::user()->id;
$facility = DB::table('facility_registrar')
         ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
         ->select('facilities.*','facility_registrar.facilitycode')
         ->where('user_id', $u_id)
         ->first();

$data['user'] = DB::table('appointments')
        ->join('afya_users','appointments.afya_user_id','=','afya_users.id')
        ->select('afya_users.*','appointments.facility_id','appointments.id as appid')
        ->where('appointments.id',$id)
        ->first();

$data['tsts'] = DB::table('appointments')
->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
->leftJoin('test_price', 'tests.id', '=', 'test_price.tests_id')
->select('tests.name as tname','patient_test_details.id as patTdid','appointments.id as AppId',
'test_price.amount','patient_test.id as ptid')
->where([['appointments.id', '=',$id],['test_price.facility_id',$facility->facilitycode],
['patient_test_details.deleted', '=',0]])
->get();
return view('registrar.feespaytest',$data);
}

public function feespaytest2($id){
$u_id = Auth::user()->id;
$data['facility'] = DB::table('facility_registrar')
         ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
         ->select('facilities.*','facility_registrar.facilitycode')
         ->where('user_id', $u_id)
         ->first();

$data['user'] = DB::table('appointments')
        ->join('afya_users','appointments.afya_user_id','=','afya_users.id')
        ->select('afya_users.*','appointments.facility_id','appointments.id as appid')
        ->where('appointments.id',$id)
        ->first();

        $data['tsts'] =  DB::table('patient_test')
            ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
            ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
            ->select('radiology_test_details.test','radiology_test_details.test_cat_id','patient_test.id as ptid',
            'radiology_test_details.id as patTdid','appointments.id as AppId')
             ->where([['appointments.id', '=',$id],['radiology_test_details.deleted', '=', 0],])
        ->get();

return view('registrar.feespaytest2',$data);
}



public function appointment_made(){
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
                   ->select('afya_users.id as parid','afya_users.firstname as first','afya_users.secondName as second','afya_users.gender as gender','afya_users.dob as dob',
                   'dependant.id as depid','dependant.firstName as dfirst','dependant.secondName as dsecond','dependant.dob as ddob', 'dependant.gender as dgender',
                    'appointments.appointment_time', 'appointments.appointment_date','appointments.id as appid','appointments.persontreated', 'doctors.name AS doc_name')
                  // ->where('appointments.status',10)
                  ->whereNotNull('appointments.appointment_date')
                   ->where('appointments.facility_id',$facilitycode)
                   ->get();
return view('registrar.appointment')->with('patients',$patients)->with('facility',$facility);

}

public function nxtapptreg(Request $request)
{

$nextappointment=$request->next_appointment;
$doc_id  = $request->doc;
$next_time =$request->next_time;
$id =$request->afya_user_id;
$facility =$request->facility;


DB::table('appointments')->insert(
[
'appointment_date'=> $nextappointment,
'appointment_time'=>$next_time,
'afya_user_id'=>$id,
'doc_id'=>$doc_id,
'persontreated'=>'Self',
'facility_id'=>$facility,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]);
return redirect()->action('RegistrarController@allPatients');

}
public function nxtapptreg2(Request $request)
{

$nextappointment=$request->next_appointment;
$doc_id  = $request->doc;
$next_time =$request->next_time;
$id =$request->afya_user_id;
$facility =$request->facility;

$phone =$request->phone;
$name1 =$request->firstname;
$name2 =$request->secondname;

$afyaId = DB::table('afya_users')->insertGetId([
  'msisdn' => $phone,
  'firstname'=>$name1,
  'secondName' => $name2,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
 ]);

DB::table('appointments')->insert(
[
'appointment_date'=> $nextappointment,
'appointment_time'=>$next_time,
'afya_user_id'=>$afyaId,
'doc_id'=>$doc_id,
'persontreated'=>'Self',
'status'=>'0',
'facility_id'=>$facility,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]);
$u_id = Auth::user()->id;
$fcode=DB::table('facility_registrar')->where('user_id',$u_id)->select('facilitycode')->first();

DB::table('patient_facility')->insert([
 'afya_user_id' => $afyaId,
 'facility_id' => $fcode->facilitycode,
 'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]);
return redirect()->action('privateController@appointmentsmadereg');

}
public function regpaytest(Request $request){

  $appointment = $request->appointment;
  $ptid = $request->ptid;
  $ptdid = $request->ptdid;
  $mode = $request->mode;
  $amount = $request->amount;

  $u_id = Auth::user()->id;
  $facility = DB::table('facility_registrar')->select('facilitycode')->where('user_id', $u_id)->first();

  DB::table('payments')->insert(
  [
  'appointment_id'=> $appointment,
  'patient_test_id'=>$ptid,
  'lab_id'=>$ptdid,
  'mode'=>$mode,
  'payments_category_id'=>2,
  'amount'=>$amount,
  'facility' =>$facility->facilitycode,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);

  DB::table('patient_test_details')->where('id', $ptdid)
  ->update(['status' => 1,]);

  // $afyaId = DB::table("appointments")->where('id',$appointment)->select('afya_user_id')->first();
  return redirect()->action('privateController@showUserpay',[$appointment]);
  // return redirect()->action('RegistrarController@feespaytest',[$appointment]);
}
public function regpaytest2(Request $request){

  $appointment = $request->appointment;
  $ptid = $request->ptid;
  $ptdid = $request->ptdid;
  $mode = $request->mode;
  $amount = $request->amount;
  $u_id = Auth::user()->id;



  $facility = DB::table('facility_registrar')->select('facilitycode')->where('user_id', $u_id)->first();
  DB::table('payments')->insert([
  'appointment_id'=> $appointment,
  'paid_app_id'=>$appointment,
  'patient_test_id'=>$ptid,
  'imaging_id'=>$ptdid,
  'mode'=>$mode,
  'payments_category_id'=>3,
  'amount'=>$amount,
  'facility' =>$facility->facilitycode,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
  DB::table('radiology_test_details')->where('id', $ptdid)
  ->update(['status' => 1,]);

  return redirect()->action('privateController@showUserpay',[$appointment]);
}

 public function showPaid1($id)
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
       ['payments.paid_app_id', '=', $id],
       ['payments.facility', '=', $facility],
     ])
     ->get();

 $data['lab'] = DB::table('payments')
 ->Join('patient_test_details', 'payments.lab_id', '=', 'patient_test_details.id')
 ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
 ->select('tests.name','payments.amount')
  ->where([
                      ['payments.payments_category_id', '=', 2],
                      ['payments.paid_app_id', '=', $id],
                      ['payments.facility', '=', $facility],
                    ])  ->get();

$data['consult'] = DB::table('payments')->select('amount')
->where([ ['payments_category_id', '=', 1],
['payments.paid_app_id', '=', $id],
['payments.facility', '=', $facility],
])  ->first();
$data['medfee'] = DB::table('payments')->select('amount')
->where([ ['payments_category_id', '=', 4],
['payments.paid_app_id', '=', $id],
['payments.facility', '=', $facility],
])  ->first();
$rectsum = DB::table('payments')
->select(DB::raw("SUM(payments.amount) as paidsum"))
->where([
                 ['payments.paid_app_id', '=', $id],
                 ['payments.facility', '=', $facility],
               ])
               ->first();

  return view('registrar.radyreceipt',$data)->with('receipt',$receipt)->with('rect',$rect)->with('rectsum',$rectsum)->with('fac',$fac);
 }

 public function showPaid2($id){
 $u_id = Auth::user()->id;
   $fac = DB::table('facility_registrar')
   ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
   ->select('facility_registrar.facilitycode','facilities.FacilityName')
   ->where('facility_registrar.user_id', $u_id)->first();
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

    return view('registrar.radyreceipt2',$data)->with('fac',$fac);
 }
 public function showPaidlab($id)
 {
   $u_id = Auth::user()->id;
   $facility = DB::table('facility_registrar')->select('facilitycode')->where('user_id', $u_id)->first();
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

    return view('registrar.labreceipt',$data);
 }
 public function showPaidlab2($id)
 {
   $u_id = Auth::user()->id;
   $facility = DB::table('facility_registrar')->select('facilitycode')->where('user_id', $u_id)->first();
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

    return view('registrar.labreceipt2',$data);
 }
 public function printout($id)
 {
    $user = DB::table('afya_users')->where('id',$id)->select('afya_users.*')->first();

    $data['tstdone'] = DB::table('appointments')
    ->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
    ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
    ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
    ->select('facilities.FacilityName','doctors.name as docname','patient_test.created_at','patient_test.test_status'
    ,'patient_test.id as ptid','appointments.id as appid')
    ->where('appointments.afya_user_id', '=',$id)
    ->groupBy('patient_test.id')
    ->orderBy('patient_test.created_at','DESC')
    ->get();

    $data['prescriptions'] = DB::table('appointments')
    ->Join('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
    ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
    ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
   ->select('facilities.FacilityName','doctors.name as docname','prescriptions.created_at','prescriptions.filled_status'
    ,'prescriptions.id as prescid','appointments.id as appid')
 ->where('appointments.afya_user_id', '=',$id)
   ->groupBy('appointments.id')
     ->orderBy('prescriptions.created_at','DESC')
      ->get();

   return view('registrar.private.printout',$data)->with('user',$user);
}
public function testprint($id)
{
  $data['pdetails'] = DB::table('patient_test')
  ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->select('appointments.persontreated','appointments.afya_user_id','appointments.id as appId',
  'doctors.name as docname','facilities.FacilityName','patient_admitted.condition')
  ->where('patient_test.id', '=',$id)
  ->first();

  $data['tsts'] = DB::table('patient_test')
  ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->leftJoin('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
  ->leftJoin('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->select('tests.name as tname','patient_test_details.created_at as date','patient_test_details.id as patTdid','patient_test_details.done',
  'patient_test_details.tests_reccommended','appointments.id as AppId')
  ->where('patient_test.id', '=',$id)
  ->get();

 $data['rady'] = DB::table('patient_test')
     ->leftJoin('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
     ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
     ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
     ->select('radiology_test_details.created_at as date','radiology_test_details.test',
     'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
     'radiology_test_details.id as patTdid','test_categories.name as tcname')
      ->where('patient_test.id', '=',$id)
      ->get();

  return view('registrar.private.testprint',$data);
}
public function prscprint($id)
{
  $data['prescriptions'] =DB::table('prescriptions')
               ->join('prescription_details','prescriptions.id','=','prescription_details.presc_id')
               ->select('prescription_details.drug_id','prescriptions.created_at')
              ->where('prescriptions.id',$id)
               ->get();

$data['pdetails']=DB::table('prescriptions')
                  ->join('appointments','prescriptions.appointment_id','=','appointments.id')
                  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                  ->select('appointments.id as appid','appointments.persontreated','appointments.afya_user_id','facilities.FacilityName',
                  'doctors.name as docname','prescriptions.created_at')
                  ->where('prescriptions.id',$id)
                  ->first();
return view('registrar.private.prscprint',$data);
}

public function  PayOthers($appid, $tpoid,$ptdid){

$data['user'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as appid')->where('appointments.id',$appid)
->first();

$userid = Auth::id();
$data['registrar'] = DB::table('facility_registrar')
        ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
        ->select('facilities.FacilityName','facilities.FacilityCode')
        ->where('facility_registrar.user_id',$userid )
        ->first();

$data['others'] = DB::table('test_prices_other')
->join('other_tests','test_prices_other.other_id','=','other_tests.id')
->select('other_tests.name')->where('test_prices_other.id',$tpoid)->first();

$data['othersprice'] = DB::table('testprice_other_option')
->select('name','amount')->where('tpo_id',$tpoid)->get();

return view('registrar.payments.others_feespay',$data)->with('ptdid',$ptdid);
}

public function regpayothers(Request $request){

$afyauser_id = $request->afya_user_id;
  $appointment = $request->appointment;
  $app = $request->cappid;
  $ptid = $request->ptid;
  $prdid = $request->prdid;
  $amount = $request->amount;
  $mode = $request->mode;
  $co = $request->company;
  $transaction = $request->transaction;
  $policy_no= $request->policy_no;
  $insurance_Id = '';
if($co){
  $insrexist = DB::table('afyauser_insurance')->select('id')
  ->where([['afya_user_id', $afyauser_id],['ins_co_id', $co],['policy_no', $policy_no]])->first();

if($insrexist){

$insurance_Id =$insrexist->id;

}else{
  $insurance= DB::table('afyauser_insurance')->insertGetId(  [
    'afya_user_id' => $afyauser_id,
    'ins_co_id'=> $co,
    'policy_no'=>$policy_no,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
$insurance_Id =$insurance;
}
}
  $u_id = Auth::user()->id;
  $facility = DB::table('facility_registrar')->select('facilitycode')->where('user_id', $u_id)->first();
  DB::table('payments')->insert([
  'appointment_id'=> $appointment,
  'paid_app_id'=> $app,
  'patient_test_id'=>$ptid,
  'imaging_id'=>$prdid,
  'mode'=>$mode,
  'payments_category_id'=>3,
  'amount'=>$amount,
  'status'=>1,
  'transaction_no'=>$transaction,
  'afyauser_ins_id'=>$insurance_Id,
  'facility' =>$facility->facilitycode,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);

  DB::table('radiology_test_details')->where('id', $prdid)
  ->update(['status' => 1,]);

  return redirect()->action('privateController@showUserpay',[$app]);
}


public function  PayCt($appid, $tpctid,$ptdid){

$data['user'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as appid')->where('appointments.id',$appid)
->first();
$userid = Auth::id();
$data['registrar'] = DB::table('facility_registrar')
        ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
        ->select('facilities.FacilityName','facilities.FacilityCode')
        ->where('facility_registrar.user_id',$userid )
        ->first();

$data['ct'] = DB::table('test_prices_ct_scan')
->join('ct_scan','test_prices_ct_scan.ct_scan_id','=','ct_scan.id')
->select('ct_scan.name')->where('test_prices_ct_scan.id',$tpctid)->first();

$data['ctprice'] = DB::table('testprice_ct_option')
->select('name','amount')->where('tpct_id',$tpctid)->get();


return view('registrar.payments.ct_feespay',$data)->with('ptdid',$ptdid);
}

public function  PayXray($appid, $tpxray,$ptdid){

$data['user'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as appid')->where('appointments.id',$appid)
->first();
$userid = Auth::id();
$data['registrar'] = DB::table('facility_registrar')
        ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
        ->select('facilities.FacilityName','facilities.FacilityCode')
        ->where('facility_registrar.user_id',$userid )
        ->first();

$data['xray'] = DB::table('test_prices_xray')
->join('xray','test_prices_xray.xray_id','=','xray.id')
->select('xray.name')->where('test_prices_xray.id',$tpxray)->first();

$data['xrayprice'] = DB::table('testprice_xray_option')
->select('name','amount')->where('tpxray_id',$tpxray)->get();

return view('registrar.payments.xray_feespay',$data)->with('ptdid',$ptdid);
}


public function  PayMri($appid, $mrid,$ptdid){

$data['user'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as appid')->where('appointments.id',$appid)
->first();
$userid = Auth::id();
$data['registrar'] = DB::table('facility_registrar')
        ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
        ->select('facilities.FacilityName','facilities.FacilityCode')
        ->where('facility_registrar.user_id',$userid )
        ->first();

$data['mri'] = DB::table('test_prices_mri')
->join('mri_tests','test_prices_mri.mri_id','=','mri_tests.id')
->select('mri_tests.name')->where('test_prices_mri.id',$mrid)->first();

$data['mriprice'] = DB::table('testprice_mri_option')
->select('name','amount')->where('tpmri_id',$mrid)->get();

return view('registrar.payments.mri_feespay',$data)->with('ptdid',$ptdid);
}


public function  PayUltra($appid, $ultid,$ptdid){

$data['user'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as appid')->where('appointments.id',$appid)
->first();
$userid = Auth::id();
$data['registrar'] = DB::table('facility_registrar')
        ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
        ->select('facilities.FacilityName','facilities.FacilityCode')
        ->where('facility_registrar.user_id',$userid )
        ->first();

$data['ultra'] = DB::table('test_prices_ultrasound')
->join('ultrasound','test_prices_ultrasound.ultrasound_id','=','ultrasound.id')
->select('ultrasound.name')->where('test_prices_ultrasound.id',$ultid)->first();

$data['ultraprice'] = DB::table('testprice_ultra_option')
->select('name','amount')->where('tpultra_id',$ultid)->get();

return view('registrar.payments.ultra_feespay',$data)->with('ptdid',$ptdid);
}


public function  PayLab($appid,$tp_id, $ptdidl){

$data['user'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as appid')->where('appointments.id',$appid)
->first();
$userid = Auth::id();
$data['registrar'] = DB::table('facility_registrar')
        ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
        ->select('facilities.FacilityName','facilities.FacilityCode')
        ->where('facility_registrar.user_id',$userid )
        ->first();

$data['lab'] = DB::table('test_price')
->join('tests','test_price.tests_id','=','tests.id')
->select('tests.name')->where('test_price.id',$tp_id)->first();

$data['labprice'] = DB::table('testprice_lab_option')
->select('name','amount')->where('tp_id',$tp_id)->get();

return view('registrar.payments.lab_feespay',$data)->with('ptdidl',$ptdidl);
}

public function regpaylab(Request $request){

$afyauser_id = $request->afya_user_id;
  $appointment = $request->appointment;
  $app = $request->cappid;
  $ptid = $request->ptid;
  $prdid = $request->prdid;
  $amount = $request->amount;
  $mode = $request->mode;
  $co = $request->company;
  $transaction = $request->transaction;
  $policy_no= $request->policy_no;
  $insurance_Id = '';
if($co){
  $insrexist = DB::table('afyauser_insurance')->select('id')
  ->where([['afya_user_id', $afyauser_id],['ins_co_id', $co],['policy_no', $policy_no]])->first();

if($insrexist){

$insurance_Id =$insrexist->id;

}else{
  $insurance= DB::table('afyauser_insurance')->insertGetId(  [
    'afya_user_id' => $afyauser_id,
    'ins_co_id'=> $co,
    'policy_no'=>$policy_no,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
$insurance_Id =$insurance;
}
}
  $u_id = Auth::user()->id;
  $facility = DB::table('facility_registrar')->select('facilitycode')->where('user_id', $u_id)->first();
  DB::table('payments')->insert([
  'appointment_id'=> $appointment,
  'paid_app_id'=> $app,
  'patient_test_id'=>$ptid,
  'lab_id'=>$prdid,
  'mode'=>$mode,
  'payments_category_id'=>2,
  'amount'=>$amount,
  'status'=>1,
  'transaction_no'=>$transaction,
  'afyauser_ins_id'=>$insurance_Id,
  'facility' =>$facility->facilitycode,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);

  DB::table('patient_test_details')->where('id', $prdid)
  ->update(['status' => 1,]);

  return redirect()->action('privateController@showUserpay',[$app]);
}
public function  PayCardiac($appid,$tpcard_id, $ptdidc){

$data['user'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as appid')->where('appointments.id',$appid)
->first();
$userid = Auth::id();
$data['registrar'] = DB::table('facility_registrar')
        ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
        ->select('facilities.FacilityName','facilities.FacilityCode')
        ->where('facility_registrar.user_id',$userid )
        ->first();

$data['cardiac'] = DB::table('testprice_cardiac')
->join('tests_cardiac','testprice_cardiac.tests_id','=','tests_cardiac.id')
->select('tests_cardiac.name')->where('testprice_cardiac.id',$tpcard_id)->first();

$data['cardprice'] = DB::table('testprice_cardiac_option')
->select('name','amount')->where('tp_id',$tpcard_id)->get();

return view('registrar.payments.card_feespay',$data)->with('ptdidc',$ptdidc);
}
public function regpaycardiac(Request $request){

$afyauser_id = $request->afya_user_id;
  $appointment = $request->appointment;
  $app = $request->cappid;
  $ptid = $request->ptid;
  $prdid = $request->prdid;
  $amount = $request->amount;
  $mode = $request->mode;
  $co = $request->company;
  $transaction = $request->transaction;
  $policy_no= $request->policy_no;
  $insurance_Id = '';
if($co){
  $insrexist = DB::table('afyauser_insurance')->select('id')
  ->where([['afya_user_id', $afyauser_id],['ins_co_id', $co],['policy_no', $policy_no]])->first();
if($insrexist){
$insurance_Id =$insrexist->id;
}else{
  $insurance= DB::table('afyauser_insurance')->insertGetId(  [
    'afya_user_id' => $afyauser_id,
    'ins_co_id'=> $co,
    'policy_no'=>$policy_no,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
$insurance_Id =$insurance;
}
}
  $u_id = Auth::user()->id;
  $facility = DB::table('facility_registrar')->select('facilitycode')->where('user_id', $u_id)->first();
  DB::table('payments')->insert([
  'appointment_id'=> $appointment,
  'paid_app_id'=> $app,
  'patient_test_id'=>$ptid,
  'cardiac_id'=>$prdid,
  'mode'=>$mode,
  'payments_category_id'=>5,
  'amount'=>$amount,
  'status'=>1,
  'transaction_no'=>$transaction,
  'afyauser_ins_id'=>$insurance_Id,
  'facility' =>$facility->facilitycode,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);

  DB::table('patient_test_details_c')->where('id', $prdid)
  ->update(['status' => 1,]);

  return redirect()->action('privateController@showUserpay',[$app]);
}
public function  PayNeurology($appid,$tpneuro_id, $ptdidn){

$data['user'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as appid')->where('appointments.id',$appid)
->first();
$userid = Auth::id();
$data['registrar'] = DB::table('facility_registrar')
        ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
        ->select('facilities.FacilityName','facilities.FacilityCode')
        ->where('facility_registrar.user_id',$userid )
        ->first();

$data['neurology'] = DB::table('testprice_neurology')
->join('tests_neurology','testprice_neurology.tests_id','=','tests_neurology.id')
->select('tests_neurology.name')->where('testprice_neurology.id',$tpneuro_id)->first();

$data['neurologyprice'] = DB::table('testprice_neurology_option')
->select('name','amount')->where('tp_id',$tpneuro_id)->get();

return view('registrar.payments.neuro_feespay',$data)->with('ptdidn',$ptdidn);
}
public function regpayneurology(Request $request){

$afyauser_id = $request->afya_user_id;
  $appointment = $request->appointment;
  $app = $request->cappid;
  $ptid = $request->ptid;
  $prdid = $request->prdid;
  $amount = $request->amount;
  $mode = $request->mode;
  $co = $request->company;
  $transaction = $request->transaction;
  $policy_no= $request->policy_no;
  $insurance_Id = '';
if($co){
  $insrexist = DB::table('afyauser_insurance')->select('id')
  ->where([['afya_user_id', $afyauser_id],['ins_co_id', $co],['policy_no', $policy_no]])->first();
if($insrexist){
$insurance_Id =$insrexist->id;
}else{
  $insurance= DB::table('afyauser_insurance')->insertGetId(  [
    'afya_user_id' => $afyauser_id,
    'ins_co_id'=> $co,
    'policy_no'=>$policy_no,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
$insurance_Id =$insurance;
}
}
  $u_id = Auth::user()->id;
  $facility = DB::table('facility_registrar')->select('facilitycode')->where('user_id', $u_id)->first();
  DB::table('payments')->insert([
  'appointment_id'=> $appointment,
  'paid_app_id'=> $app,
  'patient_test_id'=>$ptid,
  'neurology_id'=>$prdid,
  'mode'=>$mode,
  'payments_category_id'=>6,
  'amount'=>$amount,
  'status'=>1,
  'transaction_no'=>$transaction,
  'afyauser_ins_id'=>$insurance_Id,
  'facility' =>$facility->facilitycode,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);

  DB::table('patient_test_details_n')->where('id', $prdid)
  ->update(['status' => 1,]);

  return redirect()->action('privateController@showUserpay',[$app]);
}
public function  PayProcedure($appid,$tpproc_id, $ptdip){

$data['user'] = DB::table('appointments')
->join('afya_users','appointments.afya_user_id','=','afya_users.id')
->select('afya_users.*','appointments.id as appid')->where('appointments.id',$appid)
->first();
$userid = Auth::id();
$data['registrar'] = DB::table('facility_registrar')
        ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
        ->select('facilities.FacilityName','facilities.FacilityCode')
        ->where('facility_registrar.user_id',$userid )
        ->first();

$data['procedure'] = DB::table('procedure_prices')
->join('procedures','procedure_prices.procedure_id','=','procedures.id')
->select('procedures.name')->where('procedure_prices.id',$tpproc_id)->first();

$data['procedureprice'] = DB::table('procedure_option')
->select('name','amount')->where('tp_id',$tpproc_id)->get();

return view('registrar.payments.proc_feespay',$data)->with('ptdip',$ptdip);
}
public function regpayprocedures(Request $request){

$afyauser_id = $request->afya_user_id;
  $appointment = $request->appointment;
  $app = $request->cappid;
  $ptid = $request->ptid;
  $prdid = $request->prdid;
  $amount = $request->amount;
  $mode = $request->mode;
  $co = $request->company;
  $transaction = $request->transaction;
  $policy_no= $request->policy_no;
  $insurance_Id = '';
if($co){
  $insrexist = DB::table('afyauser_insurance')->select('id')
  ->where([['afya_user_id', $afyauser_id],['ins_co_id', $co],['policy_no', $policy_no]])->first();
if($insrexist){
$insurance_Id =$insrexist->id;
}else{
  $insurance= DB::table('afyauser_insurance')->insertGetId(  [
    'afya_user_id' => $afyauser_id,
    'ins_co_id'=> $co,
    'policy_no'=>$policy_no,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);
$insurance_Id =$insurance;
}
}
  $u_id = Auth::user()->id;
  $facility = DB::table('facility_registrar')->select('facilitycode')->where('user_id', $u_id)->first();
  DB::table('payments')->insert([
  'appointment_id'=> $appointment,
  'paid_app_id'=> $app,
  'patient_test_id'=>$ptid,
  'procedure_id'=>$prdid,
  'mode'=>$mode,
  'payments_category_id'=>7,
  'amount'=>$amount,
  'status'=>1,
  'transaction_no'=>$transaction,
  'afyauser_ins_id'=>$insurance_Id,
  'facility' =>$facility->facilitycode,
  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
  ]);

  DB::table('patient_procedure_details')->where('id', $prdid)
  ->update(['status' => 1,]);

  return redirect()->action('privateController@showUserpay',[$app]);
}

}
