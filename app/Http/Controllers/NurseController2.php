<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;

use Carbon\Carbon;
use App\Http\Requests;
class NurseControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
         $this->middleware('auth');
     }
    public function index()
    {
      $patients=DB::table('afya_users')->get();
      return view('nurse.home')->with('patients',$patients);
    }
    public function nurseUpdate($id){

      return view('nurse.nurseupdate')->with('id',$id);
    }
     public function showDependents($id)
    {
        
        return view('nurse.show2')->with('id',$id);
    }

   public function nurseUpdates(Request  $request){
     $id=$request->id;
     $blood=$request->blood;
     $constituency=$request->constituency;
     $phone=$request->phone;

     DB::table('afya_users')->where('id', $id)
                 ->update([
                                  'blood_type' =>  $blood,
                                  'constituency' => $constituency,
                                  'msisdn'=>$phone,
                                  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                  'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                                ]);


return Redirect::route('nurse.show', [$id]);

   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nurse.create');

    }

    public function wList(){
      $patients = DB::table('afya_users')
        ->Join('patients', 'afya_users.id', '=', 'patients.afya_user_id')
        ->select('afya_users.*')
        ->where('afya_users.status',2)
        ->get();

     return view('nurse.waitingList')->with('patients',$patients);

    }

    public function newPatient(){
        $today = Carbon::today();
      $patients = DB::table('afya_users')
        ->Join('patients', 'afya_users.id', '=', 'patients.afya_user_id')
        ->select('afya_users.*')
        ->where('afya_users.status',1)
        ->where('patients.created_at','>=',$today)

        ->get();
        return view('nurse.newpatient')->with('patients',$patients);
    }
    public function createnextkin($id){



      return view ('nurse.createkin')->with('id',$id);
    }

    public function nextkin (Request $request){

     $phone=$request->phone;
     $name=$request->name;
     $relationship=$request->relationship;
     $id=$request->id;

    DB::table('kin_details')->insert(
    ['kin_name' => $name,
    'relation' => $relationship,
    'phone_of_kin'=> $phone,
    'afya_user_id'=>$id,
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
);
     return Redirect::route('nurse.show', [$id]);

    }

    public function vaccinescreate($id){
        return view('nurse.vaccine')->with('id',$id);
    }

    public function vaccine(Request $request){
    $id=$request->id;
    $diseases=$request->diseases;
    $vaccinename=$request->vaccinename;
    $type=$request->type;
    $date=$request->date;


   DB::table('vaccination')->insert(
    ['userId' => $id,
    'diseaseId' => $diseases,
    'vaccine_name'=> $vaccinename,
    'Yes'=>$type,
    'Created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'yesdate' => \Carbon\Carbon::now()->toDateTimeString()]
);



    return Redirect::route('nurse.show', [$id]);

    }

    public function details($id){

        return view('nurse.details')->with('id',$id);

    }

    public function createdetails(Request $request)
    {
        $id=$request->id;
        $pregnant=$request->pregnant;
        $weight=$request->weight;
        $heightS=$request->current_height;
        $temperature=$request->temperature;
        $systolic=$request->systolic;
        $diastolic=$request->diastolic;
        $allergies=$request->allergies;
        $chiefcompliant=$request->chiefcompliant;
        $observation=$request->observation;
        $nurse=$request->nurse;
        $doctor=$request->doctor;

    DB::table('triage_details')->insert(
    ['patient_id' => $id,
    'facility_id' => 19310,
    'current_weight'=> $weight,
    'current_height'=>$heightS,
    'temperature'=>$temperature,
    'systolic_bp'=>$systolic,
    'diastolic_bp'=>$diastolic,
    'chief_compliant'=>$chiefcompliant,
    'observation'=>$observation,
    'consulting_physician'=>$nurse,
    'Doctor_note'=>'',
    'prescription'=>'',
    'pregnant'=>$pregnant,
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]

);
DB::table('appointments')->insert(
['afya_user_id' => $id,
'status'=>1,
'facility_id'=>19310,
'doc_id'=>$doctor,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]

);


        return Redirect::route('nurse.show', [$id]);
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
    public function Calendar(){
    return view('nurse.calendar');
    }
    public function Appointment()
    {
      return view('nurse.appointment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $patient= DB::table('afya_users')
        ->Join('patients', 'afya_users.id', '=', 'patients.afya_user_id')
        ->select('afya_users.*')
        ->where('afya_users.id',$id)
        ->first();

        $kin=DB::table('kin_details')
        ->Join('kin','kin_details.relation','=','kin.id')
        ->select('kin_details.*', 'kin.relation')
        ->where('kin_details.afya_user_id',$id)
        ->first();
        $details=DB::table('triage_details')
        ->where('triage_details.appointment_id',$id)
        ->orderby('updated_at','desc')
        ->get();

        $vaccines =DB::table('vaccination')
          ->Join('diseases','vaccination.diseaseId','=','diseases.id')
          ->select('vaccination.*', 'diseases.name')
          ->where('vaccination.userId',$id)
          ->get();
          return view('nurse.show')->with('patient',$patient)->with('vaccines',$vaccines)->with('kin',$kin)->with('details',$details);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $patient= DB::table('afya_users')
        ->Join('patients', 'afya_users.id', '=', 'patients.afya_user_id')
        ->select('afya_users.*', 'patients.allergies')
        ->where('afya_users.id',$id)
        ->first();



     return view('nurse.edit',compact('patient'));
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
    $name=$request->name;
    $idno=$request->idno;
    $relationship=$request->relationship;
    $phone=$request->phone;
    $weight=$request->weight;
    $temperature=$request->temperature;
    $systolic=$request->systolic;
    $diastolic=$request->diastolic;
    $height=$request->current_height;
    $nurse=$request->nurse;
    $chief=$request->chiefcompliant;
    $observation=$request->observation;
    $doctor=$request->doctor;
    $diseases=$request->diseases;
    $vaccines=$request->vaccinename;
    $yes=$request->yes;
    $date=$request->dates;

DB::table('patients')->where('id', $id)
            ->update(
                       array(
                             'next_kin' => $name,
                             'nextkinID' => $idno,
                             'relation_kin' => $relationship,
                             'phone_kin' => $phone,
                             'current_weight' => $weight,
                             'temperature' => $temperature,
                             'systolic_bp' => $systolic,
                             'diastolic_bp' => $diastolic,
                             'current_height' => $height,
                             'nurse_note' => $nurse,
                             'chief_compliant' => $chief,
                             'observation'=> $observation,
                             'consulting_physician'=> $doctor

                             )
                       );
      DB::table('vaccination')->insert(
    ['userId' => $id,
     'diseaseId' =>$diseases,
     'vaccine_name'=>$vaccines,
     'Yes'=>$yes,
     'yesdate'=>$date
   ]
);




    return Redirect::route('nurse.show', [$id]);

    }

    public function patient(Request $request, $id)
    {
        return 'awesome';

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
