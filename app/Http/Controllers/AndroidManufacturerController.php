<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use App\Druglist;
use App\Observation;
use App\Symptom;
use App\Chief;
use Redirect;
use Carbon\Carbon;
use App\County;

class AndroidManufacturerController extends Controller
{
    //

    public function showEmployees(Request $request)
{
  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
  $employees=DB::table('manufacturers_employees')
  ->join('users','users.id','=','manufacturers_employees.users_id')
  ->select('users.*','manufacturers_employees.job as job','manufacturers_employees.region')
  ->where('manufacturers_employees.manu_id',$id)
  ->get();
  return json_encode($employees);

}

public function insertEmployees( Request $request){

     $id=$request->id;
      $role=$request->role;
      $name=$request->name;
      $email=$request->email;
      $password=$request->password;
      $job=$request->job;
      $region=$request->region;

      //$employee = array();

   $user=DB::table('users')->insertGetId([
    'name'=>$name,
    'email'=>$email,
    'role'=>$role,
    'password'=>bcrypt($password),
    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
    'updated_at' => \Carbon\Carbon::now()->toDateTimeString() 

        ]);
    $manufacturers = DB::table('manufacturers_employees')->insert([
         'manu_id'=>$id,
         'users_id'=>$user,
         'job'=>$job,
         'region'=>$region,
         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

        ]);

 DB::table('role_user')->insert(['user_id'=>$user,
      'role_id'=>5]);

return json_encode($manufacturers);
}

public function showManustock(Request $request)
{
  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

   $Mname = $manufacturer->name;

     $one_week_ago = Carbon::now()->subWeeks(1);
                    $today = Carbon::today();
                     $invents = DB::table('inventory')
                         ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                         ->join('druglists','inventory.drug_id','=','druglists.id')
                         ->select('pharmacy.id as pharm','pharmacy.name','pharmacy.county','inventory.created_at','inventory.quantity','inventory.strength',
                         'inventory.strength_unit','druglists.id','druglists.drugname'
                        )
                         ->where([['druglists.Manufacturer','like','%'.$Mname.'%'],
                         //['druglists.id',$rep->drug_id],
                        // ['pharmacy.county',$rep->region], 
                          ])
                         ->whereIn('inventory.created_at', function($query)
                             {
                                 $query->select(DB::raw('max(inventory.created_at)'))
                                       ->from('inventory')
                                       ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                                       ->join('druglists','inventory.drug_id','=','druglists.id')
                                       ->groupBy('pharmacy.name','druglists.drugname');

                             })
                          ->get();
                             $i=1;

                            // $array = array();
                            // $array['invents']=$invents;
                            // $array['count']=count($invents);
return json_encode($invents);
}

public function showManustocktotalq(Request $request)
{
  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

   $Mname = $manufacturer->name;

  
                     $invents = DB::table('inventory')
                         ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                         ->join('druglists','inventory.drug_id','=','druglists.id')
                         ->selectRaw('SUM(inventory.quantity) as totalqb')
                         ->where([['druglists.Manufacturer','like','%'.$Mname.'%'],
                         //['druglists.id',$rep->drug_id],
                        // ['pharmacy.county',$rep->region], 
                          ])
                         ->whereIn('inventory.created_at', function($query)
                             {
                                 $query->select(DB::raw('max(inventory.created_at)'))
                                       ->from('inventory')
                                       ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                                       ->join('druglists','inventory.drug_id','=','druglists.id')
                                       ->groupBy('pharmacy.name','druglists.drugname');

                             })
                          ->get();
                             $i=1;

return json_encode($invents);
}

public function showManusales(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
//->groupBy('drugname')
//->groupBy('name')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
 // ['pharmacy.id','like', '%' .$test . '%']
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
  // ['pharmacy.id','like', '%' .$test . '%']
//['pharmacy.name','%' .$Pname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showRegionsales(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);


$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->selectRaw ('sum(prescription_filled_status.total) as TotalIncome')

->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
])
->whereNull('prescription_filled_status.substitute_presc_id')
->get();

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
//->selectRaw ('sum(total) as tt2')
//->SELECT('prescription_filled_status.*')
->selectRaw ('sum(prescription_filled_status.total) as TotalIncome')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
//->unionAll($prescribed)
->get();

 $data = array();

 $items = array_merge($prescribed,$Dsales);

$tots= array_sum(array_column($items, 'TotalIncome'));

$data['TotalIncome'] =$tots;

return json_encode(array($data));

}

public function showManuregionsummary(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
// $countytots = DB::table('county')->count();

// return json_encode($countytots);

$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.id','like', '%' .$test . '%']
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.id','like', '%' .$test . '%']
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();
return json_encode($Dsales);
}
public function showManusales1(Request $request)
{
  $i =1;

  $test =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
// ->groupBy('drugname','county')
->groupBy('name')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.id','like', '%' .$test . '%']
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.id','like', '%' .$test . '%']
//['pharmacy.name','%' .$Pname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($merge);
}
public function showManusales50(Request $request)
{
  $i =1;

  $testa =50;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->groupBy('pharmacy.name')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.id','like','%' .$testa .'%']
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
   ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.id','like','%' .$testa .'%']
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($Dsales);
}
public function showManusalesdoc1(Request $request)
{
  $i =1;

  $testa =2590;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
   ['doctors.id','like','%' .$testa .'%']
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
   ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['doctors.id','like','%' .$testa .'%']
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($Dsales);
}
public function showManusalesdoc1totalq(Request $request)
{
  $i =1;

  $testa =2590;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->selectRaw('SUM(prescription_filled_status.quantity)as ttb')
  //) as total
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
   ['doctors.id','like','%' .$testa .'%']
])
->whereNull('prescription_filled_status.substitute_presc_id')
->get();

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->selectRaw('SUM(prescription_filled_status.quantity)as ttb')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
   ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['doctors.id','like','%' .$testa .'%']
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
//->union($prescribed)
->get();

//return json_encode($Dsales);

 $data = array();
 //$data['prescribed'] = $prescribed;
 //$data['Dsales'] = $Dsales;

 $items = array_merge($prescribed,$Dsales);

$tots= array_sum(array_column($items, 'ttb'));

$data['ttb'] = $tots;

return json_encode(array($data));

}
public function showManusalesdoc2(Request $request)
{
  $i =1;

  $testa =2500;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')

->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
   ['doctors.id','like','%' .$testa .'%']
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
   ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['doctors.id','like','%' .$testa .'%']
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($Dsales);
}
public function showManusalesdoc2totalq(Request $request)
{
  $i =1;

  $testa =2500;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.quantity as ttb','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')

->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
   ['doctors.id','like','%' .$testa .'%']
])
->whereNull('prescription_filled_status.substitute_presc_id')
->get();

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.quantity as ttb','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
   ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['doctors.id','like','%' .$testa .'%']
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
//->union($prescribed)
->get();

$data = array();
 // $data['prescribed'] = $prescribed;
 // $data['Dsales'] = $Dsales;

 $items = array_merge($prescribed,$Dsales);

$tots= array_sum(array_column($items, 'ttb'));

$data['ttb'] = $tots;

return json_encode(array($data));
}
public function showManusalesdrug1(Request $request)
{
  $i =1;

  $testa =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->groupBy('doctors.name')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
   ['druglists.id','=',$testa]
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
   ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['druglists.id','=',$testa]
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($Dsales);
}
public function showManusalesdrug2(Request $request)
{
  $i =1;

  $testa =394;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->groupBy('doctors.name')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
   ['druglists.id','=',$testa]
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
   ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['druglists.id','=',$testa]
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($Dsales);
}
public function showManusalesdrug3(Request $request)
{
  $i =1;

  $testa =751;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->groupBy('doctors.name')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
   ['druglists.id','=',$testa]
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
   ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['druglists.id','=',$testa]
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($Dsales);
}
public function showManusalesdrug4(Request $request)
{
  $i =1;

  $testa =3;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid','druglists.id',
'prescription_filled_status.substitute_presc_id')
->groupBy('druglists.id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
   ['druglists.id','like','%' .$testa .'%']
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid','druglists.id',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
   ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['druglists.id','=',$testa]
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($Dsales);
}
public function showManusalesbypharmacy(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('pharmacy.name as pharmacy','pharmacy.id as pharmid')
->selectRaw('sum(prescription_filled_status.total) as TotalIncome')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
])
->whereNull('prescription_filled_status.substitute_presc_id')
->get();

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('pharmacy.name as pharmacy','pharmacy.id as pharmid')
->selectRaw('sum(prescription_filled_status.total) as TotalIncome')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
//['pharmacy.name','%' .$Pname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->get();

