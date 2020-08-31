@extends('layouts.manufacturer')
@section('title', 'Manufacturer')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
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
<div class="row">
<h3>Competition Analysis</h3>
              <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">By Sales</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">By Region</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-3">By Doctors</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-4">By Drug</a></li>


                        </ul>
                        <br>
                        <div class="tab-content">

                             <div id="tab-1" class="tab-pane active">
                             <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1a">Today</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2a">This Week</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-3a">This Month</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-4a">This Year</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-5a">Max</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-6a">Custom</a></li>
                        </ul>
                        <br>
                        <div class="tab-content">
                          <div id="tab-1a" class="tab-pane active">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

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
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>
                            <tr>
                            <th>No</th>
                             <th>Company Name</th>
                             <th>Direct Sales (Units)</th>
                             <th>Value</th>
                             <th>Substitute Sales (Units)</th>
                             <th>Value</th>
                             <th>Total Value</th>
                            </tr>

                          </thead>

                          <tbody>
                            <?php
                            use Carbon\Carbon;
                            $today = Carbon::today();
                             $i =1; $Companiez=DB::table('compe_manufacturer')
                            ->select('compe_manufacturer.*')
                             ->where('manu_id', '=',$Mid)
                             ->get(); ?>

                            @foreach($Companiez as $compz)
<tr>
<td>1</td>

<?php $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']); ?>
@if($Companiez11)

<?php    $d1t11=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->Join('prescriptions','prescriptions.id','=','prescription_details.presc_id')
->Join('appointments','appointments.id','=','prescriptions.appointment_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez11->Manufacturer}}   </td>
<td>@if($d1t11->quantity){{$d1t11->quantity}} @else 0 @endif</td>
<td>@if($d1t11->qprice){{$d1t11->qprice}} @else 0 @endif</td>

<?php    $d1st11=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>             <td>@if($d1st11->quantity){{$d1st11->quantity}} @else 0 @endif</td>
<td>@if($d1st11->qprice){{$d1st11->qprice}} @else 0 @endif</td>
<td>{{$d1st11->qprice + $d1st11->qprice}}</td>
</tr>
@endif
<tr>
  <td>2</td>
  <?php $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']); ?>
@if($Companiez1)
  <?php    $d1t=DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->select('prescription_filled_status.price as dprice')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([ ['prescription_filled_status.created_at','>=',$today],
            ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
    ?>

      <td>{{$Companiez1->Manufacturer}}   </td>
      <td>@if($d1t->quantity){{$d1t->quantity}} @else 0 @endif</td>
    <td>@if($d1t->qprice){{$d1t->qprice}} @else 0 @endif</td>
<?php    $d1st=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
          ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
  ?>             <td>@if($d1st->quantity){{$d1st->quantity}} @else 0 @endif</td>
                 <td>@if($d1st->qprice){{$d1st->qprice}} @else 0 @endif</td>
                 <td>{{$d1st->qprice + $d1st->qprice}}</td>
</tr>
<tr>
  @endif
  <td>3</td>
<?php $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']); ?>
@if($Companiez2)
<?php    $d1t2=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez2->Manufacturer}}   </td>
<td>@if($d1t2->quantity){{$d1t2->quantity}} @else 0 @endif</td>
<td>@if($d1t2->qprice){{$d1t2->qprice}} @else 0 @endif</td>
<?php    $d1st2=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>             <td>@if($d1st2->quantity){{$d1st2->quantity}} @else 0 @endif</td>
<td>@if($d1st2->qprice){{$d1st2->qprice}} @else 0 @endif</td>
<td>{{$d1st2->qprice + $d1st2->qprice}}</td>
</tr>
<tr>
@endif
  <td>4</td>
<?php $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']); ?>
@if($Companiez3)
<?php    $d1t3=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez3->Manufacturer}}   </td>
<td>@if($d1t3->quantity){{$d1t3->quantity}} @else 0 @endif</td>
<td>@if($d1t3->qprice){{$d1t3->qprice}} @else 0 @endif</td>
<?php    $d1st3=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1st3->quantity){{$d1st3->quantity}} @else 0 @endif</td>
<td>@if($d1st3->qprice){{$d1st3->qprice}} @else 0 @endif</td>
<td>{{$d1st3->qprice + $d1st3->qprice}}</td>
</tr>
<tr>
@endif
  <td>5</td>
