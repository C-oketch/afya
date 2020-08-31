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


class RegistrarControllerF extends Controller
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

 return view('registrar.full.Reg_feespay')->with('cnst',$cnst)->with('registrar',$registrar)->with('user',$user);
     }




     public function consultationFees(Request $request){

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
     $visit=$request->visit;


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

     $appointment = DB::table('appointments')->insertGetId([
       'status'=>1,
       'afya_user_id'=>$id,
       'facility_id'=>$facility,
       'persontreated'=>'Self',
       'visit_type'=>$visit,
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


     return redirect()->action('RegistrarController@showUser',['id'=> $id]);
     }
     public function showPaidConslt($id)
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

      return view('registrar.full.receiptcon',$data)->with('receipt',$receipt)->with('rect',$rect)->with('rectsum',$rectsum)->with('fac',$fac);
     }


}