$data = array();

 $items = array_merge($prescribed,$Dsales);

$tots= array_sum(array_column($items, 'TotalIncome'));

$data['TotalIncome'] =$tots;

return json_encode(array($data));

}
public function showManusalesbypharmacycontent1(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
$Pname='KALYET CHEMIST BARATON';

 $todaysales = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid','druglists.id',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid','druglists.id',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
// ['pharmacy.name','%' .$Pname . '%'],
   ['pharmacy.id','%' .$id . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($Dsales);
}
public function showManusalesbydrugs(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('druglists.drugname','druglists.id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('druglists.drugname','druglists.id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
//['pharmacy.name','%' .$Pname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($Dsales);
}
public function showManusalesbydoctor(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
//$Pname->KALYET CHEMIST BARATON;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('doctors.name as name','doctors.id as docid')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('doctors.name as name','doctors.id as docid')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
//['pharmacy.name','%' .$Pname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

return json_encode($Dsales);
}
public function showManudrugsubstitutionsawaytoday(Request $request){

 $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;
   $drug_id=DB::table('druglists');

   $today = Carbon::today();
  $one_week_ago = Carbon::now()->subWeeks(1);
  $one_month_ago = Carbon::now()->subMonths(1);
  $one_year_ago = Carbon::now()->subYears(1);
  $prescribed = DB::table('prescriptions')
   ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
   ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
   ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
   ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
   ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
   ->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
   ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
    'pharmacy.county',
   'prescription_filled_status.substitute_presc_id')
 ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
           ['prescription_filled_status.created_at','>=',$today],
         //  ['druglists.id',$rep->drug_id],
        //   ['pharmacy.county','like','%'.$rep->region.'%'],
         ])
 ->whereNotNull('prescription_filled_status.substitute_presc_id')
 ->get();

return json_encode($prescribed);
}

public function showManudrugsubstitutionsawayweek(Request $request){

 $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;
   $drug_id=DB::table('druglists');

   $today = Carbon::today();
  $one_week_ago = Carbon::now()->subWeeks(1);
  $one_month_ago = Carbon::now()->subMonths(1);
  $one_year_ago = Carbon::now()->subYears(1);
  $prescribedw = DB::table('prescriptions')
  ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
  ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
  ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
  ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
  'pharmacy.county','prescription_details.doseform',
  'prescription_filled_status.substitute_presc_id')
  ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  //['druglists.id',$rep->drug_id],
  //['pharmacy.county','like','%'.$rep->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();

return json_encode($prescribedw);
}

public function showManudrugsubstitutionsawaymonth(Request $request){

 $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;
   $drug_id=DB::table('druglists');

   $today = Carbon::today();
  $one_week_ago = Carbon::now()->subWeeks(1);
  $one_month_ago = Carbon::now()->subMonths(1);
  $one_year_ago = Carbon::now()->subYears(1);
  $prescribedm= DB::table('prescriptions')
  ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
  ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
  ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
  ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
  'pharmacy.county','prescription_details.doseform',
  'prescription_filled_status.substitute_presc_id')
  ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
  ['prescription_filled_status.created_at','>=',$one_month_ago],
  ['prescription_filled_status.created_at','<=',$today],
  // ['druglists.id',$rep->drug_id],
  // ['pharmacy.county','like','%'.$rep->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
 foreach($prescribedm as $daily){
   $substitutedm = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  //['druglists.id',$rep->drug_id],

  ])

  ->first();
  $i++;  
   } 
 
return json_encode($prescribedm);
}
public function showManudrugsubstitutionsawayyear(Request $request){

 $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;
   $drug_id=DB::table('druglists');

   $today = Carbon::today();

  $one_week_ago = Carbon::now()->subWeeks(1);
  $one_month_ago = Carbon::now()->subMonths(1);
  $one_year_ago = Carbon::now()->subYears(1);
  $prescribedy= DB::table('prescriptions')
  ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
  ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
  ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
  ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
  'pharmacy.county','prescription_details.doseform',
  'prescription_filled_status.substitute_presc_id')
  ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
  ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$today],
 // ['druglists.id',$rep->drug_id],
  //['pharmacy.county','like','%'.$rep->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();

return json_encode($prescribedy);
}
public function showManudrugsubstitutionstotoday(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
   $today = Carbon::today();
  $one_year_ago = Carbon::now()->subYears(1);

  $drugs = array();


   $today = Carbon::today();

  $Toprescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','prescription_details.doseform',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','not like', '%'.$Mname.'%'],
['prescription_filled_status.created_at','>=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->get();
foreach($Toprescribed  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
        //  ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}
public function showManudrugsubstitutionstoweek(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
   $today = Carbon::today();
  $one_year_ago = Carbon::now()->subYears(1);

  $drugs = array();


  $one_week_ago = Carbon::now()->subWeeks(1);
  $one_month_ago = Carbon::now()->subMonths(1);
  $one_year_ago = Carbon::now()->subYears(1);
  $Toprescribedw = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','prescription_details.doseform',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','not like', '%'.$Mname.'%'],
['prescription_filled_status.created_at','>=',$one_week_ago],
['prescription_filled_status.created_at','<=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->get();
foreach($Toprescribedw  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
         // ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}
public function showManudrugsubstitutionstomonth(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
   $today = Carbon::today();
  
$one_month_ago = Carbon::now()->subMonths(1);
  $drugs = array();

 $Toprescribedm= DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','prescription_details.doseform',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','not like', '%'.$Mname.'%'],
['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->get();
foreach($Toprescribedm  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
        //  ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}
public function showManudrugsubstitutionstoyear(Request $request){

$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
   $today = Carbon::today();
  $one_year_ago = Carbon::now()->subYears(1);

  $drugs = array();

$Toprescribedy= DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','prescription_details.doseform',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','not like', '%'.$Mname.'%'],
['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->get();
foreach($Toprescribedy  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
         // ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}

public function showManudrugsubstitutionstomax(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
   $today = Carbon::today();
  $one_year_ago = Carbon::now()->subYears(1);

  $drugs = array();

$Toprescribedall = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','prescription_details.doseform',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','not like', '%'.$Mname.'%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->get();
foreach($Toprescribedall  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
         // ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}
//look for specific controllers from here
public function  showManudrugsubstitutionsintoday(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;


$today = Carbon::today();

  $drugs = array();

$intprescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','prescription_details.doseform',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
['prescription_filled_status.created_at','>=',$today],
 // ['pharmacy.county','like','%'.$rep->region.'%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->get();
foreach($intprescribed  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
         // ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}

public function  showManudrugsubstitutionsinweek(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
   $today = Carbon::today();
  $one_year_ago = Carbon::now()->subYears(1);

  $drugs = array();

$today = Carbon::today();
$one_week_ago = Carbon::now()->subWeeks(1);


$intprescribedw = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','prescription_details.doseform',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
['prescription_filled_status.created_at','>=',$one_week_ago],
['prescription_filled_status.created_at','<=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->get();
foreach($intprescribedw  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
         // ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}


public function  showManudrugsubstitutionsinmonth(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;

                 $drugs = array();
   $today = Carbon::today();
  $one_year_ago = Carbon::now()->subYears(1);
$one_month_ago = Carbon::now()->subMonths(1);
$one_year_ago = Carbon::now()->subYears(1);
$intprescribedm= DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','prescription_details.doseform',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->get();
foreach($intprescribedm  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
         // ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}
public function  showManudrugsubstitutionsinyear(Request $request){

$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;
   $today = Carbon::today();
  $one_year_ago = Carbon::now()->subYears(1);

  $drugs = array();

$intprescribedy= DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','prescription_details.doseform',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->get();
foreach($intprescribedy  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
         // ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}

public function  showManudrugsubstitutionsinmax(Request $request){

$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
   $today = Carbon::today();
  $one_year_ago = Carbon::now()->subYears(1);

  $drugs = array();

$intprescribedall = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','prescription_details.doseform',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
 ->get();
 //dd($prescribed); 
foreach($intprescribedall  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
        //  ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
//check this out
}
else {
$i=0;

        }
}
  return json_encode($drugs);
  
}

public function  showManusectorsummary(Request $request){

 $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   
  $companies=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.manufacturer as name','druglists.drugname as drugname','druglists.id as id')
->selectRaw('SUM(price * quantity) as total')->orderby('total','DESC')->limit(10)->get();

return json_encode($companies);

}
public function  showManusectorsummarytotalcash(Request $request){

 $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   
  $companies=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.manufacturer as name','druglists.drugname as drugname','druglists.id as id')
->selectRaw('SUM(price * quantity) as totalqb')->orderby('totalqb','DESC')->limit(10)->get();

return json_encode($companies);

}

public function  showManucompetition(Request $request){

 $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
  $Mid = 9;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');


 //start


     $today = Carbon::today();
                             $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 
      foreach($Companiez as $compz){
   $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']);                          
                       
   $d1t11=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->Join('prescriptions','prescriptions.id','=','prescription_details.presc_id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
 ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();


   $d1st11=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today], 
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
 ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
   }

     foreach($Companiez as $compz){
   $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']);  

   $d1t=DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->select('prescription_filled_status.price as dprice')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([ ['prescription_filled_status.created_at','>=',$today],
   ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
             ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
    

   
    $d1st=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], 
          ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
             
              } 

       foreach($Companiez as $compz){
   $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']);  
  $d1t2=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
 ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();



  $d1st2=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
 }
  //sugestion ya ken
// $data = array();
// $data['dist2'] = //$data['dist2'];
 
 $data = array();
 $data['d1t11']=$d1t11;
 $data['d1st11']=$d1st11;
 $data['d1t']=$d1t;
 $data['d1st']=$d1st;
 $data['d1t2']=$d1t2;
 $data['d1st2']=$d1st2;



return json_encode($data);
// $data = array();
//  return json_encode($d1t);
//return json_encode($d1st2);

// $d1t11
// $d1st11   //the ones with an s display the sub details displays sub
//$d1t
//$d1st
//d1t2
//d1st2
}

public function showComapnyanddrugcompe( Request $request){
   $i =1;

$empty= 0;
 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);
                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;


                     //$Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();
                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){


  $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select  ('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity',
  'prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
//->whereNull('prescription_filled_status.substitute_presc_id')
//->str_replace(['0', 'null', '$d1y'])DB::raw('IFNULL( prescription_filled_status.substitute_presc_id, "N/A")')
//->str_replace('search', replace, subject)
//->whereNotNull('druglists.Manufacturer')
//->whereNull("0")
// ->is_null('druglists.Manufacturer, 0')
 //['pharmacy.county','like','%'.$rep->region.'%'],

->first();
//->map(function ())

return json_encode($d1y);

// return json_encode(array($data));
// return json_encode($d1w11);
//test
// $data = array();
//  $data['Companiez11'] = [{$Companiez11}];
//  $data['d1w11'] = [{$d1w11}];
//  return json_encode($data);
}

//second company in compe analysyis
public function showComapny2anddrugcompe( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     //$Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();
                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){

 $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']); }

 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);

                     }

public function showComapny3anddrugcompe( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                                   
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){


   $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);


                     }
  public function showComapny4anddrugcompe( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){

 $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']); 
   }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);



                     }
  public function showComapny5anddrugcompe( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){

 $Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']); 
  }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);

}
public function showComapny6anddrugcompe( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);
                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){

$Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']); 

}
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);


                     }

 public function showcomapnyanddrugcompetoday( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
$Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);
}
  public function showcomapny2anddrugcompetoday( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']);}
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);

} 

 public function showcomapny3anddrugcompetoday( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']); 
}
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);

}

 public function showcomapny4anddrugcompetoday( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);
}
 public function showcomapny5anddrugcompetoday( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 $Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);

}

 public function showcomapny6anddrugcompetoday( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
  $Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);
}
public function showcomapnyanddrugcompemonth( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);
} 

public function showcomapny2anddrugcompemonth( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
  $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);
} 
public function showcomapny3anddrugcompemonth( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 
  $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);

} 
public function showcomapny4anddrugcompemonth( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
  $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();

return json_encode($d1y);

} 
public function showcomapny5anddrugcompemonth( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                           
  foreach($Companiez as $compz){
 $Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
//['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
 ])
