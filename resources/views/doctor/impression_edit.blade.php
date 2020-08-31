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
<h5>Impression</h5>

</div>
<div class="ibox-content">
<div class="row">
<div class="col-sm-12"><h3 class="m-t-none m-b"></h3>
<form class="form-horizontal" role="form" method="POST" action="/impedit">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
{{ Form::hidden('impression_id',$imp->id, array('class' => 'form-control')) }}
{{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}



<div class="form-group">
<label class="col-lg-2 control-label">Impression </label><br>
<div class="col-lg-10">
<textarea class="form-control" rows="5"  name="doc_note"> {{ $imp->notes }}  </textarea>
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
