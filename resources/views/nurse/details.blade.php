@extends('layouts.nurse_layout')
@section('title', 'Nurse Dashboard')


@section('content')
<?php   $pat=$patient->id;  ?>
@section('leftmenu')
@include('includes.nurse_inc.leftmenu2')
@endsection
@include('includes.nurse_inc.topnavbar')
<div class="row">
<br><br>
<div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Patient Details</h5>
      </div>
      <div class="ibox-content">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

 {!! Form::open(array('route' => 'createdetail','method'=>'POST')) !!}
    <div class="col-md-6">

    <input type="hidden" class="form-control" value="{{$patient->id}}" name="id"  required>
        <input type="hidden" class="form-control" value="{{$patient->appid}}" name="appointment_id"  required>
    <div class="form-group">
    <label for="exampleInputEmail1">Weight (kg)</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="80" name="weight"  required>
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">Height (cm)</label>
    <input type="text" class="form-control" placeholder="200" name="current_height" required>
    </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Temperature °C</label>
    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="37.2" name="temperature"  required>
   </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Systolic BP</label>
    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="110" name="systolic"  required>
    </div>

    </div>
    <div class="col-md-6">

    <div class="form-group">
    <label for="exampleInputEmail1">Diastolic BP</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="60 - 110" name="diastolic"  required>
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">RBS mmol/l</label>
    <input type="name" class="form-control"  aria-describedby="emailHelp" placeholder="RBS mmol/l" name="rbs">
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">HR b/min</label>
    <input type="name" class="form-control"  aria-describedby="emailHelp" placeholder="HR b/min" name="hr">
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">RR breaths/min</label>
    <input type="name" class="form-control"  aria-describedby="emailHelp" placeholder="RR breaths/min" name="rr">
    </div>
</div>

    <button type="submit" class="btn btn-primary">SUBMIT</button>
     {!! Form::close() !!}

    </div>
    </div>
  </div>
</div>


  @endsection
  @section('script')

@endsection
