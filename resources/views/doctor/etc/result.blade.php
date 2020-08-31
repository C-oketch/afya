@extends('layouts.doctor_layout')
@section('title', 'Test')
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


}


      foreach ($patientD as $pdetails) {

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

if($app_id_prev !==0){ $app_id2 = $app_id_prev;}else{$app_id2 = $app_id;}
 $now = time(); // or your date as well
 $your_date = strtotime($dependantAge);
 $datediff = $now - $your_date;
 $dependantdays= floor($datediff / (60 * 60 * 24));


 if ($dependantId =='Self') {
          $dob=$AfyaUserAge;
          $gender=$pdetails->gender;
          $firstName = $pdetails->firstname;
          $secondName = $pdetails->secondName;
          $name =$firstName." ".$secondName;
          $lmp = $pdetails->almp;
          $pregnant = $pdetails->apregnant;
   }

 else {    $dob=$dependantAge;
           $gender=$pdetails->depgender;
           $firstName = $pdetails->dep1name;
           $secondName = $pdetails->dep2name;
           $name =$firstName." ".$secondName;
           $lmp = $pdetails->dlmp;
           $pregnant = $pdetails->dpregnant;
      }


  $interval = date_diff(date_create(), date_create($dob));
  $age= $interval->format(" %Y Year, %M Months, %d Days Old");


 $appStatue=$stat;
if ($appStatue == 2) {
  $appStatue ='ACTIVE';
} elseif ($stat == 3) {
  $appStatue='Discharged Outpatient';
} elseif ($stat == 4) {
  $appStatue='Admitted';
} elseif ($stat == 5) {
  $appStatue='Refered';
}
elseif ($stat == 6) {
  $appStatue='Discharged Intpatient';
}
elseif ($stat == 7) {
  $appStatue='Waiting Test Result';
}
}
?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-6">
            <h2>{{$name}}</h2>
            <ol class="breadcrumb">
            <li><a>{{$gender}}</a></li>
            <li><a>{{$age}}</a> </li>
            @if($gender =="Female")
            <li><a>LMP /{{$lmp}}</a> </li>
            <li><a>Pregnant /{{$pregnant}}</a></li>
            @endif
            <li>
            <strong> <button type="btn" class="btn btn-primary">{{$appStatue}}</button></strong>
            </li>
            </ol>
            </div>
        <div class="col-lg-6">
          <h2>{{$pdetails->FacilityName}} </h2>
          <ol class="breadcrumb">
          <li class="active"><strong>{{$Name}} </strong></li>
          </ol>
        </div>
        </div>

        <!--tabs Menus-->
        <div class="row border-bottom">
        <nav class="navbar" role="navigation">
          <div class="navbar-collapse " id="navbar">
                <ul class="nav navbar-nav">
                  <li><a role="button" href="{{route('showPatient',$app_id)}}">Today's Triage</a></li>
                  <li><a role="button" href="{{route('patienthistory',$app_id)}}">History</a></li>
                  <li class="active"><a role="button" href="{{route('alltestes',$app_id)}}">Tests</a></li>
                  <li><a role="button" href="{{route('diagnoses',$app_id)}}">Diagnosis</a></li>
                  <li><a role="button" href="{{route('medicines',$app_id)}}">Prescriptions</a></li>
                  <li><a role="button" href="{{route('procedure',$app_id)}}">Procedures</a></li>

                  @if ($condition =='Admitted')
                    <li><a role="button" href="{{route('discharge',$app_id)}}">Discharge</a></li>
                   @else
                    <li><a role="button" href="{{route('admit',$app_id)}}">Admit</a></li>@endif
                    <li><a role="button" href="{{route('transfering',$app_id)}}">Referral</a></li>
                   <li><a role="button" href="{{route('endvisit',$app_id)}}">End Visit</a></li>
                 </ul>
             </div>
        </nav>
     </div>

          <div class="row wrapper border-bottom">
             <div class="float-e-margins">
               <div class="col-lg-12">
                     <div class="tabs-container">
<div class="row">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
     <div class="col-md-6 col-md-offset-3">
       <div class="col-lg-3">
       <a class="btn btn-primary btn-lg btn-block" data-toggle="tab" href="#tab-1"><i class="fa fa-flask"></i> ADD TEST</a>
       </div>
        <div class="col-lg-6">
         <a class="btn btn-info btn-lg btn-block" data-toggle="tab" href="#tab-2"><i class="fa fa-database"></i>X-RAY TEST RESULTS</a>
          </div>
        </div>
  </ul>
            <div class="tab-content">

                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">

<div class="row" id="">





<div class="ibox float-e-margins">
<div class="col-lg-11">
<div class="ibox-title">
<h5>X-RAY TESTS</h5>

</div>
<div class="ibox-content">

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-tests" >
<thead>
<tr>
  <th>#</th>
  <th>Name</th>
  <th>Actions</th>

</tr>
</thead>
<tbody>
<?php
$i=1;?>
<?php  $cttests = DB::table('xray')->get();  ?>
@foreach ($cttests as $ctt)

  <tr class="item{{$ctt->id}}">
    <td>{{$ctt->id}}</td>
    <td>{{$ctt->name}}</td>


