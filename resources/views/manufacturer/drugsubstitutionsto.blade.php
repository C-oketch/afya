<div id="tab-2" class="tab-pane">
<ul class="nav nav-tabs">
<li class="active"><a data-toggle="tab" href="#tab-21a">Today</a></li>
<li class=""><a data-toggle="tab" href="#tab-22a">This Week</a></li>
<li class=""><a data-toggle="tab" href="#tab-23a">This Month</a></li>
<li class=""><a data-toggle="tab" href="#tab-24a">This Year</a></li>
<li class=""><a data-toggle="tab" href="#tab-25a">Max</a></li>
<li class=""><a data-toggle="tab" href="#tab-26a">Custom</a></li>
</ul>
<br>
<div class="tab-content">
<div id="tab-21a" class="tab-pane active">
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
use Carbon\Carbon;
$today = Carbon::today();
$one_week_ago = Carbon::now()->subWeeks(1);
$one_month_ago = Carbon::now()->subMonths(1);
$one_year_ago = Carbon::now()->subYears(1);
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
?>
@foreach($Toprescribed  as $daily)
<?php $Tosubstituted = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select('druglists.drugname as subdrugname')
->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
['druglists.Manufacturer','like', '%'.$Mname.'%'],
])

->first();
?>
<?php if($Tosubstituted) { ?>
<tr>
<td>{{$i}}</td>
<td>{{ $daily->drugname}}</td>
<td>{{$daily->pharmacy}}</td>
<td>{{$daily->name}}</td>
<td>{{$Tosubstituted->subdrugname}}</td>
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
</div>
</div>
</div>
</div>
</div>
<!--................................. THIS WEEK ...........................-->
<div id="tab-22a" class="tab-pane">
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
?>
@foreach($Toprescribedw  as $daily)
<?php $Tosubstitutedw = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select('druglists.drugname as subdrugname')
->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
['druglists.Manufacturer','like', '%'.$Mname.'%'],
])

->first();
?>
<?php if($Tosubstitutedw) { ?>
<tr>
<td>{{$i}}</td>
<td>{{ $daily->drugname}}</td>
<td>{{$daily->pharmacy}}</td>
<td>{{$daily->name}}</td>
<td>{{$Tosubstitutedw->subdrugname}}</td>
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
</div>
</div>
</div>
</div>
</div>

<!--................................. THIS MONTH ...........................-->
<div id="tab-23a" class="tab-pane">
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
?>
@foreach($Toprescribedm as $daily)
<?php $Tosubstitutedm = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select('druglists.drugname as subdrugname')
->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
['druglists.Manufacturer','like', '%'.$Mname.'%'],
])

->first();
?>
<?php if($Tosubstitutedm) { ?>
<tr>
<td>{{$i}}</td>
<td>{{ $daily->drugname}}</td>
<td>{{$daily->pharmacy}}</td>
<td>{{$daily->name}}</td>
<td>{{$Tosubstitutedm->subdrugname}}</td>
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
</div>
</div>
</div>
</div>
</div>

<!--................................. THIS YEAR ...........................-->
<div id="tab-24a" class="tab-pane">
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
?>
@foreach($Toprescribedy as $daily)
<?php $Tosubstitutedy = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select('druglists.drugname as subdrugname')
->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
['druglists.Manufacturer','like', '%'.$Mname.'%'],
])

->first();
?>
<?php if($Tosubstitutedy) { ?>
<tr>
<td>{{$i}}</td>
<td>{{ $daily->drugname}}</td>
<td>{{$daily->pharmacy}}</td>
<td>{{$daily->name}}</td>
<td>{{$Tosubstitutedy->subdrugname}}</td>
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
</div>
</div>
</div>
</div>
</div>

<!--................................. MAX...........................-->
<div id="tab-25a" class="tab-pane">
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
?>
@foreach($Toprescribedall  as $daily)
<?php $Tosubstitutedall = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select('druglists.drugname as subdrugname')
->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
['druglists.Manufacturer','like', '%'.$Mname.'%'],
])

->first();
?>
<?php if($Tosubstitutedall) { ?>
<tr>
<td>{{$i}}</td>
<td>{{ $daily->drugname}}</td>
<td>{{$daily->pharmacy}}</td>
<td>{{$daily->name}}</td>
<td>{{$Tosubstitutedall->subdrugname}}</td>
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
</div>
</div>
</div>
</div>
</div>


<!--................................. CUSTOM ...........................-->
<div id="tab-26a" class="tab-pane">
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
?>
@foreach($Toprescribedall  as $daily)
<?php $Tosubstitutedall = DB::table('substitute_presc_details')
->Join('druglists', 'substitute_presc_details.drug_id', '=', 'druglists.id')
->select('druglists.drugname as subdrugname')
->where([ ['substitute_presc_details.id', '=', $daily->substitute_presc_id],
['druglists.Manufacturer','like', '%'.$Mname.'%'],
])

->first();
?>
<?php if($Tosubstitutedall) { ?>
<tr>
<td>{{$i}}</td>
<td>{{ $daily->drugname}}</td>
<td>{{$daily->pharmacy}}</td>
<td>{{$daily->name}}</td>
<td>{{$Tosubstitutedall->subdrugname}}</td>
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
</div>
</div>
</div>
</div>
</div>

<!--  ................custom............................. -->
</div><!--  tab-content -->
</div>
