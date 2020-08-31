@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')

@section('style')
<link rel="stylesheet" href="{!! asset('css/plugins/steps/jquery.steps.css') !!}" />
@endsection

@section('content')
<?php $user=DB::table('afya_users')->where('id',$id)->first();
$patient=DB::Table('kin_details')->where('afya_user_id',$user->id)->first();
$kin = DB::table('kin')->get();
$kinbit = DB::table('kin')->where('id',$user->id)->first();
$countys='';
if($user->constituency){
  $countys=DB::Table('constituency')->where('id',$user->constituency)->first();
  $usercounty=$countys->Constituency;
}else{$usercounty=''; }
?>
@include('includes.registrar.topnavbar_v2')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Patient Details</h2>
  </div>
  <div class="col-lg-2">
    <br>
    <a href="{{ url('registrar.shows',$user->id) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <form role="form"  method="POST" action="/reg_updateusers" >

          <div class="ibox-content">
            <div id="wizard">

              <h1>Basic Info</h1>
              <div class="step-content">
                <div class="col-sm-6 b-r">

                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="afya_user_id" value="{{$user->id}}">


                  <div class="form-group col-lg-6">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="first" placeholder="first name" value="{{$user->firstname }}"  required=""/>
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Second Name</label>
                    <input type="text" class="form-control" placeholder="surname/Second Name" value="{{$user->secondName}}" name="second"  required=""/>
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Place of Birth</label>
                    <input type="text" class="form-control" name="pob" placeholder="" value="{{$user->pob}}" />
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Gender:</label>
                    <select class="form-control" name="gender">
                      <option value="">Please select one</option>
                      <option value="Female" @if($user->gender== 'Female') selected @endif >Female</option>
                      <option value="Male" @if($user->gender== 'Male') selected @endif >Male</option>
                      <option value="others" @if($user->gender== 'others') selected @endif >Other</option>
                  </select>
                  </div>
  <div class="form-group col-lg-6">
                  <label>Marital Status</label>
                  <select class="form-control select2_demo_1" name="marital">
                    <option value="Not Specified" @if($user->marital== 'Not Specified') selected @endif >Not Specified</option>
                    <option value="Single" @if($user->marital== 'Single') selected @endif >Single</option>
                    <option value="Married" @if($user->marital== 'Married') selected @endif >Married</option>
                    <option value="Divorced" @if($user->marital== 'Divorced') selected @endif >Divorced</option>
                  </select>
                </div>

                <?php  $blood=DB::table('blood_types')->get();
                $const=DB::table('constituency')->get();
                ?>
        <div class="form-group col-lg-5">
                  <label>Blood Type</label>
                  <select class="form-control select2_demo_1" name="bloodtype" >
                    <option value="{{$user->blood_type}}">{{$user->blood_type}}</option>

                    @foreach ($blood as $type)
                    <option value="{{$type->type}}">{{$type->type}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-lg-6" id="data_21">
                  <label>Date of Birth</label>
                  <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" class="form-control" value="{{ $user->dob}}" name="dob" />
                  </div>
                </div>
              </div>
              <div class="col-sm-6">

                <div class="form-group col-lg-6">
                  <label>Occupation</label>
                  <input type="text" class="form-control" name="occupation" placeholder="" value="{{$user->occupation}}" />
                </div>

                <div class="form-group col-lg-6">
                  <label>ID Number</label>
                  <input type="text" class="form-control" value="{{ $user->nationalId }}"  name="nationalId" />
                </div>
                <div class="form-group col-lg-6">
                  <label for="exampleInputEmail1">K.R.A PIN</label>
                  <input type="text" class="form-control"  value="{{$user->kra_pin}}" id="kra" name="kra" />
                </div>

                <div class="form-group col-lg-6">
                  <label>Constituency of Residence</label>
                  <select class="form-control select2_demo_1"  name="constituency">
                    @if($countys)
                    <option value="{{$countys->id}}">{{$usercounty}}</option>
                    @endif
                    @foreach ($const as $cost)
                    <option value="{{$cost->id}}">{{$cost->Constituency}}</option>
                    @endforeach
                  </select>
                </div>



              <div class="form-group  col-lg-6">
                <label>Do you have a smartphone?</label>
              <label class="checkbox-inline">  <input type="radio" value="yes"  name="smartphone" <?php echo ($user->has_smartphone =='yes')?'checked':'' ?> >Yes</label>
              <label class="checkbox-inline">  <input type="radio" value="no"  name="smartphone" <?php echo ($user->has_smartphone =='no')?'checked':'' ?> >No</label>
              </div>
            </div>
          </div>
          <h1>NHIF & INSURANCE DETAILS</h1>
          <div class="step-content">
            <div class="col-sm-6 b-r">

              <div class="form-group">
                <label>NHIF Number</label>
                <input type="text" class="form-control" value="{{$user->nhif}}"  name="nhif"/>
              </div>


            </div>
            <div class="col-sm-6">

              <div class="form-group ">
                <?php   $insurances=DB::table('insurance_companies')->get();   ?>
                <label>Insurance company</label>
                <select class="form-control select2_demo_1" name="insurance_company" >
                   <option selected disabled value="">Select insurance company</option>
                  @foreach ($insurances as $insurance)
                  <option value="{{$insurance->id}}">{{$insurance->company_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Policy No</label>
                <input type="text" class="form-control" name="policy_no"/>
              </div>


            </div>
          </div>

          <h1>CONTACT DETAILS</h1>
          <div class="step-content">
            <div class="col-sm-6 b-r">
              <div class="form-group">
                <label >Phone (2547---)</label>
                <input type="text" class="form-control" value="{{ $user->msisdn }}" id="phone" name="phone" />
              </div>
              <div class="form-group ">
                <label>Email</label>
                <input type="email" class="form-control"  value="{{$user->email }}" name="email"/>
              </div>
              <div class="form-group">
                <label>Postal Address</label>
                <input type="text" class="form-control" name="paddress" value="{{$user->postal_address}}" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Postal Code</label>
                <input type="text" class="form-control" name="code" value="{{$user->postal_code}}"/>
              </div>
              <div class="form-group">
                <label>Town</label>
                <input type="text" class="form-control" name="town" value="{{$user->town}}" />
              </div>
            </div>
          </div>
          <h1>NEXT OF KIN DETAILS</h1>
          <div class="step-content">
            <div class="col-sm-6 b-r">
              <div class="form-group">
                <label >Name</label>
                <input type="text" class="form-control" value="@if($patient){{ $patient->kin_name }}@endif"  name="kin_name" />
              </div>
              <div class="form-group">
                <label>Relation</label>
                <select class="form-control select2_demo_1"  name="relation" >
                  @if($kinbit) <option value="{{$kinbit->id}}">{{$kinbit->relation}}</option>@endif
                  @foreach ($kin as $cost)
                  <option value="{{$cost->id}}">{{$cost->relation}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone_of_kin" value="@if($patient){{$patient->phone_of_kin}}@endif" />
              </div>
              <div class="form-group">
                <label>Postal Address</label>
                <input type="text" class="form-control" name="kin_postal" value="@if($patient){{$patient->postal}}@endif"/>
              </div>
            </div>
            <button class="btn btn-sm btn-primary"  type="submit"><strong>Submit</strong></button>

            {!! Form::close() !!}
          </div>

        </div>

      </div>
    </div>
  </div>
</div>
</div>
@endsection
@section('script-reg')
<script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}" type="text/javascript"></script>

<script>
$(document).ready(function() {
  // Smart Wizard
  $("#wizard").steps();
  $('#data_21 .input-group.date').datepicker({
    startView: 1,
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    format: "yyyy-mm-dd"
  });

  $(".select2_demo_1").select2({ width: '100%' });

});


</script>
@endsection