<?php $Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']); ?>
@if($Companiez4)
<?php    $d1t4=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez4->Manufacturer}}   </td>
<td>@if($d1t4->quantity){{$d1t4->quantity}} @else 0 @endif</td>
<td>@if($d1t4->qprice){{$d1t4->qprice}} @else 0 @endif</td>
<?php    $d1st4=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1st4->quantity){{$d1st4->quantity}} @else 0 @endif</td>
<td>@if($d1st4->qprice){{$d1st4->qprice}} @else 0 @endif</td>
<td>{{$d1st4->qprice + $d1st4->qprice}}</td>
</tr>
<tr>
@endif
  <td>5</td>
<?php $Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']); ?>
@if($Companiez5)

<?php    $d1t5=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez5->Manufacturer}}   </td>
<td>@if($d1t5->quantity){{$d1t5->quantity}} @else 0 @endif</td>
<td>@if($d1t5->qprice){{$d1t5->qprice}} @else 0 @endif</td>
<?php    $d1st5=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['prescription_filled_status.created_at','>=',$today],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1st5->quantity){{$d1st5->quantity}} @else 0 @endif</td>
<td>@if($d1st5->qprice){{$d1st5->qprice}} @else 0 @endif</td>
<td>{{$d1st5->qprice + $d1st5->qprice}}</td>
</tr>
@endif
                            @endforeach
                          </tbody>

                         </table>
                         </div>
                         </div>
                         </div>

        </div>
        </div>
        <!--................................. THIS WEEK ...........................-->
                                <div id="tab-2a" class="tab-pane ">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

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
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                  <tr>
                                  <th>No</th>
                                   <th>Company Name</th>
                                   <th>Direct Sales (Units)</th>
                                   <th>Value</th>
                                   <th>Substitute Sales (Units)</th>
                                   <th>Value</th>
                                   <th>Total Value</th>
                                  </tr>

                            </thead>


                            <tbody>
                              <?php
                              $one_week_ago = Carbon::now()->subWeeks(1);
                               $i =1; $Companiez=DB::table('compe_manufacturer')
                              ->select('compe_manufacturer.*')
                               ->where('manu_id', '=',$Mid)
                               ->get(); ?>

                              @foreach($Companiez as $compz)
  <tr>
  <td>1</td>
  <?php $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']); ?>
@if($Companiez11)
  <?php    $d1w11=DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->select('prescription_filled_status.price as dprice')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  ?>

  <td>{{$Companiez11->Manufacturer}}   </td>
  <td>@if($d1w11->quantity){{$d1w11->quantity}} @else 0 @endif</td>
  <td>@if($d1w11->qprice){{$d1w11->qprice}} @else 0 @endif</td>
  <?php    $d1sw11=DB::table('prescription_filled_status')
  ->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
  ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
  ->select('prescription_filled_status.*')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->first();
  ?>
  <td>@if($d1sw11->quantity){{$d1sw11->quantity}} @else 0 @endif</td>
  <td>@if($d1sw11->qprice){{$d1sw11->qprice}} @else 0 @endif</td>
  <td>{{($d1w11->qprice + $d1sw11->qprice)}}</td>
  </tr>
  @endif
                              <tr>
                                <td>2</td>
    <?php $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']); ?>
@if($Companiez1)

    <?php    $d1w=DB::table('prescription_filled_status')
    ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
    ->join('druglists','druglists.id','=','prescription_details.drug_id')
    ->select('prescription_filled_status.price as dprice')
    ->selectRaw('SUM(quantity) as quantity')
    ->selectRaw('SUM(price*quantity) as qprice')
    ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
    ['prescription_filled_status.created_at','<=',$today],
    ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
    ->whereNull('prescription_filled_status.substitute_presc_id')
    ->first();
      ?>

        <td>{{$Companiez1->Manufacturer}}   </td>
        <td>@if($d1w->quantity){{$d1w->quantity}} @else 0 @endif</td>
      <td>@if($d1w->qprice){{$d1w->qprice}} @else 0 @endif</td>
  <?php    $d1sw=DB::table('prescription_filled_status')
  ->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
  ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
  ->select('prescription_filled_status.*')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->first();
    ?>             <td>@if($d1sw->quantity){{$d1sw->quantity}} @else 0 @endif</td>
                   <td>@if($d1sw->qprice){{$d1sw->qprice}} @else 0 @endif</td>
                   <td>{{$d1w->qprice + $d1sw->qprice}}</td>
  </tr>
  <tr>
    @endif
    <td>3</td>
  <?php $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']); ?>