->whereNull('prescription_filled_status.substitute_presc_id')
//->whereNotNull('druglists.Manufacturer')
->first();

return json_encode($d1y);
} 

public function showcomapny6anddrugcompemonth( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 $Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']); }
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')

->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->whereNotNull('Manufacturer')
->first();

return json_encode($d1y);

} 
public function showcomapnyanddrugcompeyear( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
     $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
$Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']); 
 //  foreach($Companiez as $compz){
 // $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']);

}
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')

->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->whereNotNull('Manufacturer')
->first();

return json_encode($d1y);

} 

public function showcomapny2anddrugcompeyear( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
     $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']);

}
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')

->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->whereNotNull('Manufacturer')
->first();

return json_encode($d1y);
} 

public function showcomapny3anddrugcompeyear( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
     $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']);

}
 $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->whereNotNull('Manufacturer')

->first();

return json_encode($d1y);

} 

public function showcomapny4anddrugcompeyear( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);
   $two_year_ago = Carbon::now()->subYears(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']); 
}

$d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->whereNotNull('Manufacturer')

->first();

return json_encode($d1y);
} 

public function showcomapny5anddrugcompeyear( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
     $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
$Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']);
}

$d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->whereNotNull('Manufacturer')

->first();

return json_encode($d1y);

} 

public function showcomapny6anddrugcompeyear( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
     $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);
                   
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                 $Drugw = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                   $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){
 $Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']); }

$d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('druglists.Manufacturer','prescription_filled_status.price as dprice','prescription_filled_status.quantity','prescription_filled_status.price','prescription_filled_status.total')

->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as dprice')
->selectRaw('IFNULL(prescription_filled_status.quantity, "N/A") as quantity')
->selectRaw('IFNULL(prescription_filled_status.price, "N/A") as price')
->selectRaw('IFNULL(prescription_filled_status.total, "N/A") as total')
->selectRaw('IFNULL(SUM(price*quantity), "N/A") as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->whereNotNull('Manufacturer')
->first();

return json_encode($d1y);

} 
 public function showManucompetitionregiontoday( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);




                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();
                      $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

          foreach($Companiez as $compz){
                      $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']);
  $r1t = DB::table('prescription_filled_status')
                          ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                          ->join('druglists','druglists.id','=','prescription_details.drug_id')
                          ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                          ->select('county as county', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
                            ->groupBy('county','Manufacturer')
                            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                     ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], 
                                     ])
                            ->whereNull('prescription_filled_status.substitute_presc_id')
                             ->orderBy('totalq', 'desc','Manufacturer')
                              ->get();
                             }

                  foreach($r1t as $region){
                     
                     foreach($Companiez as $compz){
                      $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']);
                  $r1tm = DB::table('prescription_filled_status')
                     ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                     ->join('druglists','druglists.id','=','prescription_details.drug_id')
                     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                     ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                               ['pharmacy.county','=', $region->county],
                               ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], 
                               ])
                       ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->first();

                          $r1stm = DB::table('prescription_filled_status')
                             ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                             ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                             ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                             ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                             ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                       ['pharmacy.county','=', $region->county],
                                       ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], 
                                       ])
                               ->whereNotNull('prescription_filled_status.substitute_presc_id')
                              ->first();
}
                              
                              foreach($Companiez as $compz){
                      $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']);
                     $co1 = DB::table('prescription_filled_status')
                        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                        ->join('druglists','druglists.id','=','prescription_details.drug_id')
                        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                        ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                  ['pharmacy.county','=', $region->county],
                                  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
                                  ])
                          ->whereNull('prescription_filled_status.substitute_presc_id')
                         ->first();

                   $co11 = DB::table('prescription_filled_status')
                      ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                      ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                      ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                      ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                      ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                ['pharmacy.county','=', $region->county],
                                ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
                                 ])
                        ->whereNotNull('prescription_filled_status.substitute_presc_id')
                       ->first();
}
            foreach($Companiez as $compz){
                      $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']);          

         $co2 = DB::table('prescription_filled_status')
            ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
            ->join('druglists','druglists.id','=','prescription_details.drug_id')
            ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
            ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                      ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
                       ])
              ->whereNull('prescription_filled_status.substitute_presc_id')
             ->first();
             $co22 = DB::table('prescription_filled_status')
                ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                          ['pharmacy.county','=', $region->county],
                          ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], 
                          ])
                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                 ->first();

                  }
                  foreach($Companiez as $compz){
                      $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']);
       $co3 = DB::table('prescription_filled_status')
          ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
          ->join('druglists','druglists.id','=','prescription_details.drug_id')
          ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
          ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
          ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                    ['pharmacy.county','=', $region->county],
                    ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], 
                    ])
            ->whereNull('prescription_filled_status.substitute_presc_id')
           ->first();
           $co33 = DB::table('prescription_filled_status')
              ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
              ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
              ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
              ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
              ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                        ['pharmacy.county','=', $region->county],
                       ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], 
                        ])
                ->whereNotNull('prescription_filled_status.substitute_presc_id')
               ->first();

}

