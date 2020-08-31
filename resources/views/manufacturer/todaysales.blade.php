<?php use Carbon\Carbon;?>
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
<h3>Sales</h3>
            <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">By Drug</a></li>
                            <li clas,s=""><a data-toggle="tab" href="#tab-2">By Prescribing Doctor</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-3">By Region</a></li>
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
                              <!-- sales Today -->
                              <div class="ibox-content">
                                  <div class="table-responsive">
                                  @if(!empty($rep))
                                   <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>

                                                          <th>Prescribing Doctor</th>
                                                           <th>Facility</th>
                                                          <th>Pharmacy  name</th>
                                                         <th> Quantity</th>
                                                         <th>Dosage</th>
                                                         <th>Unit Cost</th>
                                                         <th>Total </th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
<?php $i =1;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
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
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
['prescription_filled_status.created_at','>=',$today],
['druglists.id',$rep->drug_id],
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
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
['prescription_filled_status.created_at','>=',$today],
['druglists.id',$rep->drug_id],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

?>
                                                 @foreach($Dsales as $mandrug)
                                                 <?php $total= ($mandrug->quantity * $mandrug->price);

                                                 ?>
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$mandrug->drugname}}</td>
                                                          <td>{{$mandrug->name}}</td>
                                                          <td>{{$mandrug->FacilityName}}</td>
                                                          <td>{{$mandrug->pharmacy}}</td>
                                                          <td>{{$mandrug->quantity}}</td>
                                                          <td>{{$mandrug->dose_given}}</td>
                                                          <td>{{$mandrug->price}}</td>
                                                          <td>{{$total}}</td>
                                                        </tr>
                                                          <?php $i++;  ?>
                                                        @endforeach

                                                     </tbody>
                                                 </table>
                                  @else
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>

                                                          <th>Prescribing Doctor</th>
                                                           <th>Facility</th>
                                                          <th>Pharmacy  name</th>
                                                         <th> Quantity</th>
                                                         <th>Dosage</th>
                                                         <th>Unit Cost</th>
                                                         <th>Total </th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
<?php $i =1;
$one_mon_ago = Carbon::now()->subMonths(1);
$todaysales = Carbon::now();
$one_week_ago = Carbon::now()->subWeeks(1);
$today = Carbon::today();
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
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
['prescription_filled_status.created_at','>=',$today],
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
->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
'pharmacy.county',
'prescription_filled_status.substitute_presc_id')
->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
['prescription_filled_status.created_at','>=',$today],
])
->whereNotNull('prescription_filled_status.substitute_presc_id')
->union($prescribed)
->get();