@if($Companiez2)
  <?php    $d1w2=DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->select('prescription_filled_status.price as dprice')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  ?>

  <td>{{$Companiez2->Manufacturer}}   </td>
  <td>@if($d1w2->quantity){{$d1w2->quantity}} @else 0 @endif</td>
  <td>@if($d1w2->qprice){{$d1w2->qprice}} @else 0 @endif</td>
  <?php    $d1sw2=DB::table('prescription_filled_status')
  ->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
  ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
  ->select('prescription_filled_status.*')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->first();
  ?>
  <td>@if($d1sw2->quantity){{$d1sw2->quantity}} @else 0 @endif</td>
  <td>@if($d1sw2->qprice){{$d1sw2->qprice}} @else 0 @endif</td>
  <td>{{$d1w2->qprice + $d1sw2->qprice}}</td>
  </tr>
  <tr>
@endif
    <td>4</td>
  <?php $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']); ?>
  @if($Companiez3)
  <?php    $d1w3=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->select('prescription_filled_status.price as dprice')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  ?>

  <td>{{$Companiez3->Manufacturer}}   </td>
  <td>@if($d1w3->quantity){{$d1w3->quantity}} @else 0 @endif</td>
  <td>@if($d1w3->qprice){{$d1w3->qprice}} @else 0 @endif</td>
  <?php    $d1sw3=DB::table('prescription_filled_status')
  ->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
  ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
  ->select('prescription_filled_status.*')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->first();
  ?>
  <td>@if($d1sw3->quantity){{$d1sw3->quantity}} @else 0 @endif</td>
  <td>@if($d1sw3->qprice){{$d1sw3->qprice}} @else 0 @endif</td>
  <td>{{$d1w3->qprice + $d1sw3->qprice}}</td>
  </tr>
  <tr>
@endif
    <td>5</td>
  <?php $Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']); ?>
@if($Companiez4)
  <?php    $d1w4=DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->select('prescription_filled_status.price as dprice')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  ?>

  <td>{{$Companiez4->Manufacturer}}   </td>
  <td>@if($d1w4->quantity){{$d1w4->quantity}} @else 0 @endif</td>
  <td>@if($d1w4->qprice){{$d1w4->qprice}} @else 0 @endif</td>
  <?php    $d1sw4=DB::table('prescription_filled_status')

  ->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
  ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
  ->select('prescription_filled_status.*')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->first();
  ?>
  <td>@if($d1sw4->quantity){{$d1sw4->quantity}} @else 0 @endif</td>
  <td>@if($d1sw4->qprice){{$d1sw4->qprice}} @else 0 @endif</td>
  <td>{{$d1w4->qprice + $d1sw4->qprice}}</td>
  </tr>
  <tr>
