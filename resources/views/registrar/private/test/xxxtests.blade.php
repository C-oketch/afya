@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-md-6">
    <address>
      <br />
      <strong>FACILITY :</strong><br>
      <strong> Name :</strong>{{$facilitycode->FacilityName}}<br>
      <strong> Type :</strong> {{$facilitycode->Type}}<br>
    </address>
  </div>
  <div class="col-md-6 text-right">
    <address>
      <br /><br />
      <strong>DATE :</strong><br>
      {{date("l jS \of F Y ")}}
    </address>
  </div>
</div>

<?php $facd = $facilitycode->facilitycode; ?>

<div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                          <div class="col-lg-11">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                        <h4>ALL TESTS</h4>
                                        <div class="ibox-tools">
                                    <a class="btn btn-sm btn-primary"  href="{{route('reg.test',$id)}}"><i class="fa fa-angle-double-left"></i>&nbsp;BACK</a>

                          </div>
                              </div>
                              <div class="ibox-content">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
  <tr>
  <th>No</th>
  <th>Tests Name</th>
  <th>Action</th>
  </tr>
  </thead>
  <tbody>


    <!-- Imaging OTHER TESTS -->
    <?php
    $i=1;?>
    <?php  $othertests = DB::table('other_tests')
    ->Join('test_prices_other', 'other_tests.id', '=', 'test_prices_other.other_id')
    ->where('test_prices_other.facility_id',$facd)
    ->orderBy('status', 'desc')
    ->get();
    ?>
    @foreach ($othertests as $other)
    <tr class="item{{$other->id}}">
        <td>{{$i}}</td>
        <td>{{$other->name}}</td>
    <?php
    $datadetails13 = DB::table('radiology_test_details')
    ->Where([['test',$other->id],
             ['appointment_id',$id],
            ['done',0],
            ['test_cat_id',13],
            ['deleted',0],])
    ->first();
    ?>
    @if($datadetails13)
    <td>
      <button class="delete-modal11 btn btn-danger" data-rtd="{{$datadetails13->id}}"
          data-name="{{$other->name}}"  data-cat_id="{{$other->test_cat_id}}" data-appid="{{$id}}">
          <span class="glyphicon glyphicon-minus"></span>Remove
        </button>
    </td>
    @else
    <td>
    <button class="add-modal1 btn btn-primary" data-id="{{$other->id}}"
        data-name="{{$other->name}}" data-appid="{{$id}}" data-catid="{{$other->test_cat_id}}">
        <span class="glyphicon glyphicon-plus"></span>ADD
      </button>
    </td>
    @endif
    </tr>
    <?php $i++;  ?>
    @endforeach


    <!-- Imaging X_RAY TESTS -->
    <?php
    $i=$i;?>
    <?php  $xraytests = DB::table('xray')
    ->Join('test_prices_xray', 'xray.id', '=', 'test_prices_xray.xray_id')
    ->where('test_prices_xray.facility_id',$facd)
    ->orderBy('status', 'desc')
    ->get();  ?>
    @foreach ($xraytests as $xray)
    <tr class="item{{$xray->id}}">
        <td>{{$i}}</td>
        <td>{{$xray->name}}</td>
    <?php
    $datadetails10 = DB::table('radiology_test_details')
    ->Where([['test',$xray->id],
             ['appointment_id',$id],
            ['done',0],
            ['test_cat_id',10],
            ['deleted',0],])
    ->first();
    ?>
    @if($datadetails10)
    <td>
      <button class="delete-modal11 btn btn-danger" data-rtd="{{$datadetails10->id}}"
          data-name="{{$xray->name}}"  data-cat_id="{{$xray->test_cat_id}}" data-appid="{{$id}}">
          <span class="glyphicon glyphicon-minus"></span>Remove
        </button>
    </td>
    @else
    <td>
    <button class="add-modal1 btn btn-primary" data-id="{{$xray->id}}"
        data-name="{{$xray->name}}" data-appid="{{$id}}" data-catid="{{$xray->test_cat_id}}">
        <span class="glyphicon glyphicon-plus"></span>ADD
      </button>
    </td>
    @endif
    </tr>
    <?php $i++;  ?>
    @endforeach

    <!-- Imaging MRI TESTS -->
    <?php
    $i=$i;?>
    <?php  $mritests = DB::table('mri_tests')
    ->Join('test_prices_mri', 'mri_tests.id', '=', 'test_prices_mri.mri_id')
    ->where('test_prices_mri.facility_id',$facd)
    ->orderBy('status', 'desc')
    ->get();  ?>
    @foreach ($mritests as $mri)
    <tr class="item{{$mri->id}}">
        <td>{{$i}}</td>
        <td>{{$mri->name}}</td>
    <?php
    $datadetails11= DB::table('radiology_test_details')
    ->Where([['test',$mri->id],
            ['appointment_id',$id],
            ['done',0],
            ['test_cat_id',11],
            ['deleted',0],])
    ->first();
    ?>
    @if($datadetails11)
    <td>
      <button class="delete-modal11 btn btn-danger" data-rtd="{{$datadetails11->id}}"
          data-name="{{$mri->name}}"  data-cat_id="{{$mri->test_cat_id}}" data-appid="{{$id}}">
          <span class="glyphicon glyphicon-minus"></span>Remove
        </button>
    </td>
    @else
    <td>
    <button class="add-modal1 btn btn-primary" data-id="{{$mri->id}}"
        data-name="{{$mri->name}}" data-appid="{{$id}}" data-catid="{{$mri->test_cat_id}}">
        <span class="glyphicon glyphicon-plus"></span>ADD
      </button>
    </td>
    @endif
    </tr>
    <?php $i++;  ?>
    @endforeach

    <!-- Imaging ULTRASOUND TESTS -->
    <?php
    $i=$i;?>
    <?php  $ultrasound = DB::table('ultrasound')
    ->Join('test_prices_ultrasound', 'ultrasound.id', '=', 'test_prices_ultrasound.ultrasound_id')
    ->where('test_prices_ultrasound.facility_id',$facd)
    ->orderBy('status', 'desc')->get();  ?>
    @foreach ($ultrasound as $ultra)
    <tr class="item{{$ultra->id}}">
        <td>{{$i}}</td>
        <td>{{$ultra->name}}</td>
    <?php
    $datadetails12 = DB::table('radiology_test_details')
    ->Where([['test',$ultra->id],
            ['appointment_id',$id],
            ['done',0],
            ['test_cat_id',12],
            ['deleted',0],])
    ->first();
    ?>
    @if($datadetails12)
    <td>
      <button class="delete-modal11 btn btn-danger" data-rtd="{{$datadetails12->id}}"
          data-name="{{$ultra->name}}"  data-cat_id="{{$ultra->test_cat_id}}" data-appid="{{$id}}">
          <span class="glyphicon glyphicon-minus"></span>Remove
        </button>
    </td>
    @else
    <td>
    <button class="add-modal1 btn btn-primary" data-id="{{$ultra->id}}"
        data-name="{{$ultra->name}}" data-appid="{{$id}}" data-catid="{{$ultra->test_cat_id}}">
        <span class="glyphicon glyphicon-plus"></span>ADD
      </button>
    </td>
    @endif
    </tr>
    <?php $i++;  ?>
    @endforeach



    <!-- Imaging CTSCAN TESTS -->
    <?php
    $i=$i;?>
    <?php  $ctscan = DB::table('ct_scan')
    ->Join('test_prices_ct_scan', 'ct_scan.id', '=', 'test_prices_ct_scan.ct_scan_id')
    ->where('test_prices_ct_scan.facility_id',$facd)
    ->orderBy('status', 'desc')->get();  ?>
    @foreach ($ctscan as $cts)
    <tr class="item{{$cts->id}}">
        <td>{{$i}}</td>
        <td>{{$cts->name}}</td>
    <?php
    $datadetails9 = DB::table('radiology_test_details')
    ->Where([['test',$cts->id],
            ['appointment_id',$id],
            ['done',0],
            ['test_cat_id',9],
            ['deleted',0],])
    ->first();
    ?>
    @if($datadetails9)
    <td>
      <button class="delete-modal11 btn btn-danger" data-rtd="{{$datadetails9->id}}"
          data-name="{{$cts->name}}"  data-cat_id="{{$cts->test_cat_id}}" data-appid="{{$id}}">
          <span class="glyphicon glyphicon-minus"></span>Remove
        </button>
    </td>
    @else
    <td>
    <button class="add-modal1 btn btn-primary" data-id="{{$cts->id}}"
        data-name="{{$cts->name}}" data-appid="{{$id}}" data-catid="{{$cts->test_cat_id}}">
        <span class="glyphicon glyphicon-plus"></span>ADD
      </button>
    </td>
    @endif
    </tr>
    <?php $i++;  ?>
    @endforeach
 <!-- LAB TESTS -->
  <?php
  $i=$i;?>
  @foreach ($tests as $tsts)
  <tr class="item{{$tsts->testId}}">
  <td>{{$i}}</td>
  <td>{{$tsts->tname}}</td>

  <?php
  $datadetailsl = DB::table('patient_test_details')
  ->Where([['tests_reccommended',$tsts->testId],
  ['appointment_id',$id],
  ['deleted',0],
  ['done',0],])
  ->first();
  ?>
  @if($datadetailsl)
  <td>
  <button class="delete-modal22 btn btn-danger" data-id2="{{$datadetailsl->id}}" data-tname2="{{$tsts->tname}}" data-appid2="{{$id}}"
    data-scat2="{{$tsts->subname}}" data-cat2="{{$tsts->cname}}" >
      <span class="glyphicon glyphicon-minus"></span>Remove
    </button>
  </td>
  @else
  <td><button class="add-modal2 btn btn-primary" data-id2="{{$tsts->testId}}" data-tname2="{{$tsts->tname}}"
  data-scat2="{{$tsts->subname}}" data-cat2="{{$tsts->cname}}" data-appid2="{{$id}}">
  <span class="glyphicon glyphicon-plus"></span>ADD
  </button>
  </td>
  @endif
  </tr>
  <?php $i++;  ?>
  @endforeach
  </tbody>

  </table>
  </div>



