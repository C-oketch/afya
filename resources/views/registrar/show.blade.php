@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

@include('includes.registrar.topnavbar_v2')
<?php $patient=DB::Table('kin_details')->where('afya_user_id',$user->id)->first();
$kin = DB::table('kin')->get();
if($user->constituency){
$countys=DB::Table('constituency')->where('id',$user->constituency)->first();

$usercounty=$countys->Constituency;
}else{$usercounty=''; }
$today = date('Y-m-d');
$conpaid=DB::Table('appointments')
->join('payments', 'appointments.id', '=', 'payments.appointment_id')
->select('appointments.id')
->where([['appointments.afya_user_id',$user->id],['payments.payments_category_id',1]])
->whereDate('appointments.created_at','=',$today)
->orderBy('appointments.id','Desc')
->first();

?>
<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-4">
<h2>Action</h2>
</div>
<div class="col-lg-8">
<div class="title-action">

<a href="{{ URL('edit_patient_details', $user->id) }}"  class="btn btn-primary pull-left"><i class="fa fa-print"></i> Update Patient Details </a>
@if($conpaid)
<a href="{{ URL('registrar.consltreceiptF', $conpaid->id) }}"   class="btn btn-primary  pull-right"><i class="fa fa-ceck"></i> Consultation Fee - Receipt</a>

@else
<a href="{{ URL('registrar.Reg_feespay_F', $user->id) }}"  class="btn btn-primary  pull-right"><i class="fa fa-money"></i> Consultation Fee </a>
@endif
</div>
</div>
</div>
<div class="row wrapper border-bottom">
<div class="row">
<div class="col-lg-6">
<div class="ibox float-e-margins">
<div class="ibox-content">
<table class="table table-hover no-margins">
<thead>
<tr>
<th colspan="2">PATIENT BASIC INFO</th>
</tr>
</thead>
<tbody>
<tr>
<td>  <strong>Name  </strong></td>
<td>{{$user->firstname}}  {{$user->secondName}}</td>
</tr>
<tr>
<td><strong>Gender  </strong> </td>
<td>{{$user->gender}}</td>
</tr>
<tr>
<td><strong>Date Of Birth </strong></td>
<td>{{$user->dob}}</td>
</tr>
<tr>
<td><strong>Place of Birth </strong></td>
<td>{{$user->pob}}</td>
</tr>
<tr>
<td><strong>Id </strong></td>
<td>{{$user->nationalId}}</td>
</tr>



</tbody>
</table>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="ibox float-e-margins">

<div class="ibox-content">
<table class="table table-hover no-margins">
<thead>
<tr>
<th colspan="2">Contact Details</th>

</tr>
</thead>
<tbody>
<tr>
<td><strong>Phone </strong> </td>
<td>{{$user->msisdn}}</td>
</tr>
<tr>
<td>  <strong>Email </strong> </td>
<td>{{$user->email}}</td>
</tr>
<tr>
<td><strong>Constituency </strong> </td>
<td>{{$usercounty }}</td>
</tr>

<tr>
<td></td>
<td></td>
</tr>

</tbody>
</table>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-6">
<div class="ibox float-e-margins">
<div class="ibox-content">
<table class="table table-hover no-margins">
<thead>
<tr>
<th colspan="2">Insurance Details</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>  NHIF </strong></td>
<td>{{$user->nhif}}</td>
</tr>
@foreach($insrnc as $ins)
<tr>
<td><strong> INSURER </strong></td>
<td>{{$ins->company_name}}</td>
</tr>
<tr>
<td><strong> POLICY NO </strong></td>
<td>{{$ins->policy_no}}</td>
</tr>
@endforeach


</tbody>
</table>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="ibox float-e-margins">

<div class="ibox-content">
<table class="table table-hover no-margins">
<thead>
<tr>
<th colspan="2">Next Of Kin Details</th>

</tr>
</thead>
<tbody>
@if($patient)
<tr>
<td><strong>Name </strong></td>
<td>{{$patient->kin_name}}</td>
</tr>
<tr>
<td><strong>Relation </strong><br></td>
<?php $relate = DB::Table('kin')->where('id',$patient->relation)->first();?>
<td>{{$relate->relation}}</td>
</tr>

<tr>
<td><strong>Phone  </strong></td>
<td>{{$patient->phone_of_kin}}</td>

</tr>
<tr>
<td></td><td></td>

</tr>
@endif
</tbody>
</table>
</div>
</div>
</div>



</div>


<div>
</div>
</div>


@endsection