?>
                                                 @foreach($Dsales as $mandrug)
                                                 <?php $total= ($mandrug->quantity * $mandrug->price);

                                                 ?>
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$mandrug->drugname}}</td>
                                                          <td>{{$mandrug->name}}</td>
                                                          <td>{{$mandrug->FacilityName}}</td>
                                                          <td>{{$mandrug->pharmacy}}</td>
                                                          <td>{{$mandrug->quantity}}</td>
                                                          <td>{{$mandrug->dose_given}}</td>
                                                          <td>{{$mandrug->price}}</td>
                                                          <td>{{$total}}</td>
                                                        </tr>
                                                          <?php $i++;  ?>
                                                        @endforeach

                                                     </tbody>
                                                 </table>
                                        @endif
                                                 </div>
                                                 </div>
                                                 </div>

                                </div>
                                </div>
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
    <!-- sales This week -->
                                  <div class="table-responsive">
                                  @if(!empty($rep))
                                  <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>

                                                          <th>Prescribing Doctor</th>
                                                           <th>Facility</th>
                                                          <th>Pharmacy  name</th>
                                                         <th> Quantity</th>
                                                         <th>Dosage</th>
                                                         <th>Unit Cost</th>
                                                         <th>Total  </th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                    <?php $i =1;

                                                    $drugwprsc = DB::table('prescriptions')
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
                                                  ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                  ['prescription_filled_status.created_at','>=',$one_week_ago],
                                                  ['prescription_filled_status.created_at','<=',$todaysales],
                                                  ['druglists.id',$rep->drug_id],])
                                                  ->whereNull('prescription_filled_status.substitute_presc_id');

                                                   $drugw=DB::table('prescriptions')
                                                  ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
                                                  ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                                                  ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
                                                 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                                                  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                                                  ->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
                                                  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
                                                  ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
                                                    'pharmacy.county',
                                                    'prescription_filled_status.substitute_presc_id')
                                                  ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                  ['prescription_filled_status.created_at','>=',$one_week_ago],
                                                  ['prescription_filled_status.created_at','<=',$todaysales],
                                                  ['druglists.id',$rep->drug_id],
                                                        ])
                                                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                                                  ->union($drugwprsc)
                                                  ->get();


                                                    ?>
                                                 @foreach($drugw as $mandrug)
                                                 <?php $total= ($mandrug->quantity * $mandrug->price);

                                                 ?>
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$mandrug->drugname}}</td>
                                                          <td>{{$mandrug->name}}</td>
                                                          <td>{{$mandrug->FacilityName}}</td>
                                                          <td>{{$mandrug->pharmacy}}</td>
                                                          <td>{{$mandrug->quantity}}</td>
                                                          <td>{{$mandrug->dose_given}}</td>
                                                          <td>{{$mandrug->price}}</td>
                                                          <td>{{$total}}</td>
                                                        </tr>
                                                          <?php $i++;  ?>
                                                        @endforeach

                                                     </tbody>
                                                   </table>

                                  @else
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>

                                                          <th>Prescribing Doctor</th>
                                                           <th>Facility</th>
                                                          <th>Pharmacy  name</th>
                                                         <th> Quantity</th>
                                                         <th>Dosage</th>
                                                         <th>Unit Cost</th>
                                                         <th>Total  </th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                    <?php $i =1;

                                                    $drugwprsc = DB::table('prescriptions')
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
                                                  ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                  ['prescription_filled_status.created_at','>=',$one_week_ago],
                                                  ['prescription_filled_status.created_at','<=',$todaysales],])
                                                  ->whereNull('prescription_filled_status.substitute_presc_id');

                                                   $drugw=DB::table('prescriptions')
                                                  ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
                                                  ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                                                  ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
                                                 ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                                                  ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                                                  ->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
                                                  ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
                                                  ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
                                                    'pharmacy.county',
                                                    'prescription_filled_status.substitute_presc_id')
                                                  ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                  ['prescription_filled_status.created_at','>=',$one_week_ago],
                                                  ['prescription_filled_status.created_at','<=',$todaysales],
                                                        ])
                                                  ->whereNotNull('prescription_filled_status.substitute_presc_id')
                                                  ->union($drugwprsc)
                                                  ->get();


                                                    ?>
                                                 @foreach($drugw as $mandrug)
                                                 <?php $total= ($mandrug->quantity * $mandrug->price);

                                                 ?>
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$mandrug->drugname}}</td>
                                                          <td>{{$mandrug->name}}</td>
                                                          <td>{{$mandrug->FacilityName}}</td>
                                                          <td>{{$mandrug->pharmacy}}</td>
                                                          <td>{{$mandrug->quantity}}</td>
                                                          <td>{{$mandrug->dose_given}}</td>
                                                          <td>{{$mandrug->price}}</td>
                                                          <td>{{$total}}</td>
                                                        </tr>
                                                          <?php $i++;  ?>
                                                        @endforeach

                                                     </tbody>
                                                   </table>
                                                   @endif
                                                 </div>
                                                 </div>
                                                 </div>

                                </div>
                                </div>
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
    <!-- sales This Month -->
                                  <div class="table-responsive">

                            @if(!empty($rep))
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>

                                                          <th>Prescribing Doctor</th>
                                                           <th>Facility</th>
                                                          <th>Pharmacy  name</th>
                                                         <th> Quantity</th>
                                                         <th>Dosage</th>
                                                         <th>Unit Cost</th>
                                                         <th>Total  </th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                    <?php $i =1;

                                                     $drugmprsc = DB::table('prescriptions')
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
                                                    ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                    ['prescription_filled_status.created_at','>=',$one_mon_ago],
                                                    ['prescription_filled_status.created_at','<=',$todaysales],
                                                    ['druglists.id',$rep->drug_id],])
                                                   ->whereNull('prescription_filled_status.substitute_presc_id');

                                                     $drugM=DB::table('prescriptions')
                                                    ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
                                                    ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                                                    ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
                                                    ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                                                    ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                                                    ->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
                                                    ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
                                                    ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
                                                      'pharmacy.county',
                                                      'prescription_filled_status.substitute_presc_id')
                                                    ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                    ['prescription_filled_status.created_at','>=',$one_mon_ago],
                                                    ['prescription_filled_status.created_at','<=',$todaysales],
                                                    ['druglists.id',$rep->drug_id],
                                                          ])
                                                    ->whereNotNull('prescription_filled_status.substitute_presc_id')
                                                   ->union($drugmprsc)
                                                   ->get();
                                                   ?>
                                                 @foreach($drugM as $mandrug)
                                                 <?php $total= ($mandrug->quantity * $mandrug->price);

                                                 ?>
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$mandrug->drugname}}</td>
                                                          <td>{{$mandrug->name}}</td>
                                                          <td>{{$mandrug->FacilityName}}</td>
                                                          <td>{{$mandrug->pharmacy}}</td>
                                                          <td>{{$mandrug->quantity}}</td>
                                                          <td>{{$mandrug->dose_given}}</td>
                                                          <td>{{$mandrug->price}}</td>
                                                          <td>{{$total}}</td>
                                                        </tr>
                                                          <?php $i++;  ?>
                                                        @endforeach

                                                     </tbody>

                                                 </table>
                            @else
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>

                                                          <th>Prescribing Doctor</th>
                                                           <th>Facility</th>
                                                          <th>Pharmacy  name</th>
                                                         <th> Quantity</th>
                                                         <th>Dosage</th>
                                                         <th>Unit Cost</th>
                                                         <th>Total  </th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                    <?php $i =1;

                                                     $drugmprsc = DB::table('prescriptions')
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
                                                    ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                    ['prescription_filled_status.created_at','>=',$one_mon_ago],
                                                    ['prescription_filled_status.created_at','<=',$todaysales],])
                                                   ->whereNull('prescription_filled_status.substitute_presc_id');

                                                     $drugM=DB::table('prescriptions')
                                                    ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
                                                    ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                                                    ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
                                                    ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                                                    ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                                                    ->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
                                                    ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
                                                    ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
                                                      'pharmacy.county',
                                                      'prescription_filled_status.substitute_presc_id')
                                                    ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                    ['prescription_filled_status.created_at','>=',$one_mon_ago],
                                                    ['prescription_filled_status.created_at','<=',$todaysales],
                                                          ])
                                                    ->whereNotNull('prescription_filled_status.substitute_presc_id')
                                                   ->union($drugmprsc)
                                                   ->get();
                                                   ?>
                                                 @foreach($drugM as $mandrug)
                                                 <?php $total= ($mandrug->quantity * $mandrug->price);

                                                 ?>
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$mandrug->drugname}}</td>
                                                          <td>{{$mandrug->name}}</td>
                                                          <td>{{$mandrug->FacilityName}}</td>
                                                          <td>{{$mandrug->pharmacy}}</td>
                                                          <td>{{$mandrug->quantity}}</td>
                                                          <td>{{$mandrug->dose_given}}</td>
                                                          <td>{{$mandrug->price}}</td>
                                                          <td>{{$total}}</td>
                                                        </tr>
                                                          <?php $i++;  ?>
                                                        @endforeach

                                                     </tbody>

                                                 </table>
                                            @endif
                                                 </div>
                                                 </div>
                                                 </div>

                                </div>
                                </div>
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
  <!-- sales This Year -->
                                  <div class="table-responsive">
                                  @if(!empty($rep))
                                  <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>

                                                          <th>Prescribing Doctor</th>
                                                           <th>Facility</th>
                                                          <th>Pharmacy  name</th>
                                                         <th> Quantity</th>
                                                         <th>Dosage</th>
                                                         <th>Unit Cost</th>
                                                         <th>Total  </th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                    <?php $i =1;
                                                    // use Carbon\Carbon;

                                                    $one_year_ago = Carbon::now()->subYears(1);
                                                    $drugyprsc = DB::table('prescriptions')
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
                                                   ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                   ['prescription_filled_status.created_at','>=',$one_year_ago],
                                                   ['prescription_filled_status.created_at','<=',$todaysales],
                                                   ['druglists.id',$rep->drug_id],])
                                                  ->whereNull('prescription_filled_status.substitute_presc_id');

                                                    $drugY=DB::table('prescriptions')
                                                   ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
                                                   ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                                                   ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
                                                  ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                                                   ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                                                   ->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
                                                   ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
                                                   ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
                                                     'pharmacy.county',
                                                     'prescription_filled_status.substitute_presc_id')
                                                   ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                   ['prescription_filled_status.created_at','>=',$one_year_ago],
                                                   ['prescription_filled_status.created_at','<=',$todaysales],
                                                   ['druglists.id',$rep->drug_id],
                                                         ])
                                                   ->whereNotNull('prescription_filled_status.substitute_presc_id')
                                                  ->union($drugyprsc)
                                                  ->get();
                                                  ?>
                                                 @foreach($drugY as $mandrug)
                                                 <?php $total= ($mandrug->quantity * $mandrug->price);

                                                 ?>
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$mandrug->drugname}}  </td>
                                                          <td>{{$mandrug->name}}</td>
                                                          <td>{{$mandrug->FacilityName}}</td>
                                                          <td>{{$mandrug->pharmacy}}</td>
                                                          <td>{{$mandrug->quantity}}</td>
                                                          <td>{{$mandrug->dose_given}}</td>
                                                          <td>{{$mandrug->price}}</td>
                                                          <td>{{$total}}</td>
                                                        </tr>
                                                          <?php $i++;  ?>
                                                        @endforeach

                                                     </tbody>

                                                 </table>
                                  @else
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                          <th>No</th>
                                                     <th>Drug Name</th>

                                                          <th>Prescribing Doctor</th>
                                                           <th>Facility</th>
                                                          <th>Pharmacy  name</th>
                                                         <th> Quantity</th>
                                                         <th>Dosage</th>
                                                         <th>Unit Cost</th>
                                                         <th>Total  </th>
                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                    <?php $i =1;
                                                    // use Carbon\Carbon;

                                                    $one_year_ago = Carbon::now()->subYears(1);
                                                    $drugyprsc = DB::table('prescriptions')
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
                                                   ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                   ['prescription_filled_status.created_at','>=',$one_year_ago],
                                                   ['prescription_filled_status.created_at','<=',$todaysales],])
                                                  ->whereNull('prescription_filled_status.substitute_presc_id');

                                                    $drugY=DB::table('prescriptions')
                                                   ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
                                                   ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                                                   ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
                                                   ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                                                   ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                                                   ->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
                                                   ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
                                                   ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
                                                     'pharmacy.county',
                                                     'prescription_filled_status.substitute_presc_id')
                                                   ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                                                   ['prescription_filled_status.created_at','>=',$one_year_ago],
                                                   ['prescription_filled_status.created_at','<=',$todaysales],
                                                         ])
                                                   ->whereNotNull('prescription_filled_status.substitute_presc_id')
                                                  ->union($drugyprsc)
                                                  ->get();
                                                  ?>
                                                 @foreach($drugY as $mandrug)
                                                 <?php $total= ($mandrug->quantity * $mandrug->price);

                                                 ?>
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$mandrug->drugname}}  </td>
                                                          <td>{{$mandrug->name}}</td>
                                                          <td>{{$mandrug->FacilityName}}</td>
                                                          <td>{{$mandrug->pharmacy}}</td>
                                                          <td>{{$mandrug->quantity}}</td>
                                                          <td>{{$mandrug->dose_given}}</td>
                                                          <td>{{$mandrug->price}}</td>
                                                          <td>{{$total}}</td>
                                                        </tr>
                                                          <?php $i++;  ?>
                                                        @endforeach

                                                     </tbody>

                                                 </table>
                                                 @endif
                                                 </div>
                                                 </div>
                                                 </div>

                                </div>
                                </div>
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
               <!-- sales All times-->
