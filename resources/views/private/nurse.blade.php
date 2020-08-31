@extends('layouts.private')
@section('title', 'Patient Details')
@section('style')
<link rel="stylesheet" href="{{asset('css/plugins/slick/slick.css') }}" />
<link rel="stylesheet" href="{{asset('css/plugins/slick/slick-theme.css') }}" />
@endsection
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-md-12">
<br /><br />
<div class="col-md-4">
<address>
<strong>PATIENT BASIC DETAILS:</strong><br>
Name: {{$patient->firstname}}  {{$patient->secondName}}<br>
Gender: {{$patient->gender}} <br>
Age: {{$patient->age}} <br />
Blood Type: {{$patient->blood_type or ''}} <br />

</address>
</div>

<div class="col-md-4">
<address>
<strong>PATIENT ADDRESS DETAILS :</strong><br>

Phone : {{$patient->msisdn}}  <br />
Constituency :<?php
if ($patient->constituency != "") {$county=DB::Table('constituency')->where('id',$patient->constituency)->first();
echo $county->Constituency;}
else{ echo "";} ?>  <br />
County : <?php
if ($patient->constituency != "") {$county=DB::Table('county')->where('id',$county->cont_id)->first();
echo $county->county;}
else{ echo "";} ?>
</address>
</div>
<div class="col-md-4 text-right">
<address>

<strong>Next of Kin Details :</strong><br>
@if(is_null($kin))
No Kin Details
@else

Name: {{$kin->kin_name}}<br>
Relationship : {{$kin->relation}} <br>
Phone :{{$kin->phone_of_kin}} <br>
@endif

</address>
</div>
</div>
</div>
<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">

          <ol class="breadcrumb">
              <li>
                  <a href="index.html">Add</a>
              </li>
              <li>
                Patient
              </li>
              <li class="active">
                  <strong>Triage</strong>
              </li>


          <li class="pull-right">
            <a href="{{ url('nurseVitals', $patient->id) }}" class="btn btn-primary btn-sm">ADD VITALS</a>
          </li>
      </ol>
      </div>
  </div>

@endsection

@section('script')

</script>

@endsection