foreach($Companiez as $compz){
                      $Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']);
                  $co4 = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('druglists','druglists.id','=','prescription_details.drug_id')
                    ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                    ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                    ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                              ['pharmacy.county','=', $region->county],
                              ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
                               ])
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                     ->first();
                     $co44 = DB::table('prescription_filled_status')
                        ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                        ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                        ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                  ['pharmacy.county','=', $region->county],
                                  ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
                                 ])
                          ->whereNotNull('prescription_filled_status.substitute_presc_id')
                         ->first();
}

foreach($Companiez as $compz){
         $Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']);

                           $co5 = DB::table('prescription_filled_status')
            ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
            ->join('druglists','druglists.id','=','prescription_details.drug_id')
            ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
            ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                      ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'],
                       ])
              ->whereNull('prescription_filled_status.substitute_presc_id')
             ->first();
             $co55 = DB::table('prescription_filled_status')
                ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
                ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                          ['pharmacy.county','=', $region->county],
                          ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'],
                           ])
                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                 ->first();
}
                   $i++;  
                    }

 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($r1t);//working but displaying 1 row ata a time
 }
 public function showManucompetitionregionweek( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

  $r1t = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select('county as county', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
          ->groupBy('county')
          ->where([
                   ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
                            ])
          ->whereNull('prescription_filled_status.substitute_presc_id')
           ->orderBy('totalq', 'desc')
            ->get();
       foreach($r1t as $region){
          $r1tm = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
                   ['pharmacy.county','=', $region->county],
                  // ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
          ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                    //  ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

        $co1 = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
              //  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
               ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms1 = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
                //      ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

      $co2 = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
        ['pharmacy.county','=', $region->county],
      //  ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
       ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms2 = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
               //       ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

       $co3 = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
        ['pharmacy.county','=', $region->county],
      //  ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], 
        ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms3 = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
              //        ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

        $co4 = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
            ['pharmacy.county','=', $region->county],
          //  ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
           ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms4 = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
               //       ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

          $co5 = DB::table('prescription_filled_status')
        ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
        ->join('druglists','druglists.id','=','prescription_details.drug_id')
        ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
        ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
        ->where([ ['prescription_filled_status.created_at','>=',$one_week_ago],
                   ['prescription_filled_status.created_at','<=',$todaysales],
        ['pharmacy.county','=', $region->county],
      //  ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
       ])
        ->whereNull('prescription_filled_status.substitute_presc_id')
        ->first();
        $coms5 = DB::table('prescription_filled_status')
           ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
           ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
           ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
           ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
           ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
                      ['prescription_filled_status.created_at','<=',$todaysales],
                      ['pharmacy.county','=', $region->county],
        //              ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

   $i++; 
       }
       //ken2
 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($r1t);//working but displaying 1 row ata a time
 }
 public function showManucompetitionregionmonth( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

 $r1t = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select('county as county', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
    ->groupBy('county')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])
    ->whereNull('prescription_filled_status.substitute_presc_id')
     ->orderBy('totalq', 'desc')
      ->get();
 

 foreach($r1t as $region){
    $r1tm = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
             ['pharmacy.county','=', $region->county],
           //  ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
    ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
              //  ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

   $co1 = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
          ['pharmacy.county','=', $region->county],
        //  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
         ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco1 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
              //  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

  $co2 = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  //['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
   ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco2 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
             //   ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

   $co3 = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  //['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
   ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco3 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
              //  ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

  $co4 = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
      ['pharmacy.county','=', $region->county],
    //  ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], 
      ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco4 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
        //        ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

      $co5 = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
 // ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], 
  ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $mco5 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
      //          ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();
 $i++;  
}


 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($r1t);//working but displaying 1 row ata a time
 }
 public function showManucompetitionregionyear( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
    $one_month_ago = Carbon::now()->subMonths(1);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

  $r1t = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select('county as county', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
    ->groupBy('county')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])
    ->whereNull('prescription_filled_status.substitute_presc_id')
     ->orderBy('totalq', 'desc')
      ->get();
    
    foreach($r1t as $region){
  
    $r1ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
             ['pharmacy.county','=', $region->county],
           //  ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
    ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco1 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
             //   ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

    $r2ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
          ['pharmacy.county','=', $region->county],
        //  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
           ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco1 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
              //  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

   $r3ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
 // ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
   ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco2 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
       //         ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

    $r4ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  //['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
   ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco3 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
    //            ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

   $r5ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
      ['pharmacy.county','=', $region->county],
      //['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], 
      ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco4 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
        //        ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

       $r6ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  //['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], 
  ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco5 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
              //  ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

    $i++; 
  
                    }

 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($r1t);//working but displaying 1 row ata a time
 }
  public function showManucompetitionregionyeartotalq( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);
                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

  $r1t = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select('county as county', DB::raw('SUM(quantity) as totalqb'), DB::raw('SUM(price * quantity) as total'))
    //->groupBy('county')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])
    ->whereNull('prescription_filled_status.substitute_presc_id')
     ->orderBy('totalqb', 'desc')
      ->get();
    
    foreach($r1t as $region){
  
    $r1ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
             ['pharmacy.county','=', $region->county],
           //  ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
    ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco1 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
             //   ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

    $r2ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
          ['pharmacy.county','=', $region->county],
        //  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
           ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco1 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
              //  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

   $r3ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
 // ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
   ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco2 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
       //         ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

    $r4ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  //['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
   ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco3 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
    //            ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

   $r5ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
      ['pharmacy.county','=', $region->county],
      //['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], 
      ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco4 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
        //        ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();

       $r6ty = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
  ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
  ->where([ ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','=', $region->county],
  //['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], 
  ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  $yco5 = DB::table('prescription_filled_status')
     ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
     ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
     ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
     ->select( DB::raw('SUM(quantity) as totalq1'), DB::raw('SUM(price * quantity) as total1'))
     ->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
                ['prescription_filled_status.created_at','<=',$todaysales],
                ['pharmacy.county','=', $region->county],
              //  ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'],
       ])
       ->whereNotNull('prescription_filled_status.substitute_presc_id')
      ->first();
    $i++; 
                    }

