@extends('layouts.doctor')
@section('title', 'Your Fees')
@section('content')

  <?php    use Carbon\Carbon;
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
                                          <th>Age</th>
                                          <th>Gender</th>
                                          <th>Date</th>
                                          <th>Mode of Payment</th>
                                              <th>Category</th>
                                          <th>Amount</th>
                                          <th>Action</th>

                                      </tr>
                                  </thead>

                                  <tbody>
                                    <?php  $i =1;?>
                                      @foreach($feesdaily as $apatient)
                                      <?php

                                       if ($apatient->persontreated=='Self'){
                                      $name = $apatient->firstname." ".$apatient->secondName;
                                      $gender=$apatient->gender;
                                      $dob=$apatient->dob;

                                      }else {
                                      $name = $apatient->Infname." ".$apatient->InfName;
                                      $gender=$apatient->Infgender;
                                      $dob=$apatient->Infdob;

                                      }

                                      $interval = date_diff(date_create(), date_create($dob));
                                      $age= $interval->format(" %Y Ys Old");


                                      if(! is_null($apatient->mode))
                                      {
                                      $modes =DB::table('payment_options')->select('name')->where('id', '=', $apatient->mode)->first();
                                      $mode = $modes->name;
                                      }
                                      else
                                      {
                                        $mode ='';
                                      }

                                        ?>

                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$name}}</td>
                                            <td>{{$age}}</td>
                                            <td>{{$gender}}</td>
                                            <td>{{$apatient->paydate}}</td>
                                            <td>{{$mode}}</td>
                                            <td>{{$apatient->category_name}}</td>
                                            <?php $today=DB::table('payments')->where([['appointment_id', '=', $apatient->app_id],['payments_category_id', '=', $apatient->paycatid], ])
                                             ->select(DB::raw("SUM(amount) as count"))->first(); ?>
                                            <td>{{$today->count}}</td>
                                            @if($apatient->paycatid == 1)
                                            <td><a href="{{route('registrar.show_receipt',$apatient->app_id)}}">View Receipt</a></td>
                                            @elseif($apatient->paycatid == 3)
                                            <td><a href="{{url('registrar.radyreceipt2',$apatient->app_id)}}">View Receipt</a></td>
                                            @elseif($apatient->paycatid == 2)
                                            <td><a href="{{url('registrar.labreceipt2',$apatient->app_id)}}">View Receipt</a></td>
                                           @endif                                       </tr>
                                      <?php $i++ ?>
                                        @endforeach
                                         </tbody>
                                <td colspan="7">Total</td> <td colspan="2">{{$wekexp1}}</td>

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
                                      <th>Age</th>
                                      <th>Gender</th>
                                      <th>Date</th>
                                      <th>Mode of Payment</th>
                                      <th>Category</th>
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

                                      }else {
                                      $name = $apatient->Infname." ".$apatient->InfName;
                                      $gender=$apatient->Infgender;
                                      $dob=$apatient->Infdob;

                                      }

                                      $interval = date_diff(date_create(), date_create($dob));
                                      $age= $interval->format(" %Y Ys, Old");


                                      if(! is_null($apatient->mode))
                                      {
                                      $modes =DB::table('payment_options')->select('name')->where('id', '=', $apatient->mode)->first();
                                      $mode = $modes->name;
                                      }
                                      else
                                      {
                                        $mode ='';
                                      }

                                        ?>

                                        <tr>
                                          <td>{{$i}}</td>
                                          <td>{{$name}}</td>
                                          <td>{{$age}}</td>
                                          <td>{{$gender}}</td>
                                          <td>{{$apatient->paydate}}</td>
                                          <td>{{$mode}}</td>
                                          <td>{{$apatient->category_name}}</td>
                                          <?php $month=DB::table('payments')->where([['appointment_id', '=', $apatient->app_id],['payments_category_id', '=', $apatient->paycatid], ])
                                           ->select(DB::raw("SUM(amount) as count"))->first(); ?>
                                          <td>{{$month->count}}</td>

                                          @if($apatient->paycatid == 1)
                                          <td><a href="{{route('registrar.show_receipt',$apatient->app_id)}}">View Receipt</a></td>
                                          @elseif($apatient->paycatid == 3)
                                          <td><a href="{{url('registrar.radyreceipt2',$apatient->app_id)}}">View Receipt</a></td>
                                          @elseif($apatient->paycatid == 2)
                                          <td><a href="{{url('registrar.labreceipt2',$apatient->app_id)}}">View Receipt</a></td>
                                         @endif                                       </tr>
                                      <?php $i++ ?>
                                        @endforeach
                                        </tbody>
                         <td colspan="7">Total</td> <td colspan="2">{{$wekexp2}}</td>
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
                                          <th>Age</th>
                                          <th>Gender</th>
                                          <th>Date</th>
                                          <th>Mode of Payment</th>
                                              <th>Category</th>
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

                                      }else {
                                      $name = $apatient->Infname." ".$apatient->InfName;
                                      $gender=$apatient->Infgender;
                                      $dob=$apatient->Infdob;

                                      }

                                      $interval = date_diff(date_create(), date_create($dob));
                                      $age= $interval->format(" %Y YsOld");


                                      if(! is_null($apatient->mode))
                                      {
                                      $modes =DB::table('payment_options')->select('name')->where('id', '=', $apatient->mode)->first();
                                      $mode = $modes->name;
                                      }
                                      else
                                      {
                                        $mode ='';
                                      }

                                        ?>

                                        <tr>
                                          <td>{{$i}}</td>
                                          <td>{{$name}}</td>
                                          <td>{{$age}}</td>
                                          <td>{{$gender}}</td>
                                          <td>{{$apatient->paydate}}</td>
                                          <td>{{$mode}}</td>
                                          <td>{{$apatient->category_name}}</td>
                                          <?php $today=DB::table('payments')->where([['appointment_id', '=', $apatient->app_id],['payments_category_id', '=', $apatient->paycatid], ])
                                           ->select(DB::raw("SUM(amount) as count"))->first(); ?>
                                          <td>{{$today->count}}</td>

                                          @if($apatient->paycatid == 1)
                                          <td><a href="{{route('registrar.show_receipt',$apatient->app_id)}}">View Receipt</a></td>
                                          @elseif($apatient->paycatid == 3)
                                          <td><a href="{{url('registrar.radyreceipt2',$apatient->app_id)}}">View Receipt</a></td>
                                          @elseif($apatient->paycatid == 2)
                                          <td><a href="{{url('registrar.labreceipt2',$apatient->app_id)}}">View Receipt</a></td>
                                         @endif
                                        </tr>
                                      <?php $i++ ?>
                                        @endforeach
                                               <?php $wekexp=DB::table('payments')
                                               ->join('appointments','appointments.id','=','payments.appointment_id')
                                               ->where([
                                                 ['appointments.facility_id', '=', $facility->facilitycode], ])
                                                   ->sum('amount'); ?>
                                                   </tbody>
                          <tr><td colspan="7">Total</td> <td colspan="2">{{$wekexp}}</td></tr>

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

       @include('includes.default.footer')

@endsection
