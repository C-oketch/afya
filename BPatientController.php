<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Doctor;
use Carbon\Carbon;
use Auth;
use App\Patient;
use App\Facility;
use PDF;
class BPatientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $id = Auth::id();
      $patient=DB::table('afya_users')->where('users_id',$id)->first();
      $nextkin=DB::table('kin_details')
      ->join('kin','kin.id','=','kin_details.relation')
      ->select('kin_details.kin_name','kin_details.phone_of_kin',
        'kin.relation')->where('kin_details.afya_user_id',$patient->id)->
      first();
     
       
       return json_encode(array($patient,$nextkin));
    }
    public function patientAllergies(){
      $id = Auth::id();
      $patient=DB::table('afya_users')->where('users_id',$id)->first();
      $allergies=DB::table('afya_users_allergy')
    ->Join('allergies_type','allergies_type.id','=','afya_users_allergy.allergies_type_id')
    ->Join('allergies','allergies.id','=','allergies_type.allergies_id')
    ->Select('allergies_type.name','allergies.name as Allergy','afya_users_allergy.created_at')
    ->Where('afya_users_allergy.afya_user_id','=',$patient->id)
    ->get();
    $vaccines=DB::table('vaccination')->
                         join('vaccine','vaccine.id','=','vaccination.diseaseId')->
                         select('vaccine.*','vaccination.*')
                         ->where('vaccination.userId',$patient->id)
                         ->where('vaccination.yes','=','yes')->
                         Orderby('yesdate','desc')->get();
    $triages=DB::table('triage_details')->join('appointments','appointments.id','=','triage_details.appointment_id')
                         ->select('triage_details.*')->where('appointments.afya_user_id',$patient->id)->Orderby('triage_details.updated_at','desc')->get();
    $tests=DB::table('patient_test_details')->join('patient_test','patient_test.id','=','patient_test_details.patient_test_id')->join('tests','tests.id','=','patient_test_details.tests_reccommended')->select('patient_test.*','patient_test_details.*','tests.name','tests.sub_categories_id')->where('patient_test_details.afya_user_id',$patient->id) ->get();
    $prescs=DB::table('prescription_details')->Join('diagnoses','diagnoses.id','=','prescription_details.diagnosis')->join('druglists','druglists.id','=','prescription_details.drug_id')->join('prescriptions','prescriptions.id','=','prescription_details.presc_id')->select('prescription_details.*','diagnoses.name as name','druglists.drugname as drugname','prescriptions.doc_id as doc')
                              ->where('prescription_details.afya_user_id',$patient->id)->get();
    $admits=DB::table('patient_admitted')->join('appointments','appointments.id','=','patient_admitted.appointment_id')->join('prescriptions','prescriptions.appointment_id','=','appointments.id')->join('prescription_details','prescription_details.presc_id','=','prescriptions.id')->Join('diagnoses','diagnoses.id','=','prescription_details.diagnosis')->Join('triage_details','triage_details.appointment_id','=','appointments.id')
                         ->select('patient_admitted.*','diagnoses.name as name','triage_details.chief_compliant as triage')->where('appointments.afya_user_id',$patient->id)->get();                     

      echo json_encode(array($allergies,$vaccines,$triages,$tests,$prescs,$admits));
    }

  
  public function Expenditure(){
    $id = Auth::id();
      $patient=DB::table('afya_users')->where('users_id',$id)->first();

       $expenditures=DB::table('consultation_fees')->where('afyauser_id',$patient->id)->get();


       return json_encode($expenditures);

    
  }
    

}

