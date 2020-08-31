<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Appointment;
use App\Facility;
use App\Facility_doctor;
use App\Afya_user;
use Auth;
use Session;
use DB;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['appointments']=Appointment::where([['status','=',0],['doc_id','=',2505]])
       ->where('facility_id','=',Controller::doctor_reg_facility()->FacilityCode)
       ->get();
       $data['facility'] = Controller::doctor_reg_facility();
       $data['doctors']=Facility_doctor::select('doctors.*')
        ->where('facilitycode','=',Controller::doctor_reg_facility()->FacilityCode)
        ->join('doctors','doctors.id','=','facility_doctor.doctor_id')
        ->get();

       return view('appointments.calendar',$data);
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


if($request->afya_user_id==null){

$us=Afya_user::where('msisdn','=',$request->msisdn)->first();

if(is_null($us)){
$us=Afya_user::create(['msisdn'=>$request->msisdn,'firstname'=>$request->firstname,'gender'=>$request->gender,'secondName'=>$request->secondName,'file_no'=>$request->filenumber]);
$u=$us->id;
$u_id = Auth::user()->id;
$fcode=DB::table('facility_registrar')->where('user_id',$u_id)->select('facilitycode')->first();

DB::table('patient_facility')->insert([
 'afya_user_id' =>$u,
 'facility_id' => $fcode->facilitycode,
 'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]);
  }else{
 $u=$us->id;
  }

}else{
$u= $request->afya_user_id;
    }

Appointment::create(['afya_user_id'=>$u,'persontreated'=>'Self', 'appointment_date'=>$request->appointment_date, 'appointment_time'=>$request->appointment_time, 'doc_id'=>$request->doc_id, 'facility_id'=>Controller::doctor_reg_facility()->FacilityCode, 'created_by_users_id'=>Auth::user()->id]);
if($request->app_note){
DB::table('appointment_notes')->insert([
 'appointment_id' =>$request->appointment_id,
 'notes' => $request->app_note,
 'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]);
}
         if($request->email!=null){
         $subject="Appointment";
        $msg="Your appointment with ".Controller::doctor($request->doc_id)->name." for ".date('d M Y',strtotime($request->appointment_date)). " at ".$request->appointment_time." has been booked. Please avail yourself.
        Thank you!";



        $to=$request->email;
        $from='info@afyapepe.com';
        $from_name="AFyapepe";

        Controller::send_mail($from,$from_name,$to,$subject,$msg);
        }
        return redirect('calendar');
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $data['user']=Afya_user::find($id);


      $data['appointments']=Appointment::where('status','=',0)
          ->where('facility_id','=',Controller::doctor_reg_facility()->FacilityCode)
          ->get();

       $data['appointment']=DB::table('appointments')->where('afya_user_id','=',$id)->orderBy('id', 'DESC')->first();


      $data['facility'] = Controller::doctor_reg_facility();
      $data['doctors']=Facility_doctor::select('doctors.*')
         ->where('facilitycode','=',Controller::doctor_reg_facility()->FacilityCode)
         ->join('doctors','doctors.id','=','facility_doctor.doctor_id')
         ->get();

      return view('appointments.calendarreg',$data);
    }


    // public function load()
    // {
    //     $id=Session::get('afya_user_id');
    //
    //
    // }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment )
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $appointment=Appointment::find($id);

        $appointment->update([ 'filenumber'=>$request->filenumber,'appointment_date'=>$request->appointment_date, 'appointment_time'=>$request->appointment_time, 'doc_id'=>$request->doc_id,'created_by_users_id'=>Auth::user()->id]);


        return redirect('calendar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $appointment=Appointment::find($id);
        $appointment->delete();


        return redirect('calendar');
        return redirect()->action('CalendarController@show',['id'=> $request->afya_user_id]);

    }
}