</div>
</div>
</div>
</div>
</div>


<div id="myModal1" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"></h4>
</div>
<div class="modal-body">
  {!! Form::open(array('url' => 'reg.save','method'=>'POST')) !!}
    <form class="form-horizontal" role="form">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
<label>Test Name:</label>
<input type="text" class="form-control" id="name" readonly>
<input type="hidden" class="form-control" id="fid" name="test" >
<input type="hidden" class="form-control" id="appId" name="appointment" >
<input type="hidden" class="form-control" id="catId" name="cat_id" >
</div>
<div class="form-group adds">
<label for="tag_list" class="">Target:</label>
<select class="form-control" name="target" style="width: 100%">
<option value=''>N/A</option>
<option value='Left'>Left</option>
<option value='Right'>Right</option>
<option value='Both'>Both </option>
</select>
</div>
<div class="form-group adds">
<label for="d_list2">Clinical Information:</label>
<textarea rows="4" name="clinical" cols="50" class="form-control"></textarea>
</div>


</div>

<div class="modal-footer">
  <!-- <button type="button" class="btn actionBtn" data-dismiss="modal">
    <span id="footer_action_button" class='glyphicon'> </span>
  </button> -->

<button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>


  <button type="button" class="btn btn-warning" data-dismiss="modal">
