<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Redirect;
use App\Doctor;
use App\Testprice;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Auth;



class FacilityAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $admin= DB::table('facility_admin')
        ->Join('facilities', 'facility_admin.facilitycode', '=', 'facilities.FacilityCode')
        ->where('facility_admin.user_id', '=', Auth::user()->id)
        ->select('facilities.FacilityName','facilities.Type','facility_admin.facilitycode')
        ->first();
        // Auth::user()->id
// dd(Auth::user()->id);
    $facility_id= $admin->facilitycode;

    $youngest= DB::table('afya_users')
    ->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
    ->where([['appointments.facility_id', '=',$facility_id]])
    ->whereNotNull('afya_users.dob')
    ->select('afya_users.dob','afya_users.firstname','afya_users.secondName')
    ->orderby('afya_users.dob', 'DESC')
    ->first();
    $oldest= DB::table('afya_users')
    ->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
    ->where([['appointments.facility_id', '=',$facility_id]])
    ->whereNotNull('afya_users.dob')
    ->select('afya_users.dob','afya_users.firstname','afya_users.secondName')
    ->orderby('afya_users.dob', 'ASC')
    ->first();




  return view('facilityadmin.index')->with('admin',$admin)->with('oldest',$oldest)->with('youngest',$youngest);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function facilityregister(){
      $facilitycode=DB::table('facility_admin')->where('user_id', Auth::id())->first();
      $data['facilities']=DB::table('facility_registrar')
      ->join('practice','facility_registrar.practice','=','practice.id')
      ->join('users','users.id','=','facility_registrar.user_id')
      ->join('facilities','facilities.FacilityCode','=','facility_registrar.facilitycode')
      ->select('users.name as name','facility_registrar.regno as regno','practice.name','facilities.*')
      ->where('facility_registrar.facilitycode',$facilitycode->facilitycode)
      ->get();

        return view('facilityadmin.register',$data);
    }

    public function addfacilityregister(){
        return view('facilityadmin.addregister');
    }
    public function facilityusers(){
      $facility = DB::table('facility_admin')
                ->join('facilities','facility_admin.facilitycode','=','facilities.FacilityCode')
                ->select('facility_admin.facilitycode','facilities.set_up','facilities.payment')
                ->where('user_id', Auth::id())
                ->first();
      $facilitycode = $facility->facilitycode;
      $fsetup = $facility->set_up;

  $data['reg']=DB::table('facility_registrar')->distinct('user_id')->where('facilitycode', $facilitycode)->count('user_id');
  $data['nurse']=DB::table('facility_nurse')->distinct('user_id')->where('facilitycode', $facilitycode)->count('user_id');
  $data['doc']=DB::table('facility_doctor')->distinct('user_id')->where('facilitycode', $facilitycode)->count('user_id');
  $data['co']=DB::table('facility_officer')->distinct('user_id')->where('facilitycode', $facilitycode)->count('user_id');
  $data['finance']=DB::table('facility_finance')->distinct('user_id')->where('facilitycode', $facilitycode)->count('user_id');

        return view('facilityadmin.facilityusers',$data);
    }

    // public function addregistrar(Request $request){
    //
    // }

    public function store(Request $request)
    {
        $name=$request->name;
        $email=$request->email;
        $role=$request->role;
        $regno=$request->regno;
        $password=bcrypt($request->password);
        $facility=$request->facility;
        $practice=$request->practice;

        $userid=DB::table('users')->insertGetId([
            'name'=>$name,
            'email'=>$email,
            'role'=>$role,
            'password'=>$password,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('facility_registrar')->insert([
            'user_id'=>$userid,
            'regno'=>$regno,
            'facilitycode'=>$facility,
            'practice'=>$practice,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('role_user')->insert([
            'user_id'=>$userid,
            'role_id'=>9
            ]);

        return  Redirect()->action('FacilityAdminController@facilityregister');
    }

    public function facilitynurse(){

        return view('facilityadmin.nurse');
    }

public function storenurse(Request $request){

    $name=$request->name;
        $email=$request->email;
        $role=$request->role;
        $regno=$request->regno;
        $password=bcrypt($request->password);
        $facility=$request->facility;

        $userid=DB::table('users')->insertGetId([
            'name'=>$name,
            'email'=>$email,
            'role'=>$role,
            'password'=>$password,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('facility_nurse')->insert([
            'user_id'=>$userid,
            'regno'=>$regno,
            'facilitycode'=>$facility,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('role_user')->insert([
            'user_id'=>$userid,
            'role_id'=>4
            ]);

        return  Redirect()->action('FacilityAdminController@facilitynurse');
}
 public function facilitydoctor(){

    return view('facilityadmin.doctor');
 }

 public function laboratory(){

    return view('facilityadmin.lab');
 }

public function storelabtech(Request $request){
        $name=$request->name;
        $email=$request->email;
        $role=$request->role;
        $password=bcrypt($request->password);
        $facility=$request->facility;


        $userid=DB::table('users')->insertGetId([
            'name'=>$name,
            'email'=>$email,
            'role'=>$role,
            'password'=>$password,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('facility_test')->insert([
            'user_id'=>$userid,
            'firstname'=>$request->get('firstname'),
            'secondname'=>$request->get('lastname'),
            'address'=>$request->get('address'),
            'phone'=>$request->get('phone'),
            'department'=>$request->get('department'),
            'speciality'=>$request->get('speciality'),
            'qualification'=>$request->get('qualification'),
            'facilitycode'=>$facility,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('role_user')->insert([
            'user_id'=>$userid,
            'role_id'=>7  ]);


        return  Redirect()->action('FacilityAdminController@laboratory');


 }
 public function storedoctor(Request $request){
        $name=$request->name;
        $email=$request->email;
        $role=$request->role;
        $password=bcrypt($request->password);
        $facility=$request->facility;
        $doc=$request->doc;
        $userid=DB::table('users')->insertGetId([
            'name'=>$name,
            'email'=>$email,
            'role'=>$role,
            'password'=>$password,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('facility_doctor')->insert([
            'user_id'=>$userid,
            'doctor_id'=>$doc,
            'facilitycode'=>$facility,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('role_user')->insert([
            'user_id'=>$userid,
            'role_id'=>2
            ]);
        DB::table('doctors')->where('id',$doc)
         ->limit(1)->update([
            'user_id'=>$userid]);

        return  Redirect()->action('FacilityAdminController@facilitydoctor');


 }

 public function facilityofficer(){

    return view('facilityadmin.officers');
 }

 public function consltfee(){

   $data['fac_fee'] = DB::table('facility_admin')
   ->join('consultation_fees', 'facility_admin.facilitycode', '=', 'consultation_fees.facility_code')
   ->select('consultation_fees.old_consultation_fee as old', 'consultation_fees.new_consultation_fee as new','consultation_fees.medical_report_fee')
   ->where('facility_admin.user_id', Auth::user()->id)
   ->first();

   $today = Carbon::today();
   $dat =$today->toDateString();

   $date1 = Carbon::now();
   $date2 = Carbon::now();
   $date3 = Carbon::now();
   $endweek= $date1->endOfWeek();
   $datw =$endweek->toDateString();

   $startmonth=$date2->startOfMonth();
   $datmm =$startmonth->toDateString();
   $endmonth= $date3->endOfMonth();
   $datm =$endmonth->toDateString();

   // dd($datm);

   $category_id = DB::table('payments_categories')
   ->where('payments_categories.category_name', '=', 'Consultation fee')
   ->first();
   $cat_id = $category_id->id;
   $facility=DB::table('facility_admin')->where('user_id', Auth::user()->id)->first();

   $data['feesdaily']=DB::table('payments')
   ->leftJoin('appointments', 'appointments.id', '=','payments.appointment_id' )
   ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
   ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
   ->select('afya_users.*','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
   'dependant.dob as Infdob','payments.amount','payments.id as payment_id','payments.mode','payments.created_at as paydate','appointments.persontreated',
   'appointments.id AS app_id')
   ->where([
     ['payments.amount', '<>', 'None'],
     ['appointments.facility_id', '=', $facility->facilitycode],
   ])
   ->whereDate('payments.created_at','=',$dat)
   ->groupBy('payments.appointment_id')
   ->get();

   $data['wekexp1']=DB::table('payments')
   ->join('appointments','appointments.id','=','payments.appointment_id')
   ->where('appointments.facility_id', '=', $facility->facilitycode)
   ->whereDate('payments.created_at','=',$dat)
   ->sum('amount');

   $data['feesmonth'] = DB::table('payments')
   ->Join('appointments', 'appointments.id', '=','payments.appointment_id' )
   ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
   ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
   ->select('afya_users.*','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
   'dependant.dob as Infdob','payments.amount','payments.id as payment_id','payments.mode','payments.created_at as paydate','appointments.persontreated',
   'appointments.id AS app_id')
   ->where([
     ['payments.amount', '<>', 'None'],
     ['payments.created_at','>=',$datmm],
     ['payments.created_at','<=',$datm],
     ['appointments.facility_id', '=', $facility->facilitycode],
   ])
   ->groupBy('payments.appointment_id')
   ->get();

   $data['wekexp2']=DB::table('payments')
   ->join('appointments','appointments.id','=','payments.appointment_id')
   ->where([  ['appointments.facility_id', '=', $facility->facilitycode],
   ['payments.created_at','>=',$datmm],
   ['payments.created_at','<=',$datm],
   ])
   ->sum('amount');

   $data['fees'] = DB::table('payments')
   ->Join('appointments', 'appointments.id', '=','payments.appointment_id' )
   ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
   ->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
   ->select('afya_users.*','dependant.firstName as Infname','dependant.secondName as InfName','dependant.gender as Infgender',
   'dependant.dob as Infdob','payments.amount','payments.id as payment_id','payments.mode','payments.created_at as paydate','appointments.persontreated',
   'appointments.id AS app_id')
   ->where([
   ['payments.amount', '<>', 'None'],
   ['appointments.facility_id', '=', $facility->facilitycode],
   ])
   ->groupBy('payments.appointment_id')
   ->get();

   $data['newp']=DB::table('payments')
   ->where([['facility', '=', $facility->facilitycode],['payments_category_id',1],['amount',2000]])->sum('amount');
   $data['exip']=DB::table('payments')
   ->where([['facility', '=', $facility->facilitycode],['payments_category_id',1],['amount',1500]])->sum('amount');
   $data['Texip']=DB::table('payments')
   ->where([['facility', '=', $facility->facilitycode],['payments_category_id',1]])->sum('amount');
   $data['lab']=DB::table('payments')
   ->where([['facility', '=', $facility->facilitycode],['payments_category_id',2]])->sum('amount');
   $data['rad']=DB::table('payments')
   ->where([['facility', '=', $facility->facilitycode],['payments_category_id',3]])->sum('amount');
   $data['mrip']=DB::table('payments')
   ->where([['facility', '=', $facility->facilitycode],['payments_category_id',4]])->sum('amount');

    return view('facilityadmin.consltfee',$data)->with('facility',$facility);
 }

 public function storeofficer(Request $request){

     $name=$request->name;
        $email=$request->email;
        $role=$request->role;
        $regno=$request->regno;
        $regdate=$request->regdate;
        $address=$request->address;
        $qualify=$request->qualify;
        $speciality=$request->speciality;
        $sub=$request->sub_speciality;
        $password=bcrypt($request->password);
        $facility=$request->facility;

        $userid=DB::table('users')->insertGetId([
            'name'=>$name,
            'email'=>$email,
            'role'=>$role,
            'password'=>$password,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('facility_officer')->insert([
            'user_id'=>$userid,
            'regno'=>$regno,
            'facilitycode'=>$facility,
            'regdate'=>$regdate,
            'address'=>$address,
            'qualification'=>$qualify,
            'speciality'=>$speciality,
            'sub_speciality'=>$sub,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('role_user')->insert([
            'user_id'=>$userid,
            'role_id'=>2
            ]);

        return  Redirect()->action('FacilityAdminController@facilityofficer');

 }

 public function setfees(Request $request){


        $new=$request->new;
        $old=$request->old;
        $med_report =$request->med_report;
        $fac = DB::table('facility_admin')
        ->leftJoin('consultation_fees', 'facility_admin.facilitycode', '=', 'consultation_fees.facility_code')
        ->select('facility_admin.facilitycode','consultation_fees.facility_code')
        ->where('facility_admin.user_id', Auth::user()->id)->first();

        $facility=$fac->facilitycode;
        $feecode=$fac->facility_code;


if($feecode){
  DB::table('consultation_fees')->where('facility_code',$feecode)
  ->update([
    'new_consultation_fee'=>$new,
    'old_consultation_fee'=>$old,
    'medical_report_fee'=>$med_report,
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]);
}else{
$userid=DB::table('consultation_fees')->insert([
'facility_code'=>$facility,
'new_consultation_fee'=>$new,
'old_consultation_fee'=>$old,
'medical_report_fee'=>$med_report,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
]);
}
$data['fac_fee'] = DB::table('facility_admin')
->join('consultation_fees', 'facility_admin.facilitycode', '=', 'consultation_fees.facility_code')
->select('consultation_fees.old_consultation_fee as old', 'consultation_fees.new_consultation_fee as new')->where('facility_admin.user_id', Auth::user()->id)
->first();

return  Redirect()->action('FacilityAdminController@consltfee');
 }


 public function createdoc(){
  return view('facilityadmin.createdoc');
 }

public function finddoc(Request $request){

      $term = trim($request->q);
      if (empty($term)) {
           return \Response::json([]);
         }
       $drugs = Doctor::search($term)->limit(100)->get();
         $formatted_drugs = [];
          foreach ($drugs as $drug) {
             $formatted_drugs[] = ['id' => $drug->id, 'text' => $drug->name];
         }
     return \Response::json($formatted_drugs);
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
     public function labtech($id)
     {
$labtechs=DB::table('facility_test')->where('user_id',$id)
->first();
       return view('facilityadmin.labtechupdate')->with('labtechs',$labtechs);
   }
  public function uplabtech(Request $request){


    $userid = $request->user_id;
    $address = $request->address;
    $phone = $request->phone;
    $department = $request->department;
    $speciality = $request->speciality;
    $qualification = $request->qualifications;
  DB::table('facility_test')
            ->where('user_id',$userid)
            ->update(['department'=>$department,
            'address'=>$address,
            'phone'=>$phone,
                  ]);

return  Redirect()->action('FacilityAdminController@laboratory');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroylabtech($id)
    {
      DB::table("facility_test")->where('user_id',$id)->delete();
      DB::table("users")->where('id',$id)->delete();
      DB::table("role_user")->where('user_id',$id)->delete();
   return  Redirect()->action('FacilityAdminController@laboratory')
    ->with('success','Record deleted successfully');
         }
         public function testranges()
         {
$testranges=DB::table('tests')
->leftjoin('test_ranges','tests.id','=','test_ranges.tests_id')
->leftjoin('test_subcategories','tests.sub_categories_id','=','test_subcategories.id')
->leftjoin('test_machines','test_ranges.machine_id','=','test_machines.id')
->select('test_ranges.*','tests.name as tname','test_machines.id as machine_id','test_machines.name as machine',
'tests.id as testId','test_subcategories.name as subname')
->get();
return view('facilityadmin.testranges')->with('testranges',$testranges);
        }
        public function rangesadd(Request $request){
               $machine_id=$request->machine_name;
               $test_id=$request->test_id;
               $facility_id=$request->facility_id;
               $low_male=$request->low_male;
               $high_male=$request->high_male;
               $low_female=$request->low_female;
               $high_female=$request->high_female;
               $units=$request->units;
        $rangeId = DB::table('test_ranges')->insertGetId([
                   'tests_id'=>$test_id,
                   'machine_id'=>$machine_id,
                   'facility_id'=>$facility_id,
                   'low_male'=>$low_male,
                   'high_male'=>$high_male,
                   'low_female'=>$low_female,
                   'high_female'=>$high_female,
                   'units'=>$units,
                   'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                   ]);

                   $data=DB::table('tests')
                   ->leftjoin('test_ranges','tests.id','=','test_ranges.tests_id')
                   ->leftjoin('test_subcategories','tests.sub_categories_id','=','test_subcategories.id')
                   ->leftjoin('test_machines','test_ranges.machine_id','=','test_machines.id')
                   ->select('test_ranges.*','tests.name as tname','test_machines.id as machine_id','test_machines.name as machine',
                   'tests.id as testId','test_subcategories.name as subname')
                   ->where('test_ranges.id',$rangeId)
                   ->first();
                   return response()->json($data);

  }

  public function destroyranges($id)
  {
DB::table("test_ranges")->where('id',$id)->delete();
return  Redirect()->action('FacilityAdminController@testranges');
 }

     public function updateranges(Request $request)
     {
     $t_ranges = $request->tranges_id;
       $units = $request->unit;
       $low_female = $request->low_female;
       $high_female = $request->high_female;
       $low_male = $request->low_male;
       $high_male = $request->high_male;
       $machine_id = $request->machine_id;

     DB::table('test_ranges')
               ->where('id',$t_ranges)
               ->update(['units'=>$units,
               'low_female'=>$low_female,
               'high_female'=>$high_female,
               'low_male'=>$low_male,
               'high_male'=>$high_male,
               'machine_id'=>$machine_id,
               ]);
               $data=DB::table('tests')
               ->leftjoin('test_ranges','tests.id','=','test_ranges.tests_id')
               ->leftjoin('test_subcategories','tests.sub_categories_id','=','test_subcategories.id')
               ->leftjoin('test_machines','test_ranges.machine_id','=','test_machines.id')
               ->select('test_ranges.*','tests.name as tname','test_machines.id as machine_id','test_machines.name as machine',
               'tests.id as testId','test_subcategories.name as subname')
               ->where('test_ranges.id',$t_ranges)
               ->first();
               return response()->json($data);

  // return view('admin.testranges');
     }


public function showPaid($id)
{
  $u_id = Auth::user()->id;
  $fac = DB::table('facility_admin')
  ->join('facilities', 'facilities.FacilityCode', '=', 'facility_admin.facilitycode')
  ->select('facility_admin.facilitycode','facilities.FacilityName')
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
                      ['payments.appointment_id', '=', $id],
                      ['payments.facility', '=', $facility],
                    ])  ->get();

$data['lab'] = DB::table('payments')
->Join('patient_test_details', 'payments.lab_id', '=', 'patient_test_details.id')
->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
->select('tests.name','payments.amount')
 ->where([
                     ['payments.payments_category_id', '=', 2],
                     ['payments.appointment_id', '=', $id],
                     ['payments.facility', '=', $facility],
                   ])  ->get();
$data['consult'] = DB::table('payments')->select('amount')
->where([ ['payments_category_id', '=', 1],
['payments.appointment_id', '=', $id],
['payments.facility', '=', $facility],])  ->first();

$data['medfee'] = DB::table('payments')->select('amount')
->where([ ['payments_category_id', '=', 4],
['payments.appointment_id', '=', $id],
['payments.facility', '=', $facility],
])  ->first();

$rectsum = DB::table('payments')
->select(DB::raw("SUM(payments.amount) as paidsum"))
->where([
                ['payments.appointment_id', '=', $id],
                ['payments.facility', '=', $facility],
              ])
              ->first();
return view('facilityadmin.receipt',$data)->with('receipt',$receipt)->with('rect',$rect)->with('rectsum',$rectsum)->with('fac',$fac);


}


}
