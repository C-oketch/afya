@extends('layouts.doctor_layout')
@section('title', 'Doctor Dashboard')
@section('content')


@section('leftmenu')
@include('includes.doc_inc.leftmenu')
@endsection
@include('includes.doc_inc.topnavbar_v1')

<div class="wrapper wrapper-content animated fadeIn">


          <div class="row">
              <div class="col-lg-12">
                  <div class="tabs-container">
                      <ul class="nav nav-tabs">
                          <li class="active"><a data-toggle="tab" href="#tab-1">Today Appointments</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-2">Tomorrow Appointments</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-3"> This Week Appointments</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-4">This Month Appointments</a></li>
                      </ul>
                      <div class="tab-content">
                          <div id="tab-1" class="tab-pane active">
                              <div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
<th>No</th>
<th>Name</th>
<th>File No</th>
<th>Gender</th>
<th>Phone</th>
<th>Appointment Date</th>
<th>Appointment Time</th>
<th>Notes</th>
</tr>
</thead>

<tbody>
<?php $i =1; ?>
@foreach($patients as $patient)
<tr>


<td>{{$i}}</td>
<td>{{$patient->first}} {{$patient->second}}</td>
<td>{{$patient->file_no}}</td>
<td>{{$patient->gender}}</td>
<?php
    $in = $patient->msisdn;  $result =  str_replace("254","0",$in);   ?>
<td>{{$result}}</td>

  <?php

$timestamp = $patient->appointment_date;
$datetime = explode(" ",$timestamp);
$date = $datetime[0];
$time = $datetime[1];
?>

<td>{{$date}}</td>
<td>{{$patient->appointment_time}}</td>
<td>{{$patient->notes}}</td>
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
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>File No</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Notes</th>
                                </thead>

                                <tbody>
                                <?php $i =1; ?>
                                @foreach($patients2 as $patient)
                                <tr>
                                <td>{{$i}}</td>
                                <td>{{$patient->first}} {{$patient->second}}</td>
                                <td>{{$patient->file_no}}</td>
                                 <td>{{$patient->gender}}</td>
                                <?php
                                    $in = $patient->msisdn;  $result =  str_replace("254","0",$in);   ?>
                                <td>{{$result}}</td>

                                  <?php
                                $timestamp = $patient->appointment_date;
                                $datetime = explode(" ",$timestamp);
                                $date = $datetime[0];
                                $time = $datetime[1];
                                ?>

                                <td>{{$date}}</td>
                                <td>{{$patient->appointment_time}}</td>
                                <td>{{$patient->notes}}</td>
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
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>File No</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Notes</th>
                              </tr>
                                </thead>

                                <tbody>
                                <?php $i =1; ?>
                                @foreach($patients3 as $patient)
                                <tr>


                                <td>{{$i}}</td>
                                <td>{{$patient->first}} {{$patient->second}}</td>
                                <td>{{$patient->file_no}}</td>
                               <td>{{$patient->gender}}</td>
                                <?php
                                    $in = $patient->msisdn;  $result =  str_replace("254","0",$in);   ?>
                                <td>{{$result}}</td>

                                  <?php
                                $timestamp = $patient->appointment_date;
                                $datetime = explode(" ",$timestamp);
                                $date = $datetime[0];
                                $time = $datetime[1];
                                ?>

                                <td>{{$date}}</td>
                                <td>{{$patient->appointment_time}}</td>
                                <td>{{$patient->notes}}</td>
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
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>File No</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Notes</th>
                              </tr>
                                </thead>

                                <tbody>
                                <?php $i =1; ?>
                                @foreach($patients4 as $patient)
                                <tr>
                                <td>{{$i}}</td>
                                <td>{{$patient->first}} {{$patient->second}}</td>
                                <td>{{$patient->file_no}}</td>
                                 <td>{{$patient->gender}}</td>
                                <?php
                                    $in = $patient->msisdn;  $result =  str_replace("254","0",$in);   ?>
                                <td>{{$result}}</td>
                                  <?php

                                $timestamp = $patient->appointment_date;
                                $datetime = explode(" ",$timestamp);
                                $date = $datetime[0];
                                $time = $datetime[1];
                                ?>

                                <td>{{$date}}</td>
                                <td>{{$patient->appointment_time}}</td>
                                <td>{{$patient->notes}}</td>
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

@endsection
