@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

@include('includes.registrar.topnavbar_v2')

  <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
          <div class="col-lg-5">
                  <div class="jumbotron">
                      <h1>NEXT</h1>
                      <p>Select visit Type and Doctor to be seen By the Patient. --></p>
                      <p><a href="http://www.jquery-steps.com/GettingStarted" target="_blank" class="btn btn-primary btn-lg" role="button">For Consultation Fee Receipt</a>
                      </p>
                  </div>
              </div>
          <div class="col-lg-5">
                  <div class="ibox float-e-margins">
                      <div class="ibox-title">
                          <h5>Visit Type</h5>

                      </div>
                      <div class="ibox-content">

                            <form class="form-horizontal" role="form" method="POST" action="/visit" >
                              @if (count($errors) > 0)
                                  <div class="alert alert-danger">
                                      <ul>
                                          @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                          @endforeach
                                      </ul>
                                  </div>
                              @endif

                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                              <input type="hidden" class="form-control" value="{{$user->appid}}" name="appointment_id"  required>
<?php
$doctor = DB::table('facility_doctor')
              ->join('doctors', 'facility_doctor.doctor_id', '=','doctors.id' )
              ->select('doctors.name','doctors.id')
              ->where('facility_doctor.facilitycode', '=', $user->facility_id)
               ->get();
?>
                              <div class="form-group">
                              <label class="control-label" for="name">Visit Type</label>
                               <select name="visit" class="form-control required">
                                         <option value="">Select reason</option>
                                         <option value="normal">Normal Visit</option>
                                         <option value="triage">Follow up with triage</option>
                                         <option value="no_triage">Follow up without triage</option>
                                      </select>
                                     </div>


                                <div class="form-group">
                                  <label class="control-label" for="name">Doctor</label>
                                   <select name="doc" class="form-control required">
                                             <option value="">Select Doctor</option>
                                             @foreach($doctor as $doc)
                                           <option value="{{$doc->id}}">{{$doc->name}}</option>
                                             @endforeach>
                                          </select>
                                  </div>

                              <div class="form-group">
                                  <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
                                  </div>
                              </div>
                        {!! Form::close() !!}
                      </div>
                  </div>
              </div>

  </div>
</div>



@endsection
