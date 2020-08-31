<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Auth;
use Carbon\Carbon;
use App\Afya_user;


class DoctorController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

public function DashboardPrivate()
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

return view('private.dashboard')->with('doc',$doc)->with('oldest',$oldest)->with('youngest',$youngest);

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
