@extends('layouts.doctor_layout')
@section('title', 'Patient History')
@section('content')



<?php
use Carbon\Carbon;
$doc = (new \App\Http\Controllers\DoctorController);
$Docdatas = $doc->DocDetails();
foreach($Docdatas as $Docdata){
$Did = $Docdata->id;
$Name = $Docdata->name;

}
$afyauserId = $user->afyaId;
$condition = $user->condition;
$apps = DB::table('appointments')
->orderBy('id', 'desc')
->where('afya_user_id', '=',$afyauserId)->first();

$cur_app_id = $apps->id;

$app_id=$user->appid;


if($user->persontreated == 'Self'){
  $name = $user->firstname ." ". $user->secondName;
  $gender = $user->gender;
  $dob = $user->dob;
  $age = $user->age;
  $occupation = $user->occupation;
}
if($dob){
$interval = date_diff(date_create(), date_create($dob));
$age= $interval->format(" %Y Years Old");
}else{
$age=$age;
}

?>
@section('leftmenu')
@include('includes.doc_inc.leftmenu2')
@endsection

<div class="row wrapper white-bg page-heading">
              <div class="col-lg-8">
                  <h2>PATIENT</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="#">  <strong>Name:</strong> {{$name}}</a>
                      </li>
                      <li>
                          <strong>Gender:</strong> {{$gender}}<br>

                      </li>
                      <li class="active">
                          <strong>Age:</strong> {{$age}}
                      </li>
                  </ol>
              </div>
              <div class="col-lg-4">
                  <div class="title-action">


                  </div>
              </div>
          </div>





<div class="wrapper wrapper-content">
  <div class="row"  id="div_print">

      <div class="ibox float-e-margins">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
          <!-- <div class="">
          <h5>Summary</h5>
          </div> -->
          <div class="">
          <div class="row">
          <div class="col-sm-12"><h3 class="m-t-none m-b"></h3>
          <form class="form-horizontal" role="form" method="POST" action="/mrPatients" >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          {{ Form::hidden('appointment_id',$user->appid, array('class' => 'form-control')) }}
          {{ Form::hidden('afya_user_id',$afyauserId, array('class' => 'form-control')) }}




<div class="form-group">
<label>Patient Summary </label><br>
<div class="col-lg-10 white-bg">
<textarea class="form-control" rows="5"  name="doc_note">@if ($psummary){{$psummary->notes}} @endif</textarea>
</div>
</div>

<div class="form-group">
<label>Patient Impression </label><br>
<div class="col-lg-10 white-bg">
<ul class="list-group clear-list m-t">
@foreach($impression as $impress)
<li class="list-group-item fist-item">
{{$impress->notes}}        <a href="{{route('imp_delete', ['impid'=>$impress->id, 'appid'=>$user->appid])}}" class="marg">Remove</a>

</li>
@endforeach
</ul>
<textarea class="form-control" rows="5"  name="impression"></textarea>
</div>
</div>



<div class="form-group">
<label>Current Medication </label><br>
<div class="col-lg-10 white-bg">
<ul class="list-group clear-list m-t">
@foreach($cmed as $cmeds)
<li class="list-group-item fist-item">
{{$cmeds->drugs}}  <a href="{{route('cm_delete', ['cmid'=>$cmeds->id, 'appid'=>$user->appid])}}" class="marg">Remove</a>
</li>
@endforeach
</ul>
<textarea class="form-control" rows="3"  name="current_med"></textarea>
</div>
</div>

<div class="form-group">
<label class="">DIAGNOSIS : </label><br>
<div class="col-lg-10 white-bg">
<ul class="list-group clear-list m-t">
@foreach($diagnosis as $tst1)
<li class="list-group-item fist-item">
{{$tst1->disease_id}}  <a href="{{route('diag_delete', ['diagid'=>$tst1->id, 'appid'=>$user->appid])}}" class="marg">Remove</a>
</li>
@endforeach
</ul>
<textarea class="form-control" rows="5"  name="diagnosis"></textarea>
</div>
</div>



<div class="col-md-10">
  <button class="btn btn-primary btn-rounded btn-block" type="submit"><i class="fa fa-info-circle"></i> <strong>UPDATE CHANGES</strong></button>
</div>
          {{ Form::close() }}

          </div>
          </div>
          </div>

          </div>
        </div>
      </div>





    </div><!--tfloat-e-margins-->
    </div><!--row wrapper-->


    @endsection
    @section('script-test')


    @endsection
