@extends('layouts.doctor_layout')
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
$condition = $patient->condition;
$afyauserId =$patient->id;
$app_id=$patient->appid;
?>
@section('leftmenu')
@include('includes.doc_inc.leftmenu2')
@endsection
@include('includes.doc_inc.topnavbar_v2')

<div>
  <div class="col-lg-10">
    <h2>Self Reported Details</h2>
  </div>
  <div class="col-lg-2">
    <br>
    <a href="{{ url('doctor.show',$app_id) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
  </div>
</div>




<div class="row m-t-lg">
  <div class="col-lg-12">
    <div class="tabs-container">

      <div class="tabs-left">
        <ul class="nav nav-tabs">
          <li><a href="{{ route('doctor.histdetails',$app_id) }}">Smoking & Alcohol</a></li>
          <li><a href="{{ url('doctor.medicalhistdata',$app_id) }}" >Medical History</a></li>
          <li><a href="{{ route('doctor.surghistdata',$app_id) }}" >Surgical Procedures</a></li>
          <li><a href="{{ route('doctor.chronichistdata',$app_id) }}" >Chronic Disease</a></li>
          <li><a href="{{ route('doctor.medhistdata',$app_id) }}">Medications</a></li>
          <li class="active"><a href="{{ route('doctor.allergyhistdata',$app_id) }}">Allergies</a></li>
           <li><a href="{{ route('doctor.vacchistdata',$app_id) }}" >Vaccinations</a></li>
          <li><a href="{{ route('doctor.abnorhistdata',$app_id) }}">Functions</a></li>

        </ul>
        <div class="tab-content ">
          <div id="tab-6" class="tab-pane active">
            <div class="panel-body">
              <h3>Allergies</h3>
              {!! Form::open(array('url' => 'doctor.allergy','method'=>'POST' ,'id'=>'add_proc')) !!}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" value="{{$patient->appid}}" name="appointment_id">
              <div class="table-responsive">
                <table class="table borderless" id="procedure_table" align=center>
                  <tr id="row1">
                    <td><input type="text" name="members[0][allergies]" placeholder="Allergy" class="form-control"></td>
                    <td><input type="text" name="members[0][status]"  placeholder="Description" class="form-control"></td>
                    <td><input type="hidden" name="members[0][afya_user_id]"  value="{{$patient->id}}" class="form-control"></td>

                  </tr>
                </table>
                <input type="button" onclick="add_row_proc();" value="ADD ROW" class='btn btn-primary'>
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







@endsection
@section('script-test')

<script type="text/javascript">
function add_row_proc()
{
  data:$('#add_proc').serializeArray(),
  $rowno=$("#procedure_table tr").length;
  $rowno=$rowno+1;
  $("#procedure_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' name='members["+$rowno+"][allergies]' class='form-control' placeholder='Allergies'></td><td><input type='text' name='members["+$rowno+"][status]' class='form-control' placeholder='Description'></td><td><input type='hidden' name='members["+$rowno+"][afya_user_id]' value='{{$patient->id}}'><input type='button' class='btn btn-danger' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
}
function delete_row(rowno)
{
  $('#'+rowno).remove();
}
</script>
@endsection
