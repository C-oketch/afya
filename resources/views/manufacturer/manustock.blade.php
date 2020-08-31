<?php  use Carbon\Carbon; ?>
@extends('layouts.manufacturer')
@section('title', 'Manufacturer')
@section('content')


  <div class="content-page  equal-height">
    <?php
    $id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', Auth::id())->first();

}

    $Mname = $manufacturer->name;
    $Mid = $manufacturer->id;
    ?>
      <div class="content">
          <div class="container">
             <div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                          <div class="col-lg-11">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                    PHARMACY STOCKS
                                  <div class="ibox-tools">

                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                          <i class="fa fa-wrench"></i>
                                      </a>
                                      <ul class="dropdown-menu dropdown-user">

                                          <li><a href="#">Config option 1</a>
                                          </li>
                                          <li><a href="#">Config option 2</a>
                                          </li>
                                      </ul>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <div class="ibox-content">

                                  <div class="table-responsive">

                                  @if(!empty($rep))

                                  <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                          <th>Pharmacy</th>
                                                          <th>County</th>
                                                          <th>Drug Name</th>
                                                          <th>Quantity</th>
                                                          <th>Rate of Sales(Per Day)</th>
                                                          <th>Run of Rate</th>

                                                         </tr>
                                                    </tr>
                                                  </thead>

                    <?php

                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $today = Carbon::today();
                     $invents = DB::table('inventory')
                         ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                         ->join('druglists','inventory.drug_id','=','druglists.id')
                         ->select('pharmacy.id as pharm','pharmacy.name','pharmacy.county','inventory.created_at','inventory.quantity','inventory.strength',
                         'inventory.strength_unit','druglists.id','druglists.drugname'
                        )
                         ->where([['druglists.Manufacturer','like','%'.$Mname.'%'],['druglists.id',$rep->drug_id],
                         ['pharmacy.county',$rep->region],  ])
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
                          ?>
                        <tbody>
                          @foreach($invents as $stock)

                          <?php    $d1st=DB::table('prescription_filled_status')
                          ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                      ->join('pharmacy','pharmacy.id','=','prescription_filled_status.outlet_id')
                          ->join('druglists','druglists.id','=','prescription_details.drug_id')
                          ->select('prescription_filled_status.*')
                          ->selectRaw('SUM(quantity) as sum')
                          ->selectRaw('SUM(price*quantity) as qprice')
                          ->where([  ['prescription_filled_status.created_at','<=',$today],
                                     ['prescription_filled_status.created_at','>=',$one_week_ago],
                                    ['druglists.id','=', $stock->id],
                                    ['pharmacy.id','=', $stock->pharm], ])
                          ->whereNull('prescription_filled_status.substitute_presc_id')
                          ->first();

                          $d2st=DB::table('prescription_filled_status')
                        ->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                    ->join('pharmacy','pharmacy.id','=','prescription_filled_status.outlet_id')
                        ->join('druglists','druglists.id','=','substitute_presc_details.drug_id')
                        ->select('prescription_filled_status.*')
                        ->selectRaw('SUM(quantity) as sum')
                        ->selectRaw('SUM(price*quantity) as qprice')
                        ->where([   ['prescription_filled_status.created_at','<=',$today],
                                   ['prescription_filled_status.created_at','>=',$one_week_ago],
                                  ['druglists.id','=', $stock->id],
                                  ['pharmacy.id','=', $stock->pharm], ])
                        ->whereNotNull('prescription_filled_status.substitute_presc_id')
                        ->first();
        $rate = (round(($d1st->sum + $d2st->sum)/7));
 ?>
                          <tr>
                          <td>{{$i}}</td>
                          <td>{{$stock->name}}</td>
                          <td>{{$stock->county}}</td>
                          <td>{{$stock->drugname}}</td>
                          <td>{{$stock->quantity}}</td>
                          <td>{{$rate}}</td>
                          <td><?php if ($rate <= 0){
                            echo "-- days";
                          } else { echo (round($stock->quantity/$rate)).'days'; } ?></td>


                          </tr>
                      <?php $i++; ?>
                          @endforeach

                                                   </tbody>

                                                 </table>
                           @elseif(!empty($emp))
                           <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                          <th>Pharmacy</th>
                                                          <th>County</th>
                                                          <th>Drug Name</th>
                                                          <th>Quantity</th>
                                                          <th>Rate of Sales(Per Day)</th>
                                                          <th>Run of Rate</th>

                                                         </tr>
                                                    </tr>
                                                  </thead>

                    <?php

                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $today = Carbon::today();
                     $invents = DB::table('inventory')
                         ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                         ->join('druglists','inventory.drug_id','=','druglists.id')
                         ->select('pharmacy.id as pharm','pharmacy.name','pharmacy.county','inventory.created_at','inventory.quantity','inventory.strength',
                         'inventory.strength_unit','druglists.id','druglists.drugname'
                        )
                         ->where([['druglists.Manufacturer','like','%'.$Mname.'%'],
                          ['pharmacy.county',$emp->region],  ])
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
                          ?>
                        <tbody>
                          @foreach($invents as $stock)

                          <?php    $d1st=DB::table('prescription_filled_status')
                          ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                      ->join('pharmacy','pharmacy.id','=','prescription_filled_status.outlet_id')
                          ->join('druglists','druglists.id','=','prescription_details.drug_id')
                          ->select('prescription_filled_status.*')
                          ->selectRaw('SUM(quantity) as sum')
                          ->selectRaw('SUM(price*quantity) as qprice')
                          ->where([  ['prescription_filled_status.created_at','<=',$today],
                                     ['prescription_filled_status.created_at','>=',$one_week_ago],
                                    ['druglists.id','=', $stock->id],
                                    ['pharmacy.id','=', $stock->pharm], ])
                          ->whereNull('prescription_filled_status.substitute_presc_id')
                          ->first();

                          $d2st=DB::table('prescription_filled_status')
                        ->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                    ->join('pharmacy','pharmacy.id','=','prescription_filled_status.outlet_id')
                        ->join('druglists','druglists.id','=','substitute_presc_details.drug_id')
                        ->select('prescription_filled_status.*')
                        ->selectRaw('SUM(quantity) as sum')
                        ->selectRaw('SUM(price*quantity) as qprice')
                        ->where([   ['prescription_filled_status.created_at','<=',$today],
                                   ['prescription_filled_status.created_at','>=',$one_week_ago],
                                  ['druglists.id','=', $stock->id],
                                  ['pharmacy.id','=', $stock->pharm], ])
                        ->whereNotNull('prescription_filled_status.substitute_presc_id')
                        ->first();
        $rate = (round(($d1st->sum + $d2st->sum)/7));
 ?>
                          <tr>
                          <td>{{$i}}</td>
                          <td>{{$stock->name}}</td>
                          <td>{{$stock->county}}</td>
                          <td>{{$stock->drugname}}</td>
                          <td>{{$stock->quantity}}</td>
                          <td>{{$rate}}</td>
                          <td><?php if ($rate <= 0){
                            echo "-- days";
                          } else { echo (round($stock->quantity/$rate)).'days'; } ?></td>


                          </tr>
                      <?php $i++; ?>
                          @endforeach

                                                   </tbody>

                                                 </table>
                           @else

                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                          <th>Pharmacy</th>
                                                          <th>County</th>
                                                          <th>Drug Name</th>
                                                          <th>Quantity</th>
                                                          <th>Rate of Sales(Per Day)</th>
                                                          <th>Run of Rate</th>

                                                         </tr>
                                                    </tr>
                                                  </thead>
                    <?php

                    $one_week_ago = Carbon::now()->subWeeks(1);
                    $today = Carbon::today();
                     $invents = DB::table('inventory')
                         ->join('pharmacy','inventory.outlet_id','=','pharmacy.id')
                         ->join('druglists','inventory.drug_id','=','druglists.id')
                         ->select('pharmacy.id as pharm','pharmacy.name','pharmacy.county','inventory.created_at','inventory.quantity','inventory.strength',
                         'inventory.strength_unit','druglists.id','druglists.drugname'
                        )
                         ->where([['druglists.Manufacturer','like','%'.$Mname.'%'],  ])
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
                          ?>
                        <tbody>
                          @foreach($invents as $stock)

                          <?php    $d1st=DB::table('prescription_filled_status')
                          ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
                      ->join('pharmacy','pharmacy.id','=','prescription_filled_status.outlet_id')
                          ->join('druglists','druglists.id','=','prescription_details.drug_id')
                          ->select('prescription_filled_status.*')
                          ->selectRaw('SUM(quantity) as sum')
                          ->selectRaw('SUM(price*quantity) as qprice')
                          ->where([  ['prescription_filled_status.created_at','<=',$today],
                                     ['prescription_filled_status.created_at','>=',$one_week_ago],
                                    ['druglists.id','=', $stock->id],
                                    ['pharmacy.id','=', $stock->pharm], ])
                          ->whereNull('prescription_filled_status.substitute_presc_id')
                          ->first();

                          $d2st=DB::table('prescription_filled_status')
                        ->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
                    ->join('pharmacy','pharmacy.id','=','prescription_filled_status.outlet_id')
                        ->join('druglists','druglists.id','=','substitute_presc_details.drug_id')
                        ->select('prescription_filled_status.*')
                        ->selectRaw('SUM(quantity) as sum')
                        ->selectRaw('SUM(price*quantity) as qprice')
                        ->where([   ['prescription_filled_status.created_at','<=',$today],
                                   ['prescription_filled_status.created_at','>=',$one_week_ago],
                                  ['druglists.id','=', $stock->id],
                                  ['pharmacy.id','=', $stock->pharm], ])
                        ->whereNotNull('prescription_filled_status.substitute_presc_id')
                        ->first();
        $rate = (round(($d1st->sum + $d2st->sum)/7));
 ?>
                          <tr>
                          <td>{{$i}}</td>
                          <td>{{$stock->name}}</td>
                          <td>{{$stock->county}}</td>
                          <td>{{$stock->drugname}}</td>
                          <td>{{$stock->quantity}}</td>
                          <td>{{$rate}}</td>
                          <td><?php if ($rate <= 0){
                            echo "-- days";
                          } else { echo (round($stock->quantity/$rate)).'days'; } ?></td>


                          </tr>
                      <?php $i++; ?>
                          @endforeach

                                                   </tbody>

                                                 </table>
                                                 @endif
                                                     </div>

                                                 </div>
                                             </div>
                                         </div>
                                         </div>
                                     </div>



                         </div>
@include('includes.default.footer')
          </div><!--content-->
      </div><!--content page-->

@endsection
