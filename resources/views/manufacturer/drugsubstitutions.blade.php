<?php  use Carbon\Carbon; ?> 
@extends('layouts.manufacturer')
@section('title', 'Manufacturer')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
                <?php
                $id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')
->where('users_id',$id)->first();
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
<h3>Drug Substitutions</h3>
              <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> AWAY FROM {{$Mname}}</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">TO {{$Mname}}</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3">{{$Mname}} TO {{$Mname}}</a></li>

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
  @if(!empty($rep))
  <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
            <th>No</th>
            <th>Prescribed Drug</th>
            <th>Pharmacy  name</th>
            <th>Prescribing Doctor</th>
            <th>Substituted Drug</th>
            <th>Facility Name</th>
            <th>Reason</th>
            <th>Quantity</th>
            <th>Price</th>
            <th> Value</th>
            </tr>

            </thead>

<tbody><?php  $i =1;
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
    'pharmacy.county','prescription_details.doseform',
   'prescription_filled_status.substitute_presc_id')
 ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
           ['prescription_filled_status.created_at','>=',$today],
           ['druglists.id',$rep->drug_id],
           ['pharmacy.county','like','%'.$rep->region.'%'],
         ])
 ->whereNotNull('prescription_filled_status.substitute_presc_id')
 ->get();
  ?>
@foreach($prescribed  as $daily)
<?php $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select('druglists.drugname as subdrugname')
 ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
           ['druglists.id',$rep->drug_id],
           ['pharmacy.county','like','%'.$rep->region.'%'],
         ])

->first();
?>
<?php if($substituted) { ?>
<tr>
<td>{{$i}}</td>
<td>{{ $daily->drugname}}</td>
<td>{{$daily->pharmacy}}</td>
<td>{{$daily->name}}</td>
<td>{{$substituted->subdrugname}}</td>
<td>{{$daily->FacilityName}}</td>
<td>{{$daily->substitution_reason}}</td>
<td>{{$daily->quantity}}</td>
<td>{{$daily->price}}</td>
<td>{{($daily->quantity * $daily->price)}}</td>
</tr>
<?php $i++;  ?>
<?php } ?>

      @endforeach


   </tbody>

   </table>
   @elseif(!empty($emp))
   <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
            <th>No</th>
            <th>Prescribed Drug</th>
            <th>Pharmacy  name</th>
            <th>Prescribing Doctor</th>
            <th>Substituted Drug</th>
            <th>Facility Name</th>
            <th>Reason</th>
            <th>Quantity</th>
            <th>Price</th>
            <th> Value</th>
            </tr>

            </thead>

<tbody><?php  $i =1;
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
    'pharmacy.county','prescription_details.doseform',
   'prescription_filled_status.substitute_presc_id')
 ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
           ['prescription_filled_status.created_at','>=',$today],
           ['pharmacy.county','like', '%'.$emp->region.'%'],
         ])
 ->whereNotNull('prescription_filled_status.substitute_presc_id')
 ->get();
  ?>
@foreach($prescribed  as $daily)
<?php $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select('druglists.drugname as subdrugname')
 ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],

         ])

->first();
?>
<?php if($substituted) { ?>
<tr>
<td>{{$i}}</td>
<td>{{ $daily->drugname}}</td>
<td>{{$daily->pharmacy}}</td>
<td>{{$daily->name}}</td>
<td>{{$substituted->subdrugname}}</td>
<td>{{$daily->FacilityName}}</td>
<td>{{$daily->substitution_reason}}</td>
<td>{{$daily->quantity}}</td>
<td>{{$daily->price}}</td>
<td>{{($daily->quantity * $daily->price)}}</td>
</tr>
<?php $i++;  ?>
<?php } ?>

      @endforeach


   </tbody>

   </table>
  @else
      <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
            <th>No</th>
            <th>Prescribed Drug</th>
            <th>Pharmacy  name</th>
            <th>Prescribing Doctor</th>
            <th>Substituted Drug</th>
            <th>Facility Name</th>
            <th>Reason</th>
            <th>Quantity</th>
            <th>Price</th>
            <th> Value</th>
            </tr>

            </thead>

