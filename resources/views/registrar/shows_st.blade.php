@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('style')
@endsection
@section('content')
@include('includes.registrar.topnavbar_v2')
<?php
 $Constituency='';
$patient=DB::Table('kin_details')->where('afya_user_id',$user->id)->first();
 $kin = DB::table('kin')->get();
 if($user->constituency){
$countys=DB::Table('constituency')->where('id',$user->constituency)->first();

$usercounty=$countys->Constituency;
}else{$usercounty=''; }
?>
<div class="container">
<div class="row">
<div class="col-md-11">
  <div class="ibox float-e-margins">
    <div class="tabs-container">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs">
          <li class="active"><a href="#Section1">BASIC DETAILS</a></li>
          <li class=""><a href="{{ URL('register_edit_patient', $user->id) }}"><i class="fa fa-print"></i>UPDATE PATIENT DETAILS</a></li>

          <!-- <li role="presentation" class=""><a href="{{ URL('registrar.histdata', $user->id) }}"><i class="fa fa-print"></i>HISTORICAL DATA</a></li> -->
    </ul>
    <div class="wrapper wrapper-content animated fadeIn">

      <div class="row">
      <div class="col-sm-12">
      <div class="ibox float-e-margins">
      <div class="ibox-title">
      <h5>Send To Doctor</h5>
      </div>
      <div class="ibox-content">
      <form class="form-inline" role="form" method="POST" action="/privateconsultationfee" >


      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="facility" value="{{$path->facilitycode}}">
      <input type="hidden" class="form-control" value="{{$user->id}}" name="id">
      <input type="hidden" class="form-control" value="{{$appointment}}" name="appointment">

      <div class="form-group mr-1 ">
      <label class="control-label" for="name">Type of Visit</label>
      <select name="visit" class="form-control" required>
      <option value="">Select visit type</option>
      <option value="normal">Normal Visit</option>
      <option value="triage">Follow up with triage</option>
      <option value="no_triage">Follow up without triage</option>
      </select>
      </div>

<button type="submit" class="btn btn-primary">Submit</button>
{!! Form::close() !!}

      </div>
      </div>
      </div>
      <div>
      </div>
      </div>


      <div class="p-w-md m-t-sm">
        <div class="row">
          <div class="col-lg-4">
                <table class="table table-hover no-margins">
                          <thead>
                          <tr>
                              <th colspan="2">PATIENT BASIC INFO</th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                              <td>  <strong>Name  </strong></td>
                              <td>{{$user->firstname}}  {{$user->secondName}}</td>
                          </tr>
                          <tr>
                              <td><strong>Gender  </strong> </td>
                              <td>{{$user->gender}}</td>
                          </tr>
                          <tr>
                              <td><strong>Date Of Birth </strong></td>
                              <td>{{$user->dob}}</td>
                          </tr>
                          <tr>
                              <td><strong>Place of Birth </strong></td>
                              <td>{{$user->pob}}</td>
                          </tr>
                          <tr>
                              <td><strong>Id </strong></td>
                              <td>{{$user->nationalId}}</td>
                          </tr>
                          <tr>
                              <td><strong>  NHIF </strong></td>
                              <td>{{$user->nhif}}</td>
                          </tr>

                          @foreach ($insurance as $ins)

                          <tr>
                            <td><strong> INSURER </strong></td>
                            <td>{{$ins->company_name}}</td>
                          </tr>
                          <tr>
                            <td><strong> POLICY NO </strong></td>
                            <td>{{$ins->policy_no}}</td>
                          </tr>
                          @endforeach

                          </tbody>
                      </table>
                  </div>

                  <div class="col-lg-4">
                  <table class="table table-hover no-margins">
                  <thead>
                  <tr>
                  <th colspan="2">Contact Details</th>

                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                  <td><strong>Phone </strong> </td>
                  <td>{{$user->msisdn}}</td>
                  </tr>
                  <tr>
                  <td>  <strong>Email </strong> </td>
                  <td>{{$user->email}}</td>
                  </tr>
                  <tr>
                  <td><strong>Constituency </strong> </td>
                  <td>{{$usercounty }}</td>
                  </tr>

                  <tr>
                  <td></td>
                  <td></td>
                  </tr>

                  </tbody>
                  </table>
                  </div>

                  <div class="col-lg-4">
                  <table class="table table-hover no-margins">
                  <thead>
                  <tr>
                  <th colspan="2">Next Of Kin Details</th>

                  </tr>
                  </thead>
                  <tbody>
                  @if($patient)
                  <tr>
                  <td><strong>Name </strong></td>
                  <td>{{$patient->kin_name}}</td>
                  </tr>
                  <tr>
                  <td><strong>Relation </strong><br></td>
                  <?php $relate = DB::Table('kin')->where('id',$patient->relation)->first();?>
                  <td>{{$relate->relation}}</td>
                  </tr>

                  <tr>
                  <td><strong>Phone  </strong></td>
                  <td>{{$patient->phone_of_kin}}</td>

                  </tr>
                  <tr>
                  <td></td><td></td>

                  </tr>
                  @endif
                  </tbody>
                  </table>
                  </div>


        </div>
      </div>
    </div>




      <!-- Tab panes -->
      <div class="tab-content tabs">
          <div role="tabpanel" class="tab-pane fade in active" id="Section1">






          </div>
       </div>
      </div>
    </div>
  </div>
</div>
  </div>
@endsection
@section('script-reg')

@endsection