return json_encode($r1t);//working but displaying 1 row ata a time
 }
 public function showManucompetitiondrugs( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                     foreach($Drugt as $drt)
                {
    $Drug1 = DB::table('druglists')->where('id','>=',$drt->company )->first();
                  $drugsum=DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([  ['prescription_filled_status.created_at','>=',$today],
                             ['prescription_details.drug_id','=',$drt->company], ])
                  ->whereNull('prescription_filled_status.substitute_presc_id')
                  ->first();

                  $subdrugsum=DB::table('prescription_filled_status')
                  ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
                  ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
                  ->where([   ['prescription_filled_status.created_at','>=',$today],
                             ['substitute_presc_details.drug_id','=',$drt->company], ])
                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                  ->first();

                  //part 2
                   $Drug2 = DB::table('druglists')->where('id','>=',$drt->competition_1 )->first();
                $drugsum1=DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
                ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
                ->where([  ['prescription_filled_status.created_at','>=',$today],
                           ['prescription_details.drug_id','=',$drt->competition_1], ])
                ->whereNull('prescription_filled_status.substitute_presc_id')
                ->first();

                

                $subdrugsum1=DB::table('prescription_filled_status')
                ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                ->select('prescription_filled_status.price as dprice')
                ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
                ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
                ->where([  ['prescription_filled_status.created_at','>=',$today],
                           ['substitute_presc_details.drug_id','=',$drt->competition_1], ])
                ->whereNotNull('prescription_filled_status.substitute_presc_id')
                ->first();
                  
                  //part 3

                 $Drug3 = DB::table('druglists')->where('id','>=',$drt->competition_2 )->first();
               $drugsum2=DB::table('prescription_filled_status')
               ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
               ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
               ->where([  ['prescription_filled_status.created_at','>=',$today],
                          ['prescription_details.drug_id','=',$drt->competition_2], ])
               ->whereNull('prescription_filled_status.substitute_presc_id')
               ->first();

               $subdrugsum2=DB::table('prescription_filled_status')
               ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
               ->select('prescription_filled_status.price as dprice')
               ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
               ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
               ->where([  ['prescription_filled_status.created_at','>=',$today],
                          ['substitute_presc_details.drug_id','=',$drt->competition_2], ])
               ->whereNotNull('prescription_filled_status.substitute_presc_id')
               ->first();

               //part 4

                $Drug4 = DB::table('druglists')->where('id','>=',$drt->competition_3 )->first();
              $drugsum3=DB::table('prescription_filled_status')
              ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
              ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
              ->where([  ['prescription_filled_status.created_at','>=',$today],
                         ['prescription_details.drug_id','=',$drt->competition_3], ])
              ->whereNull('prescription_filled_status.substitute_presc_id')
              ->first();



              $subdrugsum3=DB::table('prescription_filled_status')
              ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
              ->select('prescription_filled_status.price as dprice')
              ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
              ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
              ->where([  ['prescription_filled_status.created_at','>=',$today],
                         ['substitute_presc_details.drug_id','=',$drt->competition_3], ])
              ->whereNotNull('prescription_filled_status.substitute_presc_id')
              ->first();

              //part 5
              $Drug5 = DB::table('druglists')->where('id','>=',$drt->competition_4 )->first();

             $drugsum4=DB::table('prescription_filled_status')
             ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
             ->select('prescription_filled_status.price as dprice')
             ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
             ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
             ->where([  ['prescription_filled_status.created_at','>=',$today],
                        ['prescription_details.drug_id','=',$drt->competition_4], ])
             ->whereNull('prescription_filled_status.substitute_presc_id')
             ->first();

             $subdrugsum4=DB::table('prescription_filled_status')
             ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
             ->select('prescription_filled_status.price as dprice')
             ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
             ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
             ->where([  ['prescription_filled_status.created_at','>=',$today],
                        ['substitute_presc_details.drug_id','=',$drt->competition_4], ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
             ->first();

             //part 6t
              $Drug6 = DB::table('druglists')->where('id','>=',$drt->competition_5 )->first();
            $drugsum5=DB::table('prescription_filled_status')
            ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
            ->select('prescription_filled_status.price as dprice')
            ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
            ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
            ->where([  ['prescription_filled_status.created_at','>=',$today],
                       ['prescription_details.drug_id','=',$drt->competition_5], ])
            ->whereNull('prescription_filled_status.substitute_presc_id')
            ->first();

            $subdrugsum5=DB::table('prescription_filled_status')
            ->join('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
            ->select('prescription_filled_status.price as dprice')
            ->selectRaw('SUM(prescription_filled_status.quantity) as quantity')
            ->selectRaw('SUM(prescription_filled_status.price*prescription_filled_status.quantity) as qprice')
            ->where([  ['prescription_filled_status.created_at','>=',$today],
                       ['substitute_presc_details.drug_id','=',$drt->competition_5], ])
            ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->first();

           
           }
 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($Drug2);//working but displaying 1 row ata a time
 }
 public function showManucompetitionsales( Request $request){
   $i =1;
   //$Companiez1='';
   //$Companiez2='';
   $data = array();

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;
                $today = Carbon::today();
                $one_week_ago = Carbon::now()->subWeeks(1);
                $one_month_ago = Carbon::now()->subMonths(1);
                $one_year_ago = Carbon::now()->subYears(1);
                
// today compe analysis
                //is working and displays company names

 $today = Carbon::today();
                             $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); 

                            foreach($Companiez as $compz){

$Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']);
$Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']);
$Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']);
$Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']);
$Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']);
$Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']);

}
 
 //$data['dist2'];
 $data['Companiez11']=$Companiez11;
 $data['Companiez1']=$Companiez1;
 $data['Companiez2']=$Companiez2;
 $data['Companiez3']=$Companiez3;
 $data['Companiez4']=$Companiez4;
 $data['Companiez5']=$Companiez5;
return json_encode($data);
}

 public function addManuemployeess (Request $request){
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
 //return json_encode(value)


    }

public function showManutrends(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

$Trendsale = DB::table('prescription_filled_status')
                         ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                         ->join('druglists','druglists.id','=','prescription_details.drug_id')
                         ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                           ->groupBy('Manufacturer')
                           ->whereNull('prescription_filled_status.substitute_presc_id')
                           ->where([ ['prescription_filled_status.created_at','<',$today],
                                     ['prescription_filled_status.created_at','>=',$one_year_ago],
                                    ])
                            ->orderBy('totalq', 'desc')
                            ->LIMIT(10)
                             ->get();
                             $i=1;

                         
}
public function showManutrendscompanytoday8(Request $request){
  $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
   $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

  //$Trendsalew->Manufacturer;

   $Mname = $manufacturer->name;

                $Trendsalew = DB::table('prescription_filled_status')
                       ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                       ->join('druglists','druglists.id','=','prescription_details.drug_id')
                       ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                         ->groupBy('Manufacturer')
                         ->whereNull('prescription_filled_status.substitute_presc_id')
                         ->where([ ['prescription_filled_status.created_at','<',$today],
                                   ['prescription_filled_status.created_at','>=',$one_week_ago],
                                  ])
                          ->orderBy('totalq', 'desc')
                          ->LIMIT(10)
                           ->get();
                           $i=1;
                        

         //->$Trendsalew as $trend;

          $Trendsoldw = DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                  ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                    ->groupBy('Manufacturer')
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->where([ ['prescription_filled_status.created_at','<',$one_week_ago],
                              ['prescription_filled_status.created_at','>=',$two_week_ago],
                              ['druglists.Manufacturer','like','%'.$Trendsalew->Manufacturer.'%'],

                             ])
                     ->orderBy('totalq', 'desc')
                      ->first();
      
          if($Trendsoldw && ($Trendsalew->totalq > $Trendsoldw->totalq))  { 
               // $i;
                $Trendsalew->Manufacturer;
                 echo (round((($Trendsalew->totalq - $Trendsoldw->totalq)/$Trendsold->totalq)*100,2)).'%' ;
                 //{{$trend->totalq}}
                  
                    $i++;
                  }
                  $TrendsalewL = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('druglists','druglists.id','=','prescription_details.drug_id')
                    ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('Manufacturer')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_week_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                    

                $TrendsoldwL = DB::table('prescription_filled_status')
                ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                ->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                 ->groupBy('Manufacturer')
                 ->whereNull('prescription_filled_status.substitute_presc_id')
                 ->where([ ['prescription_filled_status.created_at','<',$one_week_ago],
                           ['prescription_filled_status.created_at','>=',$two_week_ago],
                           ['druglists.Manufacturer','like','%'.$trendL->Manufacturer.'%'],

                          ])
                  ->orderBy('totalq', 'desc')
                   ->first();
               
                  if($TrendsoldwL && ($trendL->totalq < $TrendsoldwL->totalq))  { 

                                //  {{$i}}
              // {{$trendL->Manufacturer}}
                echo (round((($trendL->totalq - $TrendsoldwL->totalq)/$trendL->totalq)*100,2)).'%' ;
               // {{$trendL->totalq}}
                  $i++;  
                   } 
                //replaced trend with Trendsalew!!

return json_encode($Trendsale);
}
public function showManutrendscompanyweek8(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

$Trendsale = DB::table('prescription_filled_status')
                         ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                         ->join('druglists','druglists.id','=','prescription_details.drug_id')
                         ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                           ->groupBy('Manufacturer')
                           ->whereNull('prescription_filled_status.substitute_presc_id')
                           ->where([ ['prescription_filled_status.created_at','<',$today],
                                     ['prescription_filled_status.created_at','>=',$one_week_ago],
                                    ])
                            ->orderBy('totalq', 'desc')
                            ->LIMIT(10)
                             ->get();
                             $i=1;

return json_encode($Trendsale);
}

public function showManutrendscompanymonth8(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

$Trendsale = DB::table('prescription_filled_status')
                         ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                         ->join('druglists','druglists.id','=','prescription_details.drug_id')
                         ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                           ->groupBy('Manufacturer')
                           ->whereNull('prescription_filled_status.substitute_presc_id')
                           ->where([ ['prescription_filled_status.created_at','<',$today],
                                     ['prescription_filled_status.created_at','>=',$one_month_ago],
                                    ])
                            ->orderBy('totalq', 'desc')
                            ->LIMIT(10)
                             ->get();
                             $i=1;

return json_encode($Trendsale);
}
public function showManutrendscompanyyear8(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

$Trendsale = DB::table('prescription_filled_status')
                         ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                         ->join('druglists','druglists.id','=','prescription_details.drug_id')
                         ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                           ->groupBy('Manufacturer')
                           ->whereNull('prescription_filled_status.substitute_presc_id')
                           ->where([ ['prescription_filled_status.created_at','<',$today],
                                     ['prescription_filled_status.created_at','>=',$one_year_ago],
                                    ])
                            ->orderBy('totalq', 'desc')
                            ->LIMIT(10)
                             ->get();
                             $i=1;

return json_encode($Trendsale);
}
public function showManutrendssubstitutionyear(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

 $sdTrendsaley = DB::table('substitute_presc_details')
                ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                ->where([ ['prescription_filled_status.created_at','<',$today],
                          ['prescription_filled_status.created_at','>=',$one_year_ago],
                         ])
                  ->groupBy('drugname')
                  ->orderBy('totalq', 'desc')
                   ->LIMIT(10)
                    ->get();
                    $i=1;
 


return json_encode($sdTrendsaley);
}
public function showManutrendssubstitutionmonth(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

  $sdTrendsalem = DB::table('substitute_presc_details')
                  ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                  ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                  ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                  ->where([ ['prescription_filled_status.created_at','<',$today],
                            ['prescription_filled_status.created_at','>=',$one_month_ago],
                           ])
                    ->groupBy('drugname')
                    ->orderBy('totalq', 'desc')
                     ->LIMIT(10)
                      ->get();
                      $i=1;
 


return json_encode($sdTrendsalem);
}
public function showManutrendssubstitutionweek(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

   $sdTrendsalew = DB::table('substitute_presc_details')
                  ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                  ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                  ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                  ->where([ ['prescription_filled_status.created_at','<',$today],
                            ['prescription_filled_status.created_at','>=',$one_week_ago],
                           ])
                    ->groupBy('drugname')
                    ->orderBy('totalq', 'desc')
                     ->LIMIT(10)
                      ->get();
                      $i=1;

return json_encode($sdTrendsalew);
}
public function showManutrendssubstitutiontoday(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

   $sdTrendsale = DB::table('substitute_presc_details')
                    ->join('prescription_filled_status','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                    ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
                    ->select('drug_id','drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                    ->where([ ['prescription_filled_status.created_at','<',$today],
                              ['prescription_filled_status.created_at','>=',$yesterday],
                             ])
                      ->groupBy('drugname')
                      ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;

return json_encode($sdTrendsale);

}
public function showManutrendsregiontoday(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

  $RTrendsale = DB::table('prescription_filled_status')
                      ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                      ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                      ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                        ->groupBy('county')
                        ->whereNull('prescription_filled_status.substitute_presc_id')
                        ->where([ ['prescription_filled_status.created_at','<',$today],
                                  ['prescription_filled_status.created_at','>=',$yesterday],
                                 ])
                         ->orderBy('totalq', 'desc')
                         ->LIMIT(10)
                          ->get();
                          $i=1;

return json_encode($RTrendsale);
}
public function showManutrendsregionweek(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

   $RTrendsalew = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                    ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('county')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_week_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                     

return json_encode($RTrendsalew);
}
public function showManutrendsregionmonth(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

   $RTrendsalem = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                    ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('county')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_month_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;

return json_encode($RTrendsalem);
}
public function showManutrendsregionyear(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

  $RTrendsaley = DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                  ->join('pharmacy','prescription_filled_status.outlet_id','=','pharmacy.id')
                  ->select('pharmacy.county','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                    ->groupBy('county')
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->where([ ['prescription_filled_status.created_at','<',$today],
                              ['prescription_filled_status.created_at','>=',$one_year_ago],
                             ])
                     ->orderBy('totalq', 'desc')
                     ->LIMIT(10)
                      ->get();
                      $i=1;

return json_encode($RTrendsaley);
}

public function showManutrendsdrugtoday(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

   $DTrendsale = DB::table('prescription_filled_status')
                      ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                      ->join('druglists','druglists.id','=','prescription_details.drug_id')
                      ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                        ->groupBy('drugname')
                        ->whereNull('prescription_filled_status.substitute_presc_id')
                        ->where([ ['prescription_filled_status.created_at','<',$today],
                                  ['prescription_filled_status.created_at','>=',$yesterday],
                                 ])
                         ->orderBy('totalq', 'desc')
                         ->LIMIT(10)
                          ->get();
                          $i=1;
                     

return json_encode($DTrendsale);
}
public function showManutrendsdrugweek(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

    $DTrendsalew = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('druglists','druglists.id','=','prescription_details.drug_id')
                    ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('drugname')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_week_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                     

return json_encode($DTrendsalew);
}
public function showManutrendsdrugmonth(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

    $DTrendsalem = DB::table('prescription_filled_status')
                    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                    ->join('druglists','druglists.id','=','prescription_details.drug_id')
                    ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                      ->groupBy('drugname')
                      ->whereNull('prescription_filled_status.substitute_presc_id')
                      ->where([ ['prescription_filled_status.created_at','<',$today],
                                ['prescription_filled_status.created_at','>=',$one_month_ago],
                               ])
                       ->orderBy('totalq', 'desc')
                       ->LIMIT(10)
                        ->get();
                        $i=1;
                     

return json_encode($DTrendsalem);
}
public function showManutrendsdrugyear(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

     $DTrendsaley = DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                  ->join('druglists','druglists.id','=','prescription_details.drug_id')
                  ->select('drugname','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                    ->groupBy('drugname')
                    ->whereNull('prescription_filled_status.substitute_presc_id')
                    ->where([ ['prescription_filled_status.created_at','<',$today],
                              ['prescription_filled_status.created_at','>=',$one_year_ago],
                             ])
                     ->orderBy('totalq', 'desc')
                     ->LIMIT(10)
                      ->get();
                      $i=1;
                     

return json_encode($DTrendsaley);
}

public function showManutrendscompanystoday(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

      $Trendsale = DB::table('prescription_filled_status')
                         ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                         ->join('druglists','druglists.id','=','prescription_details.drug_id')
                         ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                           ->groupBy('Manufacturer')
                           ->whereNull('prescription_filled_status.substitute_presc_id')
                           ->where([ ['prescription_filled_status.created_at','<',$today],
                                     ['prescription_filled_status.created_at','>=',$yesterday],
                                    ])
                            ->orderBy('totalq', 'desc')
                            ->LIMIT(10)
                             ->get();
                             $i=1;
                     

return json_encode($Trendsale);
}
public function showManutrendscompanysmonth(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

  $Trendsalem = DB::table('prescription_filled_status')
                       ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                       ->join('druglists','druglists.id','=','prescription_details.drug_id')
                       ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                         ->groupBy('Manufacturer')
                         ->whereNull('prescription_filled_status.substitute_presc_id')
                         ->where([ ['prescription_filled_status.created_at','<',$today],
                                   ['prescription_filled_status.created_at','>=',$one_month_ago],
                                  ])
                          ->orderBy('totalq', 'desc')
                          ->LIMIT(10)
                           ->get();
                           $i=1;
                     

return json_encode($Trendsalem);
}
public function showManutrendscompanysweek(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

   $Trendsalew = DB::table('prescription_filled_status')
                       ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                       ->join('druglists','druglists.id','=','prescription_details.drug_id')
                       ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                         ->groupBy('Manufacturer')
                         ->whereNull('prescription_filled_status.substitute_presc_id')
                         ->where([ ['prescription_filled_status.created_at','<',$today],
                                   ['prescription_filled_status.created_at','>=',$one_week_ago],
                                  ])
                          ->orderBy('totalq', 'desc')
                          ->LIMIT(10)
                           ->get();
                           $i=1;
                     

return json_encode($Trendsalew);
}
public function showManutrendscompanysyear(Request $request){

   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
   $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);

   $Trendsaley = DB::table('prescription_filled_status')
                     ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                     ->join('druglists','druglists.id','=','prescription_details.drug_id')
                     ->select('Manufacturer','prescription_filled_status.created_at', DB::raw('SUM(quantity) as totalq'))
                       ->groupBy('Manufacturer')
                       ->whereNull('prescription_filled_status.substitute_presc_id')
                       ->where([ ['prescription_filled_status.created_at','<',$today],
                                 ['prescription_filled_status.created_at','>=',$one_year_ago],
                                ])
                        ->orderBy('totalq', 'desc')
                        ->LIMIT(10)
                         ->get();
                         $i=1;
                     

return json_encode($Trendsaley);
}
 public function showManucompetitiondoctortoday( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

$Dt = DB::table('prescription_filled_status')
                          ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                          ->join('druglists','druglists.id','=','prescription_details.drug_id')
                          ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
                          ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
                          ->join('doctors','appointments.doc_id','=','doctors.id')

                          ->select('doctors.name as name', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
                            ->groupBy('name')
                            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                     ])

                             ->orderBy('totalq', 'desc')
                              ->get();

 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($Dt);//working but displaying 1 row ata a time
 }
 public function showManucompetitiondoctortodaytotalq( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
  
                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

$Dt = DB::table('prescription_filled_status')
                          ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                          ->join('druglists','druglists.id','=','prescription_details.drug_id')
                          ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
                          ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
                          ->join('doctors','appointments.doc_id','=','doctors.id')
                          ->select('doctors.name as name', DB::raw('SUM(quantity) as totalqb'), DB::raw('SUM(price * quantity) as total'))
->selectRaw('IFNULL(name, "0") as names')
//->selectRaw('IFNULL(Manufacturer, "0") as Manufacturer')
->selectRaw('IFNULL(SUM(quantity), "0") as totalqb')
->selectRaw('IFNULL(SUM(price * quantity), "0") as total')
                            ->where([ ['prescription_filled_status.created_at','>=',$todaysales],
                                     ])

                             ->orderBy('totalqb', 'desc')
                              ->get();

return json_encode($Dt);//working but displaying 1 row ata a time
 }

  public function showManucompetitiondoctorweek( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

$Dw = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')

  ->select('doctors.name as name', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
    ->groupBy('name')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_week_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])

     ->orderBy('totalq', 'desc')
      ->get();

 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($Dw);//working but displaying 1 row ata a time
 }

 public function showManucompetitiondoctorweektotalq( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                  
                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

$Dw = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')

  ->select('doctors.name as name', DB::raw('SUM(quantity) as totalqb'), DB::raw('SUM(price * quantity) as total'))
    //->groupBy('name')
  //->selectRaw('IFNULL(Manufacturer, "0") as Manufacturer')
->selectRaw('IFNULL(SUM(quantity), "0") as totalqb')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_week_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])

     ->orderBy('totalqb', 'desc')
      ->get();

