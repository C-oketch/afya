
@extends('layouts.doctor')
@section('content')
<div class="content-page  equal-height">
 <div class="content">
  <div class="container">
    <div class="row">

<div class="col-sm-6">
  <div class="panel-box">
    <p>Please provide your accurate data.</p>
      <h4>Personal Info</h4>
<div class="row">
  @if (count($errors) > 0)
 <div class="alert alert-danger">
  <strong>Whoops!</strong> There were some problems with your input.<br><br>
 <ul>
  @foreach ($errors->all() as $error)
 <li>{{ $error }}</li>
  @endforeach
 </ul>
 </div>
 @endif
 {{ Form::open(array('route' => 'doctor.store','method'=>'POST')) }}
 <div class="col-xs-12 col-sm-12 col-md-12">
 <div class="form-group">
 <!-- <strong>user ID:</strong> -->
 {{  Form::text('user_id', Auth::user()->id, array('class' => 'form-control')) }}
 </div>
   </div>
 <div class="col-xs-12 col-sm-12 col-md-12">
 <div class="form-group">
 <strong>Name:</strong>
{{  Form::text('name', null, array('placeholder' => 'FullName','class' => 'form-control')) }}
 </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-12">
   <div class="form-group">
 <strong>Date Registered:</strong>
{{  Form::text('regdate', null, array('placeholder' => '22/10/2039','class' => 'form-control')) }}
 </div>
 </div>

 <div class="col-xs-12 col-sm-12 col-md-12">
 <div class="form-group">
<strong>Registration NO:</strong>
{{ Form::text('regno', null, array('placeholder' => 'NB02','class' => 'form-control')) }}
</div>
</div>
  <h4>Contact Info</h4>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Address:</strong>
{{ Form::text('address', null, array('placeholder' => 'address','class' => 'form-control')) }}
</div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
<strong>Phone No:</strong>
{{ Form::text('phone', null, array('placeholder' => 'phone','class' => 'form-control')) }}
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Residence:</strong>
{{ Form::text('residence', null, array('placeholder' => 'residence','class' => 'form-control')) }}
</div>
</div>

<h4>Qualification Info</h4>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Speciality:</strong>
{{ Form::text('speciality', null, array('placeholder' => 'speciality','class' => 'form-control')) }}
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Sub-Speciality:</strong>
{{ Form::text('subspeciality', null, array('placeholder' => 'Sub-Speciality','class' => 'form-control')) }}
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Facility:</strong>
{{ Form::text('facility', null, array('placeholder' => 'facility','class' => 'form-control')) }}
</div>
</div>
 <div class="col-xs-12 col-sm-12 col-md-12 text-center">
 <button type="submit" class="btn btn-primary">Submit</button>
 </div>
 </div>
 	{{ Form::close() }}
    </div>
</div>
</div><!--container-->
</div><!--content -->
</div><!--content page-->
@endsection
