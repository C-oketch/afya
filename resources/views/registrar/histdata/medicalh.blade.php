@extends('layouts.registrar_layout')
@section('title', 'Details')
@section('content')
<?php
$doc = (new \App\Http\Controllers\DoctorController);
$Docdatas = $doc->DocDetails();
foreach($Docdatas as $Docdata){
  $Did = $Docdata->id;
  $Name = $Docdata->name;
  $Address = $Docdata->address;
  $RegNo = $Docdata->regno;
  $RegDate = $Docdata->regdate;
  $Speciality = $Docdata->speciality;
  $Sub_Speciality = $Docdata->subspeciality;
  $set_up = $Docdata->set_up;
}
$afyauserId =$patient->id;
$appid=$patient->app_id;
?>
@include('includes.registrar.topnavbar_v3')


<div class="col-lg-10">
  <h2>Self Reported Details</h2>
</div>
<div class="col-lg-2">
  <br>
  <a href="{{ url('registrar.histdata',$patient->id) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
</div>


<div class="row m-t-lg">
  <div class="col-lg-12">
    <div class="tabs-container">

      <div class="tabs-left">
        <ul class="nav nav-tabs">
          <li><a href="{{ url('registrar.histdetails',$patient->app_id) }}">Smoking & Alcohol</a></li>
          <li class="active"><a href="{{ url('registrar.mhistdata',$patient->app_id) }}" >Medical History</a></li>
          <li><a href="{{ url('registrar.surghistdata',$patient->app_id) }}" >Surgical Procedures</a></li>
          <li><a href="{{ url('registrar.chronichistdata',$patient->app_id) }}" >Chronic Disease</a></li>
          <li><a href="{{ url('registrar.medhistdata',$patient->app_id) }}">Medications</a></li>
          <li><a href="{{ url('registrar.allergyhistdata',$patient->app_id) }}">Allergies</a></li>
        <li><a href="{{ url('registrar.vacchistdata',$patient->app_id) }}" >Vaccinations</a></li>
          <li><a href="{{ url('registrar.abnorhistdata',$patient->app_id) }}">Functions</a></li>

        </ul>
        <div class="tab-content ">
          <div id="tab-6" class="tab-pane active">
            <div class="panel-body">
              <h3>Self Reported Medical History</h3>
              <div id="form_div">
                {!! Form::open(array('url' => 'registrar.medical','method'=>'POST','id'=>'add_name')) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="appId"  value="{{$appid}}" >
                <div class="table-responsive">
                  <table class="table borderless" id="employee_table" align=center>
                    <tr id="row1">
                      <td><input type="text" name="members[0][name]" placeholder="Condition Name" class="form-control"></td>
                      <td><input type="text" name="members[0][status]" placeholder="Description" class="form-control"></td>
                      <td><input type="hidden" name="members[0][afya_user_id]"  value="{{$patient->id}}" class="form-control"></td>
                      <td><input type="hidden" name="members[0][appointment_id]"  value="{{$appid}}" class="form-control"></td>
                    </tr>
                  </table>
                  <input type="button" onclick="add_row();" value="ADD ROW" class='btn btn-primary'>
                  <input type="submit" class='btn btn-primary' name="submit_row" value="SUBMIT">
                </form>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>

  </div>
</div>
</div>









@endsection
@section('script-reg')

<script type="text/javascript">
function add_row()
{
  data:$('#add_name').serializeArray(),
  $rowno=$("#employee_table tr").length;
  $rowno=$rowno+1;
  $("#employee_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' name='members["+$rowno+"][name]' class='form-control' placeholder='Condition Name'></td><td><input type='text' name='members["+$rowno+"][status]' placeholder='Description' class='form-control'></td><td><input type='hidden' name='members["+$rowno+"][afya_user_id]' value='{{$patient->id}}'><input type='hidden' name='members["+$rowno+"][appointment_id]' value='{{$appid}}'><input type='button' class='btn btn-danger' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
}
function delete_row(rowno)
{
  $('#'+rowno).remove();
}


</script>
@endsection