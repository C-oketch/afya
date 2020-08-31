@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('style')

@endsection
@section('content')
@include('includes.registrar.topnavbar_v2')
<?php

$regid = Auth::id();

$feereg = DB::table('users')->select('name')->where('id',$regid)->first();
$regname=$feereg->name;
$paymentmode = DB::table('payment_options')->select('name','id')->get();

if($appdetails){ $app_id = $appdetails->id; }else{ $app_id = ''; }


$afyauserId= $user->id;
$facd = $facility->facilitycode;
// dd($app_id);

?>
<div class="container">
  <div class="row">
    <div class="col-md-11">
      <div class="ibox float-e-margins">
        <div class="tab" role="tabpanel">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class=""><a href="{{ URL('registrar.shows', $user->id) }}" aria-controls="home" role="tab" >BASIC DETAILS</a></li>
            <li role="presentation" class=""><a href="{{ URL('registrar.shows_test', $user->id) }}" aria-controls="profile" role="tab" >PATIENT TESTS</a></li>
            <li role="presentation" class="active"><a href="#" aria-controls="messages" role="tab">PAYMENTS</a></li>
            <li><a href="{{route('registrar.radyreceipt',$app_id)}}" class="btn btn-primary pull-right"><i class="fa fa-print"></i>View Receipt</a> </li>
          </ul>
          <!-- Tab panes -->

          <div role="tabpanel" class="tab-pane fade in active" id="Section2">