@endif
    <td>5</td>
  <?php $Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']); ?>
  @if($Companiez5)

  <?php    $d1w5=DB::table('prescription_filled_status')
  ->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
  ->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->select('prescription_filled_status.price as dprice')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
  ->whereNull('prescription_filled_status.substitute_presc_id')
  ->first();
  ?>

  <td>{{$Companiez5->Manufacturer}}   </td>
  <td>@if($d1w5->quantity){{$d1w5->quantity}} @else 0 @endif</td>
  <td>@if($d1w5->qprice){{$d1w5->qprice}} @else 0 @endif</td>
  <?php    $d1sw5=DB::table('prescription_filled_status')
  ->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
  ->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
  ->select('prescription_filled_status.*')
  ->selectRaw('SUM(quantity) as quantity')
  ->selectRaw('SUM(price*quantity) as qprice')
  ->where([  ['prescription_filled_status.created_at','>=',$one_week_ago],
  ['prescription_filled_status.created_at','<=',$today],
  ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->first();
  ?>
  <td>@if($d1sw5->quantity){{$d1sw5->quantity}} @else 0 @endif</td>
  <td>@if($d1sw5->qprice){{$d1sw5->qprice}} @else 0 @endif</td>
  <td>{{$d1w5->qprice + $d1sw5->qprice}}</td>
  </tr>
@endif
                              @endforeach
                            </tbody>
                                                 </table>
                                                 </div>
                                                 </div>
                                   </div>
                                 </div>
                                </div>
<!--................................. THIS MONTH...........................-->
<div id="tab-3a" class="tab-pane ">
<div class="panel-body">
<div class="ibox float-e-margins">
<div class="ibox-title">

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
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
  <tr>
  <th>No</th>
   <th>Company Name</th>
   <th>Direct Sales (Units)</th>
   <th>Value</th>
   <th>Substitute Sales (Units)</th>
   <th>Value</th>
   <th>Total Value</th>
  </tr>

</thead>


<tbody>
<?php
$one_month_ago = Carbon::now()->subMonths(1);
$i =1; $Companiez=DB::table('compe_manufacturer')
->select('compe_manufacturer.*')
->where('manu_id', '=',$Mid)
->get(); ?>

@foreach($Companiez as $compz)
<tr>
<td>1</td>
<?php $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']); ?>
@if($Companiez11)
<?php    $d1m11=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez11->Manufacturer}}   </td>
<td>@if($d1m11->quantity){{$d1m11->quantity}} @else 0 @endif</td>
<td>@if($d1m11->qprice){{$d1m11->qprice}} @else 0 @endif</td>
<?php    $d1sm11=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sm11->quantity){{$d1sm11->quantity}} @else 0 @endif</td>
<td>@if($d1sm11->qprice){{$d1sm11->qprice}} @else 0 @endif</td>
<td>{{($d1m11->qprice + $d1sm11->qprice)}}</td>
</tr>
@endif
<tr>
<td>2</td>
<?php $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']); ?>
@if($Companiez1)
<?php    $d1m=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez1->Manufacturer}}   </td>
<td>@if($d1m->quantity){{$d1m->quantity}} @else 0 @endif</td>
<td>@if($d1m->qprice){{$d1m->qprice}} @else 0 @endif</td>
<?php    $d1sm=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>             <td>@if($d1sm->quantity){{$d1sm->quantity}} @else 0 @endif</td>
<td>@if($d1sm->qprice){{$d1sm->qprice}} @else 0 @endif</td>
<td>{{$d1m->qprice + $d1sm->qprice}}</td>
</tr>
<tr>
@endif
<td>3</td>
<?php $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']); ?>
@if($Companiez2)
<?php    $d1m2=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez2->Manufacturer}}   </td>
<td>@if($d1m2->quantity){{$d1m2->quantity}} @else 0 @endif</td>
<td>@if($d1m2->qprice){{$d1m2->qprice}} @else 0 @endif</td>
<?php    $d1sm2=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sm2->quantity){{$d1sm2->quantity}} @else 0 @endif</td>
<td>@if($d1sm2->qprice){{$d1sm2->qprice}} @else 0 @endif</td>
<td>{{$d1m2->qprice + $d1sm2->qprice}}</td>
</tr>
<tr>
@endif
<td>4</td>
<?php $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']); ?>
@if($Companiez3)
<?php    $d1m3=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez3->Manufacturer}}   </td>
<td>@if($d1m3->quantity){{$d1m3->quantity}} @else 0 @endif</td>
<td>@if($d1m3->qprice){{$d1m3->qprice}} @else 0 @endif</td>
<?php    $d1sm3=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sm3->quantity){{$d1sm3->quantity}} @else 0 @endif</td>
<td>@if($d1sm3->qprice){{$d1sm3->qprice}} @else 0 @endif</td>
<td>{{$d1m3->qprice + $d1sm3->qprice}}</td>
</tr>
<tr>
@endif
<td>5</td>
<?php $Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']); ?>
@if($Companiez4)
<?php    $d1m4=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez4->Manufacturer}}   </td>
<td>@if($d1m4->quantity){{$d1m4->quantity}} @else 0 @endif</td>
<td>@if($d1m4->qprice){{$d1m4->qprice}} @else 0 @endif</td>
<?php    $d1sm4=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sm4->quantity){{$d1sm4->quantity}} @else 0 @endif</td>
<td>@if($d1sm4->qprice){{$d1sm4->qprice}} @else 0 @endif</td>
<td>{{$d1m4->qprice + $d1sm4->qprice}}</td>
</tr>
<tr>
@endif
<td>5</td>
<?php $Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']); ?>
@if($Companiez5)
<?php    $d1m5=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez5->Manufacturer}}   </td>
<td>@if($d1m5->quantity){{$d1m5->quantity}} @else 0 @endif</td>
<td>@if($d1m5->qprice){{$d1m5->qprice}} @else 0 @endif</td>
<?php    $d1sm5=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_month_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sm5->quantity){{$d1sm5->quantity}} @else 0 @endif</td>
<td>@if($d1sm5->qprice){{$d1sm5->qprice}} @else 0 @endif</td>
<td>{{$d1m5->qprice + $d1sm5->qprice}}</td>
</tr>
@endif
@endforeach
</tbody>
                 </table>
                 </div>
                 </div>
   </div>
 </div>