<div class="table-responsive">

@if(!empty($rep))
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>


                <tr>
                    <th>No</th>
               <th>Drug Name</th>

                    <th>Prescribing Doctor</th>
                     <th>Facility</th>
                    <th>Pharmacy  name</th>
                   <th> Quantity</th>
                   <th>Dosage</th>
                   <th>Unit Cost</th>
                   <th>Total  </th>
                   </tr>

            </thead>

            <tbody>
              <?php $i =1;
              // use Carbon\Carbon;


              $drugallprsc = DB::table('prescriptions')
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
             ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
              ['druglists.id',$rep->drug_id],

             ])
             ->whereNull('prescription_filled_status.substitute_presc_id');

              $drugall=DB::table('prescriptions')
             ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
             ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
             ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
             ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
             ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
             ->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
             ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
             ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
              'pharmacy.county',
               'prescription_filled_status.substitute_presc_id')
             ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
              ['druglists.id',$rep->drug_id],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->union($drugallprsc)
            ->get();
            ?>
           @foreach($drugall as $mandrug)
           <?php $total= ($mandrug->quantity * $mandrug->price);

           ?>
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$mandrug->drugname}}  </td>
                    <td>{{$mandrug->name}}</td>
                    <td>{{$mandrug->FacilityName}}</td>
                    <td>{{$mandrug->pharmacy}}</td>
                    <td>{{$mandrug->quantity}}</td>
                    <td>{{$mandrug->dose_given}}</td>
                    <td>{{$mandrug->price}}</td>
                    <td>{{$total}}</td>
                  </tr>
                    <?php $i++;  ?>
                  @endforeach

               </tbody>