return json_encode($Dw);//working but displaying 1 row ata a time
 }
  public function showManucompetitiondoctormonth( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

$Dm = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')

  ->select('doctors.name as name', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
    ->groupBy('name')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])

     ->orderBy('totalq', 'desc')
      ->get();

 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($Dm);//working but displaying 1 row ata a time
 }
 public function showManucompetitiondoctormonthtotalq( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

$Dm = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')

  ->select('doctors.name as name', DB::raw('SUM(quantity) as totalqb'), DB::raw('SUM(price * quantity) as total'))
  //  ->groupBy('name')
  ->selectRaw('IFNULL(SUM(quantity), "0") as totalqb')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_month_ago],
             ['prescription_filled_status.created_at','<=',$todaysales]
,                      ])
    //->whereNull(0)

     ->orderBy('totalqb', 'desc')
      ->get();

 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($Dm);//working but displaying 1 row ata a time
 }
  public function showManucompetitiondoctoryear( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

$Dy = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')

  ->select('doctors.name as name', DB::raw('SUM(quantity) as totalq'), DB::raw('SUM(price * quantity) as total'))
    ->groupBy('name')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])

     ->orderBy('totalq', 'desc')
      ->get();

 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($Dy);//working but displaying 1 row ata a time

 }
  public function showManucompetitiondoctoryeartotalq( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

$Dy = DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->join('prescriptions','prescription_details.presc_id','=','prescriptions.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
  ->join('doctors','appointments.doc_id','=','doctors.id')

  ->select('doctors.name as name', DB::raw('SUM(quantity) as totalqb'), DB::raw('SUM(price * quantity) as total'))
  //  ->groupBy('name')
  ->selectRaw('IFNULL(SUM(quantity), "0") as totalqb')
    ->where([
             ['prescription_filled_status.created_at','>=',$one_year_ago],
             ['prescription_filled_status.created_at','<=',$todaysales],
                      ])

     ->orderBy('totalqb', 'desc')
      ->get();

return json_encode($Dy);
}
 public function showManucompetitiondrugtoday( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $today = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();

                      foreach($Drugt as $drt)
                {

 $drugsum=DB::table('prescription_filled_status')
                  ->join('prescription_details','prescription_filled_status.presc_details_id','=','prescription_details.id')
                  ->select('prescription_filled_status.price as dprice')
                  ->selectRaw('SUM(quantity) as quantity')
                  ->selectRaw('SUM(price*quantity) as qprice')
                  ->where([  ['prescription_filled_status.created_at','>=',$today],
                             ['prescription_details.drug_id','=',$drt->company], ])
                  ->whereNull('prescription_filled_status.substitute_presc_id')
                  ->get();
}
 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($drugsum);//working but displaying 1 row ata a time
 }
 public function showManucompetitiondrugweek( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();







 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($Dy);//working but displaying 1 row ata a time
 }
 public function showManucompetitiondrugmonth( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();




 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($Dy);//working but displaying 1 row ata a time
 }
 public function showManucompetitiondrugyear( Request $request){
   $i =1;

 $rep=DB::table('sales_rep');

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 
  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();
  $drug_id=DB::table('druglists');

   $Mname = $manufacturer->name;

   $todaysales = Carbon::today();
   $yesterday = Carbon::today()->subDays(1);
                    $previous = Carbon::today()->subDays(2);
                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $two_week_ago = Carbon::now()->subWeeks(2);
                    $one_month_ago = Carbon::now()->subMonths(1);
                    $two_month_ago = Carbon::now()->subMonths(2);
                    $one_year_ago = Carbon::now()->subYears(1);
                    $two_year_ago = Carbon::now()->subYears(2);


                
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
} 

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;
                $Mid = $manufacturer->id;

                     $Drugt = DB::table('compe_drugs')->where('manu_id','>=',$Mid )->get();






 // $data = array();
 // $data['dist2'] = [{}]
            //part 7
            //this week

return json_encode($Dy);//working but displaying 1 row ata a time
 }
 public function showManucounties(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
$countytots = DB::table('county')
->select(DB::raw('count(county.county) as totcounty'))
->get();

return json_encode($countytots);
}
public function showManudoctors(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
$doctortots = DB::table('doctors')
->select(DB::raw('count(doctors.name) as totdoctors'))
->get();

return json_encode($doctortots);

}
public function showManupharmacies(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
$pharmacytots = DB::table('pharmacy')
->select(DB::raw('count(pharmacy.name) as totpharmacies'))
->get();

return json_encode($pharmacytots);
}
public function showManuprescriptions(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
$prescriptionstots = DB::table('prescriptions')
->select(DB::raw('count(prescriptions.id) as totprescriptions'))
 //->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
    
->get();

return json_encode($prescriptionstots);
}
public function showManudrugs(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;
$drugstots = DB::table('druglists')
->select(DB::raw('count(druglists.id) as totdrugs'))
  ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
    ])
