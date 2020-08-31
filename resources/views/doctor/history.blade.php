@extends('layouts.doctor_layout')
@section('title', 'Patient History')
@section('content')
<?php

         $stat= $pdetails->status;

         $afyauserId= $pdetails->afya_user_id;
         $dependantId= $pdetails->persontreated;
          $app_id= $pdetails->id;
          $doc_id= $pdetails->doc_id;
          $fac_id= $pdetails->facility_id;
          $fac_setup= $pdetails->set_up;
          $dependantAge = $pdetails->depdob;
          $AfyaUserAge = $pdetails->dob;
          $condition = $pdetails->condition;


?>

@section('leftmenu')
@include('includes.doc_inc.leftmenu2')
@endsection
@include('includes.doc_inc.topnavbar_v2')



<div class="row wrapper border-bottom page-heading">
<div class="ibox float-e-margins">
  <div class="col-lg-12">
      <div class="tabs-container">
<?php if ($dependantId =='Self') {
$i =1;
     $triagedetails= DB::table('appointments')
     ->Join('triage_details', 'appointments.id', '=', 'triage_details.appointment_id')
     ->select('triage_details.*','appointments.created_at as visitDate','appointments.id as appid')
     ->where('appointments.afya_user_id', '=',$afyauserId)
     ->orderBy('visitDate', 'desc')
     ->get();
?>
<!-- TRIAGE HISTORY ------------------------------------------------------------>

<div class ="ibox-content">
   <h5>Patient Triage Details</h5>
      <div class="table-responsive ibox-content">
      <table class="table table-striped table-bordered table-hover dataTables-conditional" >
      <thead>
      <tr>
      <th></th>
      <th>Date Of Visit</th>
      <th>Height</th>
      <th>weight</th>
      <th>Temperature</th>
      <th>Systolic BP</th>
      <th>Diastolic BP</th>
      <!-- <th>Chief Compliant</th> -->
      <th>Report</th>

      </tr>
      </thead>

      <tbody>

      @foreach($triagedetails as $triage)
      <tr>
      <td><a href="{{route('visitDetails',$triage->appid)}}">{{ +$i }}</a></td>
      <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->visitDate}}</a></td>
      <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->current_height}}</a></td>
      <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->current_weight}}</a></td>
      <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->temperature}}</a></td>
      <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->systolic_bp}}</a></td>
      <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->diastolic_bp}}</a></td>
      <!-- <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->chief_compliant}}</a></td> -->
      <td><a href="{{route('doctor.medica_report',$triage->appid)}}">Medical Report</a></td>
      </tr>
      <?php $i++; ?>
      @endforeach
      </tbody>
      </table>
      </div>
      </div>
 <?php }  ?>





    </div>
  </div><!-- col md 12" -->
</div><!-- emargis" -->
</div>

@endsection
