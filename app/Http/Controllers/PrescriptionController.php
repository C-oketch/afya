<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;
use App\Prescription;
use App\Prescription_detail;
use Auth;
use Carbon\Carbon;
use App\Druglist;
class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function diagnoses(Request $request)
    {
    $Now = Carbon::now();
    $appointment=$request->get('appointment_id');
    $state = $request->get('state');
    $care=$request->get('care');
    $ptdid =$request->get('ptdid');
    $disease_id = $request->get('disease');


    $prevapp = DB::table('appointments')
    ->select('last_app_id')
    ->where('id',$appointment)
    ->first();
  $appointment2 = $prevapp->last_app_id;
     // Inserting  supportive care
     if ($care) {
    $supportiveCare= DB::table('patient_supp_care')->insert([
                       'name' => $care,
                       'appointment_id' => $appointment,
                          ]);
              }
// Inserting  diagnosis
$pttids= DB::table('patient_diagnosis')
->select('disease_id')
->where([['appointment_id',$appointment2],
              ['disease_id', '=',$disease_id],])
->orwhere([['appointment_id',$appointment],
    ['disease_id', '=',$disease_id],])
->first();


    if (is_null($pttids)) {
     $diagnosis= DB::table('patient_diagnosis')->insert([
                        'afya_user_id' => $request->get('afya_user_id'),
                        'disease_id' => $request->get('disease'),
                        'level' => $request->get('level'),
                        'state' => $request->get('state'),
                        'severity' => $request->get('severity'),
                        'chronic' => $request->get('chronic'),
                        'appointment_id' => $request->get('appointment_id'),
                        'date_diagnosed' => $Now,

]);
}
DB::table('appointments')->where('id', $appointment)
->update(['p_status' => 12,]);

if ($ptdid) {
DB::table('patient_test_details')
          ->where('id',$ptdid)
          ->update(['confirm'=>'Y']);
}
if ($state == 'Discharge') {
return redirect()->route('disdiagnosis', ['id' => $appointment]);
} elseif ($state =='Normal'){

  $tNY = DB::table('patient_test_details')
  ->where([['appointment_id',$appointment2],['confirm','N'],])
  ->first();
if ($tNY){
return redirect()->route('testes', ['id' => $appointment]);
}else{
return redirect()->route('medicines', ['id' => $appointment]);
}

}

}

public function quickdiag(Request $request)
{

$Now = Carbon::now();
$appointment=$request->get('appointment_id');
$ptdid =$request->get('ptdid');
$disease_id = $request->get('disease');
$afya_user_id = $request->get('afya_user_id');



// Inserting  diagnosis
$pttids= DB::table('patient_diagnosis')
->select('disease_id')
->where([['appointment_id',$appointment],
          ['disease_id', '=',$disease_id],])
->first();


if (is_null($pttids)) {


    foreach($disease_id as $key =>$diag) {
 $diagnosis= DB::table('patient_diagnosis')->insert([
                    'afya_user_id' => $afya_user_id,
                    'disease_id' => $diag,
                    'appointment_id' =>$appointment,
                    'date_diagnosed' => $Now,
]);
}
}

return redirect()->route('medicines', ['id' => $appointment]);
}





public function confradiology(Request $request)
{
  $Now = Carbon::now();
$appointment=$request->appointment_id;
$state = $request->state;
$notes =$request->note;
$radiology =$request->radiology;
$rtdid =$request->rtdid;

if ($radiology) {
 $diagnosis= DB::table('patient_diagnosis')->insert([
                    'state' => $state,
                    'radiology' => $radiology,
                    'notes'=> $notes,
                    'appointment_id' => $appointment,
                    'date_diagnosed' => $Now,

]);
}
DB::table('appointments')->where('id', $appointment)
->update(['p_status' => 12,]);

if ($rtdid) {
DB::table('radiology_test_details')
      ->where('id',$rtdid)
      ->update(['confirm'=>'Y']);
}
return redirect()->route('alltestes', ['id' => $appointment]);
}

