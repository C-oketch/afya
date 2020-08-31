@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-8">
                  <h2>Fees Summary</h2>

              </div>
              <div class="col-lg-4">
                  <!-- <div class="title-action">
                      <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                      <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a>
                      <a href="invoice_print.html" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>
                  </div> -->
              </div>
    </div>
    <div class="wrapper wrapper-content">

        <div class="row">
                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right update23" id="update23">Update</span>
                                <h5>Consultation Fee</h5>
                            </div>

                              <div class="ibox-content">
                               <div class="stat-percent font-bold text-success"><h1>{{$newp}} KES</h1></div>
                                <small><h1>@ {{$fac_fee->new}} KES</h1></small>
                                <div class="stat-percent font-bold text-success">Total Collected</div>
                                 <small>New Patients Fee</small>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right update23" id="update23">Update</span>
                                <h5>Consultation Fee</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"></h1>
                                <div class="stat-percent font-bold text-info"><h1>{{$exip}} KES</h1></div>
                                <h1>@ {{$fac_fee->old}} KES</h1>

                                <div class="stat-percent font-bold text-info">Total Collected</div>
                                <small>Existing Patients Fee </small>
                            </div>
                        </div>
                    </div>

                @if($mrip)
                  <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right update23" id="update23">Update</span>
                                <h5>Medical Report Fee</h5>
                            </div>
                            <div class="ibox-content">
                                <!-- <h1 class="no-margins">{{$fac_fee->medical_report_fee}} KES</h1> -->
                                <div class="stat-percent font-bold text-info"><h1>{{$mrip}}</h1></div>
                                <h1>@ {{$fac_fee->medical_report_fee}} KES</h1>

                                <div class="stat-percent font-bold text-info">Total Collected</div>
                                <small> Fee</small>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($lab || $rad)      <div class="col-lg-6">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                  <!-- <span class="label label-info pull-right update23" id="update23">Update</span> -->
                                  <h5>Test Fee</h5>
                              </div>
                              <div class="ibox-content">
                                  <!-- <h1 class="no-margins">KES</h1> -->
                                  <div class="stat-percent font-bold text-info"><h1>{{$lab + $rad}}</h1></div>
                                  <h1>Total Collected</h1>
                              </div>
                          </div>
                      </div>
                      @endif
                  </div>




  <div class="row">
  @if($fac_fee)
    <div class="col-lg-8 col-md-offset-2 ficha" id="updatediv"> @else <div class="col-lg-8" id="updatediv"> @endif
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <h5>Consultation Fee</h5>

          </div>
          <div class="ibox-content">
            <form class="form-horizontal" role="form" method="POST" action="/setfees" >
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if($fac_fee)<p>Update the required Facility Consultation Fee.</p> @else  <p>Set the required Facility Consultation Fee.</p>@endif

                  <div class="form-group"><label class="col-lg-2 control-label">New User's Fee</label>
                   <div class="col-lg-10">
                  <input type="text" value="@if($fac_fee){{$fac_fee->new}}@endif" class="form-control" name="new" required >
                  </div>
                  </div>

                  <div class="form-group"><label class="col-lg-2 control-label">Existing User's Fee</label>
                   <div class="col-lg-10">
                  <input type="text" value="@if($fac_fee){{$fac_fee->old}}@endif" class="form-control" name="old" required>
                  </div>
                  </div>

                  <div class="form-group"><label class="col-lg-2 control-label">Medical Report Fee</label>
                   <div class="col-lg-10">
                  <input type="text" value="@if($fac_fee){{$fac_fee->medical_report_fee}}@endif" class="form-control" name="med_report" required>
                  </div>
                  </div>

                  <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                          <button class="btn btn-sm btn-primary" type="submit">@if($fac_fee)Update @else Submit @endif</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
</div>



