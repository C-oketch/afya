@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')
<!-- nav -->
@include('includes.registrar.topnavbar_v1')
<div class="wrapper wrapper-content animated fadeIn">
<div class="row">
<div class="col-lg-12">
<div class="tabs-container">
<ul class="nav nav-tabs">
<li class="active"><a data-toggle="tab" href="#tab-1">Today's Patients</a></li>
<li class=""><a data-toggle="tab" href="#tab-2">This Week's Patients</a></li>
<li class=""><a data-toggle="tab" href="#tab-3"> This Month Patients</a></li>
<li class=""><a data-toggle="tab" href="#tab-4">All Patients</a></li>
</ul>
<div class="tab-content">
<div id="tab-1" class="tab-pane active">
<div class="panel-body">
<strong>Patients Seen Today</strong>
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
<th>No</th>
<th>Name</th>
<th>File No</th>
<th>Age</th>
<th>Gender</th>
<th>Phone</th>
<th>Appointment</th>
<th>Printouts</th>
</tr>
</thead>
<tbody>
<?php   $i=1;   ?>
@foreach($patientsToday as $todayp)
<tr>

<td><a href="{{URL('registrar.select',$todayp->id)}}">{{$i}}</a></td>
<td><a href="{{URL('registrar.select',$todayp->id)}}">{{$todayp->firstname}} {{$todayp->secondName}}</a></td>
<td><a href="{{URL('registrar.select',$todayp->id)}}">{{$todayp->file_no}}</a></td>
<td>
<?php

if($todayp->dob){
$interval = date_diff(date_create(), date_create($todayp->dob));
$age = $interval->format(" %Y Years Old");
}elseif ($todayp->age) {
$age =$todayp->age.' '.'Years Old';
}else{
$age ='Not Set';
}
?>
{{$age}}
</td>
<td>{{$todayp->gender}}</td>
<td>{{$todayp->msisdn}}</td>
<td><a href="{{route('calendar.show',$todayp->id)}}">create</a></td>
<td><a href="{{route('registrar.printout',$todayp->id)}}">Printouts</a></td>
</tr>
<?php $i++; ?>
@endforeach
</tbody>
</table>
</div>

</div>
</div>
<div id="tab-2" class="tab-pane">
<div class="panel-body">
<strong>Patients Seen This Week</strong>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
<th>No</th>
<th>Name</th>
<th>File No</th>
<th>Age</th>
<th>Gender</th>
<th>Phone</th>
<th>Appointment</th>
<th>Printouts</th>
</tr>
</thead>
<tbody>
<?php   $i=1;   ?>
@foreach($patientswk as $wkp)
<tr>
  <td>  <a href="{{URL('registrar.select',$wkp->id)}}">{{$i}}</a></td>
  <td><a href="{{URL('registrar.select',$wkp->id)}}">{{$wkp->firstname}} {{$wkp->secondName}}</a></td>
  <td><a href="{{URL('registrar.select',$wkp->id)}}">{{$wkp->file_no}}</a></td>
<td>
<?php

if($wkp->dob){
$interval = date_diff(date_create(), date_create($wkp->dob));
$age = $interval->format(" %Y Years Old");
}elseif ($wkp->age) {
$age =$wkp->age.' '.'Years Old';
}else{
$age ='Not Set';
}
?>
{{$age}}
</td>
<td>{{$wkp->gender}}</td>
<td>{{$wkp->msisdn}}</td>
<td><a href="{{route('calendar.show',$wkp->id)}}">create</a></td>
<td><a href="{{route('registrar.printout',$wkp->id)}}">Printouts</a></td>
</tr>
<?php $i++; ?>
@endforeach
</tbody>
</table>
</div>

</div>
</div>
<div id="tab-3" class="tab-pane">
<div class="panel-body">
<strong>Patients Seen This Month</strong>


<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
<th>No</th>
<th>Name</th>
<th>File No</th>
<th>Age</th>
<th>Gender</th>
<th>Phone</th>
<th>Appointment</th>
<th>Printouts</th>
</tr>
</thead>
<tbody>
<?php   $i=1;   ?>
@foreach($patientmonth as $pmons)
<tr>
  <td>  <a href="{{URL('registrar.select',$pmons->id)}}">{{$i}}</a></td>
  <td><a href="{{URL('registrar.select',$pmons->id)}}">{{$pmons->firstname}} {{$pmons->secondName}}</a></td>
  <td><a href="{{URL('registrar.select',$pmons->id)}}">{{$pmons->file_no}}</a></td>
<td>
<?php


if($pmons->dob){
$interval = date_diff(date_create(), date_create($pmons->dob));
$age = $interval->format(" %Y Years Old");
}elseif ($pmons->age) {
$age =$pmons->age.' '.'Years Old';
}else{
$age ='Not Set';
}
?>
{{$age}}
</td>
<td>{{$pmons->gender}}</td>
<td>{{$pmons->msisdn}}</td>
<td><a href="{{route('calendar.show',$pmons->id)}}">create</a></td>
<td><a href="{{route('registrar.printout',$pmons->id)}}">Printouts</a></td>
</tr>
<?php $i++; ?>
@endforeach
</tbody>
</table>
</div>


</div>
</div>
<div id="tab-4" class="tab-pane">
<div class="panel-body">
<strong>All Patients Seen</strong>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
<th>No</th>
<th>Name</th>
<th>File No</th>
<th>Age</th>
<th>Gender</th>
<th>Phone</th>
<th>Appointment</th>
<th>Printouts</th>
</tr>
</thead>
<tbody>
<?php   $i=1;   ?>
@foreach($users as $user)
<tr>
  <td>  <a href="{{URL('registrar.select',$user->id)}}">{{$i}}</a></td>
  <td><a href="{{URL('registrar.select',$user->id)}}">{{$user->firstname}} {{$user->secondName}}</a></td>
  <td><a href="{{URL('registrar.select',$user->id)}}">{{$user->file_no}}</a></td>
<td>
<?php
if($user->dob){
$interval = date_diff(date_create(), date_create($user->dob));
$age = $interval->format(" %Y Years Old");
}elseif ($user->age) {
$age =$user->age.' '.'Years Old';
}else{
$age ='Not Set';
}
?>
{{$age}}
</td>
<td>{{$user->gender}}</td>
<td>{{$user->msisdn}}</td>

<td><a href="{{route('calendar.show',$user->id)}}">create</a></td>
<td><a href="{{route('registrar.printout',$user->id)}}">Printouts</a></td>
</tr>
<?php $i++; ?>
@endforeach
</tbody>
</table>
</div>

</div>
</div>
</div>


</div>
</div>
</div>
</div>

@include('includes.default.footer')

@endsection