</table>
@else
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>


                <tr>
                    <th>No</th>
               <th>Drug Name</th>

                    <th>Prescribing Doctor</th>
                     <th>Facility</th>
                    <th>Pharmacy  name</th>
                   <th> Quantity</th>
                   <th>Dosage</th>
                   <th>Unit Cost</th>
                   <th>Total  </th>
                   </tr>

            </thead>

            <tbody>
              <?php $i =1;
              // use Carbon\Carbon;


              $drugallprsc = DB::table('prescriptions')
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
             ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
             ])
             ->whereNull('prescription_filled_status.substitute_presc_id');

              $drugall=DB::table('prescriptions')
             ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
             ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
             ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
             ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
             ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
             ->Join('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
             ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
             ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
              'pharmacy.county',
               'prescription_filled_status.substitute_presc_id')
             ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
             ])
             ->whereNotNull('prescription_filled_status.substitute_presc_id')
            ->union($drugallprsc)
            ->get();
            ?>
           @foreach($drugall as $mandrug)
           <?php $total= ($mandrug->quantity * $mandrug->price);

           ?>
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$mandrug->drugname}}  </td>
                    <td>{{$mandrug->name}}</td>
                    <td>{{$mandrug->FacilityName}}</td>
                    <td>{{$mandrug->pharmacy}}</td>
                    <td>{{$mandrug->quantity}}</td>
                    <td>{{$mandrug->dose_given}}</td>
                    <td>{{$mandrug->price}}</td>
                    <td>{{$total}}</td>
                  </tr>
                    <?php $i++;  ?>
                  @endforeach

               </tbody>