</div>
<!--................................. THIS YEAR...........................-->
<div id="tab-4a" class="tab-pane ">
<div class="panel-body">
<div class="ibox float-e-margins">
<div class="ibox-title">

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
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
  <tr>
  <th>No</th>
   <th>Company Name</th>
   <th>Direct Sales (Units)</th>
   <th>Value</th>
   <th>Substitute Sales (Units)</th>
   <th>Value</th>
   <th>Total Value</th>
  </tr>

</thead>


<tbody>
<?php
$one_year_ago = Carbon::now()->subYears(1);
$i =1; $Companiez=DB::table('compe_manufacturer')
->select('compe_manufacturer.*')
->where('manu_id', '=',$Mid)
->get(); ?>

@foreach($Companiez as $compz)
<tr>
<td>1</td>
<?php $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']); ?>
@if($Companiez11)
<?php    $d1y11=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez11->Manufacturer}}   </td>
<td>@if($d1y11->quantity){{$d1y11->quantity}} @else 0 @endif</td>
<td>@if($d1y11->qprice){{$d1y11->qprice}} @else 0 @endif</td>
<?php    $d1sy11=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sy11->quantity){{$d1sy11->quantity}} @else 0 @endif</td>
<td>@if($d1sy11->qprice){{$d1sy11->qprice}} @else 0 @endif</td>
<td>{{($d1y11->qprice + $d1sy11->qprice)}}</td>
</tr>
@endif
<tr>
<td>2</td>
<?php $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']); ?>
@if($Companiez1)
<?php    $d1y=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez1->Manufacturer}}   </td>
<td>@if($d1y->quantity){{$d1y->quantity}} @else 0 @endif</td>
<td>@if($d1y->qprice){{$d1y->qprice}} @else 0 @endif</td>
<?php    $d1sy=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>             <td>@if($d1sy->quantity){{$d1sy->quantity}} @else 0 @endif</td>
<td>@if($d1sy->qprice){{$d1sy->qprice}} @else 0 @endif</td>
<td>{{$d1y->qprice + $d1sy->qprice}}</td>
</tr>
<tr>
@endif
<td>3</td>
<?php $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']); ?>
@if($Companiez2)
<?php    $d1y2=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez2->Manufacturer}}   </td>
<td>@if($d1y2->quantity){{$d1y2->quantity}} @else 0 @endif</td>
<td>@if($d1y2->qprice){{$d1y2->qprice}} @else 0 @endif</td>
<?php    $d1sy2=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sy2->quantity){{$d1sy2->quantity}} @else 0 @endif</td>
<td>@if($d1sy2->qprice){{$d1sy2->qprice}} @else 0 @endif</td>
<td>{{$d1y2->qprice + $d1sy2->qprice}}</td>
</tr>
@endif
<tr>

