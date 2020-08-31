@extends('layouts.doctor_layout')
@section('title', 'Prescriptions')

@section('content')



<?php



  $stat= $pdetails->status;
  $afyauserId= $pdetails->afya_user_id;
  $dependantId= $pdetails->persontreated;
  $app_id= $pdetails->id;
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


<?php
 $routem= (new \App\Http\Controllers\TestController);
$routems = $routem->RouteM();

$Strength= (new \App\Http\Controllers\TestController);
$Strengths = $Strength->Strength();

$frequency= (new \App\Http\Controllers\TestController);
$frequent = $frequency->Frequency();

use App\Http\Controllers\Controller;

$diz =DB::table('patient_diagnosis')
->select('disease_id as name','id')
->where('patient_diagnosis.appointment_id',$app_id)
->get();

?>


<div class="wrapper wrapper-content animated">


  <div class="row">
    <div class="col-lg-12">
      <div class="tabs-container">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#tab-51">Add Prescription</a></li>
          <li class=""><a data-toggle="tab" href="#tab-52">Prescription History</a></li>
            <li class=""><a  href="{{route('printpresc',$app_id)}}" >Print Prescription</a></li>
            <li class=""><a  href="{{route('reccomendation',$app_id)}}" >Recommendation</a></li>

        </ul>
        <div class="tab-content">

          <div id="tab-51" class="tab-pane active">
            <div class="panel-body">

              <div class="col-md-10">

                <div class="ibox-tools">
                  <div id="form_div">
                    <br><br><br>
                    {{ Form::open(array('url' => array('insert-presc-detail'),'method'=>'POST', 'class'=>'form-horizontal')) }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="appId"  value="{{$app_id}}" >
                <input type="hidden" class="form-control" value="{{$fac_id}}" name="facility" >
                <input type="hidden" class="form-control" value="Normal" name="state" >
                <input type="hidden" class="form-control" value="{{$afyauserId}}" name="afya_user_id" >

<!-- <select id="diseases" name="disease_id" class="form-control d_list2" style="width: 100%"> -->


<div class="form-group"><label class="col-sm-2 control-label">Condition</label>

<div class="col-sm-6">
  <select class="select2_demo_1" name="disease_id"  style="width: 100%" >
    <option value=''>Please add diagnosis</option>
  @foreach ($Pdiagnosis as $Pdiag)
    <option value='{{$Pdiag->diagId}}'>{{$Pdiag->name}}</option>
@endforeach
  </select>

</div>
</div>






                    <div class="table-responsive">
                        <table class="table borderless" id="employee_table">

                <tr id="row1">
                <td><input type="text" name="drug[0]" placeholder="Drug Details" class="form-control" required/></td>
                </tr>
                </table>
                <input type="button" onclick="add_row();" value="ADD MORE"  class='btn btn-primary'>
                <input type="submit" class='btn btn-primary' name="submit_row" value="SUBMIT">
                </form>
                </div>


                </div>



                </div>
              </div>

            </div>
          </div>

          <div id="tab-52" class="tab-pane">
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-tests" >
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Condition</th>
                      <th>Drug Details</th>
                      <th>Date Prescribed</th>
                        <th>Action</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $i=1;?>
                    @foreach ($allpresczs as $ctt)

                    <tr class="item{{$ctt->presc_details_id}}">
                      <td>{{$i}}</td>
                      <td>{{$ctt->name}}</td>
                      <td>{{$ctt->drug_id}}</td>
                      <td>{{$ctt->created_at}}</td>

                      <td>
                        @if($app_id == $ctt->appsId)
                        <a class="btn btn-danger btn-xs" href="{{route('prescs.deletes',$ctt->presc_details_id)}}"><i class="fa fa-remove"></i>Delete</a>
                      @endif</td>

                    </tr>
                    <?php $i++;  ?>
                    @endforeach
                  </tbody>

                </tbody>
                <tfoot>
                  <tr>

                  </tr>
                </tfoot>
              </table>
            </div>




          </div>
        </div>
      </div>


    </div>
  </div>
</div>
</div>






@endsection
<!-- Section Body Ends-->
@section('script-test')
<!-- Put your scripts here -->
<script>
$(".select2_demo_1").select2();
</script>
<script type="text/javascript">
function add_row()
{
data:$('#add_name').serializeArray(),
 $rowno=$("#employee_table tr").length;
 $rowno=$rowno+1;
 $("#employee_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' name='drug["+$rowno+"]' class='form-control 'placeholder='Drug Details'></td><td><input type='button' class='btn btn-danger' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
}
function delete_row(rowno)
{
 $('#'+rowno).remove();
}
</script>
@endsection
