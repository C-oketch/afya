@extends('layouts.doctor_layout')
@section('title', 'Dashboard')
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
                                          <th>Appointments</th>

                                      </tr>
                                          </thead>
                                          <tbody>
                                            <?php   $i=1;   ?>
                                            @foreach($patientsToday as $todayp)
                                            <tr>
                                            <td><a href="{{url('doctor.patient_history',$todayp->appId)}}">{{$i}}</a></td>
                                            <td><a href="{{url('doctor.patient_history',$todayp->appId)}}">{{$todayp->firstname}} {{$todayp->secondName}}</a></td>
                                           <td>{{$todayp->file_no}}</td>
                                           <td>
                                                  <?php
                                                  $dob=$todayp->dob;
                                                  $interval = date_diff(date_create(), date_create($dob));
                                                  $age= $interval->format(" %Y Years Old");
                                                  ?>
                                                  {{$age}}
                                                  </td>
                                                <td>{{$todayp->gender}}</td>
                                                <td>{{$todayp->msisdn}}</td>
                                                <td><a href="{{route('calendar.show',$todayp->id)}}">create</a></td>
                                                <!-- <td><a href="{{route('calendar.show',$todayp->id)}}">create</a></td> -->

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
                                          <th>Appointments</th>
                                      </tr>
                                          </thead>
                                          <tbody>
                                            <?php   $i=1;   ?>
                                            @foreach($patientswk as $wkp)
                                            <tr>
                                            <td><a href="{{url('doctor.patient_history',$wkp->appId)}}">{{$i}}</a></td>
                                            <td><a href="{{url('doctor.patient_history',$wkp->appId)}}">{{$wkp->firstname}} {{$wkp->secondName}}</a></td>
                                            <td>{{$wkp->file_no}}</td>
                                        <td>
                                                  <?php
                                                  $dob=$wkp->dob;
                                                  $interval = date_diff(date_create(), date_create($dob));
                                                  $age= $interval->format(" %Y Years Old");
                                                  ?>
                                                  {{$age}}
                                                  </td>
                                                <td>{{$wkp->gender}}</td>
                                                <td>{{$wkp->msisdn}}</td>
                                                <td><a href="{{route('calendar.show',$wkp->id)}}">create</a></td>
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
                                          <th>Appointments</th>
                                      </tr>
                                          </thead>
                                          <tbody>
                                            <?php   $i=1;   ?>
                                            @foreach($patientmonth as $pmons)
                                            <tr>
                                            <td><a href="{{url('doctor.patient_history',$pmons->appId)}}">{{$i}}</a></td>
                                              <td><a href="{{url('doctor.patient_history',$pmons->appId)}}">{{$pmons->firstname}} {{$pmons->secondName}}</a></td>
                                              <td>{{$pmons->file_no}}</td>
                                     <td>
                                                  <?php
                                                  $dob=$pmons->dob;
                                                  $interval = date_diff(date_create(), date_create($dob));
                                                  $age= $interval->format(" %Y Years Old");
                                                  ?>
                                                  {{$age}}
                                                  </td>
                                                <td>{{$pmons->gender}}</td>
                                                <td>{{$pmons->msisdn}}</td>
                                                <td><a href="{{route('calendar.show',$pmons->id)}}">create</a></td>
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
                                          <th>Appointments</th>
                                      </tr>
                                          </thead>
                                          <tbody>
                                            <?php   $i=1;   ?>
                                            @foreach($users as $user)
                                            <?php  $appId = DB::table('appointments')->select('id')->where('afya_user_id', $user->id)->first();  ?>
                                            <tr>
                                            @if($appId)
                                            <td><a href="{{url('doctor.patient_history',$appId->id)}}">{{$i}}</a></td>
                                            <td><a href="{{url('doctor.patient_history',$appId->id)}}">{{$user->firstname}} {{$user->secondName}}</a></td>
                                             @else
                                             <td><a href="#">{{$i}}</a></td>
                                             <td><a href="#">{{$user->firstname}} {{$user->secondName}}</a></td>

                                             @endif
                                              <td>{{$user->file_no}}</td>
                                         <td>
                                                  <?php
                                                  $dob=$user->dob;
                                                  $interval = date_diff(date_create(), date_create($dob));
                                                  $age= $interval->format(" %Y Years Old");
                                                  ?>
                                                  {{$age}}
                                                  </td>
                                                <td>{{$user->gender}}</td>
                                                  <td>{{$user->msisdn}}</td>
                                                  <td><a href="{{route('calendar.show',$user->id)}}">create</a></td>
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
