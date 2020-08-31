<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Claim;
use App\Afya_user;
use App\Doctor;
use App\Facility_doctor;
use App\Procedure;
use App\Facility;

class ClaimsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['claims']=Claim::select('claims.*','facilities.FacilityName')
                            ->leftJoin('facilities','claims.facility_id','=','facilities.facilitycode') 
                            ->groupBy('facilities.facilitycode')                       
                            ->get();
        return view('nhif.claims',$data);
    }

    public function facility_claims()
    {
        $facility=$_REQUEST['faci'];
        $data['claims']=Claim::select('claims.*','afya_users.firstname','afya_users.secondName','afya_users.nhif','afya_users.id as ptn','facilities.FacilityName','doctors.name as docname')
                            ->leftJoin('afya_users','claims.nhif','=','afya_users.nhif')
                            ->leftJoin('facilities','claims.facility_id','=','facilities.facilitycode')
                            ->leftJoin('doctors','claims.doc_co_id','=','doctors.id')
                            ->where('claims.facility_id','=',$facility)
                            ->get();
        return view('nhif.facility_claims',$data);
    }

   public function patient_claiming(){
    $ptn=$_REQUEST['ptn'];

    $data['patient']=Afya_user::select('afya_users.*','kin_details.kin_name','kin_details.phone_of_kin','kin.relation')
                              ->where('afya_users.id','=',$ptn)
                              ->join('kin_details','afya_users.id','=','kin_details.afya_user_id')
                              ->join('kin','kin.id','=','kin_details.relation')
                              ->first();

    return view('nhif.patient',$data);
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['users']=Afya_user::where('nhif','<>','')->get();
        $data['doctors']=Facility_doctor::select('doctors.*')
                         ->join('doctors','facility_doctor.doctor_id','=','doctors.id')
                         //->where('facility_doctor.facilitycode','=',Controller::finance_facility_code())
                         ->get();
        $data['procedures']=Procedure::all();
        //$data['facility']=Controller::finance_facility_code();

        $data['facilities']=Facility::select('facilities.*','nhif_facilities.status','nhif_facilities.id as nhif_id')
                                    ->join('nhif_facilities','nhif_facilities.facility_id','=','facilities.id')
                                    ->get();

        return view('nhif.claims_enter',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Claim::create($request->all());

        return redirect('claims');
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
}