<?php
use Carbon\Carbon;
$today = Carbon::today();  ?>
<div class="wrapper wrapper-content animated fadeIn">
      <div class="row">
          <div class="col-lg-12">

              <div class="tabs-container">
                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1">Today Fees</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2">This Month Fees</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3">All Time</a></li>

                  </ul>
                  <div class="tab-content">

                      <div id="tab-1" class="tab-pane active">
                          <div class="panel-body">
                            <div class="ibox float-e-margins">
                                <div class="">
                                    <h4>Daily Consultation Fee </h4>
                                    <div class="ibox-tools">

                                    </div>
                                </div>
                                <div class="ibox-content">

                                    <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                  <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>File No</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>View receipt</th>

                                    </tr>
                                </thead>

                                <tbody>
                                  <?php  $i =1;?>
                                    @foreach($feesdaily as $apatient)
                                    <?php
                                     if ($apatient->persontreated=='Self'){
                                    $name = $apatient->firstname." ".$apatient->secondName;
                                    $gender=$apatient->gender;
                                    $file=$apatient->file_no;
                                    $dob=$apatient->dob;
                                    }else {
                                    $name = $apatient->Infname." ".$apatient->InfName;
                                    $gender=$apatient->Infgender;
                                    $dob=$apatient->Infdob;
                                    }
                                    $interval = date_diff(date_create(), date_create($dob));
                                    $age= $interval->format(" %Y Ys Old");
                                      ?>
                                      <tr>
                                          <td>{{$i}}</td>
                                          <td>{{$name}}</td>
                                          <td>{{$file}}</td>
                                          <td>{{$age}}</td>
                                          <td>{{$gender}}</td>
                                          <td>{{$apatient->paydate}}</td>
                                          <?php $today=DB::table('payments')->where([['appointment_id', '=', $apatient->app_id],])
                                           ->select(DB::raw("SUM(amount) as count"))->first(); ?>
                                          <td>{{$today->count}}</td>
                                          <td><a href="{{route('facadmin.show_receipt',$apatient->app_id)}}">View Receipt</a></td>
                                      </tr>
                                    <?php $i++ ?>
                                      @endforeach
                                       </tbody>
                              <td colspan="5">Total</td><td colspan="2">{{$wekexp1}}</td>

                               </table>
                                   </div>

                               </div>
                           </div>

                          </div>
                      </div>

                      <div id="tab-2" class="tab-pane">
                          <div class="panel-body">
                            <div class="ibox float-e-margins">
                                <div class="">
                                    <h4>Monthly Consultation Fee </h4>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>File No</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>View receipt</th>
                                    </tr>
                                </thead>

                                <tbody>
                                  <?php  $i =1;?>
                                    @foreach($feesmonth as $apatient)
                                    <?php

                                     if ($apatient->persontreated=='Self'){
                                    $name = $apatient->firstname." ".$apatient->secondName;
                                    $gender=$apatient->gender;
                                    $dob=$apatient->dob;
                                    $file=$apatient->file_no;

                                    }else {
                                    $name = $apatient->Infname." ".$apatient->InfName;
                                    $gender=$apatient->Infgender;
                                    $dob=$apatient->Infdob;

                                    }

                                    $interval = date_diff(date_create(), date_create($dob));
                                    $age= $interval->format(" %Y Ys, Old");
                                      ?>

                                      <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$name}}</td>
                                        <td>{{$file}}</td>
                                        <td>{{$age}}</td>
                                        <td>{{$gender}}</td>
                                        <td>{{$apatient->paydate}}</td>
                                        <?php $month=DB::table('payments')->where([['appointment_id', '=', $apatient->app_id],])
                                         ->select(DB::raw("SUM(amount) as count"))->first(); ?>
                                        <td>{{$month->count}}</td>
                                        <td><a href="{{route('facadmin.show_receipt',$apatient->app_id)}}">View Receipt</a></td>
                                    </tr>
                                    <?php $i++ ?>
                                      @endforeach
                       <tr><td colspan="5">Total</td><td colspan="2">{{$wekexp2}}</td></tr>
                       </tbody>
                               </table>
                                   </div>

                               </div>
                           </div>

                          </div>
                      </div>
                      <div id="tab-3" class="tab-pane">
                          <div class="panel-body">
                            <div class="ibox float-e-margins">
                                <div class="">
                                    <h4>All Time Consultation Fee </h4>
                                    <div class="ibox-tools">

                                    </div>
                                </div>
                                <div class="ibox-content">

                                    <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                  <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>File No</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>View receipt</th>

                                    </tr>
                                </thead>

                                <tbody>
                                  <?php  $i =1;?>
                                    @foreach($fees as $apatient)
                                    <?php
                                     if ($apatient->persontreated=='Self'){
                                    $name = $apatient->firstname." ".$apatient->secondName;
                                    $gender=$apatient->gender;
                                    $dob=$apatient->dob;
                                    $file=$apatient->file_no;
                                    }else {
                                    $name = $apatient->Infname." ".$apatient->InfName;
                                    $gender=$apatient->Infgender;
                                    $dob=$apatient->Infdob;
                                    }
                                    $interval = date_diff(date_create(), date_create($dob));
                                    $age= $interval->format(" %Y YsOld");
                                      ?>

                                      <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$name}}</td>
                                        <td>{{$file}}</td>
                                        <td>{{$age}}</td>
                                        <td>{{$gender}}</td>
                                        <td>{{$apatient->paydate}}</td>

                        <?php $today=DB::table('payments')->where([['appointment_id', '=', $apatient->app_id],])
                                         ->select(DB::raw("SUM(amount) as count"))->first(); ?>
                                        <td>{{$today->count}}</td>
                                        <td><a href="{{route('facadmin.show_receipt',$apatient->app_id)}}">View Receipt</a></td>
                                      </tr>
                                    <?php $i++ ?>
                                      @endforeach
                                             <?php $wekexp=DB::table('payments')
                                             // ->join('appointments','appointments.id','=','payments.appointment_id')
                                             ->where('facility', '=', $facility->facilitycode)
                                                 ->sum('amount'); ?>
                                                 </tbody>
                        <tr><td colspan="5">Total</td> <td colspan="2">{{$wekexp}}</td></tr>

                               </table>
                                   </div>

                               </div>
                           </div>

                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </div>





<script>
$('.update23').on('click', function(e){

    $("#updatediv").show();

});
</script>
@endsection