->get();

return json_encode($drugstots);
}
public function showManusaletots(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select (DB::raw('SUM(prescription_filled_status.total) as tt'))
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$today],
 // ['pharmacy.id','like', '%' .$test . '%']
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select (DB::raw('SUM(prescription_filled_status.total) as tt'))
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')

->union($prescribed)                                               
->get();
return json_encode($Dsales);
}
public function showManusaletots1(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

 $today = Carbon::today();
   $one_year_ago = Carbon::now()->subYears(1);


$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select (DB::raw('SUM(prescription_filled_status.total) as tt'))
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')

//->union($prescribed)                                               
->get();
return json_encode($Dsales);
}


//showmanudrugsubstitutionsawaytodaysub line:263
public function showManudrugsubstitutionsawaytodaysub(Request $request){

 $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
  
   $drug_id=DB::table('druglists');
  $today = Carbon::today();
  $one_week_ago = Carbon::now()->subWeeks(1);
  $one_month_ago = Carbon::now()->subMonths(1);
  $one_year_ago = Carbon::now()->subYears(1);

   $drugs = array();
  $prescribed = DB::table('prescriptions')
   ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
   ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
   ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
   ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
   ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
   ->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
   ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
    'pharmacy.county',
   'prescription_filled_status.substitute_presc_id')
 ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
           ['prescription_filled_status.created_at','>=',$today],
         //  ['druglists.id',$rep->drug_id],
        //   ['pharmacy.county','like','%'.$rep->region.'%'],
         ])
 ->whereNotNull('prescription_filled_status.substitute_presc_id')
 ->get();
foreach($prescribed as $daily){
   $substituted = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ['druglists.id',$rep->drug_id],

  ])

  ->first();
$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}else{
    return json_encode($drugs);
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}
public function showManudrugsubstitutionsawayweeksub(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
  
   $drug_id=DB::table('druglists');

   $today = Carbon::today();
  $one_week_ago = Carbon::now()->subWeeks(1);
  $one_month_ago = Carbon::now()->subMonths(1);
  $one_year_ago = Carbon::now()->subYears(1);

   $drugs = array();

  $prescribedw = DB::table('prescriptions')
  ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
  ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
  ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
  ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
  'pharmacy.county','prescription_details.doseform',
  'prescription_filled_status.substitute_presc_id')
  ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  //['druglists.id',$rep->drug_id],
  //['pharmacy.county','like','%'.$rep->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
foreach($prescribedw as $daily){
   $substituted = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ['druglists.id',$rep->drug_id],

  ])

  ->first();
  //$i++;  
   $drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}

}
  return json_encode($drugs);
}

