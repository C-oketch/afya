@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

@include('includes.registrar.topnavbar_v2')
<?php
$facility = DB::table('facility_registrar')
->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
->select('facility_registrar.facilitycode','facilities.set_up')
->where('facility_registrar.user_id', Auth::user()->id)
->first();
$facilitycode = $facility->facilitycode;
$setup = $facility->set_up;

$doctor = DB::table('facility_doctor')
              ->join('doctors', 'facility_doctor.doctor_id', '=','doctors.id' )
              ->select('doctors.name','doctors.id')
              ->where('facility_doctor.facilitycode', '=', $facilitycode)
               ->get();
?>

<div class="wrapper wrapper-content animated fadeInRight">
  {{ Form::open(array('url' => array('nxtappt-reg'),'method'=>'POST')) }}

  <div class="form-group col-md-8 col-md-offset-1">
    <label class="control-label" for="name">Doctor</label>
     <select name="doc" class="form-control required">
               <option value="">Select Doctor</option>
               @foreach($doctor as $doc)
             <option value="{{$doc->id}}">{{$doc->name}}</option>
               @endforeach>
            </select>
    </div>

  <div class="form-group col-md-8 col-md-offset-1" id="data_1">
                <label class="font-normal">Next Doctor Visit</label>
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" class="form-control" name="next_appointment" value="">
                </div>
            </div>
            <div class="form-group col-md-8 col-md-offset-1" id="data_1">
                <label class="font-normal">Time For Visit</label>
                <div class="input-group clockpicker" data-autoclose="true">
              <input type="text" class="form-control" name="next_time" placeholder="09:30" > <span class="input-group-addon">
                      <span class="fa fa-clock-o"></span>   </span>
                    </div>
            </div>


      {{ Form::hidden('afya_user_id',$user->id, array('class' => 'form-control')) }}
   {{ Form::hidden('facility',$facilitycode, array('class' => 'form-control')) }}
  <div class="form-group  col-md-8 col-md-offset-1">
  <button type="SUBMIT" class="btn btn-primary">Submit</button>
  </div>
  {{ Form::close() }}
</div>
@endsection
