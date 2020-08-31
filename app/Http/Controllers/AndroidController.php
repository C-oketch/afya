<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Druglist;
use App\Observation;
use App\Symptom;
use App\Chief;
use Redirect;
use Carbon\Carbon;
use App\County;
use App\Http\Requests;
class AndroidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function getPatients(Request $request){
      $today = Carbon::today();

      $user=DB::table('users')->where('email', $request->email)->first();
      $facilitycode=DB::table('facility_nurse')->where('user_id', $user->id)->first();

      $patients = DB::table('appointments') 
        ->join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')       
        ->where('appointments.status','=',1)
        ->where('appointments.created_at','>=',$today)
        ->where('facility_id',$facilitycode->facilitycode)
        ->select('appointments.id','firstname','secondName','age','gender','p_status','appointments.created_at')
        ->get();

      //$parent=DB::table('afya_users')->where('id',$patient->afya_user_id)->first();

      return json_encode($patients);
    }

    public function getAllPatients(){
      $patients=DB::table('afya_users')->get();
        return json_encode($patients);
    }

    public function getWaitingList(){
      $patients = DB::table('afya_users')
        ->Join('patients', 'afya_users.id', '=', 'patients.afya_user_id')
        ->select('afya_users.firstname','afya_users.secondName','afya_users.gender','afya_users.age','afya_users.created_at')
        ->where('afya_users.status',2)
        ->get();

     return json_encode($patients);

    }

    public function showPatientDetails(Request $request){
        $id = $request->id;
        $data;
        $patient= DB::table('afya_users')
        ->where('afya_users.id',$id)
        ->first();

        $data['patient'] = $patient;

        $kin=DB::table('kin_details')
        ->Join('kin','kin_details.relation','=','kin.id')
        ->select('kin_details.*', 'kin.relation')
        ->where('kin_details.afya_user_id',$id)
        ->first();

        $data['kin'] = $kin;

        $details=DB::table('triage_details')
        ->Join('appointments','appointments.id','=','triage_details.appointment_id')
        ->where('appointments.afya_user_id',$id)
        ->select('triage_details.*')
        ->orderBy('triage_details.id','desc')
        ->get();

        $data['details'] = $details;

        $vaccines =DB::table('vaccination')
          ->Join('vaccine','vaccination.diseaseId','=','vaccine.id')
          ->select('vaccination.*', 'vaccine.*')
          ->where('vaccination.yes','=','yes')
          ->where('vaccination.userId',$id)
          ->get();

        $data['vaccines'] = $vaccines;

          return json_encode($data);

}

public function getCount(Request $request){
      $data;
      $today = Carbon::today();

      $user=DB::table('users')->where('email', $request->email)->first();
      $facilitycode=DB::table('facility_nurse')->where('user_id', $user->id)->first();

      $tp = DB::table('appointments') 
        ->join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')       
        ->where('appointments.status','=',1)
        ->where('appointments.created_at','>=',$today)
        ->where('facility_id',$facilitycode->facilitycode)
        ->select('appointments.id','firstname','secondName','age','gender','p_status','appointments.created_at')
        ->count();

      $data['tp'] = $tp;

      $patients=DB::table('afya_users')->count();

      $data['patients'] = $patients;
      
      $wl = DB::table('afya_users')
        ->Join('patients', 'afya_users.id', '=', 'patients.afya_user_id')
        ->select('afya_users.firstname','afya_users.secondName','afya_users.gender','afya_users.age','afya_users.created_at')
        ->where('afya_users.status',2)
        ->count();

      $data['wl'] = $wl;

      return json_encode($data);
    }

    public function getFee(Request $request)
    {
       $today = Carbon::today();
       $user=DB::table('users')->where('email', $request->email)->first();
           $doc_id = DB::table('facility_doctor')
           ->select('doctor_id')->where('user_id', $user->id)
           ->first();

      $doctor_id=$doc_id->doctor_id;
         $patients = DB::table('payments')
         ->Join('appointments', 'appointments.id', '=','payments.appointment_id' )
        ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
          ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
          ->select('afya_users.*','dependant.firstName as fname','dependant.secondName as sname','dependant.gender as gender',
            'dependant.dob as dob','payments.amount','payments.mode','payments.created_at as paydate','payments.status','appointments.persontreated')

     ->where([
                   ['appointments.doc_id', '=',$doctor_id],
                  ])

  ->get();

return json_encode($patients);
    }
    
}
