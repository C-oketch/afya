<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Redirect;
use App\Facility;
use App\Doctor;
use App\Test;
use Session;
use App\Pharmacy;
use App\Afya_user;
use App\Appointment;
use App\Facility_doctor;
use App\Manufacturer;
use Carbon\Carbon;

class AdminController extends Controller
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

      $data['gov']=Facility::where('Owner','=','Ministry of Health')->count();
      $data['priv']=Facility::where('Owner','<>','Ministry of Health')->count();
      $data['pharm']=Pharmacy::count();
      $data['manu']=Manufacturer::count();

      $data['fac']=  DB::table('appointments')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->distinct('appointments.facility_id')->count('facilities.id');

      $data['users'] =  DB::table('afya_users')->count('id');
      $data['users2'] =  DB::table('dependant')->count('id');

      $data['activeuser']=  DB::table('appointments')
      ->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
      ->distinct('appointments.afya_user_id')->count('afya_users.id');

      $data['activeuser2']=  DB::table('appointments')
      ->Join('dependant', 'appointments.persontreated', '=', 'dependant.id')
      ->distinct('appointments.persontreated')->count('dependant.id');

      // dd($activeuser2);

      return view('admin.home',$data);

    }

    public function facility(){

        $data['facilities']= DB::table('facilities')
        ->select('id','FacilityCode','FacilityName','Type','County','Constituency','set_up','payment','Beds','Cots','Owner')
        ->where('status',1)
        ->orderBy('id')->get();

        return view('admin.facility',$data);
        }