<div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                          <div class="col-lg-11">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                        <h4>ALL TESTS</h4>
                              </div>
                              <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-8 col-md-offset-2"><h3 class="m-t-none m-b"></h3>

                                        <div class="table-responsive m-t">
                                            <table class="table invoice-table">
                                                <thead>
                                                <tr>
                                                    <th>Details</th>
                                                    <th>Total Price</th>
                                                    <th>Total Price</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                  <?php
                                              $i =1; ?>
            @foreach($tsts as $tst)
            <?php

            if ($tst->test_cat_id == 13) {
            $other =  DB::table('other_tests')
            ->Join('test_prices_other', 'other_tests.id', '=', 'test_prices_other.other_id')
            ->select('other_tests.name','test_prices_other.amount')
            ->where([['other_tests.id', '=',$tst->test],['test_prices_other.facility_id',$facility->facilitycode]])
            ->first();
            ?>
            @if($other)
            <tr class="item{{$tst->AppId}}">
            <td>{{$tst->test}}</td>
            <td>{{$tst->test_cat_id}}</td>

            <?php
            $datadetails13 = DB::table('payments')
            ->Where([['appointment_id',$tst->AppId],
            ['imaging_id',$tst->patTdid],
            ['payments_category_id',3],])
            ->first();
            ?>
            @if($datadetails13)
            <td><button class="btn btn-primary">Paid</button></td>
            @else
            <td>
            <button class="add-modal btn btn-primary" data-appid="{{$tst->AppId}}" data-amount="{{$other->amount}}"
            data-name="{{$other->name}}" data-ptid="{{$tst->ptid}}" data-ptdid="{{$tst->patTdid}}">
            <span class="glyphicon glyphicon-plus"></span>ADD
            </button>
            </td>
            @endif
            </tr>
            @endif
            <?php } ?>

            <?php
            if ($tst->test_cat_id == 9) {
            $ct =  DB::table('ct_scan')
            ->Join('test_prices_ct_scan', 'ct_scan.id', '=', 'test_prices_ct_scan.ct_scan_id')
            ->select('ct_scan.name','test_prices_ct_scan.amount')
            ->where([['ct_scan.id', '=',$tst->test],['test_prices_ct_scan.facility_id',$facility->facilitycode]])
            ->first();
            ?>
            @if($ct)
            <tr class="item{{$tst->AppId}}">
            <td>{{$ct->name}}</td>
            <td>{{$ct->amount}}</td>

            <?php
            $datadetails9 = DB::table('payments')
            ->Where([['appointment_id',$tst->AppId],
            ['imaging_id',$tst->patTdid],
            ['payments_category_id',3],])
            ->first();
            ?>
            @if($datadetails9)
            <td><button class="btn btn-primary">Paid</button></td>
            @else
            <td>
            <button class="add-modal btn btn-primary" data-appid="{{$tst->AppId}}" data-amount="{{$ct->amount}}"
            data-name="{{$ct->name}}" data-ptid="{{$tst->ptid}}" data-ptdid="{{$tst->patTdid}}">
            <span class="glyphicon glyphicon-plus"></span>ADD
            </button>
            </td>
            @endif
            </tr>
            @endif
            <?php } ?>

            <?php
            if ($tst->test_cat_id == 10) {
            $xray =  DB::table('xray')
            ->Join('test_prices_xray', 'xray.id', '=', 'test_prices_xray.xray_id')
            ->select('xray.name','test_prices_xray.amount')
            ->where([['xray.id', '=',$tst->test],['test_prices_xray.facility_id',$facility->facilitycode]])
            ->first();
            ?>
            @if($xray)
            <tr class="item{{$tst->AppId}}">
            <td>{{$xray->name}}</td>
            <td>{{$xray->amount}}</td>

            <?php
            $datadetails10 = DB::table('payments')
            ->Where([['appointment_id',$tst->AppId],
            ['imaging_id',$tst->patTdid],
            ['payments_category_id',3],])
            ->first();
            ?>
            @if($datadetails10)
            <td><button class="btn btn-primary">Paid</button></td>
            @else
            <td>
            <button class="add-modal btn btn-primary" data-appid="{{$tst->AppId}}" data-amount="{{$xray->amount}}"
            data-name="{{$xray->name}}" data-ptid="{{$tst->ptid}}" data-ptdid="{{$tst->patTdid}}">
            <span class="glyphicon glyphicon-plus"></span>ADD
            </button>
            </td>
            @endif
            </tr>
            @endif
            <?php } ?>

            <?php
            if ($tst->test_cat_id == 11) {
            $mri =  DB::table('mri_tests')
            ->Join('test_prices_mri', 'mri_tests.id', '=', 'test_prices_mri.mri_id')
            ->select('mri_tests.name','test_prices_mri.amount')
            ->where([['mri_tests.id', '=',$tst->test],['test_prices_mri.facility_id',$facility->facilitycode]])
            ->first();
            ?>
            @if($mri)
            <tr class="item{{$tst->AppId}}">
            <td>{{$mri->name}}</td>
            <td>{{$mri->amount}}</td>

            <?php
            $datadetails11 = DB::table('payments')
            ->Where([['appointment_id',$tst->AppId],
            ['imaging_id',$tst->patTdid],
            ['payments_category_id',3],])
            ->first();
            ?>
            @if($datadetails11)
            <td><button class="btn btn-primary">Paid</button></td>
            @else
            <td>
            <button class="add-modal btn btn-primary" data-appid="{{$tst->AppId}}" data-amount="{{$mri->amount}}"
            data-name="{{$mri->name}}" data-ptid="{{$tst->ptid}}" data-ptdid="{{$tst->patTdid}}">
            <span class="glyphicon glyphicon-plus"></span>ADD
            </button>
            </td>
            @endif
            </tr>
            @endif
            <?php } ?>



            <?php
            if ($tst->test_cat_id == 12) {
            $ultra =  DB::table('ultrasound')
            ->Join('test_prices_ultrasound', 'ultrasound.id', '=', 'test_prices_ultrasound.ultrasound_id')
            ->select('ultrasound.name','test_prices_ultrasound.amount')
            ->where([['ultrasound.id', '=',$tst->test],['test_prices_ultrasound.facility_id',$facility->facilitycode]])
            ->first();
            ?>
            @if($ultra)
            <tr class="item{{$tst->AppId}}">
            <td>{{$ultra->name}}</td>
            <td>{{$ultra->amount}}</td>

            <?php
            $datadetails12 = DB::table('payments')
            ->Where([['appointment_id',$tst->AppId],
            ['imaging_id',$tst->patTdid],
            ['payments_category_id',3],])
            ->first();
            ?>
            @if($datadetails12)
            <td><button class="btn btn-primary">Paid</button></td>
            @else
            <td>
            <button class="add-modal btn btn-primary" data-appid="{{$tst->AppId}}" data-amount="{{$ultra->amount}}"
            data-name="{{$ultra->name}}" data-ptid="{{$tst->ptid}}" data-ptdid="{{$tst->patTdid}}">
            <span class="glyphicon glyphicon-plus"></span>ADD
            </button>
            </td>
            @endif
            </tr>
            @endif
            <?php } ?>
            @endforeach

                                              </tbody>
                                            </table>
                                        </div><!-- /table-responsive -->
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
      {!! Form::open(array('url' => 'regpaytest2','method'=>'POST', 'class'=>'form-horizontal')) !!}
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" class="form-control" id="appid" name="appointment" >
  <input type="hidden" class="form-control" id="ptid" name="ptid" >
  <input type="hidden" class="form-control" id="ptdid" name="ptdid" >
<div class="form-group">
<label class="col-md-4">Test Name:</label>
<div class="col-md-8">
<input type="text" class="form-control" id="m" readonly>
</div>
</div>

<div class="form-group">
  <label class="col-sm-4">Amount :</label>
<div class="col-sm-8">
  <input type="text" id="n" class="form-control" name="amount">
</div>
</div>
<div class="form-group"><label class="col-sm-4">Payment Mode :</label>
    <div class="col-sm-8"><select class="form-control" name="mode">
      @foreach($paymentmode as $fee)
      <option value="{{$fee->id}}">{{$fee->name}}</option>
      @endforeach
    </select>
  </div>
  </div>
</div>
<div class="modal-footer">
  <button type="submit" class="btn btn-primary">SUBMIT</button>
{!! Form::close() !!}
</div>
</div>
</div>
</div>

@endsection
          @section('script-reg')
           <!-- Page-Level Scripts -->
          <script src="{{ asset('js/lab_id.js') }}"></script>

          @endsection