<tbody><?php  $i =1;
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
    'pharmacy.county','prescription_details.doseform',
   'prescription_filled_status.substitute_presc_id')
 ->where([ ['druglists.Manufacturer','like', '%'.$Mname.'%'],
           ['prescription_filled_status.created_at','>=',$today],
         ])
 ->whereNotNull('prescription_filled_status.substitute_presc_id')
 ->get();
  ?>
@foreach($prescribed  as $daily)
<?php $substituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select('druglists.drugname as subdrugname')
 ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
           ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
         ])

->first();
?>
<?php if($substituted) { ?>
<tr>
<td>{{$i}}</td>
<td>{{ $daily->drugname}}</td>
<td>{{$daily->pharmacy}}</td>
<td>{{$daily->name}}</td>
<td>{{$substituted->subdrugname}}</td>
<td>{{$daily->FacilityName}}</td>
<td>{{$daily->substitution_reason}}</td>
<td>{{$daily->quantity}}</td>
<td>{{$daily->price}}</td>
<td>{{($daily->quantity * $daily->price)}}</td>
</tr>
<?php $i++;  ?>
<?php } ?>

      @endforeach


   </tbody>

   </table>
   @endif
       </div>
     </div>
    </div>
  </div>
</div>
  <!--................................. THIS WEEK ...........................-->
  <div id="tab-2a" class="tab-pane">
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
  @if(!empty($rep))
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
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
  ['druglists.id',$rep->drug_id],
  ['pharmacy.county','like','%'.$rep->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedw  as $daily)
  <?php $substitutedw = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ['druglists.id',$rep->drug_id],
   ])

  ->first();
  ?>
  <?php if($substitutedw) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedw->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>
  @elseif(!empty($emp))
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
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
  ['pharmacy.county','like', '%'.$emp->region.'%']
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedw  as $daily)
  <?php $substitutedw = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ])

  ->first();
  ?>
  <?php if($substitutedw) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedw->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>

  @else
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
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
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedw  as $daily)
  <?php $substitutedw = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ])

  ->first();
  ?>
  <?php if($substitutedw) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedw->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>
          @endif
        </div>
      </div>
     </div>
    </div>
  </div>

  <!--................................. THIS MONTH ...........................-->
  <div id="tab-3a" class="tab-pane">
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
  @if(!empty($rep))
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
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
  ['druglists.id',$rep->drug_id],
  ['pharmacy.county','like','%'.$rep->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedm as $daily)
  <?php $substitutedm = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ['druglists.id',$rep->drug_id],

  ])

  ->first();
  ?>
  <?php if($substitutedm) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedm->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>
  @elseif(!empty($emp))
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
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
  ['pharmacy.county','like','%'.$emp->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedm as $daily)
  <?php $substitutedm = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],

  ])

  ->first();
  ?>
  <?php if($substitutedm) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedm->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>
  @else
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
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
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedm as $daily)
  <?php $substitutedm = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ])

  ->first();
  ?>
  <?php if($substitutedm) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedm->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>
    @endif
        </div>
      </div>
     </div>
    </div>
  </div>

  <!--................................. THIS YEAR ...........................-->
  <div id="tab-4a" class="tab-pane">
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
  @if(!empty($rep))
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
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
  ['druglists.id',$rep->drug_id],
  ['pharmacy.county','like','%'.$rep->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedy as $daily)
  <?php $substitutedy = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ['druglists.id',$rep->drug_id],
  ['pharmacy.county','like','%'.$rep->region.'%'],
  ])

  ->first();
  ?>
  <?php if($substitutedy) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedy->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>
  @elseif(!empty($emp))
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
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
  ['pharmacy.county','like', '%'.$emp->region.'%'],
  ])

  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedy as $daily)
  <?php $substitutedy = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ])

  ->first();
  ?>
  <?php if($substitutedy) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedy->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>

  @else
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
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
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedy as $daily)
  <?php $substitutedy = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ])

  ->first();
  ?>
  <?php if($substitutedy) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedy->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>
          @endif
        </div>
      </div>
     </div>
    </div>
  </div>

    <!--................................. MAX...........................-->
    <div id="tab-5a" class="tab-pane">
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
    @if(!empty($rep))
    <table class="table table-striped table-bordered table-hover dataTables-example" >
    <thead>
    <tr>
    <th>No</th>
    <th>Prescribed Drug</th>
    <th>Pharmacy  name</th>
    <th>Prescribing Doctor</th>
    <th>Substituted Drug</th>
    <th>Facility Name</th>
    <th>Reason</th>
    <th>Quantity</th>
    <th>Price</th>
    <th> Value</th>
    </tr>

    </thead>

    <tbody><?php  $i =1;
    $prescribedall = DB::table('prescriptions')
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
      ['druglists.id',$rep->drug_id],
      ['pharmacy.county','like','%'.$rep->region.'%'],
    ])
    ->whereNotNull('prescription_filled_status.substitute_presc_id')
    ->get();
    ?>
    @foreach($prescribedall  as $daily)
    <?php $substitutedall = DB::table('substitute_presc_details')
    ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
    ->select('druglists.drugname as subdrugname')
    ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
    ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
    ['druglists.id',$rep->drug_id],
    ['pharmacy.county','like','%'.$rep->region.'%'],
    ])

    ->first();
    ?>
    <?php if($substitutedall) { ?>
    <tr>
    <td>{{$i}}</td>
    <td>{{ $daily->drugname}}</td>
    <td>{{$daily->pharmacy}}</td>
    <td>{{$daily->name}}</td>
    <td>{{$substitutedall->subdrugname}}</td>
    <td>{{$daily->FacilityName}}</td>
    <td>{{$daily->substitution_reason}}</td>
    <td>{{$daily->quantity}}</td>
    <td>{{$daily->price}}</td>
    <td>{{($daily->quantity * $daily->price)}}</td>
    </tr>
    <?php $i++;  ?>
    <?php } ?>

    @endforeach
    </tbody>

            </table>
    @elseif(!empty($emp))
    <table class="table table-striped table-bordered table-hover dataTables-example" >
    <thead>
    <tr>
    <th>No</th>
    <th>Prescribed Drug</th>
    <th>Pharmacy  name</th>
    <th>Prescribing Doctor</th>
    <th>Substituted Drug</th>
    <th>Facility Name</th>
    <th>Reason</th>
    <th>Quantity</th>
    <th>Price</th>
    <th> Value</th>
    </tr>

    </thead>

    <tbody><?php  $i =1;
    $prescribedall = DB::table('prescriptions')
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
            ['pharmacy.county','like', '%'.$emp->region.'%'],
    ])
    ->whereNotNull('prescription_filled_status.substitute_presc_id')
    ->get();
    ?>
    @foreach($prescribedall  as $daily)
    <?php $substitutedall = DB::table('substitute_presc_details')
    ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
    ->select('druglists.drugname as subdrugname')
    ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
    ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
    ])

    ->first();
    ?>
    <?php if($substitutedall) { ?>
    <tr>
    <td>{{$i}}</td>
    <td>{{ $daily->drugname}}</td>
    <td>{{$daily->pharmacy}}</td>
    <td>{{$daily->name}}</td>
    <td>{{$substitutedall->subdrugname}}</td>
    <td>{{$daily->FacilityName}}</td>
    <td>{{$daily->substitution_reason}}</td>
    <td>{{$daily->quantity}}</td>
    <td>{{$daily->price}}</td>
    <td>{{($daily->quantity * $daily->price)}}</td>
    </tr>
    <?php $i++;  ?>
    <?php } ?>

    @endforeach
    </tbody>

            </table>
    @else
    <table class="table table-striped table-bordered table-hover dataTables-example" >
    <thead>
    <tr>
    <th>No</th>
    <th>Prescribed Drug</th>
    <th>Pharmacy  name</th>
    <th>Prescribing Doctor</th>
    <th>Substituted Drug</th>
    <th>Facility Name</th>
    <th>Reason</th>
    <th>Quantity</th>
    <th>Price</th>
    <th> Value</th>
    </tr>

    </thead>

    <tbody><?php  $i =1;
    $prescribedall = DB::table('prescriptions')
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
    ?>
    @foreach($prescribedall  as $daily)
    <?php $substitutedall = DB::table('substitute_presc_details')
    ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
    ->select('druglists.drugname as subdrugname')
    ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
    ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
    ])

    ->first();
    ?>
    <?php if($substitutedall) { ?>
    <tr>
    <td>{{$i}}</td>
    <td>{{ $daily->drugname}}</td>
    <td>{{$daily->pharmacy}}</td>
    <td>{{$daily->name}}</td>
    <td>{{$substitutedall->subdrugname}}</td>
    <td>{{$daily->FacilityName}}</td>
    <td>{{$daily->substitution_reason}}</td>
    <td>{{$daily->quantity}}</td>
    <td>{{$daily->price}}</td>
    <td>{{($daily->quantity * $daily->price)}}</td>
    </tr>
    <?php $i++;  ?>
    <?php } ?>

    @endforeach
    </tbody>

            </table>
            @endif
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
  @if(!empty($rep))
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
  $prescribedall = DB::table('prescriptions')
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
    ['druglists.id',$rep->drug_id],
    ['pharmacy.county','like','%'.$rep->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedall  as $daily)
  <?php $substitutedall = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ['druglists.id',$rep->drug_id],
  ['pharmacy.county','like','%'.$rep->region.'%'],
  ])

  ->first();
  ?>
  <?php if($substitutedall) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedall->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>
  @elseif(!empty($emp))
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
  $prescribedall = DB::table('prescriptions')
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
    ['pharmacy.county','like','%'.$emp->region.'%'],
  ])
  ->whereNotNull('prescription_filled_status.substitute_presc_id')
  ->get();
  ?>
  @foreach($prescribedall  as $daily)
  <?php $substitutedall = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ])

  ->first();
  ?>
  <?php if($substitutedall) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedall->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>
  @else
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>
  <tr>
  <th>No</th>
  <th>Prescribed Drug</th>
  <th>Pharmacy  name</th>
  <th>Prescribing Doctor</th>
  <th>Substituted Drug</th>
  <th>Facility Name</th>
  <th>Reason</th>
  <th>Quantity</th>
  <th>Price</th>
  <th> Value</th>
  </tr>

  </thead>

  <tbody><?php  $i =1;
  $prescribedall = DB::table('prescriptions')
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
  ?>
  @foreach($prescribedall  as $daily)
  <?php $substitutedall = DB::table('substitute_presc_details')
  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
  ->select('druglists.drugname as subdrugname')
  ->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
  ['druglists.Manufacturer','Not like','%'.$Mname.'%'],
  ])

  ->first();
  ?>
  <?php if($substitutedall) { ?>
  <tr>
  <td>{{$i}}</td>
  <td>{{ $daily->drugname}}</td>
  <td>{{$daily->pharmacy}}</td>
  <td>{{$daily->name}}</td>
  <td>{{$substitutedall->subdrugname}}</td>
  <td>{{$daily->FacilityName}}</td>
  <td>{{$daily->substitution_reason}}</td>
  <td>{{$daily->quantity}}</td>
  <td>{{$daily->price}}</td>
  <td>{{($daily->quantity * $daily->price)}}</td>
  </tr>
  <?php $i++;  ?>
  <?php } ?>

  @endforeach
  </tbody>

          </table>

        @endif
        </div>
      </div>
     </div>
    </div>
  </div>

<!--  ................custom............................. -->
 </div><!--  tab-content -->
  </div>
  <!--  ................end away ............................ -->
<!--  ................To MERCK............................. -->
  @include('manufacturer.drugsubstitutionsto')
<!-- .................INTER MERCK...................................... -->
  @include('manufacturer.drugsubstitutionsfrto')

<!--  ................INTER MERCK........................................ -->
</div><!--  tab-content -->
</div>
</div>
  </div>

             @include('includes.default.footer')
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