<td>4</td>
<?php $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']); ?>
@if($Companiez3)
<?php    $d1y3=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez3->Manufacturer}}   </td>
<td>@if($d1y3->quantity){{$d1y3->quantity}} @else 0 @endif</td>
<td>@if($d1y3->qprice){{$d1y3->qprice}} @else 0 @endif</td>
<?php    $d1sy3=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sy3->quantity){{$d1sy3->quantity}} @else 0 @endif</td>
<td>@if($d1sy3->qprice){{$d1sy3->qprice}} @else 0 @endif</td>
<td>{{$d1y3->qprice + $d1sy3->qprice}}</td>
</tr>
<tr>
@endif
<td>5</td>
<?php $Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']); ?>
@if($Companiez4)
<?php    $d1y4=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez4->Manufacturer}}   </td>
<td>@if($d1y4->quantity){{$d1y4->quantity}} @else 0 @endif</td>
<td>@if($d1y4->qprice){{$d1y4->qprice}} @else 0 @endif</td>
<?php    $d1sy4=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sy4->quantity){{$d1sy4->quantity}} @else 0 @endif</td>
<td>@if($d1sy4->qprice){{$d1sy4->qprice}} @else 0 @endif</td>
<td>{{$d1y4->qprice + $d1sy4->qprice}}</td>
</tr>
<tr>
@endif
<td>5</td>
<?php $Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']); ?>
@if($Companiez5)
<?php    $d1y5=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez5->Manufacturer}}   </td>
<td>@if($d1y5->quantity){{$d1y5->quantity}} @else 0 @endif</td>
<td>@if($d1y5->qprice){{$d1y5->qprice}} @else 0 @endif</td>
<?php    $d1sy5=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([  ['prescription_filled_status.created_at','>=',$one_year_ago],
['prescription_filled_status.created_at','<=',$today],
['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sy5->quantity){{$d1sy5->quantity}} @else 0 @endif</td>
<td>@if($d1sy5->qprice){{$d1sy5->qprice}} @else 0 @endif</td>
<td>{{$d1y5->qprice + $d1sy5->qprice}}</td>
</tr>
@endif
@endforeach
</tbody>
                 </table>
                 </div>
                 </div>
   </div>
 </div>
</div>


<!--................................. ALL TIME ...........................-->
<div id="tab-5a" class="tab-pane ">
<div class="panel-body">
<div class="ibox float-e-margins">
<div class="ibox-title">

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
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
  <tr>
  <th>No</th>
   <th>Company Name</th>
   <th>Direct Sales (Units)</th>
   <th>Value</th>
   <th>Substitute Sales (Units)</th>
   <th>Value</th>
   <th>Total Value</th>
  </tr>

</thead>


<tbody>
<?php

$i =1; $Companiez=DB::table('compe_manufacturer')
->select('compe_manufacturer.*')
->where('manu_id', '=',$Mid)
->get(); ?>

@foreach($Companiez as $compz)
<tr>
<td>1</td>
<?php $Companiez11=DB::table('druglists')  ->where('id', '=',$compz->company)->distinct()->first(['Manufacturer']); ?>
@if($Companiez11)


<?php    $d1a11=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez11->Manufacturer}}   </td>
<td>@if($d1a11->quantity){{$d1a11->quantity}} @else 0 @endif</td>
<td>@if($d1a11->qprice){{$d1a11->qprice}} @else 0 @endif</td>
<?php    $d1sa11=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez11->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sa11->quantity){{$d1sa11->quantity}} @else 0 @endif</td>
<td>@if($d1sa11->qprice){{$d1sa11->qprice}} @else 0 @endif</td>
<td>{{($d1a11->qprice + $d1sa11->qprice)}}</td>
</tr>
<tr>
@endif
<td>2</td>
<?php $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']); ?>
@if($Companiez1)


<?php    $d1a=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez1->Manufacturer}}   </td>
<td>@if($d1a->quantity){{$d1a->quantity}} @else 0 @endif</td>
<td>@if($d1a->qprice){{$d1a->qprice}} @else 0 @endif</td>
<?php    $d1sa=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez1->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>             <td>@if($d1sa->quantity){{$d1sa->quantity}} @else 0 @endif</td>
<td>@if($d1sa->qprice){{$d1sa->qprice}} @else 0 @endif</td>
<td>{{$d1a->qprice + $d1sa->qprice}}</td>
</tr>
<tr>
@endif

<td>3</td>
<?php $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']); ?>
@if($Companiez2)