<?php
$datadetails = DB::table('radiology_test_details')
->Where([['test',$ctt->id],
         ['appointment_id',$app_id],
        ['done',0],
        ['test_cat_id',10],])
->first();
?>
@if($datadetails)
<td><button class="btn btn-info" >
<span class="glyphicon glyphicon-plus"></span>ADDED
</button>
</td>
@else
<td>
<button class="add-modal btn btn-primary" data-id="{{$ctt->id}}"
    data-name="{{$ctt->name}}" data-appid="{{$app_id}}" data-catid="{{$ctt->test_cat_id}}">
    <span class="glyphicon glyphicon-plus"></span>ADD
  </button>
</td>
@endif
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

<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"></h4>
</div>
<div class="modal-body">
  <form class="form-horizontal" role="form">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
<label>Test Name:</label>
<input type="text" class="form-control" id="name" readonly>
<input type="hidden" class="form-control" id="fid" name="test" >
<input type="hidden" class="form-control" id="appId" name="appointment" >
<input type="hidden" class="form-control" id="catId" name="cat_id" >
</div>
<div class="form-group">
<label for="tag_list" class="">Target:</label>
<select class="form-control" name="target" style="width: 100%">
<option value=''>N/A</option>
<option value='Left'>Left</option>
<option value='Right'>Right</option>
<option value='Both'>Both </option>
</select>
</div>
<div class="form-group ">
<label for="d_list2">Clinical Information:</label>
<textarea rows="4" name="clinical" cols="50" class="form-control"></textarea>
</div>


</div>

<div class="modal-footer">
  <button type="button" class="btn actionBtn" data-dismiss="modal">
    <span id="footer_action_button" class='glyphicon'> </span>
  </button>
  <!-- <button type="submit" class="btn btn-primary btn-sm">SUBMIT</button> -->


  <button type="button" class="btn btn-warning" data-dismiss="modal">
<span class='glyphicon glyphicon-remove'></span> Close
</button>
{!! Form::close() !!}
</div>
</div>
</div>



</div>



            </div>


        </div><!-- Tab 1" -->
        <div id="tab-2" class="tab-pane">
                          <div class="panel-body">
                            <!--Test result tabs PatientController@testdone-->
                        <?php

      if ($dependantId =='Self') {

        $radiology = DB::table('patient_test')
        ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
        ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
        ->Join('xray', 'radiology_test_details.test', '=', 'xray.id')
       ->select('radiology_test_details.*','xray.name as tname')
       ->where([['appointments.afya_user_id', '=',$afyauserId],['radiology_test_details.test_cat_id', '=',10],
     ])
        ->orderBy('radiology_test_details.created_at', 'desc')
        ->get();
      }else{

        $radiology = DB::table('patient_test')
        ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
        ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
        ->Join('xray', 'radiology_test_details.test', '=', 'xray.id')
       ->select('radiology_test_details.*','xray.name as tname')
       ->where([['appointments.persontreated', '=',$dependantId],['radiology_test_details.test_cat_id', '=',10],
     ])
        ->orderBy('radiology_test_details.created_at', 'desc')
        ->get();

      }
      ?>
      <div class="table-responsive ibox-content">
        <h5>RADIOLOGY TESTS</h5>
      <table class="table table-striped table-bordered table-hover dataTables-tests" >
                               <thead>
                            <tr>
                             <th></th>

                               <th>Date </th>
                              <th>Clinical Information</th>
                              <th>Test</th>
                              <th>Conclusion</th>
                            <th>Action</th>

                          </tr>
                          </thead>

                            <tbody>
                              <?php $i =1; ?>
                          @foreach($radiology as $tstdn)

                              <tr>
                              <td>{{ +$i }}</td>
                             <td>{{$tstdn->created_at}}</td>
                             <td>{{$tstdn->clinicalinfo}} </td>
                             <td>{{$tstdn->tname}}</td>
                             <td>{{$tstdn->conclusion}}</td>

                       @if($tstdn->confirm =='N')
                               @if($tstdn->done =='0')
                               <td>
                                 {{ Form::open(['method' => 'DELETE','route' => ['xray.deletes', $tstdn->id],'style'=>'display:inline']) }}
                                  {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                                  {{ Form::close() }}
                              </td>

                               @else
                               <td>

                                  {{ Form::open(array('route' => array('ctreport'),'method'=>'POST')) }}
                                    {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
                                    {{ Form::hidden('rtd_id',$tstdn->id, array('class' => 'form-control')) }}
                                    <button class="btn btn-sm btn-primary  m-t-n-xs" type="submit"><strong>Confirm Diagnosis</strong></button>
                                   {{ Form::close() }}
                               </td>
                                @endif
                          @else
                          <td> Confirmed</td>
                          @endif
                        </tr>
                            <?php $i++; ?>
                        @endforeach
                            </tbody>
                          </table>
                </div>
         </div>
      </div>
    </div><!-- Tab content" -->

  </div><!-- Tab container" -->
</div>

      </div><!-- col md 12" -->
   </div><!-- emargis" -->
   </div>
@endsection
@section('script-test')
 <!-- Page-Level Scripts -->
<script src="{{ asset('js/imaging.js') }}"></script>
@endsection