</table>
@endif
</div>
</div>
</div>

</div>
</div>
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
                   <!-- sales All Custom-->
                                  <div class="table-responsive">
                                  @if(!empty($rep))
                                  <table class="table table-striped table-bordered table-hover dataTables-example" >


                            <div class="col-md-3">
                                 <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
                            </div>
                            <div class="col-md-3">
                                 <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
                            </div>
                            <div class="col-md-5">
                                 <input type="button" name="filter" id="filter" value="Filter" class="btn btn-info" />
                            </div>
                            <div style="clear:both"></div>
                            <br />
                            <div id="order_table">


                   <thead>
                    <tr>
                     <th>No</th>
                     <th>Drug Name</th>
                     <th>Prescribing Doctor</th>
                     <th>Facility</th>
                     <th>Pharmacy  name</th>
                     <th> Quantity</th>
                     <th>Dosage</th>
                     <th>Unit Cost</th>
                     <th>Total  </th>
                          </tr>
                         </thead>
                         <tbody>
                           <?php $i =1;
                           // use Carbon\Carbon;

                           $drugcust = DB::table('prescriptions')
                            ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
                            ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                            ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
                            ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                            ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                            ->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
                            ->leftJoin('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
                            ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
                            'pharmacy.county',
                            'prescription_filled_status.substitute_presc_id')
                          ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],
                            ['druglists.id',$rep->drug_id],

                                ])

                          ->get();


                           ?>
          @foreach($drugcust as $mandrug)
          <?php $total= ($mandrug->quantity * $mandrug->price);

             ?>
             <tr>
             <td>{{$i}}</td>
             <td> <?php if($mandrug->substitute_presc_id){
             $drugs = DB::table('substitute_presc_details')
             ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
             ->select('druglists.drugname as subdrugname')
             ->where([
                     ['substitute_presc_details.id','=',$mandrug->substitute_presc_id],
                     ['druglists.id',$rep->drug_id],
                   ])
             ->first();
             echo $drugs->subdrugname;
             }
             else{ echo $mandrug->drugname;   } ?>

             </td>
             <td>{{$mandrug->name}}</td>
             <td>{{$mandrug->FacilityName}}</td>
             <td>{{$mandrug->pharmacy}}</td>
             <td>{{$mandrug->quantity}}</td>
             <td>{{$mandrug->dose_given}}</td>
             <td>{{$mandrug->price}}</td>
             <td>{{$total}}</td>
             </tr>
             <?php $i++;  ?>
             @endforeach

             </tbody>

                         </table>

                                  @else

                              <table class="table table-striped table-bordered table-hover dataTables-example" >


                            <div class="col-md-3">
                                 <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
                            </div>
                            <div class="col-md-3">
                                 <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
                            </div>
                            <div class="col-md-5">
                                 <input type="button" name="filter" id="filter" value="Filter" class="btn btn-info" />
                            </div>
                            <div style="clear:both"></div>
                            <br />
                            <div id="order_table">


                   <thead>
                    <tr>
                     <th>No</th>
                     <th>Drug Name</th>
                     <th>Prescribing Doctor</th>
                     <th>Facility</th>
                     <th>Pharmacy  name</th>
                     <th> Quantity</th>
                     <th>Dosage</th>
                     <th>Unit Cost</th>
                     <th>Total  </th>
                          </tr>
                         </thead>
                         <tbody>
                           <?php $i =1;
                           // use Carbon\Carbon;

                           $drugcust = DB::table('prescriptions')
                            ->Join('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
                            ->Join('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                            ->Join('pharmacy', 'prescription_filled_status.outlet_id', '=', 'pharmacy.id')
                            ->Join('appointments','appointments.id','=','prescriptions.appointment_id')
   ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                            ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                            ->Join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
                            ->leftJoin('substitute_presc_details', 'prescription_filled_status.substitute_presc_id', '=', 'substitute_presc_details.id')
                            ->select('prescription_filled_status.*','facilities.FacilityName','doctors.name','druglists.drugname','pharmacy.name as pharmacy',
                            'pharmacy.county',
                            'prescription_filled_status.substitute_presc_id')
                          ->where([ ['druglists.Manufacturer','like', '%' .$Mname . '%'],

                                ])

                          ->get();


                           ?>
          @foreach($drugcust as $mandrug)
          <?php $total= ($mandrug->quantity * $mandrug->price);

             ?>
             <tr>
             <td>{{$i}}</td>
             <td> <?php if($mandrug->substitute_presc_id){
             $drugs = DB::table('substitute_presc_details')
             ->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
             ->select('druglists.drugname as subdrugname')
             ->where([
                     ['substitute_presc_details.id','=',$mandrug->substitute_presc_id],
                   ])
             ->first();
             echo $drugs->subdrugname;
             }
             else{ echo $mandrug->drugname;   } ?>

             </td>
             <td>{{$mandrug->name}}</td>
             <td>{{$mandrug->FacilityName}}</td>
             <td>{{$mandrug->pharmacy}}</td>
             <td>{{$mandrug->quantity}}</td>
             <td>{{$mandrug->dose_given}}</td>
             <td>{{$mandrug->price}}</td>
             <td>{{$total}}</td>
             </tr>
             <?php $i++;  ?>
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
                             <!-- End drug-->
            <!-- Sales by doctor-->
            @include('manufacturer.todaysalesdoctor')
            <!--sales by doctor  end-->
                <!--sales by region-->
            @include('manufacturer.todaysalesregion')
              <!--sales by region  end-->



                            </div>
                        </div>


                    </div>
                </div>

            </div>
             @include('includes.default.footer')
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