public function Diagnosis($id)
{
  $data['pdetails'] =DB::table('appointments')
  ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
  ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
  ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
  ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
  ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
    'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
    'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
  ->where('appointments.id',$id)
  ->first();

  $data['imp']= DB::table('impression')->where('appointment_id',$id)->get();

  $data['condy']=DB::table('patient_diagnosis')
  ->Where('appointment_id',$id)
 ->select('patient_diagnosis.id','patient_diagnosis.disease_id as name','patient_diagnosis.date_diagnosed')
 ->get();

  return view('doctor.diagnosis',$data);

}


    public function prescriptions($id)
    {
      $data['pdetails'] =DB::table('appointments')
      ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
      ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
      ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
        'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
        'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
      ->where('appointments.id',$id)
      ->first();

      $data['Pdiagnosis']=DB::table('patient_diagnosis')
      ->Where('appointment_id',$id)
     ->select('patient_diagnosis.id as diagId','patient_diagnosis.disease_id as name','patient_diagnosis.date_diagnosed')
     ->get();



      $cript =DB::table('appointments')
      ->leftjoin('prescriptions','prescriptions.appointment_id','=','appointments.id')
     ->select('prescriptions.id','appointments.afya_user_id')
     ->where('appointments.id',$id)->first();

      $data['allpresczs'] =DB::table('prescription_details')
    ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
    // ->join('druglists','prescription_details.drug_id','=','druglists.id')
     ->join('appointments','prescriptions.appointment_id','=','appointments.id')
     ->leftjoin('patient_diagnosis','prescription_details.diagnosis','=','patient_diagnosis.id')
     // ->leftjoin('icd10_option','patient_diagnosis.disease_id','=','icd10_option.id')
      ->select('prescription_details.id as presc_details_id','prescription_details.created_at','prescription_details.drug_id','patient_diagnosis.disease_id as name','prescriptions.id as prescid','appointments.id as appsId')
      ->where([['appointments.afya_user_id',$cript->afya_user_id],['prescription_details.deleted',0]])
      ->orderBy('prescription_details.created_at','Desc')
      ->get();

      return view('doctor.prescription',$data)->with('cript',$cript);

    }

    public function procedures($id)
    {
      $pdetails =DB::table('appointments')
      ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
      ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
      ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
      ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
      ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
        'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
        'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
      ->where('appointments.id',$id)
      ->first();

      $Pdiagnosis=DB::table('patient_diagnosis')
      ->leftjoin('icd10_option','patient_diagnosis.disease_id','=','icd10_option.id')
      ->leftjoin('severity','patient_diagnosis.severity','=','severity.id')
      ->select('icd10_option.name','patient_diagnosis.level','patient_diagnosis.id as diag_id',
      'severity.name as severity','icd10_option.id')

      ->where([
                    ['patient_diagnosis.appointment_id',$id],
                    ['patient_diagnosis.state', '=', 'Normal'],

                   ])
      ->get();

      return view('doctor.procedure')->with('pdetails',$pdetails)->with('Pdiagnosis',$Pdiagnosis);

    }

    /**
     *
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

   protected function store(Request $request)
   {
    $appid=$request->appId;
    $facility_id=$request->facility;

  $pttids= Prescription::where('appointment_id',$appid)
       ->first();

      if (is_null($pttids)) {
      //  - add new
      $Prescription=Prescription::create([
           'appointment_id' => $appid,
           'facility_id' =>$facility_id,
           'filled_status' => 0,  ]);
      $id=$Prescription->id;




      } else {
      // Already exist - get the id the existing
       $id =$pttids->id;
      }

$drug=$request->drug;
$state =$request->state;
$diagnosisId =$request->disease_id;
$afya_user_id = $request->afya_user_id;


if ($drug)  {
  foreach($drug as $key =>$presc) {

    $insertedId = DB::table('prescription_details')->insert([
           'presc_id' => $id,
           'diagnosis' => $diagnosisId,
           'state' => $state,
           'drug_id' => $presc,
           'is_filled' => 0,
           'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
       ]);
  }
}
    return redirect()->action('PrescriptionController@prescriptions', ['id' => $appid]);

   }
   protected function store2F(Request $request)
   {
  $appid=$request->appId;

     $u_id = Auth::user()->id;
     $facility2 = DB::table('facility_doctor')
     ->select('facilitycode','doctor_id')->where('user_id', $u_id)->first();

     $facility =$facility2->facilitycode;
     $doc_id =$facility2->doctor_id;


  $pttids= Prescription::where('appointment_id',$appid)
       ->first();

      if (is_null($pttids)) {
      //  - add new
      $Prescription=Prescription::create([
           'appointment_id' => $appid,
           'facility_id' =>$facility,
           'filled_status' => 0,  ]);
      $id=$Prescription->id;
  } else {
      // Already exist - get the id the existing
       $id =$pttids->id;
      }

$drug=$request->drug_id;
$state ='Normal';
$diagnosisId =$request->condition;
$notes =$request->notes;


if ($drug)  {


   DB::table('prescription_details')->insert([
           'presc_id' => $id,
           'diagnosis' => $diagnosisId,
           'state' => $state,
           'drug_id' => $drug,
           'note' => $notes,
           'is_filled' => 0,
           'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
       ]);

}
     return redirect()->action('PrescriptionController@prescriptions', ['id' => $appid]);
   //  $data =DB::table('druglists')
   //           ->select('id','drugname','Ingridients')
   //          ->get();
   //
   // return response()->json($data);

   }






   public function destroypresc($id)
   {
     $pttd=DB::table('prescription_details')
     ->Join('prescriptions', 'prescription_details.presc_id', '=', 'prescriptions.id')
     ->select('prescriptions.appointment_id')
     ->where('prescription_details.id',$id)
     ->first();
$appid =$pttd->appointment_id;
     //DB::table("prescription_details")->where('id',$id)->delete();
     DB::table("prescription_details")->where('id',$id)->update(array('deleted'=>1));

    return redirect()->action('PrescriptionController@prescriptions', ['id' => $appid]);

    }

          //ADD Patient Procedures
          public function addproc(Request $request)
            {

              $proc_id=$request->proc_id;
              $appId=$request->appId;
              $notes=$request->notes;
              $status=$request->status;

            $proc = DB::table('patient_procedure')->insert([
                  'appointment_id'=>$appId,
                   'procedure_id'=>$proc_id,
                   'notes'=>$notes,
                   'status'=>$status,
                   ]);

           $data =DB::table('procedures')
                    ->select('id','code','icd10_codes','description')
                    ->where('procedures.id',$proc_id)
                    ->first();

          return response()->json($data);
            }

            //ADD Patient Procedures
            public function editproc(Request $request)
              {

                $proc_id=$request->id;
                $docId=$request->doc_id;
                $status=$request->stat;
                $dat2=$request->datp;

                DB::table('patient_procedure')
                          ->where('id', $proc_id)
                          ->update([
                            'doc_id' => $docId,
                            'status'=> $status,
                            'procedure_date'=>$dat2
                          ]);

             $data =DB::table('patient_procedure')
                      ->leftjoin('procedures','patient_procedure.procedure_id','=','procedures.id')
                      ->select('patient_procedure.id','patient_procedure.created_at','patient_procedure.notes','patient_procedure.procedure_date',
                      'patient_procedure.status','procedures.code','procedures.icd10_codes','procedures.description')
                        ->where('patient_procedure.id',$proc_id)
                      ->first();

            return response()->json($data);
              }
              public function deleteproc(Request $request)
                {
                  $proc_id=$request->id;
                  $data =DB::table('patient_procedure')
                           ->leftjoin('procedures','patient_procedure.procedure_id','=','procedures.id')
                           ->select('patient_procedure.id','patient_procedure.created_at','patient_procedure.notes','patient_procedure.procedure_date',
                           'patient_procedure.status','procedures.code','procedures.icd10_codes','procedures.description')
                             ->where('patient_procedure.id',$proc_id)
                           ->first();
   $delete=DB::table('patient_procedure')->where('id', $proc_id)->delete();

                  return response()->json($data);
                  }

                  public function allPosts(Request $request)
                      {

                          $columns = array(
                                              0 =>'id',
                                              1 =>'drugname',
                                              2=> 'Ingridients',
                                              3=> 'strength_perdose',
                                              4=> 'Manufacturer',
                                          );

                          $totalData = Prescription::count();

                          $totalFiltered = $totalData;

                          $limit = $request->input('length');
                          $start = $request->input('start');
                          $order = $columns[$request->input('order.0.column')];
                          $dir = $request->input('order.0.dir');

                          if(empty($request->input('search.value')))
                          {
                              $posts = Prescription::offset($start)
                                           ->limit($limit)
                                           ->orderBy($order,$dir)
                                           ->get();
                          }
                          else {
                              $search = $request->input('search.value');

                              $posts =  Post::where('id','LIKE',"%{$search}%")
                                              ->orWhere('drugname', 'LIKE',"%{$search}%")
                                              ->offset($start)
                                              ->limit($limit)
                                              ->orderBy($order,$dir)
                                              ->get();

                              $totalFiltered = Post::where('id','LIKE',"%{$search}%")
                                               ->orWhere('drugname', 'LIKE',"%{$search}%")
                                               ->count();
                          }

                          $data = array();
                          if(!empty($posts))
                          {
                              foreach ($posts as $post)
                              {
                                  $show =  route('posts.show',$post->id);
                                  $edit =  route('posts.edit',$post->id);

                                  $nestedData['id'] = $post->id;
                                  $nestedData['drugname'] = $post->drugname;
                                  $nestedData['Ingridients'] = substr(strip_tags($post->Ingridients),0,50)."...";
                                  $nestedData['strength_perdose'] = $post->strength_perdose;
                                  $nestedData['Manufacturer'] = $post->Manufacturer;
                                  $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                                  $data[] = $nestedData;

                              }
                          }

                          $json_data = array(
                                      "draw"            => intval($request->input('draw')),
                                      "recordsTotal"    => intval($totalData),
                                      "recordsFiltered" => intval($totalFiltered),
                                      "data"            => $data
                                      );

                          echo json_encode($json_data);

                      }


      public function prescdetails($id)
        {
$prescriptions =DB::table('prescriptions')
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
            ->where('prescriptions.id',$id)
             ->get();

          $usedetails=DB::table('prescriptions')
                ->join('appointments','prescriptions.appointment_id','=','appointments.id')
                ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                ->select('appointments.id as appid','appointments.persontreated','appointments.afya_user_id','facilities.FacilityName',
                'doctors.name as docname','prescriptions.created_at')
                ->where('prescriptions.id',$id)
                ->first();
    return view('doctor.done.prscdetails')->with('prescriptions',$prescriptions)->with('usedetails',$usedetails);
    }


          public function prescdetails2($id)
            {
    $prescriptions =DB::table('prescriptions')
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
                ->where('prescriptions.id',$id)
                 ->get();

              $usedetails=DB::table('prescriptions')
                    ->join('appointments','prescriptions.appointment_id','=','appointments.id')
                    ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                    ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                    ->select('appointments.id as appid','appointments.persontreated','appointments.afya_user_id','facilities.FacilityName',
                    'doctors.name as docname','prescriptions.created_at')
                    ->where('prescriptions.id',$id)
                    ->first();
        return view('doctor.done.prscdetails2')->with('prescriptions',$prescriptions)->with('usedetails',$usedetails);
        }
        public function printpresc($id)
          {
            $u_id = Auth::user()->id;
            $facility = DB::table('facility_doctor')->select('facilitycode')->where('user_id', $u_id)->first();
            $facility =$facility->facilitycode;

            $data['receipt'] = DB::table('appointments')
                     ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
                     ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
                     ->leftJoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
                     ->leftjoin('facility_doctor', 'facility_doctor.doctor_id', '=', 'doctors.id')
                     ->leftjoin('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
                     ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
                     ->select('afya_users.id as afyaId','afya_users.firstname', 'afya_users.secondName', 'dependant.firstName as dep_fname','dependant.secondName as dep_lname',
                     'doctors.name AS doc_name','doctors.subspeciality', 'facilities.FacilityName','patient_admitted.condition',
                     'appointments.id as appid', 'appointments.persontreated', 'appointments.appointment_date')
                     ->where([
                       ['appointments.id', '=', $id],
                     ])
                     ->first();


                     $data['presczs'] =DB::table('prescriptions')
                    ->join('prescription_details','prescriptions.id','=','prescription_details.presc_id')
                    // ->join('druglists','prescription_details.drug_id','=','druglists.id')
                    ->leftjoin('icd10_option','prescription_details.diagnosis','=','icd10_option.id')
                     ->select('prescription_details.id as presc_details_id','prescription_details.drug_id',
                     'icd10_option.name','icd10_option.id','prescriptions.id as prescid','prescription_details.note')
                     ->where([['prescriptions.appointment_id',$id],['prescription_details.deleted',0]])
                     ->get();

                     $data['prb'] =DB::table('prescriptions')->select('id','created_at')->where('prescriptions.appointment_id',$id)
                     ->first();

            return view('doctor.prscprint',$data);
          }

public function reccomendation($id)
  {
    // $u_id = Auth::user()->id;
    // $facility = DB::table('facility_doctor')->select('facilitycode')->where('user_id', $u_id)->first();
    // $facility =$facility->facilitycode;

    $data['pdetails'] =DB::table('appointments')
    ->leftjoin('afya_users','appointments.afya_user_id','=','afya_users.id')
    ->leftjoin('dependant','appointments.persontreated','=','dependant.id')
    ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
    ->leftjoin('facilities','appointments.facility_id','=','facilities.FacilityCode')
    ->select('appointments.*','afya_users.firstname','afya_users.dob','afya_users.secondName','afya_users.gender',
      'dependant.firstName as dep1name','dependant.secondName as dep2name','dependant.gender as depgender',
      'dependant.dob as depdob','facilities.FacilityName','facilities.set_up','patient_admitted.condition')
    ->where('appointments.id',$id)
    ->first();

    return view('doctor.reccomendation',$data);
  }

  protected function storeRecomendation(Request $request)
  {
   $appid=$request->appId;
   $reco=$request->reco;
 if ($reco)  {
 foreach($reco as $key =>$presc) {

   $insertedId = DB::table('patient_recommendation')->insert([
          'appointment_id' => $appid,
          'notes' => $presc,
          'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
          'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
      ]);
 }
 }
   return redirect()->action('PrescriptionController@prescriptions', ['id' => $appid]);
  }




}
