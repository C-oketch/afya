@extends('layouts.patient')
@section('title', 'Patient Tests')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profile</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li class="active">
                <strong>Expenditures</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-md-6">

  <h2>{{$patient->firstname}} {{$patient->secondName}}</h2>
  <h4>Patient</h4>

            </div>
            <div class="col-md-6 pul-right">
<br />
                          <address class="text-center ">
                        <strong>Contact Details : </strong><br>
                      Phone : <strong>{{$patient->msisdn}} </strong><br>
                      Email : <strong>{{$patient->email}} </strong><br>
                    </address>
                    </div>

</div>
</div>
  <div class="content-page  equal-height">
      <div class="content">
          <div class="container">

    <div class="row">
  <div class="col-lg-12">


            <div class="tabs-container">
              <!-- <div class="col-lg-12 tbg"> -->
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1">This Week</button></a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2">This Month</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3">This Year</a></li>


                </ul>
                <br>
          <div class="tab-content">
                      <div id="tab-1" class="tab-pane active">
            <div class="row">
                <div class="col-lg-11">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Health Expenditures </h5>
                        <div class="ibox-tools">
                          @role('Patient')
                           <a class="collapse-link">

                          </a>  @endrole
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">

                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Facility</th>
                            <th>Patient Name</th>
                            <th>Amount(Kshs)</th>

                      </tr>
                    </thead>

                    <tbody>

  <?php
        $i=1;
             $expenditures=DB::table('appointments')
                    ->join('payments','appointments.id','=','payments.appointment_id')
                    ->select('payments.*','appointments.persontreated')
                     ->where('appointments.afya_user_id',$patient->id)
                    ->where('payments.amount', '<>', 'None')
                    ->whereBetween('payments.created_at', [
                    Carbon\Carbon::now()->startOfWeek(),
                    Carbon\Carbon::now()->endOfWeek(),
                ])
                    ->orderby('payments.created_at','desc')->get(); ?>
                    @foreach($expenditures as $exp)
                      <tr>
                      <td><a href="{{URL('receipts.patient',$exp->id) }}" target="_blank">{{$i}}</a></td>
                       <td><a href="{{URL('receipts.patient',$exp->id) }}" target="_blank">{{ date('d -m- Y', strtotime($exp->created_at)) }}</a></td>
                       <td><a href="{{URL('receipts.patient',$exp->id) }}" target="_blank">{{ date('H:i:s', strtotime($exp->created_at)) }}</a></td>
                      <td><?php $facility=$exp->facility; $name=DB::table('facilities')->where('FacilityCode',$facility)->first();?>{{$name->FacilityName}}</td>
                        <td><?php $person=$exp->persontreated; if($person=='Self'){
                          echo "Primary";
                           }else{
                             $user=DB::table('dependant')->where('id',$exp->persontreated)->first();
                             echo $user->firstName." ".$user->secondName;
                               }
    ?>
                          </td>
                      <td>{{$exp->amount}}</td>
                      </tr>
                      <?php $i++ ?>
                      @endforeach
                       </tbody>

