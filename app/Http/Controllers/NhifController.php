<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Facility;
use App\Doctor;
use App\Test;
use Session;
use App\Pharmacy;
use App\Afya_user;
use App\Appointment;
use App\Facility_doctor;
use App\Manufacturer;
use App\NhifFacility;


class NhifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $data['outpatient']=Afya_user::join('appointments','appointments.afya_user_id','=','afya_users.id')
                                       ->where('afya_users.nhif','<>','')
                                       ->groupBy('appointments.afya_user_id')
                                       ->count();

          $data['inpatient']=Afya_user::join('appointments','appointments.afya_user_id','=','afya_users.id')
                                       ->groupBy('afya_users.id')
                                       ->where('nhif','<>','')->count();
          $data['maternity']=Afya_user::join('appointments','appointments.afya_user_id','=','afya_users.id')
                                       ->groupBy('afya_users.id')
                                        ->where('nhif','<>','')->count();
          $data['radiology']=Afya_user::join('appointments','appointments.afya_user_id','=','afya_users.id')
                                       ->groupBy('afya_users.id')
                                       ->where('nhif','<>','')->count();
          $data['oncology']=Afya_user::join('appointments','appointments.afya_user_id','=','afya_users.id')
                                       ->groupBy('afya_users.id')
                                        ->where('nhif','<>','')->count();
          $data['renal']=Afya_user::join('appointments','appointments.afya_user_id','=','afya_users.id')
                                       ->groupBy('afya_users.id')
                                        ->where('nhif','<>','')->count();
          $data['faci']=Appointment::groupBy('facility_id')->count();

        return view('nhif.home',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function nhif_facilities()
    {

        $data['nhif_facilities']=Facility::select('facilities.*')
                                    ->join('appointments','appointments.facility_id','=','facilities.FacilityCode')
                                    ->get();
        $data['facilities']=Facility::all();

        return view('nhif.facility',$data);
    }


    public function nhif_facility()
    {

         $facilitycode=$_REQUEST['facilitycode'];
         $data['patients']=Afya_user::join('appointments','appointments.afya_user_id','=','afya_users.id')
                                 ->where('facility_id','=',$facilitycode)
                                 ->groupBy('afya_users.id')->count();
      $data['doctors']=Facility_doctor::where('facilitycode','=',$facilitycode)->count();
      $data['adverts']=0;
      $data['facilitycode']=$facilitycode;

        return view('nhif.faci',$data);
    }



    public function nhif_patients()
    {
         $data['patients']=Afya_user::select('afya_users.*','doctors.name')
                                    ->join('appointments','appointments.afya_user_id','=','afya_users.id')
                                    ->join('doctors','appointments.doc_id','=','doctors.id')
                                    ->groupBy('afya_users.id')
                                    ->where('nhif','<>','')->get();

        return view('nhif.patients',$data);
    }

    Public function suspend_facility($id){

      NhifFacility::find($id)->update(['status'=>'SUSPENDED']);

      return redirect('nhif-facilities');

    }

    Public function unsuspend_facility($id){

      NhifFacility::find($id)->update(['status'=>'ACTIVE']);

      return redirect('nhif-facilities');

    }

    Public function dashboard_details(){

        $data['dep']=$_REQUEST['dep'];
        $data['facilities']=Facility::select('facilities.*')
                                    ->join('appointments','appointments.facility_id','=','facilities.FacilityCode')
                                    ->groupBy('facilities.FacilityCode')
                                    ->get();

         return view('nhif.dashboard_details',$data);

    }

    public function facility_patients()
    {
        $facility=$_REQUEST['faci'];
        $data['patients']=Appointment::select('appointments.*','afya_users.firstname','afya_users.secondName','afya_users.nhif','afya_users.id as ptn','facilities.FacilityName','doctors.name as docname')
                            ->Join('afya_users','appointments.afya_user_id','=','afya_users.id')
                            ->Join('facilities','appointments.facility_id','=','facilities.FacilityCode')
                            ->Join('doctors','appointments.doc_id','=','doctors.id')
                            ->where('appointments.facility_id','=',$facility)
                            ->where('afya_users.nhif','<>','')
                            ->groupBy('appointments.afya_user_id')
                            ->get();
        return view('nhif.facility_patients',$data);
    }

    public function patient_visits()
    {
        $facility=$_REQUEST['faci'];
        $ptn=$_REQUEST['ptn'];
        $data['patients']=Appointment::select('appointments.*','afya_users.firstname','afya_users.secondName','afya_users.nhif','afya_users.id as ptn','facilities.FacilityName','doctors.name as docname')
                            ->Join('afya_users','appointments.afya_user_id','=','afya_users.id')
                            ->Join('facilities','appointments.facility_id','=','facilities.FacilityCode')
                            ->Join('doctors','appointments.doc_id','=','doctors.id')
                            ->where('appointments.facility_id','=',$facility)
                            ->where('appointments.afya_user_id','=',$ptn)
                            ->get();
        return view('nhif.patient_visits',$data);
    }

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
      NhifFacility::create($request->all());
      return redirect('nhif-facilities');
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
        NhifFacility::find($id)->delete();

      return redirect('nhif-facilities');
    }
}
