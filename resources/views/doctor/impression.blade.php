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

$imp= DB::table('impression')->where('appointment_id',$app_id)->get();
?>


@section('leftmenu')
@include('includes.doc_inc.leftmenu2')
@endsection
@include('includes.doc_inc.topnavbar_v2')



<div class="row wrapper border-bottom page-heading">
  <div class="ibox float-e-margins">


<div class="wrapper wrapper-content">
<div class="col-lg-6">
<div class="ibox float-e-margins">
<div class="ibox-title">
<h5>Impression</h5>

</div>
<div class="ibox-content">
<div class="row">
<div class="col-sm-12"><h3 class="m-t-none m-b"></h3>
<form class="form-horizontal" role="form" method="POST" action="/impPost">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
{{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}



<!-- <div class="form-group">
<label class="col-lg-2 control-label">Impression </label><br>
<div class="col-lg-10">
<textarea class="form-control" rows="5"  name="doc_note">@foreach($imp as $imps)  {!! nl2br(e($imps->notes)) !!}  @endforeach</textarea>
</div>
</div> -->

<table class="table borderless" id="procedure_table" align=center>
  <tr id="row1">
<td><textarea class="form-control"  name="members[0][notes]"></textarea></td>
<td><input type="hidden" name="members[0][appointment_id]" value="{{$app_id}}"></td>
  </tr>
</table>
<input type="button" onclick="add_row_proc();" value="ADD ROW" class='btn btn-primary'>
<input type="submit" class='btn btn-primary' name="submit_row" value="SUBMIT">
{{ Form::close() }}


</div>
</div>
</div>
</div>
</div>


<div class="col-lg-6">
  <div class="ibox float-e-margins">
    <div class="ibox-title">
      <h5>Impression</h5>
    </div>
    <div class="ibox-content">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Impression</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php   $i=1;   ?>
          @foreach($imp as $imps)
          <tr>
            <td>{{$i}}</td>
            <td><span>{{ $imps->notes }}</span></td>
            <td><a href="{{route('impression_edit',$imps->id)}}">edit</a></td>
            <td><a href="{{route('impression_remove',$imps->id)}}">remove</a></td>
          </tr>
          <?php   $i++;   ?>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>





</div>





</div><!--tfloat-e-margins-->
</div><!--row wrapper-->
@endsection
@section('script-test')

<script type="text/javascript">
function add_row_proc()
{
  data:$('#add_proc').serializeArray(),
  $rowno=$("#procedure_table tr").length;
  $rowno=$rowno+1;
  $("#procedure_table tr:last").after("<tr id='row"+$rowno+"'><td><textarea  name='members["+$rowno+"][notes]' class='form-control' placeholder='impression Details'></textarea></td><td><input type='hidden' name='members["+$rowno+"][appointment_id]' value='{{$app_id}}'><input type='button' class='btn btn-danger' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
}

function delete_row(rowno)
{
  $('#'+rowno).remove();
}
</script>
@endsection