public function addfacc(){

    $data['facilities']= DB::table('facilities')
    ->select('id','FacilityCode','FacilityName','Ward')
    ->orderBy('id')->get();

    return view('admin.addfacility',$data);
}

    public function gov_facility(){
     $data['facilities']=Facility::where('Owner','=','Ministry of Health')->get();
        return view('admin.facility',$data);
    }

    public function priv_facility(){

      $data['facilities']=Facility::where('Owner','<>','Ministry of Health')->get();


        return view('admin.facility',$data);
    }

    public function pharmacies(){

      $data['facilities']=Pharmacy::all();

        return view('admin.pharm',$data);
    }

    public function manufacturers(){

      $data['facilities']=Manufacturer::all();

        return view('admin.manu',$data);
    }


    public function faci_single($facilitycode){

      $data['patients']=Afya_user::join('appointments','appointments.afya_user_id','=','afya_users.id')
                                 ->where('facility_id','=',$facilitycode)
                                 ->groupBy('afya_users.id')->count();
      $data['doctors']=Facility_doctor::where('facilitycode','=',$facilitycode)->count();
      $data['adverts']=0;
      $data['facilitycode']=$facilitycode;

        return view('admin.faci',$data);
    }

     public function faci_patients(){

      $facilitycode=$_REQUEST['facilitycode'];

      $data['patients']=Afya_user::join('appointments','appointments.afya_user_id','=','afya_users.id')
                                 ->where('facility_id','=',$facilitycode)
                                 ->groupBy('afya_users.id')->get();


        return view('admin.patients',$data);
    }

     public function faci_doctors(){

      $facilitycode=$_REQUEST['facilitycode'];

       $data['doctors']=Facility_doctor::select('doctors.*')
                                       ->join('doctors','doctors.id','=','facility_doctor.doctor_id')
                                       ->where('facility_doctor.facilitycode','=',$facilitycode)
                                       ->get();


        return view('admin.doctors',$data);
    }

  public function addfacility1(Request $request){
        $code=$request->facilitycode;
        $setup=$request->setup;
        $payment=$request->payment;

  DB::table('facilities')->where('id',$code)->update([
             'set_up'=>$setup,
             'payment'=>$payment,
             'status'=>1,
            ]);

return redirect()->action('AdminController@facility');
    }
    public function addfacility2(Request $request){
          $code=$request->code;
          $name=$request->name;
          $type=$request->type;
          $county=$request->county;
          $constituency=$request->constituency;
          $ward=$request->ward;
          $setup=$request->setup;
          $payment=$request->payment;

    DB::table('facilities')->insert([
              'FacilityCode'=>$code,
               'FacilityName'=>$name,
               'Type'=>$type,
               'County'=>$county,
               'Constituency'=>$constituency,
               'Ward'=>$ward,
               'set_up'=>$setup,
               'payment'=>$payment,
               'status'=>1,
              ]);

  return redirect()->action('AdminController@facility');
      }

    public function facilityAdmin(){
        return view('admin.facilityadmin');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name=$request->name;
        $email=$request->email;
        $role=$request->role;
        $password=bcrypt($request->password);
        $facility=$request->facility;
        $department=$request->department;

        $userid=DB::table('users')->insertGetId([
            'name'=>$name,
            'email'=>$email,
            'role'=>$role,
            'password'=>$password,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('facility_admin')->insert([
            'user_id'=>$userid,
            'department'=>$department,
            'facilitycode'=>$facility,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        DB::table('role_user')->insert([
            'user_id'=>$userid,
            'role_id'=>10
            ]);

        return redirect()->action('AdminController@facilityAdmin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addtest()
    {
       return view('admin.tests');
    }
    public function addtestrady()
    {
       return view('admin.testsrady');
    }
    public function testcardiac()
    {
      $data['tests']=DB::table('tests_cardiac')
      ->where('deleted','=',0)
       ->select('id','name')
      ->orderBy('name', 'asc')
      ->get();


       return view('admin.tests.cardiac_tests',$data);
    }
    public function testneurology()
    {

      $data['tests']=DB::table('tests_neurology')
      ->where('deleted','=',0)
       ->select('id','name')
      ->orderBy('name', 'asc')
      ->get();
       return view('admin.tests.neurology_tests',$data);
    }
    public function testprocedure()
    {

      $data['tests']=DB::table('procedures')
      ->where('deleted','=',0)
       ->select('id','name','category')
      ->orderBy('name', 'asc')
      ->get();
       return view('admin.tests.procedures',$data);
    }





    public function storetest(Request $request)
    {
      $test_cat=$request->test_cat;
      $sub_name=$request->sub_name;
      $sub_cat_id =$request->sub_cat_id;
      $test=$request->test;

          if($sub_name){
      $sub_id=DB::table('test_subcategories')->insertGetId([
          'name'=>$sub_name,
          'categories_id'=>$test_cat,
          ]);

      DB::table('tests')->insert([
          'name'=>$test,
          'sub_categories_id'=>$sub_id,
          ]);
                }else{
                  DB::table('tests')->insert([
                      'name'=>$test,
                      'sub_categories_id'=>$sub_cat_id,
                    ]);
                  }

    return view('admin.tests');
}
public function storetestimaging(Request $request)
{
  $test_cat=$request->test_cat;
  $test=$request->test;
  $technique=$request->technique;
  $status=$request->status;

if($test_cat== 9){
DB::table('ct_scan')->insert([
'test_cat_id'=>$test_cat,
'name'=>$test,
'technique'=>$technique,
'status'=>$status,
]);
}
if($test_cat== 10){
  DB::table('xray')->insert([
      'test_cat_id'=>$test_cat,
      'name'=>$test,
      'technique'=>$technique,
      'status'=>$status,
      ]);
}
if($test_cat== 11){
DB::table('mri_tests')->insert([
'test_cat_id'=>$test_cat,
'name'=>$test,
'technique'=>$technique,
'status'=>$status,
]);
}
if($test_cat== 12){
DB::table('ultrasound')->insert([
'test_cat_id'=>$test_cat,
'name'=>$test,
'technique'=>$technique,
'status'=>$status,
]);
}
if($test_cat== 13){
DB::table('other_tests')->insert([
'test_cat_id'=>$test_cat,
'name'=>$test,
'technique'=>$technique,
'status'=>$status,
]);
}

return redirect()->action('AdminController@addtestrady');

}
public function storecardiac(Request $request)
{
  $test=$request->test;
  $today = Carbon::today();
  $user =Auth::user()->id;
  DB::table('tests_cardiac')->insert([
      'name'=>$test,
      'user_id'=>$user,
      'created_at'=>$today,
      ]);
      return redirect()->back();
}

public function storeprocedure(Request $request)
{
  $test=$request->test;
  $cat=$request->category;
  $today = Carbon::today();
  $user =Auth::user()->id;
  DB::table('procedures')->insert([
      'name'=>$test,
      'category'=>$cat,
      'user_id'=>$user,
      'created_at'=>$today,
      ]);
      return redirect()->back();
}
public function storeneurology(Request $request)
{
  $test=$request->test;
  $today = Carbon::today();
  $user =Auth::user()->id;
  DB::table('tests_neurology')->insert([
      'name'=>$test,
      'user_id'=>$user,
      'created_at'=>$today,
      ]);
      return redirect()->back();
}

 public function get_test_subcat(Request $request)
    {

      return $request->cat_id;

        $sub=DB::table('test_subcategories')->where('categories_id','=',$request->cat_id)->distinct()->get(['id','name']);
      foreach($sub as $Gcat){
        echo "<option value='".$Gcat->id."'>".$Gcat->name."</option>";
      }


    }

public function storetestsbg(Request $request)
{
  $main=$request->main_test;
  $sub=$request->sub_test;


  DB::table('test_groups')->insert([
      'main_test'=>$main,
      'sub_test'=>$sub,
      ]);
return redirect()->action('AdminController@teststo', ['id' => $main]);

// return view('admin.tests');
}


    public function teststo($id)
    {

$tests=DB::table('overall_test')
 ->join('test_categories','overall_test.id','=','test_categories.overall_test_id')
 ->join('test_subcategories','test_categories.id','=','test_subcategories.categories_id')
 ->join('tests','test_subcategories.id','=','tests.sub_categories_id')
 ->select('overall_test.category as oname','test_categories.name as cname',
          'test_subcategories.name as sname','test_subcategories.id as sid',
          'tests.id as test_id','tests.name as test_name')
 ->where('tests.id',$id)
 ->first();
      return view('admin.testsupdate')->with('tests',$tests);
  }

  public function viewgrp($id)
  {

$grps=DB::table('test_groups')
 ->join('tests','test_groups.sub_test','=','tests.id')
 ->select('tests.name as tname')
->where('test_groups.main_test',$id)
->get();

$tstname=DB::table('tests')->where('id',$id)->first();
    return view('admin.viewgrp')->with('grps',$grps)->with('tstname',$tstname);
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
    public function destroytests($id)
    {
    DB::table("tests")->where('id',$id)->delete();
      return view('admin.tests');
    }


public function destroycardiac($id)
{

  DB::table('tests_cardiac')->where('id',$id)->update(
    ['deleted' => 1,
    'deleted_by' => Auth::user()->id,
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
  );
return redirect()->back();
}

public function destroyneurology($id)
{

  DB::table('tests_neurology')->where('id',$id)->update(
    ['deleted' => 1,
    'deleted_by' => Auth::user()->id,
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
  );
return redirect()->back();
}

public function destroyprocedure($id)
{

  DB::table('procedures')->where('id',$id)->update(
    ['deleted' => 1,
    'deleted_by' => Auth::user()->id,
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
  );
return redirect()->back();
}

    public function ftest(Request $request)
     {
         $term = trim($request->q);
             if (empty($term)) {
              return \Response::json([]);
         }

         $test = Facility::search($term)->limit(100)->get();
          $formatted_test = [];
     foreach ($test as $fac) {
             $formatted_test[] = ['id' => $fac->FacilityCode, 'text' => $fac->FacilityName];
         }

         return \Response::json($formatted_test);
     }

     public function invoice($id)
     {
       $subscription=DB::table('B_quotations')
      ->leftjoin('B_address','B_quotations.B_address_id','=','B_address.id')
      ->leftjoin('B_monthly','B_quotations.B_monthly_id','=','B_monthly.id')
      ->leftjoin('B_set_up','B_quotations.setup_fee','=','B_set_up.id')
      ->join('B_packages','B_quotations.B_set_up_id','=','B_packages.id')
      ->leftjoin('B_monthlyAnnually','B_quotations.B_monthlyAnnually_id','=','B_monthlyAnnually.id')
      ->select('B_packages.name as package','B_monthly.amount','B_set_up.amount as setup','B_monthlyAnnually.amount as yearly',
      'B_address.*','B_quotations.invoice_no','B_quotations.quantity','B_quotations.invoice_date','B_quotations.due_date')
      ->where('B_quotations.id',$id)
      ->first();

      $data['addons']=DB::table('B_Baddons')
      ->join('B_addons','B_Baddons.addons_id','=','B_addons.id')
      ->select('B_addons.name','B_Baddons.addons_description as desc','B_Baddons.amount as addamounts')
      ->where('B_Baddons.B_quotation_id',$id)
      ->get();

      $data['addsum'] = DB::table('B_Baddons')
      ->select(DB::raw("SUM(amount) as adddsum"))
      ->where('B_Baddons.B_quotation_id',$id)
      ->first();
         return view('admin.invoice',$data)->with('subscription',$subscription);
     }

     public function quotation()
     {

         return view('admin.quotation');
     }
     public function billquot($id)
     {
     $package = DB::table('B_packages')
     ->join('B_monthly','B_packages.id','=','B_monthly.B_package_id')
     ->join('B_set_up','B_packages.id','=','B_set_up.B_package_id')
     ->join('B_monthlyAnnually','B_packages.id','=','B_monthlyAnnually.B_package_id')
   ->select('B_packages.id','B_packages.name','B_set_up.amount as setup','B_set_up.id as setupid',
   'B_monthly.id as monid','B_monthly.amount','B_monthlyAnnually.amount as yearly','B_monthlyAnnually.id as yearlyid')
    ->where('B_packages.id',$id)
   ->first();



         return view('admin.quotation2')->with('package',$package);
     }

     public function billquots(Request $request)
{
  $tab=$request->tab;
  if($tab == 'month'){
    $monthly=$request->monthly;
    $annually='';
     $period=$request->period;
  }elseif ($tab == 'year') {
    $monthly ='';
    $annually=$request->annually;
    $period = 12;

  }
     $building=$request->building;          $setup=$request->setup;
     $phone=$request->phone;                $floor=$request->floor;
     $package=$request->package;            $bus_name=$request->bus_name;
    $due_date=$request->due_date;          $street=$request->street;
    $invoice_date=$request->invoice_date;


       $B_add=DB::table('B_address')->insertGetId([
           'name'=>$bus_name,
           'building'=>$building,
           'floor_room'=>$floor,
           'street'=>$street,
           'phone'=>$phone,
           'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
           ]);
$ptss= 900;
$pt= $ptss.$B_add;
           $quat=DB::table('B_quotations')->insertGetId([
               'B_address_id'=>$B_add,
               'B_set_up_id'=>$package,
               'setup_fee'=>$setup,
               'B_monthly_id'=>$monthly,
               'B_monthlyAnnually_id'=>$annually,
               'invoice_date'=>$invoice_date,
               'due_date'=>$due_date,
               'quantity'=>$period,
               'created_by'=> Auth::user()->id,
               'invoice_no'=>$pt,
               'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
               'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
               ]);

             $id=$quat;
             $safid=$request->safid;
             $safdesc=$request->safdesc;
             $safamount=$request->safamount;
             $add_id=$request->add_id;
             $adddesc=$request->adddesc;
             $addamount=$request->addamount;
    if($safdesc){
             $B_add=DB::table('B_Baddons')->insert([
                 'B_quotation_id'=>$id,
                 'addons_id'=>$safid,
                 'addons_description'=>$safdesc,
                 'amount'=>$safamount,
                 'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                 ]);
               }
               if($adddesc){
                        $B_add=DB::table('B_Baddons')->insert([
                            'B_quotation_id'=>$id,
                            'addons_id'=>$add_id,
                            'addons_description'=>$adddesc,
                            'amount'=>$addamount,
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                            ]);
                          }
              return redirect()->action('AdminController@invoice', [$id]);
}
}
