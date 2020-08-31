<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Druglist;
use App\Observation;
use App\Symptom;
use App\Chief;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\County;
use App\Http\Requests;

/**
*
*/
class PharmacyAndroidController extends Controller
{

      public function pharmacyhomepage( Request $request)
    {
       $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;


        $today = Carbon::today();
        $today2 = $today->toDateString();



 $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

        $facility = $data->premiseid;

        $results = DB::table('afya_users')
                ->join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
                ->join('appointments', 'appointments.afya_user_id', '=', 'afya_users.id')
                ->join('prescriptions', 'prescriptions.appointment_id', '=', 'appointments.id')
                ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
                ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
                ->select('afya_users.*','prescriptions.created_at AS presc_date','prescriptions.id AS presc_id',
                'doctors.name', 'appointments.persontreated', 'afya_users.id AS af_id')
                ->where('afyamessages.facilityCode', '=', $facility)
                ->whereNotNull('afya_users.dob')
                ->whereDate('afyamessages.created_at','=',$today2)
                ->whereIn('prescriptions.filled_status', [0, 2])
                ->orWhere(function ($query) use ($facility,$today2){
                $query->where('afyamessages.facilityCode', '=', $facility)
                      ->whereNotNull('afya_users.dob')
                      ->whereDate('afyamessages.created_at','=',$today2)
                      ->where('prescriptions.filled_status', '=', 0);
                })
                ->groupBy('appointments.id')
                ->get();

        //         $drugs = DB::table('druglists')->distinct()->get(['drugname']);

        // $alternatives = DB::table('afya_users')
        //               ->join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
        //               ->select('afya_users.*','afyamessages.created_at AS created_at')
        //               ->where('afyamessages.facilityCode', '=', $facility)
        //               ->whereDate('afyamessages.created_at','=',$today2)
        //               ->whereNull('afya_users.dob')
        //               ->whereNull('afyamessages.status')
        //               ->get();


        // return view('pharmacy.home')->with('results',$results)->with('drugs', $drugs)
        // ->with('alternatives',$alternatives);
                      return json_encode($results);

    }
public function showPharmadmininventoryreport(Request $request)
{

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $reports = DB::table('prescription_filled_status')
              ->join('prescription_details', 'prescription_filled_status.presc_details_id', '=', 'prescription_details.id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->leftJoin('inventory', 'inventory.drug_id', '=', 'druglists.id')
              ->leftJoin('inventory_updates', 'inventory_updates.drug_id', '=', 'inventory.drug_id')
              ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
              ->select('prescription_filled_status.id','prescription_filled_status.quantity',
              'inventory.quantity AS inv_qty', 'inventory_updates.quantity AS inv_qty2',
              'druglists.drugname', 'prescription_filled_status.available')
             ->selectRaw('IFNULL(inventory_updates.quantity,"Update not available")  as  inv_qty2')
              ->selectRaw('IFNULL(inventory.quantity,"Update not available") as inv_qty')
              //->selectRaw('IFNULL(Manufacturer, "N/A") as Manufacturer')
              ->get();

      return json_encode($reports);
}
public function showPharmdrugs(Request $request)
{

  // $user=DB::table('users')->where('email', $request->email)->first();
  // $id = $user->id;

  $reports = DB::table('druglists')
               ->select('id','drugname')
              ->get();
// // $array = array();
//                             // $array['invents']=$invents;
// $array = array();

// $array ['result'] = $reports;

      return json_encode($reports);
}
public function showPharmsuppliers(Request $request)
{

  // $user=DB::table('users')->where('email', $request->email)->first();
  // $id = $user->id;

  $reports = DB::table('drug_suppliers')
               ->select('id','name')
              ->get();

                       // $array['invents']=$invents;
$array = array();

$array ['result'] = $reports;

      return json_encode($array);
   //   return json_encode($reports);
}

public function showPharmmangerinventoryreport(Request $request)
{

  $user=DB::table('users')->where('email', $request->email)->first();
  $id = $user->id;

  $reports = DB::table('prescription_filled_status')
              ->join('prescription_details', 'prescription_filled_status.presc_details_id', '=', 'prescription_details.id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->leftJoin('inventory', 'inventory.drug_id', '=', 'druglists.id')
              ->leftJoin('inventory_updates', 'inventory_updates.drug_id', '=', 'inventory.drug_id')
              ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
              ->select('prescription_filled_status.id','prescription_filled_status.quantity',
              'inventory.quantity AS inv_qty', 'inventory_updates.quantity AS inv_qty2',
              'druglists.drugname', 'prescription_filled_status.available')
              ->get();

      return json_encode($reports);
}
public function showPharmadminprescriptions(Request $request)

{
   $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;
   //$user_id = Auth::id();
        // $data = DB::table('pharmacists')
        //           ->where('user_id', $user_id)
        //           ->first();

        //$facility = $data->premiseid;
      //  
  // $results = DB::table('prescriptions')
  //       ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
  //       ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
  //       ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
  //       ->join('route', 'prescription_details.routes', '=', 'route.id')
  //       ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
  //       ->select('druglists.drugname', 'druglists.id AS drug_id', 'prescriptions.*','prescription_details.*',
  //        'route.name','prescription_details.id AS presc_id','prescriptions.id AS the_id',
  //        'prescriptions.appointment_id','appointments.persontreated','appointments.afya_user_id')
  //       ->where([
  //         ['prescription_details.id', '=', $id]
  //       ])
  //       ->groupBy('prescription_details.id')
  //       ->first();
       $prescs = DB::table('prescription_filled_status')
            ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
            ->join('prescriptions', 'prescriptions.id', '=', 'prescription_details.presc_id')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
            ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
            ->leftJoin('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
            ->leftjoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
            ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
            'prescription_details.*', 'prescription_filled_status.created_at AS date_filled', 'doctors.name AS doc', 'prescriptions.*',
            'prescriptions.created_at AS prescription_date', 'inventory.drugname AS inv_drug', 'prescriptions.id AS presc_id',
            'prescription_details.id AS pdetails_id', 'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
            ->where('prescription_filled_status.outlet_id', '=', $facility)
            ->groupBy('prescription_filled_status.id')
            ->get();

            return json_encode($prescs);

}
public function showPharmadmininventory(Request $request){
   $i = 1;
     
   // $id = $request->inventory_id;
  // $id=DB::table('id');
   //, DB::raw('DATE_FORMAT (prescription_filled_status.created_at ,"%d-%b-%Y") AS date_filled'),

       $inventory = DB::table('inventory')
                ->join('druglists','druglists.id','=','inventory.drug_id')
                ->join('strength','strength.strength','=','inventory.strength')
                ->select('druglists.Manufacturer','druglists.drugname',
                'druglists.id AS drug_id','strength.strength','inventory.*','inventory.id AS inventory_id',
                DB::raw('DATE_FORMAT (inventory.updated_at ,"%d-%b-%Y") AS updated_at'))
                ->where([
                //  ['inventory.id', '=', $id],
                //  ['is_active', '=', 'yes'],
                ])
                ->get();

                return json_encode($inventory);
}
// public function updateInventorymsh(Request $request)
//   {

//     //$inv = $request->inventory_id;
//     $id = $request->id;
//     $quantity = $request->quantity;
//     $drug_id = $request->drug_id;

//     $user_id = Auth::user()->id;

//     $data = DB::table('pharmacists')
//               ->where('user_id', $user_id)
//               ->first();

//     $facility = $data->premiseid;

//     $count = count($drug_id);
// //the old update status updated to 0 and the new insert will have 1 to show it is the latest
//     for($i=0;$i<$count;$i++)
//     {
//       DB::table('inventory_updates')->where('id','=', $id[$i])
//       ->update([
//         'status'=>0,
//         'updated_at'=>Carbon::now()
//       ]);

//     DB::table('inventory_updates')
//     ->insert([
//       'drug_id'=>$drug_id[$i],
//       'quantity'=>$quantity[$i],
//       'status'=>1, //this is latest inventory update
//       'submitted_by'=>$user_id,
//       'outlet_id'=>$facility,
//       'created_at'=>Carbon::now(),
//       'updated_at'=>Carbon::now()

//     }
// echo "bb";;
//   }
public function showPharmmanagerinventory(Request $request){
   $i = 1;
     
   // $id = $request->inventory_id;
  // $id=DB::table('id');

       $inventory = DB::table('inventory')
                ->join('druglists','druglists.id','=','inventory.drug_id')
                ->join('strength','strength.strength','=','inventory.strength')
                ->select('druglists.Manufacturer','druglists.drugname',
                'druglists.id AS drug_id','strength.strength','inventory.*','inventory.id AS inventory_id')
                ->where([
                //  ['inventory.id', '=', $id],
                  ['is_active', '=', 'yes'],
                ])
                ->get();

                return json_encode($inventory);
}

//sales
public function showPharmadminpresc(Request $request){

   $user=DB::table('users')->where('email', $request->email)->first();
     
      $user_id = Auth::id();

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

   //   $facility = $data->premiseid;

    
    //start of presc
      $i = 1;

      $inventory=DB::table('inventory');
       foreach($inventory as $inv)
       {

         $inv_id = $inv->inv_id;

         $entry_date = $inv->entry_date;
         $drug_id = $inv->drug_id;
         $inventory_id = $inv->inventory_id;
         $counter = DB::table('prescription_filled_status')
                ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                ->select(DB::raw('SUM(prescription_filled_status.quantity) AS count1'))
                ->where('prescription_details.drug_id', '=', $drug_id)
                ->first();
        $sold= $counter->count1;

        $stock = DB::table('inventory')
                    ->join('druglists','druglists.id','=','inventory.drug_id')
                    ->join('strength','strength.strength','=','inventory.strength')
                    ->where([
                      ['inventory.quantity', '>', 0],
                      ['is_active', '=', 'yes'],
                      ['inventory.drug_id' , '=', $drug_id],
                    ])
                    ->sum('inventory.quantity');

          $bought = $stock;

          $stock_level = $bought - $sold;

          /**
          *Get supplier
          */
          $supplier = DB::table('inventory')
                    ->join('drug_suppliers', 'drug_suppliers.id', '=', 'inventory.supplier')
                    ->select('drug_suppliers.name')
                    ->where('inventory.id', '=', $inventory_id)
                    ->first();
        }

  return json_encode($supplier);
// <!--   end of presc
//  -->
}


//inventory test
public function showInv(Request $request){

  $i=1;

  $user=DB::table('users')->where('email', $request->email)->first();
     
      $user_id = Auth::id();

 
  //  $user_id = Auth::user()->id;
  $user=DB::table('users')->where('email', $request->email)->first();

    $data = DB::table('pharmacists')
              ->where('user_id', $user_id)
              ->first();
              

  //  $facility = $data->premiseid;

    //$manufacturer = $request->manufacturer;

    $drug = $request->prescription;
    $supplier = $request->supplier;
    $strength = $request->strength;
    $strength_unit = $request->strength_unit;
    $quantity = $request->quantity;
    $price = $request->price;
    $retail_price = $request->retail_price;

     $dname = DB::table('druglists')
            ->select('drugname')
            ->where('id', '=', $drug)
            ->first();
   // $drug_name = $dname->drugname;


    $id1 = DB::table('inventory')->insertGetId([
      'drug_id'=>$drug,
      'supplier'=>$supplier,
      'drugname'=>$drugname,
      'strength'=>$strength,
      'strength_unit'=>$strength_unit,
      'quantity'=>$quantity,
      'price'=>$price,
      'recommended_retail_price'=>$retail_price,
      'submitted_by'=>$user_id,
     // 'outlet_id'=>$facility,
      'is_active'=>'yes',
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);

    DB::table('inventory_updates')->insert(
      [
      'drug_id'=>$drug,
      'created_at'=>Carbon::now()
      ]
    );

    echo "success";

}
public function showPharmadminsalestoday(Request $request){

   $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;
      $today = Carbon::today();

    //     /* Get today's sales*/
    $todays = DB::table('prescription_filled_status')
            ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
            ->join('prescriptions', 'prescriptions.id', '=', 'prescription_details.presc_id')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
            ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
            ->leftJoin('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
            ->leftjoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
            ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
        'prescription_details.*', DB::raw('DATE_FORMAT (prescription_filled_status.created_at ,"%d-%b-%Y") AS date_filled'),
        'doctors.name AS doc',DB::raw('DATE_FORMAT (prescriptions.created_at, "%d-%b-%Y") AS prescription_date'),
        'inventory.drugname AS inv_drug', 'prescriptions.id AS presc_id','prescription_details.id AS pdetails_id', 
               'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
         ->where([
              ['prescription_filled_status.outlet_id', '=', $facility],
         ])
            ->whereRaw('date(prescription_filled_status.created_at) = CURDATE()')
            ->orderby('prescription_filled_status.created_at','desc')
            ->groupBy('prescription_filled_status.id')
            ->get();

return json_encode($todays);
     // echo $today;
}
public function showPharmadminsalesweek(Request $request){

 $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;
          /* Get this week's sales*/
    $weeks = DB::table('prescription_filled_status')
            ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
            ->join('prescriptions', 'prescriptions.id', '=', 'prescription_details.presc_id')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
            ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
            ->leftJoin('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
            ->leftjoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
             ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
        'prescription_details.*', DB::raw('DATE_FORMAT (prescription_filled_status.created_at ,"%d-%b-%Y") AS date_filled'),
        'doctors.name AS doc',DB::raw('DATE_FORMAT (prescriptions.created_at, "%d-%b-%Y") AS prescription_date'),
        'inventory.drugname AS inv_drug', 'prescriptions.id AS presc_id','prescription_details.id AS pdetails_id', 
               'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
        ->where([
              ['prescription_filled_status.outlet_id', '=', $facility],
            ])
            ->whereBetween('prescription_filled_status.created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
            ])
            ->orderby('prescription_filled_status.created_at','desc')
            ->groupBy('prescription_filled_status.id')
            ->get();

            return json_encode($weeks);
}

            /* Get this month's sales*/
public function showPharmadminsalesmonth(Request $request){

  $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;

      $months = DB::table('prescription_filled_status')
              ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
              ->join('prescriptions', 'prescriptions.id', '=', 'prescription_details.presc_id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
              ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
              ->leftJoin('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
              ->leftjoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
              ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
        'prescription_details.*', DB::raw('DATE_FORMAT (prescription_filled_status.created_at ,"%d-%b-%Y") AS date_filled'),
        'doctors.name AS doc',DB::raw('DATE_FORMAT (prescriptions.created_at, "%d-%b-%Y") AS prescription_date'),
        'inventory.drugname AS inv_drug', 'prescriptions.id AS presc_id','prescription_details.id AS pdetails_id', 
               'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
         ->where([
                ['prescription_filled_status.outlet_id', '=', $facility],
              ])
              ->whereBetween('prescription_filled_status.created_at', [
              Carbon::now()->startOfMonth(),
              Carbon::now()->endOfMonth(),
              ])
              ->orderby('prescription_filled_status.created_at','desc')
              ->groupBy('prescription_filled_status.id')
              ->get();

              return json_encode($months);

}
public function showPharmadminsalesyear(Request $request){

    $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id; 

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;
              /* Get this year's sales*/
        $years = DB::table('prescription_filled_status')
              ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
              ->join('prescriptions', 'prescriptions.id', '=', 'prescription_details.presc_id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
              ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
              ->leftJoin('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
              ->leftjoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
              //->groupBy('druglists.drugname')
              // ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
              // 'prescription_details.*', 'prescription_filled_status.created_at AS date_filled', 'doctors.name AS doc',
              //  'prescriptions.*','prescriptions.created_at AS prescription_date', 'inventory.drugname AS inv_drug', 
              //  'prescriptions.id AS presc_id','prescription_details.id AS pdetails_id', 
              //  'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
              ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
        'prescription_details.*', DB::raw('DATE_FORMAT (prescription_filled_status.created_at ,"%d-%b-%Y") AS date_filled'),
        'doctors.name AS doc',DB::raw('DATE_FORMAT (prescriptions.created_at, "%d-%b-%Y") AS prescription_date'),
        'inventory.drugname AS inv_drug', 'prescriptions.id AS presc_id','prescription_details.id AS pdetails_id', 
               'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
        
              ->where([
                ['prescription_filled_status.outlet_id', '=', $facility],
              ])
              ->whereBetween('prescription_filled_status.created_at', [
              Carbon::now()->startOfYear(),
              Carbon::now()->endOfYear(),
              ])
              ->orderby('prescription_filled_status.created_at','desc')
              //->groupBy('druglists.drugname')
              ->groupBy('prescription_filled_status.id')
            //  ->selectRaw('prescription_filled_status.total')->distinct()
              ->get();


        return json_encode($years);
}
public function showPharmadminsalesall(Request $request)
{
$user=DB::table('users')->where('email', $request->email)->first();
$user_id = $user->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;

      $prescs = DB::table('prescriptions')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
        ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
        ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
        ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
        ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
        ->join('prescription_filled_status', 'prescription_filled_status.presc_details_id', '=', 'prescription_details.id')
        ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
        ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
        ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
        'prescription_details.*', DB::raw('DATE_FORMAT (prescription_filled_status.created_at ,"%d-%b-%Y") AS date_filled'),
        'doctors.name AS doc',DB::raw('DATE_FORMAT (prescriptions.created_at, "%d-%b-%Y") AS prescription_date'),'inventory.drugname AS inv_drug')
      
        ->where([
          ['afyamessages.facilityCode', '=', $facility],
        ])
        ->groupBy('prescription_filled_status.id')
        ->get();

        return json_encode($prescs);

      }
































//olals stuff
	public function prescriptions(Request $request)
    {
        $today = Carbon::today();
        $today2 = $today->toDateString();

        $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;

        $data = DB::table('pharmacists')
                  ->where('user_id', $user_id)
                  ->first();

        $facility = $data->premiseid;

        $results = DB::table('afya_users')
                ->join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
                ->join('appointments', 'appointments.afya_user_id', '=', 'afya_users.id')
                ->join('prescriptions', 'prescriptions.appointment_id', '=', 'appointments.id')
                ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
                ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
                ->select('afya_users.*','prescriptions.created_at AS presc_date','prescriptions.id AS presc_id',
                'doctors.name', 'appointments.persontreated', 'afya_users.id AS af_id')
                ->where('afyamessages.facilityCode', '=', $facility)
                ->whereDate('afyamessages.created_at','=',$today2)
                ->whereIn('prescriptions.filled_status', [0, 2])
                ->orWhere(function ($query) use ($facility,$today2){
                $query->where('afyamessages.facilityCode', '=', $facility)
                      ->whereDate('afyamessages.created_at','=',$today2)
                      ->where('prescriptions.filled_status', '=', 0);
                })
                ->groupBy('appointments.id')
                ->get();

                $drugs = DB::table('druglists')->distinct()->get(['drugname']);
                // $drugs = array($drugs);
              //  return response(view('drug',array('drug'=>$drug)),200, ['Content-Type' => 'application/json']);

        return json_encode($results);

    }


      public function inventoryReport(Request $request)
  {
     /*$user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;*/

    $reports = DB::table('prescription_filled_status')
              ->join('prescription_details', 'prescription_filled_status.presc_details_id', '=', 'prescription_details.id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->leftJoin('inventory', 'inventory.drug_id', '=', 'druglists.id')
              ->leftJoin('inventory_updates', 'inventory_updates.drug_id', '=', 'inventory.id')
              ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
              ->leftJoin(DB::raw('(select prescription_filled_status.quantity as qq_quantity,prescription_filled_status.id as qid from prescription_filled_status left join substitute_presc_details on substitute_presc_details.id=prescription_filled_status.substitute_presc_id) as qq'), function($join){
                                 $join->on('prescription_filled_status.id', '=', 'qq.qid');
                            })
              ->select('prescription_filled_status.id','prescription_filled_status.quantity',
              'inventory.quantity AS inv_qty', 'inventory_updates.quantity AS inv_qty2',
              'druglists.drugname', 'prescription_filled_status.available','qq.qq_quantity')
              ->get();

      return json_encode($reports);
  }

  //under FilledPresc

     public function TodaysSales(Request $request)
    {


        $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;


        /* Get today's sales*/
        $todays = DB::table('prescriptions')
          ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
          ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
          ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
          ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
          ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
          ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
          ->join('prescription_filled_status', 'prescription_filled_status.presc_details_id', '=', 'prescription_details.id')
          ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
          ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
          ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*','prescription_details.*',
          'prescription_filled_status.created_at AS date_filled','doctors.name AS doc',
          'prescription_filled_status.total AS total','inventory.drugname AS inv_drug',
          'prescriptions.created_at AS prescription_date')
          ->where([
            ['afyamessages.facilityCode', '=', $facility],
          ])
          ->whereRaw('date(prescription_filled_status.created_at) = CURDATE()')
          ->orderby('prescription_filled_status.created_at','desc')
          ->groupBy('prescription_filled_status.id')
          ->get();


        return json_encode($todays);
        }


             public function ThisWeeksSales(Request $request)
    {


        $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;


          /* Get this week's sales*/
          $weeks = DB::table('prescriptions')
            ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
            ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
            ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
            ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
            ->join('prescription_filled_status', 'prescription_filled_status.presc_details_id', '=', 'prescription_details.id')
            ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
            ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
            ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*','prescription_details.*',
            'prescription_filled_status.created_at AS date_filled','doctors.name AS doc',
            'prescription_filled_status.total AS total','inventory.drugname AS inv_drug',
            'prescriptions.created_at AS prescription_date')
            ->where([
              ['afyamessages.facilityCode', '=', $facility],
            ])
            ->whereBetween('prescription_filled_status.created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
            ])
            ->orderby('prescription_filled_status.created_at','desc')
            ->groupBy('prescription_filled_status.id')
            ->get();


        return json_encode($weeks);

            }


            public function ThisMonthsSales(Request $request)
    {


        $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;


            /* Get this month's sales*/
            $months = DB::table('prescriptions')
              ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
              ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
              ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
              ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
              ->join('prescription_filled_status', 'prescription_filled_status.presc_details_id', '=', 'prescription_details.id')
              ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
              ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
              ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*','prescription_details.*',
              'prescription_filled_status.created_at AS date_filled','doctors.name AS doc',
              'prescription_filled_status.total AS total','inventory.drugname AS inv_drug',
              'prescriptions.created_at AS prescription_date')
              ->where([
                ['afyamessages.facilityCode', '=', $facility],
              ])
              ->whereBetween('prescription_filled_status.created_at', [
              Carbon::now()->startOfMonth(),
              Carbon::now()->endOfMonth(),
              ])
              ->orderby('prescription_filled_status.created_at','desc')
              ->groupBy('prescription_filled_status.id')
              ->get();


        return json_encode($months);

            }


                 public function ThisYearsSales(Request $request)
    {


        $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;


              /* Get this year's sales*/
              $years = DB::table('prescriptions')
                ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
                ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
                ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
                ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
                ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
                ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
                ->join('prescription_filled_status', 'prescription_filled_status.presc_details_id', '=', 'prescription_details.id')
                ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
                ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
                ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*','prescription_details.*',
                'prescription_filled_status.created_at AS date_filled','doctors.name AS doc',
                'prescription_filled_status.total AS total','prescription_details.id AS pdd',
                'prescriptions.created_at AS prescription_date','inventory.drugname AS inv_drug')
                ->where([
                  ['afyamessages.facilityCode', '=', $facility],
                ])
                ->whereBetween('prescription_filled_status.created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
                ])
                ->orderby('prescription_filled_status.created_at','desc')
                ->groupBy('prescription_filled_status.id')
                ->get();


        return json_encode($years);
    }



    public function AllSales(Request $request)
    {

      $user=DB::table('users')->where('email', $request->email)->first();
        $user_id = $user->id;


      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;

      $prescs = DB::table('prescriptions')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
        ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
        ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
        ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
        ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
        ->join('prescription_filled_status', 'prescription_filled_status.presc_details_id', '=', 'prescription_details.id')
        ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
        ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
        ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
        'prescription_details.*', 'prescription_filled_status.created_at AS date_filled',
        'doctors.name AS doc','prescriptions.created_at AS prescription_date','inventory.drugname AS inv_drug')
        ->where([
          ['afyamessages.facilityCode', '=', $facility],
        ])
        ->groupBy('prescription_filled_status.id')
        ->get();

        return json_encode($prescs);

      }


      public function showInventory(Request $request)
  {
    $inventory = DB::table('inventory')
                ->join('druglists','druglists.id','=','inventory.drug_id')
                ->join('strength','strength.strength','=','inventory.strength')
                ->select('druglists.Manufacturer','druglists.drugname','inventory.created_at AS entry_date','inventory.id AS inv_id',
                'druglists.id AS drug_id','strength.strength','inventory.*','inventory.id AS inventory_id')
                ->where([
                  ['inventory.quantity', '>', 0],
                  ['is_active', '=', 'yes'],
                ])
                ->orderBy('inventory.created_at', 'desc')
                ->get();

    return json_encode($inventory);
  }


  public function editedInventory(Request $request)
  {

    $id = $request->inventory_id;
    // $count = count($id);

  $inventory = DB::table('inventory')
              ->join('druglists','druglists.id','=','inventory.drug_id')
              ->join('strength','strength.strength','=','inventory.strength')
              ->join('drug_suppliers', 'drug_suppliers.id', '=', 'inventory.supplier')
              ->select('druglists.Manufacturer','druglists.drugname','drug_suppliers.id AS supplier_id','drug_suppliers.name AS supplier_name',
              'druglists.id AS drug_id','strength.strength','inventory.*','inventory.id AS inventory_id')
              ->where('inventory.id', '=', $id)
              ->get();


    return json_encode($inventory);
  }



  // public function editedInventory(Request $request)
  // {

  //     $user=DB::table('users')->where('email', $request->email)->first();
  //       $user_id = $user->id;

  //   $data = DB::table('pharmacists')
  //             ->where('user_id', $user_id)
  //             ->first();

  //   $facility = $data->premiseid;
  //   // $id = $request->inventory_id;
  //   // $count = count($id);

  //   for($i=0; $i<$count; $i++)
  //   {
  //     $drug = $request->prescription;
  //     $strength = $request->strength;
  //     $strength_unit = $request->strength_unit;
  //     $quantity = $request->quantity;
  //     $price = $request->price;
  //     $supplier = $request->supplier;
  //     $retail_price = $request->retail_price;

  //     $dname = DB::table('druglists')
  //             ->select('drugname')
  //             ->where('id', '=', $drug[$i])
  //             ->first();
  //     $drug_name = $dname->drugname;

  //   DB::table('inventory')
  //                   ->where('id', '=', $id[$i])
  //                   ->update([
  //                     'drug_id'=>$drug[$i],
  //                     'drugname'=>$drug_name,
  //                     'strength'=>$strength[$i],
  //                     'strength_unit'=>$strength_unit[$i],
  //                     'quantity'=>$quantity[$i],
  //                     'price'=>$price[$i],
  //                     'recommended_retail_price'=>$retail_price[$i],
  //                     'supplier'=>$supplier[$i],
  //                     'submitted_by'=>$user_id,
  //                     'outlet_id'=>$facility,
  //                     'updated_at'=>Carbon::now()
  //                   ]);

  //     }

  //   rreturn json_encode($dname);
  // }




  public function getInventory2(Request $request)
  {
    $id = $request->inventory_id;
    $inventory = DB::table('inventory')
                ->join('druglists','druglists.id','=','inventory.drug_id')
                ->join('strength','strength.strength','=','inventory.strength')
                ->select('druglists.Manufacturer','druglists.drugname',
                'druglists.id AS drug_id','strength.strength','inventory.*','inventory.id AS inventory_id')
                ->where([
                  ['inventory.id', '=', $id],
                  ['is_active', '=', 'yes'],
                ])
                ->get();

    return json_encode($inventory);
  }
}