<?php    $d1a2=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez2->Manufacturer}}   </td>
<td>@if($d1a2->quantity){{$d1a2->quantity}} @else 0 @endif</td>
<td>@if($d1a2->qprice){{$d1a2->qprice}} @else 0 @endif</td>
<?php    $d1sa2=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez2->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sa2->quantity){{$d1sa2->quantity}} @else 0 @endif</td>
<td>@if($d1sa2->qprice){{$d1sa2->qprice}} @else 0 @endif</td>
<td>{{$d1a2->qprice + $d1sa2->qprice}}</td>
</tr>
<tr>
  @endif
<td>4</td>
<?php $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']); ?>
@if($Companiez3)

<?php    $d1a3=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez3->Manufacturer}}   </td>
<td>@if($d1a3->quantity){{$d1a3->quantity}} @else 0 @endif</td>
<td>@if($d1a3->qprice){{$d1a3->qprice}} @else 0 @endif</td>
<?php    $d1sa3=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez3->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sa3->quantity){{$d1sa3->quantity}} @else 0 @endif</td>
<td>@if($d1sa3->qprice){{$d1sa3->qprice}} @else 0 @endif</td>
<td>{{$d1a3->qprice + $d1sa3->qprice}}</td>
</tr>
<tr>
  @endif
<td>5</td>
<?php $Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']); ?>
@if($Companiez4)

<?php    $d1a4=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez4->Manufacturer}}   </td>
<td>@if($d1a4->quantity){{$d1a4->quantity}} @else 0 @endif</td>
<td>@if($d1a4->qprice){{$d1a4->qprice}} @else 0 @endif</td>
<?php    $d1sa4=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez4->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sa4->quantity){{$d1sa4->quantity}} @else 0 @endif</td>
<td>@if($d1sa4->qprice){{$d1sa4->qprice}} @else 0 @endif</td>
<td>{{$d1a4->qprice + $d1sa4->qprice}}</td>
</tr>
<tr>
@endif
<td>6</td>
<?php $Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']); ?>

@if($Companiez5)
<?php    $d1a5=DB::table('prescription_filled_status')
->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')
->join('druglists','druglists.id','=','prescription_details.drug_id')
->select('prescription_filled_status.price as dprice')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNull('prescription_filled_status.substitute_presc_id')
->first();
?>

<td>{{$Companiez5->Manufacturer}}   </td>
<td>@if($d1a5->quantity){{$d1a5->quantity}} @else 0 @endif</td>
<td>@if($d1a5->qprice){{$d1a5->qprice}} @else 0 @endif</td>
<?php    $d1sa5=DB::table('prescription_filled_status')
->join('substitute_presc_details','substitute_presc_details.id','=','prescription_filled_status.substitute_presc_id')
->join('druglists','substitute_presc_details.drug_id','=','druglists.id')
->select('prescription_filled_status.*')
->selectRaw('SUM(quantity) as quantity')
->selectRaw('SUM(price*quantity) as qprice')
->where([ ['druglists.Manufacturer','like', '%' .$Companiez5->Manufacturer. '%'], ])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->first();
?>
<td>@if($d1sa5->quantity){{$d1sa5->quantity}} @else 0 @endif</td>
<td>@if($d1sa5->qprice){{$d1sa5->qprice}} @else 0 @endif</td>
<td>{{$d1a5->qprice + $d1sa5->qprice}}</td>
</tr>
@endif
@endforeach
</tbody>
                 </table>
                 </div>
                 </div>
   </div>
 </div>
</div>

<!--................................. CUSTOM ...........................-->
                                <div id="tab-6a" class="tab-pane">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

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
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>



                                                      <tr>
                                                      <th>No</th>
                                                     <th>Company Name</th>
                                                     <th>Sales (Units)</th>
                                                          <th>Total Sales</th>


                                                         </tr>

                                                  </thead>

                                                  <tbody>


                                                   </tbody>

                                                 </table>
                                                 </div>
                                                 </div>
                                                 </div>

                                </div>
                                </div>
                            </div>
                            </div>
                            <!-- REGION -->
                      @include('manufacturer.competitionregion')
                              <!-- Doctors -->
                      @include('manufacturer.competitiondoctr')
                                <!-- Drugs -->
                      @include('manufacturer.competitiondrug')
                                  <!-- Drugs -->
                                     </div>
                        </div>


                    </div>
                </div>


             @include('includes.default.footer')
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
