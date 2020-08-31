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
<div class="row wrapper border-bottom">
<div class="row">
                <div class="col-lg-4">
                    <div class="ibox float-e-margins">

                        <div class="ibox-content">
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

                                @if($user->insurance_company_id)
                                <?php
                                $insurer = DB::table('insurance_companies')
                                         ->select('company_name')
                                         ->where('id', '=', $user->insurance_company_id)
                                         ->first();
                                $insurer = $insurer->company_name;
                                 ?>
                                <tr>
                                    <td><strong> INSURER </strong></td>
                                    <td>{{$insurer}}</td>
                                </tr>
                                <tr>
                                    <td><strong> POLICY NO </strong></td>
                                    <td>{{$user->policy_no}}</td>
                                </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ibox float-e-margins">

                        <div class="ibox-content">
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
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ibox float-e-margins">

                        <div class="ibox-content">
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
                <div>
                  </div>
            </div>

</div>
<?php

$path=DB::table('facility_registrar')
->join('facilities','facility_registrar.facilitycode', '=', 'facilities.FacilityCode')
->select('facilities.path','facility_registrar.facilitycode')->where('facility_registrar.user_id',Auth::user()->id)->first();
 ?>
   @if($path->path == 'stano')
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
<div class="col-sm-8 col-md-offset-3">
  <div class="ibox float-e-margins">
    <div class="ibox-title">
        <!-- <h5>Type of Visit</h5> -->

    </div>
    <div class="ibox-content">
    <form class="form-inline" role="form" method="POST" action="/privateconsultationfee" >
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

<input type="hidden" name="facility" value="{{$path->facilitycode}}">
<input type="hidden" class="form-control" value="{{$user->id}}" name="id"  required>

<div class="form-group">
<label class="control-label" for="name">Type of Visit</label>
 <select name="visit" class="form-control required">
           <option selected disabled value="">Select visit type</option>
           <option value="normal">Normal Visit</option>
           <option value="triage">Follow up with triage</option>
           <option value="no_triage">Follow up without triage</option>
        </select>
       </div>

        <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
    {!! Form::close() !!}

    </div>
  </div>
</div>
</div>
</div>

 @endif

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-4">
                    <h2>Action</h2>
                </div>
                <div class="col-lg-8">
                    <div class="title-action">

              <div class="col-lg-4">
                      <a href="{{ URL('register_edit_patient', $user->id) }}"  class="btn btn-primary pull-left"><i class="fa fa-print"></i> Update Patient Details </a>
                </div>
                @if($path->path == 'stano')
                 <div class="col-lg-4">
                      <a href="{{ URL('registrar.histdata', $user->id) }}"  class="btn btn-primary"><i class="fa fa-print"></i> Historical Details </a>
  </div>     @endif
  @if($path->path == 'nguchu')
  <div class="col-lg-4">
                        <a href="{{ URL('registrarp.Reg_feespay', $user->id) }}"  class="btn btn-primary  pull-right"><i class="fa fa-money"></i> Consultation Fee </a>
                    </div>
                    @endif
                  </div>
                </div>
            </div>


@endsection

@section('script-reg')


@endsection
