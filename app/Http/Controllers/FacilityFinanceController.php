<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\FacilityFinance;
use App\Role;
use App\User;
use App\Payment;
use App\Testprice;
use App\Procedureprice;
use App\Prescriptionfilledstatus;
use App\Appointment;
class FacilityFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['officers']= User::select('*')
               ->where('role', '=','FacilityFinance')  
               ->get();
       return view('facilityfinance.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        return view('facilityfinance.create');
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

            'email' => 'required|email|unique:users,email',

            'password' => 'required|same:confirm-password'

        ]);

        $password=bcrypt($request->password);

        $user=User::create(array('name'=>$request->name,'email'=>$request->email,'password'=>$password,'role'=>'FacilityFinance'));


         FacilityFinance::create(array('user_id'=>$user['id'],'facilitycode'=>Controller::admin_facility_code()));

         return redirect('facility-finance');
       
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
        $data['officers']=User::find($id);

        return view('facilityfinance.edit',$data);
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
        $user= new User;

        $user->update(array('name'=>$request->name,'email'=>$request->email));

        return redirect('facility-finance');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect('facility-finance');
    }


    Public function payments()
     {

        $data['facility']=Controller::finance_facility();

         
        $data['fees']=Payment::select('payments.*','afya_users.firstname','afya_users.secondName','afya_users.users_id')
                         ->join('appointments','payments.appointment_id','=','appointments.id') 
                         ->join('afya_users','appointments.afya_user_id','=','afya_users.users_id')                         
                         ->orderby('payments.created_at','desc')
                         ->get();

        $data['amount']=0;

        if(count($data['fees'])){

         if($data['fees'][0]->test_id!=null){
          
          $testprice=Testprice::select('amount')

                              ->where('tests_id','=',$data['fees'][0]->test_id)
                              ->where('user_id','=',$data['fees'][0]->users_id)
                              ->where('facility_id','=',$data['facility']->facilitycode)
                              ->get()
                              ->first();

             if(count($testprice))$data['amount']+=$testprice->amount;
         }

         if($data['fees'][0]->procedure_id!=null){
          
          $procedureprice=Procedureprice::select('amount')
                              ->where('procedure_id','=',$data['fees'][0]->procedure_id)
                              ->where('user_id','=',$data['fees'][0]->users_id)
                              ->where('facility_id','=',$data['facility']->facilitycode)
                              ->get()
                              ->first();

           if(count($procedureprice))$data['amount']+=$procedureprice->amount;
         }

          if($data['fees'][0]->prescription_id!=null){
          
          $prescriptionprice=Prescriptionfilledstatus::select('total')
                              ->where('presc_details_id','=',$data['fees'][0]->prescription_id)
                              ->where('outlet_id','=',$data['facility']->facilitycode)
                              ->get()
                              ->first();

           if(count($prescriptionprice))$data['amount']+=$prescriptionprice->total;
         }

      }

        return view('facilityfinance.payments',$data);
    }


      Public function pending()
     {

        $data['facility']=Controller::finance_facility();

         
        $data['fees']=Payment::select('payments.*','afya_users.firstname','afya_users.secondName','afya_users.users_id')
                         ->join('appointments','payments.appointment_id','=','appointments.id') 
                         ->join('afya_users','appointments.afya_user_id','=','afya_users.users_id')   
                         ->where('payments.status','=','pending')                       
                         ->orderby('payments.created_at','desc')
                         ->get();

        $data['amount']=0;

    if(count($data['fees'])){

         if($data['fees'][0]->test_id!=null){
          
          $testprice=Testprice::select('amount')

                              ->where('tests_id','=',$data['fees'][0]->test_id)
                              ->where('user_id','=',$data['fees'][0]->users_id)
                              ->where('facility_id','=',$data['facility']->facilitycode)
                              ->get()
                              ->first();

             if(count($testprice))$data['amount']+=$testprice->amount;
         }

         if($data['fees'][0]->procedure_id!=null){
          
          $procedureprice=Procedureprice::select('amount')
                              ->where('procedure_id','=',$data['fees'][0]->procedure_id)
                              ->where('user_id','=',$data['fees'][0]->users_id)
                              ->where('facility_id','=',$data['facility']->facilitycode)
                              ->get()
                              ->first();

           if(count($procedureprice))$data['amount']+=$procedureprice->amount;
         }

          if($data['fees'][0]->prescription_id!=null){
          
          $prescriptionprice=Prescriptionfilledstatus::select('total')
                              ->where('presc_details_id','=',$data['fees'][0]->prescription_id)
                              ->where('outlet_id','=',$data['facility']->facilitycode)
                              ->get()
                              ->first();

           if(count($prescriptionprice))$data['amount']+=$prescriptionprice->total;
         }
     }

        return view('facilityfinance.pending',$data);
    }


    Public function paid(Request $request)
    {
       
        $payment=Payment::find($request->id);   
        $payment->status = 'paid';
        $payment->save();


        if($request->category_id==1){

          $appointment=Appointment::find($request->appointment_id);
          $appointment->status='1';
          $appointment->save();

        }
  
    
     return redirect('pending');

    }

   
}