public function showManudrugsubstitutionsawaymonthsub(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
   $today = Carbon::today();
  $one_week_ago = Carbon::now()->subWeeks(1);
  $one_month_ago = Carbon::now()->subMonths(1);
  $one_year_ago = Carbon::now()->subYears(1);

   $drugs = array();

  $prescribedm= DB::table('prescriptions')
  ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
  ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
  ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
  ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
  'pharmacy.county','prescription_details.doseform',
  'prescription_filled_status.substitute_presc_id')
  ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
  ['prescription_filled_status.created_at','>=',$one_month_ago],
  ['prescription_filled_status.created_at','<=',$today],
 // ['druglists.id',$rep->drug_id],
 // ['pharmacy.county','like','%'.$rep->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
 foreach($prescribedm as $daily){
   $substitutedm = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ['druglists.id',$rep->drug_id],

  ])

  ->first();
  //$i++;  
   $drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substitutedm)>0){
$drugs['subdrugname'] = $substitutedm->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}
//263 line go to
public function showManudrugsubstitutionsawayyearsub(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;
 //$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
//dd($rep->drug_id);

if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', $id)->first();

}
                $Mname = $manufacturer->name;


                $Mid = $manufacturer->id;
   $today = Carbon::today();
  $one_year_ago = Carbon::now()->subYears(1);

  $drugs = array();

  $prescribed= DB::table('prescriptions')
  ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
  ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
  ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
  ->leftJoin('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
  ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
  'pharmacy.county','prescription_details.doseform',
  'prescription_filled_status.substitute_presc_id')
  ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
   ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$today],
  //['druglists.id',$rep->drug_id],
  // ['pharmacy.county','like','%'.$rep->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
 //dd($prescribed); 
foreach($substituted  as $daily)
{

 $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->Join('prescription_filled_status','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->select('druglists.drugname as subdrugname')
 ->where([ 
          ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           // ['druglists.id',$rep->drug_id],
          ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();

$drugs['drugname'] = $daily->drugname;
$drugs['pharmacy'] = $daily->pharmacy;
$drugs['name'] = $daily->name;
if(count($substituted)>0){
$drugs['subdrugname'] = $substituted->subdrugname;
}
//dd($daily->substitute_presc_id);
//return json_encode($substituted);
}
  return json_encode($drugs);
}
public function showManusalescounty1(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='MOMBASA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty2(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='KWALE';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}

public function showManusalescounty3(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='KILIFI';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}

public function showManusalescounty4(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='TANA RIVER';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty5(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='LAMU';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty6(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='TAITA TAVETA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty7(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='GARISSA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty8(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='WAJIR';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty9(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='MANDERA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty10(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='MARSABIT';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty11(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='ISIOLO';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty12(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='MERU';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty13(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='THARAKA NITHI';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty14(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='EMBU';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty15(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='KITUI';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty16(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='MACHAKOS';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty17(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='MAKUENI';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty18(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='NYANDARUA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty19(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='NYERI';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty20(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='KIRINYAGA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty21(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname="MURANG'A";
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty22(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='KIAMBU';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty23(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='TURKANA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty24(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='WEST POKOT';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty25(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='UASIN GISHU';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty26(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='TRANS-NZOIA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty27(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='SAMBURU';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty28(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='NANDI';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty29(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='ELGEYO-MARAKWET';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty30(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='BARINGO';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty31(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='LAIKIPIA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty32(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='NAKURU';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty33(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='NAROK';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty34(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='KAJIADO';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty35(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='KERICHO';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty36(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='BOMET';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty37(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='KAKAMEGA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty38(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='VIHIGA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty39(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='BUNGOMA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty40(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='BUSIA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty41(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='SIAYA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty42(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='KISUMU';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty43(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='HOMA BAY';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty44(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='MIGORI';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty45(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='KISII';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty46(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='NYAMIRA';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showManusalescounty47(Request $request)
{
  $i =1;

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

$Mname = $manufacturer->name;

$countycapsname='NAIROBI';
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
$one_year_ago = Carbon::now()->subYears(1);

$prescribed = DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
  ['prescription_filled_status.created_at','<=',$todaysales],
  ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNull('prescription_filled_status.substitute_presc_id');

$Dsales=DB::table('prescriptions')
->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select ('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county','pharmacy.id as pharmid',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
 ['prescription_filled_status.created_at','>=',$one_year_ago],
   ['prescription_filled_status.created_at','<=',$todaysales],
   ['pharmacy.county','like', '%' .$countycapsname . '%'],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

 return json_encode($Dsales);
}
public function showmanustockbypharmacy(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

   $Mname = $manufacturer->name;

     $one_week_ago = Carbon::now()->subWeeks(1);
                    $today = Carbon::today();
                     $invents = DB::table('inventory')
                         ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                         ->join('druglists','inventory.drug_id','=','druglists.id')
                         ->select('pharmacy.id as pharm','pharmacy.name'
                        )
                         ->where([['druglists.Manufacturer','like','%'.$Mname.'%'],
                          ])
                         ->whereIn('inventory.created_at', function($query)
                             {
                                 $query->select(DB::raw('max(inventory.created_at)'))
                                       ->from('inventory')
                                       ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                                       ->join('druglists','inventory.drug_id','=','druglists.id')
                                       ->groupBy('pharmacy.name','druglists.drugname');

                             })
                          ->get();
                             $i=1;

                            // $array = array();
                            // $array['invents']=$invents;
                            // $array['count']=count($invents);
return json_encode($invents);
}

//chem 1 test
public function showmanustockbypharmacy1(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $mypharm = 1;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

   $Mname = $manufacturer->name;

     $one_week_ago = Carbon::now()->subWeeks(1);
                    $today = Carbon::today();
                     $invents = DB::table('inventory')
                         ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                         ->join('druglists','inventory.drug_id','=','druglists.id')
                          ->select('pharmacy.id as pharm','pharmacy.name','pharmacy.county','inventory.created_at','inventory.quantity','inventory.strength',
                         'inventory.strength_unit','druglists.id','druglists.drugname'
                        )
                         ->where([['druglists.Manufacturer','like','%'.$Mname.'%'],
                             ['pharmacy.id','like','%'.$mypharm.'%'],
                          ])
                         ->whereIn('inventory.created_at', function($query)
                             {
                                 $query->select(DB::raw('max(inventory.created_at)'))
                                       ->from('inventory')
                                       ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                                       ->join('druglists','inventory.drug_id','=','druglists.id')
                                       ->groupBy('pharmacy.name','druglists.drugname');

                             })
                          ->get();
                             $i=1;

                            // $array = array();
                            // $array['invents']=$invents;
                            // $array['count']=count($invents);
return json_encode($invents);
}
//chem 2 test

public function showmanustockbypharmacy2(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

   $Mname = $manufacturer->name;

     $one_week_ago = Carbon::now()->subWeeks(1);
                    $today = Carbon::today();
                     $invents = DB::table('inventory')
                         ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                         ->join('druglists','inventory.drug_id','=','druglists.id')
                         ->select('pharmacy.id as pharm','pharmacy.name'
                        )
                         ->where([['druglists.Manufacturer','like','%'.$Mname.'%'],
                          ])
                         ->whereIn('inventory.created_at', function($query)
                             {
                                 $query->select(DB::raw('max(inventory.created_at)'))
                                       ->from('inventory')
                                       ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                                       ->join('druglists','inventory.drug_id','=','druglists.id')
                                       ->groupBy('pharmacy.name','druglists.drugname');

                             })
                          ->get();
                             $i=1;

                            // $array = array();
                            // $array['invents']=$invents;
                            // $array['count']=count($invents);
return json_encode($invents);
}
//chem 3 test
public function showmanustockbypharmacy3(Request $request){
$user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $mypharm = 3;

  $manufacturer=DB::table('manufacturers')->where('user_id',$id)->first();

   $Mname = $manufacturer->name;

     $one_week_ago = Carbon::now()->subWeeks(1);
                    $today = Carbon::today();
                     $invents = DB::table('inventory')
                         ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                         ->join('druglists','inventory.drug_id','=','druglists.id')
                          ->select('pharmacy.id as pharm','pharmacy.name','pharmacy.county','inventory.created_at','inventory.quantity','inventory.strength',
                         'inventory.strength_unit','druglists.id','druglists.drugname'
                        )
                         ->where([['druglists.Manufacturer','like','%'.$Mname.'%'],
                          ['pharmacy.id','like','%'.$mypharm.'%'],

                          ])
                         ->whereIn('inventory.created_at', function($query)
                             {
                                 $query->select(DB::raw('max(inventory.created_at)'))
                                       ->from('inventory')
                                       ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                                       ->join('druglists','inventory.drug_id','=','druglists.id')
                                       ->groupBy('pharmacy.name','druglists.drugname');

                             })
                          ->get();
                             $i=1;

                            // $array = array();
                            // $array['invents']=$invents;
                            // $array['count']=count($invents);
return json_encode($invents);
}

}