<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Manufacturer;
use App\DruglistController;
use DB;
use Carbon\Carbon;


class ManufacturerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manufacturer.home');
    }

    public function addManu(Request $request){
             $this->validate($request, [
      'user_id'=>'required',
        'name' => 'required',
        'location' => 'required',
        'address' => 'required',
        'box' => 'required',
        'tel' => 'required',
        'logo' => 'required',
    ]);
    $document = new Manufacturer($request->input()) ;

     if($file = $request->hasFile('logo')) {

        $file = $request->file('logo') ;

        $fileName = $file->getClientOriginalName() ;
        $destinationPath = public_path().'/img/' ;
        $file->move($destinationPath,$fileName);
        $document->logo = $fileName ;
    }
    $document->save() ;
     return redirect()->action('ManufacturerController@index');

    }

    public function Trends(){
      return view ('manufacturer.trends');
    }

    public function SectorSummary(){
      $companies=DB::table('prescription_filled_status')
      ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
      ->join('druglists','druglists.id','=','prescription_details.drug_id')
      ->select('druglists.manufacturer as name','druglists.drugname as drugname','druglists.strength_perdose as DosageForm','druglists.id as id')
      ->selectRaw('SUM(price * quantity) as total')->orderby('total','DESC')->limit(10)->get();

      return view('manufacturer.sectorsummary')->with('companies',$companies);
    }

    public function todaysales(){
      return view('manufacturer.todaysales');
    }

    public function manuDoctor(){
      return view('manufacturer.manudoctor');

    }

    public function drugsubstitution(){

      return view('manufacturer.drugsubstitutions');
    }


    public function manconfig(){
      return view('manufacturer.settings');

    }
public function adddrugs(Request $request){

$compedrugs = DB::table('compe_drugs')->insert([
             'manu_id' =>$request->get('manu_id'),
             'company' =>$request->get('base_drug'),
            'competition_1'=> $request->get('compe_drug_1'),
             'competition_2'=> $request->get('compe_drug_2'),
             'competition_3'=> $request->get('compe_drug_3'),
             'competition_4'=> $request->get('compe_drug_4'),
             'competition_5'=> $request->get('compe_drug_5'),
                    ]);
return view('manufacturer.settings');
}

public function addcompany(Request $request){

  $manuco=$request->get('manuco');
  $manuId=$request->get('manu_id');

  $pttids= DB::table('compe_manufacturer')
            ->select('company')
            ->where('manu_id', '=',$manuId)
           ->first();
 if (is_null($pttids)) {

  $compedrugs = DB::table('compe_manufacturer')->insert([
               'competition_1' => $request->get('company1'),
               'competition_2' => $request->get('company2'),
               'competition_3' => $request->get('company3'),
               'competition_4' => $request->get('company4'),
               'competition_5' => $request->get('company5'),
               'company' => $request->get('manuco'),
               'manu_id' => $request->get('manu_id'),

              ]);
             }

return view('manufacturer.settings');

}
    public function manuStock(){
      return view('manufacturer.manustock');

    }
    public function Competition(){



      return view('manufacturer.competition');
  }

  public function toCompany(){
    return view('manufacturer.to');

  }

    public function show()
    {

      $id1 = Auth::user()->name;
      $id2 = DB::table('manufacturers')
            ->where('manufacturer', '=', $id1)
            ->pluck('manufacturer');

      $manuf = DB::table('druglists')
              ->Join('manufacturers', 'manufacturers.id', '=', 'druglists.Manufacturer' )
              ->select('druglists.*','manufacturers.manufacturer')
              ->where('manufacturers.id', '=', '2')
              ->get();

              return view('manufacturer.show')->with('manuf',$manuf);
    }


    public function getEmployees(){

      return view('manufacturer.employees');
    }

    public function addEmployee (Request $request){
      $id=$request->id;
      $role=$request->role;
      $name=$request->name;
      $email=$request->email;
      $password=$request->password;
      $job=$request->job;
      $region=$request->region;

      $user=DB::table('users')->insertGetId([
         'name'=>$name,
          'email'=>$email,
          'role'=>$role,
          'password'=>bcrypt($password),
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

        ]);

      DB::table('manufacturers_employees')->insert([
         'manu_id'=>$id,
         'users_id'=>$user,
         'job'=>$job,
         'region'=>$region,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

        ]);
 DB::table('role_user')->insert(['user_id'=>$user,
      'role_id'=>5]);
return redirect()->action('ManufacturerController@getEmployees');


    }


public function getSalesrep(){

  return view('manufacturer.salesrep');
}

public function addSalesrep(Request $request){
  $id=$request->id;
  $user=$request->user;
  $drug=$request->drug;
   $region=$request->region;


     $manu=DB::table('manufacturers_employees')->where('users_id',$id)->first();



      DB::table('sales_rep')->insert([
         'manu_id'=>$manu->manu_id,
         'users_id'=>$user,
         'manager_id'=>$id,
         'drug_id'=>$drug,
         'region'=>$region,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

        ]);

return redirect()->action('ManufacturerController@getSalesrep');

}

}