<?php $wekexp=DB::table('appointments')
                    ->join('payments','appointments.id','=','payments.appointment_id')
                    ->select('payments.*','appointments.persontreated')
                     ->where('appointments.afya_user_id',$patient->id)
                    ->where('payments.amount', '<>', 'None')
                    ->whereBetween('payments.created_at', [
                    Carbon\Carbon::now()->startOfWeek(),
                    Carbon\Carbon::now()->endOfWeek(),
                ])->sum('payments.amount'); ?>
 <td></td><td></td><td></td><td>Total</td><td></td><td>{{$wekexp}}</td>


                   </table>
                       </div>

                   </div>
               </div>
           </div>
           </div>
           </div>

           <div id="tab-2" class="tab-pane">
            <div class="row">
                <div class="col-lg-11">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Health Expenditures </h5>
                        <div class="ibox-tools">
                          @role('Patient')
                           <a class="collapse-link">

                          </a>  @endrole
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">

                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Facility</th>
                            <th>Patient Name</th>
                            <th>Amount(Kshs)</th>

                      </tr>
                    </thead>

                    <tbody>

                    <?php $i=1;

                    $mexpenditures=DB::table('appointments')
                    ->join('payments','appointments.id','=','payments.appointment_id')
                    ->select('payments.*','appointments.persontreated','appointments.facility_id')
                     ->where('appointments.afya_user_id',$patient->id)
                    ->where('payments.amount', '<>', 'None')
                    ->whereBetween('payments.created_at', [
                      Carbon\Carbon::now()->startOfMonth(),
                      Carbon\Carbon::now()->endOfMonth(),   ])
                    ->orderby('payments.created_at','desc')->get();
                     ?>
                    @foreach($mexpenditures as $mexp)
                      <tr>
                      <td><a href="{{URL('receipts.patient',$mexp->id) }}" target="_blank">{{$i}}</a></td>
                       <td><a href="{{URL('receipts.patient',$mexp->id) }}" target="_blank">{{ date('d -m- Y', strtotime($mexp->created_at)) }}</a></td>
            <td><a href="{{URL('receipts.patient',$mexp->id) }}" target="_blank">{{ date('H:i:s', strtotime($mexp->created_at)) }}</a></td>
                      <td><?php $facility=$mexp->facility_id;
                       $name=DB::table('facilities')->where('FacilityCode',$facility)->first();?>{{$name->FacilityName}}</td>

                         <td><?php $mperson=$mexp->persontreated; if($mperson=='Self'){
                           echo "Primary";
                            }else{
                              $userm=DB::table('dependant')->where('id',$mexp->persontreated)->first();
                              echo $user->firstName." ".$user->secondName;
                                }
                             ?>
                           </td>

                      <td>{{$mexp->amount}}</td>
                      </tr>
                      <?php $i++ ?>
                      @endforeach
                      </tbody>

          <?php $monthexp=DB::table('appointments')
                                        ->join('payments','appointments.id','=','payments.appointment_id')
                                        ->select('payments.*','appointments.persontreated')
                                         ->where('appointments.afya_user_id',$patient->id)
                                        ->where('payments.amount', '<>', 'None')
                                        ->whereBetween('payments.created_at', [
                                          Carbon\Carbon::now()->startOfMonth(),
                                          Carbon\Carbon::now()->endOfMonth(),
                                      ])->sum('payments.amount'); ?>
                <td></td><td></td><td></td><td>Total</td><td></td><td>{{$monthexp}}</td>


                   </table>
                       </div>

                   </div>
               </div>
           </div>
           </div>
           </div>
           <div id="tab-3" class="tab-pane">
            <div class="row">
                <div class="col-lg-11">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Health Expenditures </h5>
                        <div class="ibox-tools">
                          @role('Patient')
                           <a class="collapse-link">

                          </a>  @endrole
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">

                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Facility</th>
                            <th>Patient Name</th>
                            <th>Amount(Kshs)</th>

                      </tr>
                    </thead>

                    <tbody>

                    <?php $i=1;
                    $expenditures= DB::table('appointments')
                    ->join('payments','appointments.id','=','payments.appointment_id')
                    ->select('payments.*','appointments.persontreated','appointments.facility_id')
                     ->where('appointments.afya_user_id',$patient->id)
                    ->where('payments.amount', '<>', 'None')
                    ->whereYear('payments.created_at','=',date("Y"))
                    ->orderby('payments.created_at','desc')
                    ->get();
                     ?>

                    @foreach($expenditures as $yexp)
                      <tr>
                      <td><a href="{{URL('receipts.patient',$yexp->id) }}" target="_blank">{{$i}}</a></td>
                      <td><a href="{{URL('receipts.patient',$yexp->id) }}" target="_blank">{{ date('d -m- Y', strtotime($yexp->created_at)) }}</a></td>
                     <td><a href="{{URL('receipts.patient',$yexp->id) }}" target="_blank">{{ date('H:i:s', strtotime($yexp->created_at)) }}</a></td>
                     <td>
                     <?php

                     $facility=$yexp->facility_id;
                      $name=DB::table('facilities')->where('FacilityCode',$facility)->first();
                      ?>
                      @if(count($name)){{$name->FacilityName}}@endif</td>
                       <td>
                       <?php $yperson=$yexp->persontreated;

                       if($yperson=='Self'){
                           echo "Primary";
                         } else{
                          $usery=DB::table('dependant')->where('id',$yexp->persontreated)->first();
                          if(count($usery)):
                          echo $usery->firstName." ".$usery->secondName;
                          endif;

                            }

                            ?>

                            </td>

                      <td>{{$yexp->amount}}</td>
                      </tr>
                      <?php $i++ ?>
                      @endforeach
                       </tbody>


  <?php $yearexp=DB::table('appointments')
                               ->join('payments','appointments.id','=','payments.appointment_id')
                               ->select('payments.*','appointments.persontreated')
                                ->where('appointments.afya_user_id',$patient->id)
                               ->where('payments.amount', '<>', 'None')
                               ->whereYear('payments.created_at','=',date("Y"))
                              ->sum('payments.amount'); ?>
 <td></td><td></td><td></td><td>Total</td><td></td><td>{{$yearexp}}</td>

                    </table>
                       </div>

                   </div>
               </div>
           </div>
           </div>
           </div>



           </div>







@endsection
