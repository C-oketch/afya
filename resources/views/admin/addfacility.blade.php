@extends('layouts.admin_layout')
@section('title', 'Admin Dashboard')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">

<div class="col-lg-6">
<div class="ibox float-e-margins">
<div class="ibox-title">
<h5>Search Facility</h5>
</div>
<div class="ibox-content">
<form class="form-horizontal" role="form" method="POST" action="/addfacility1" novalidate>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
<label>Facility Name</label>
<select class="form-control m-b select2_demo_1" name="facilitycode" >
<option value="">Please select one</option>
@foreach ($facilities as $type)
<option value="{{$type->id}}">{{$type->FacilityName}} &nbsp;&nbsp;&nbsp; {{$type->Ward}}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>SetUp</label>
<select class="form-control m-b select2_demo_1" name="setup" >
<option value="Partial">Partial</option>
<option value="Full">Full</option>
</select>
</div>

<div class="form-group">
<label>Payment</label>
<select class="form-control m-b select2_demo_1" name="payment" >
<option value="A">After Consultation</option>
<option value="B">Before Consultation</option>
</select>
</div>

<input type="submit" name="submit" value="SUBMIT" class="btn btn-primary" >
</form>
</div>
</div>
</div>


<div class="col-lg-6">
<div class="ibox float-e-margins">
<div class="ibox-title">
<h5>Create Facility</h5>
</div>
<div class="ibox-content">
<form class="form-horizontal" role="form" method="POST" action="addfacility2">
<input type="hidden" name="_token" value="{{ csrf_token() }}">


<div class="form-group">
<label for="exampleInputEmail1">Facility Code</label>
<input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="code">
</div>
<div class="form-group">
<label for="exampleInputEmail1">Facility Name</label>
<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name">
</div>


<div class="form-group">
<label for="exampleInputPassword1">Type</label>
<input type="text" class="form-control" id="exampleInputPassword1" name="type"/>
</div>
<div class="form-group">
<label for="exampleInputPassword1">County</label>
<input type="text" class="form-control" id="exampleInputPassword1" name="county"/>
</div>
<div class="form-group">
<label for="exampleInputPassword1">Constituency</label>
<input type="text" class="form-control" id="exampleInputPassword1" name="constituency"/>
</div>
<div class="form-group">
<label for="exampleInputPassword1">Ward</label>
<input type="text" class="form-control" id="exampleInputPassword1" name="ward"/>
</div>
<div class="form-group">
<label>SetUp</label>
<select class="form-control m-b select2_demo_1" name="setup" >
<option value="Partial">Partial</option>
<option value="Full">Full</option>
</select>
</div>

<div class="form-group">
<label>Payment</label>
<select class="form-control m-b select2_demo_1" name="setup" >
<option value="A">After Consultation</option>
<option value="B">Before Consultation</option>
</select>
</div>
<input type="submit" name="submit" value="SUBMIT" class="btn btn-primary" >
</form>
</div>
</div>
</div>


</div>
</div>
<!--container-->

  @endsection
  @section('script')

  <script>
  $(".select2_demo_1").select2();
  </script>
  @endsection
