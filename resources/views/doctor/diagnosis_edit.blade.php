@extends('layouts.doctor_layout')
@section('title', 'Triage')
@section('content')


<?php

   $stat= $pdetails->status;
   $afyauserId= $pdetails->afya_user_id;
    $dependantId= $pdetails->persontreated;
    $app_id_prev= $pdetails->last_app_id;
    $app_id =  $pdetails->id;
    $doc_id= $pdetails->doc_id;
    $fac_id= $pdetails->facility_id;
    $fac_setup= $pdetails->set_up;
    $dependantAge = $pdetails->depdob;
    $AfyaUserAge = $pdetails->dob;
    $condition = $pdetails->condition;

?>


@section('leftmenu')
@include('includes.doc_inc.leftmenu2')
@endsection
@include('includes.doc_inc.topnavbar_v2')



<div class="row wrapper border-bottom page-heading">
  <div class="ibox float-e-margins">


<div class="wrapper wrapper-content">
<div class="col-lg-8">
<div class="ibox float-e-margins">
<div class="ibox-title">
<h5>Edit Diagnosis</h5>

</div>
<div class="ibox-content">
<div class="row">
<div class="col-sm-12"><h3 class="m-t-none m-b"></h3>
<form class="form-horizontal" role="form" method="POST" action="/diagedit">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
{{ Form::hidden('diagnosis_id',$diag->id, array('class' => 'form-control')) }}
{{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}



<div class="form-group">
<label class="col-lg-2 control-label">Diagnosis </label><br>
<div class="col-lg-10">
<textarea class="form-control" rows="5"  name="diagnosis"> {{ $diag->disease_id }}  </textarea>
</div>
</div>

<input type="submit" class='btn btn-primary'  value="SUBMIT">
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