<span class='glyphicon glyphicon-remove'></span> Close
</button>
{!! Form::close() !!}
</div>
</div>
</div>
</div>

<div id="myModal11" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"></h4>
</div>
<div class="modal-body">
  {!! Form::open(array('url' => 'regRadremove','method'=>'POST')) !!}
    <form class="form-horizontal" role="form">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
<label>Test Name:</label>
<input type="text" class="form-control" id="name11" readonly>
<input type="hidden" class="form-control" id="fid11" name="test" >
<input type="hidden" class="form-control" id="appId11" name="appointment" >
<input type="hidden" class="form-control" id="catId11" name="cat_id" >
</div>
</div>

<div class="modal-footer">
<button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>
  <button type="button" class="btn btn-warning" data-dismiss="modal">
<span class='glyphicon glyphicon-remove'></span> Close
</button>
{!! Form::close() !!}
</div>
</div>
</div>
</div>


<!-- Modal ends -->
<div id="myModal2" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"></h4>
</div>
<div class="modal-body">
<form class="form-horizontal" role="form" action="/reg.savelab" method="POST">
    <!-- <form class="form-horizontal" role="form"> -->
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Category:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="cat2" readonly>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Subcategory:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="scat2" readonly>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Name:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="n2" readonly>
<input type="hidden" class="form-control" id="fid2" name="test_id" >
<input type="hidden" class="form-control" id="appId2" name="appointment_id" >

</div>
</div>
<div class="form-group" id="docnote2">
<label for="d_list2">Doctor Note(For test):</label>
<textarea rows="4" name="docnote" id="docnote2" cols="50" class="form-control"></textarea>
</div>


</div>

<div class="modal-footer">
<!-- <button type="button" class="btn actionBtn" data-dismiss="modal">
<span id="footer_action_button" class='glyphicon'>Submit </span>
</button> -->
<button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>


<button type="button" class="btn btn-warning" data-dismiss="modal">
<span class='glyphicon glyphicon-remove'></span> Close
</button>
{!! Form::close() !!}
</div>
</div>
</div>
</div>




<!-- Modal ends -->
<div id="myModal22" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"></h4>
</div>
<div class="modal-body">
<form class="form-horizontal" role="form" action="/labremove" method="POST">

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Category:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="cat22" readonly>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Subcategory:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="scat22" readonly>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="availability">Test Name:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="n22" readonly>
<input type="hidden" class="form-control" id="fid22" name="ptd_id" >
<input type="hidden" class="form-control" id="appId22" name="appointment_id" >

</div>
</div>

</div>

<div class="modal-footer">
<button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>
<button type="button" class="btn btn-warning" data-dismiss="modal">
<span class='glyphicon glyphicon-remove'></span> Close
</button>
{!! Form::close() !!}
</div>
</div>
</div>
</div>
@endsection
@section('script-reg')
<!-- Page-Level Scripts -->
<script src="{{ asset('js/reg_test.js') }}"></script>

@endsection
