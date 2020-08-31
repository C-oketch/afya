@extends('layouts.doctor_layout')
@section('title', 'Patient History')
@section('content')


@section('styles')
<link rel="stylesheet" href="{{ asset('css/plugins/slick/slick.css') }}" />
<link rel="stylesheet" href="{{ asset('css/plugins/slick/slick-theme.css') }}" />

@endsection
<?php $app_id =$appoint->id;
$afyauserId = $appoint->afya_user_id;
$condition = $appoint->condition;
?>
@section('leftmenu')
@include('includes.doc_inc.leftmenu')
@endsection

<div class="row wrapper white-bg page-heading">
<div class="col-lg-8">
<h2>MEDICAL REPORT</h2>
</div>
<div class="col-lg-4">
<div class="title-action">

<a href="{{url('doctor.patient_history',$appoint->id)}}"  class="btn btn-primary"><i class="fa fa-angle-double-left"></i> BACK </a>

</div>
</div>
</div>

<div class="wrapper wrapper-content">

<div class="row">
<div class="col-lg-10 col-lg-offset-1">
<div class="ibox">

<div class="slick_demo_1">




@foreach($appointments as $apps)
<?php

$ptdetails = DB::table('triage_details')->where('appointment_id',$apps->id)->first();
// dd($ptdetails);



$user = DB::table('appointments')
->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
->select('afya_users.firstname','afya_users.secondName','afya_users.dob','afya_users.gender','afya_users.occupation',
'afya_users.age','appointments.persontreated','appointments.id as appid','afya_users.id as afyaId','patient_admitted.condition')
->where('appointments.id', '=',$apps->id)->first();


$doct= DB::table('appointments')
->leftJoin('doctors', 'appointments.doc_id', '=', 'doctors.id')
->leftJoin('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->select('doctors.name','facilities.FacilityName','appointments.created_at','appointments.updated_at')
->where('appointments.id', '=',$apps->id)
->first();
$timestamp = strtotime($apps->created_at);
$date1= date("jS", $timestamp);
$date2= date("D F y", $timestamp);

$nextvisit = DB::table('appointments')
->select('appointment_date')
->where([['afya_user_id',$afyauserId],['status','=',0],])
->whereDate('appointment_date','>=',$apps->created_at)
->first();
if($nextvisit){
$timestampnv = strtotime($nextvisit->appointment_date);
$datenv1= date("jS", $timestampnv);
$datenv2= date("D F y", $timestampnv);
}


$timestampt1 = strtotime($apps->created_at);
$Time1= date("h:i:s A", $timestampt1);
$intervalT = date_diff(date_create($apps->updated_at), date_create($apps->created_at));
$Time2= $intervalT->format("%h Hour :%i mins");

$summary = DB::table('patient_summary')->select('notes')->where('appointment_id', '=',$apps->id)->first();
$cmeds= DB::table('current_medication')->select('drugs')->where('appointment_id', '=',$apps->id)->get();
$ge= DB::table('general_examination')->where('appointment_id', '=',$apps->id)->first();
$systemic = DB::table('patient_systemic')->Join('systematic', 'patient_systemic.systemic_id', '=', 'systematic.id')
->select('systematic.name','patient_systemic.description')->where('appointment_id', '=',$apps->id)->get();


$fsummary = DB::table('family_summary')->where([['afya_user_id',$afyauserId],['family_members',"Father"]])->first();
$msummary = DB::table('family_summary')->where([['afya_user_id',$afyauserId],['family_members',"Mother"]])->first();
$bsummary = DB::table('family_summary')->where([['afya_user_id',$afyauserId],['family_members',"Brother"]])->first();
$ssummary = DB::table('family_summary')->where([['afya_user_id',$afyauserId],['family_members',"Sister"]])->first();

$family_planning = DB::table('family_planning')->where([['afya_user_id',$afyauserId]])->first();

$mcds = DB::table('self_reported_medical_history')->select('name','status')->where('afya_user_id', '=',$afyauserId)->get();
$allergies = DB::table('afya_users_allergy')->select('allergies','status')->where('afya_user_id', '=',$afyauserId)->get();


$tsts = DB::table('appointments')
->Join('patient_test', 'patient_test.appointment_id', '=', 'appointments.id')
->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
->leftJoin('test_results', 'patient_test_details.id', '=', 'test_results.id')
->select('tests.name as tname','test_results.value','patient_test_details.id as ptdid')
->where('appointments.id', '=',$apps->id)
->get();

$rady = DB::table('patient_test')
->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
->select('radiology_test_details.created_at as date','radiology_test_details.test',
'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
'radiology_test_details.id as patTdid','test_categories.name as tcname')
->where('patient_test.appointment_id', '=',$apps->id)
->get();

$prescriptions =DB::table('prescriptions')
->join('prescription_details','prescriptions.id','=','prescription_details.presc_id')
->select('prescription_details.drug_id')
->where([['prescriptions.appointment_id',$apps->id],['prescription_details.deleted',0],])
->get();

$diagnosis = DB::table('patient_diagnosis')
->select('disease_id')
->where('appointment_id', '=',$apps->id)
->orderBy('appointment_id', 'desc')
->get();

$procedures = DB::table('appointments')
->Join('patient_procedure', 'appointments.id', '=', 'patient_procedure.appointment_id')
->Join('procedures', 'patient_procedure.procedure_id', '=', 'procedures.id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->select('procedures.description','patient_procedure.procedure_date','patient_procedure.notes','facilities.FacilityName')
->where('appointments.id', '=',$apps->id)
->orderBy('appointments.id', 'desc')
->get();

$tstsshw = DB::table('appointments')
->Join('patient_test', 'patient_test.appointment_id', '=', 'appointments.id')
->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
->select('patient_test_details.tests_reccommended')
->where('appointments.id', '=',$apps->id)
->first();

$radyshw = DB::table('patient_test')
->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
->select('radiology_test_details.test')
->where('patient_test.appointment_id', '=',$apps->id)
->first();
$reccomendations =DB::table('patient_recommendation')->select('notes')
 ->where('appointment_id',$apps->id)->get();
 $Referral =DB::table('patient_transfer')->select('facility_to','doc_to','note')
 ->where('appointment_id',$apps->id)->first();

  $gender = $user->gender;
?>
<div>
<div class="ibox-content">
<table class="table table-bordered">

<tr> <td width="15%"><h3>{{$date1}} </h3>{{$date2}} </td>
<td width="40%">{{$doct->name}}  <br> {{$doct->FacilityName}} <br>At {{$Time1}} For {{$Time2}} </td>
<td width="15%">Next Visit @if($nextvisit)<h3>{{$datenv1}} </h3>{{$datenv2}} @else <br>N/A @endif</td>
<td  width="30%"> <p class="pull-right">{{$user->firstname}}  {{$user->secondName}}<br> {{$user->gender}} <br> {{$user->age}}</p></td>
</tr>


@if($ptdetails)
<tr>
  <td colspan="4"><strong>TRIAGE </strong><br>
<div class="col-xs-3">
<small class="stats-label">Height </small>
<strong> {{$ptdetails->current_height}}cm</strong>
</div>
<div class="col-xs-3">
<small class="stats-label">Weight </small>
<strong> {{$ptdetails->current_weight}}kg</strong>
</div>
<div class="col-xs-3">
<small class="stats-label">Temperature </small>
<strong> {{$ptdetails->temperature}}°C</strong>
</div>
<div class="col-xs-3">
  <?php if($ptdetails->current_height)
  {
    $height1 =$ptdetails->current_height;
  $height =$height1/100;
  $BMI2 =$ptdetails->current_weight/($height*$height);
  $BMI =number_format((float)$BMI2, 2, '.', '');
  }else{
    $BMI ='';
  }
   ?>
<small class="stats-label">BMI </small>
<strong>@if($BMI){{$BMI}}@endif</strong>
</div>

<div class="col-xs-3">
<small class="stats-label">HR </small>
<strong> {{$ptdetails->hr}}b/min</strong>
</div>

<div class="col-xs-3">
<small class="stats-label">BP</small>
<strong> @if($ptdetails->systolic_bp){{$ptdetails->systolic_bp}} / {{$ptdetails->diastolic_bp}}mmHg @endif</strong>
</div>

<div class="col-xs-3">
<small class="stats-label">SpO2</small>
<strong> {{$ptdetails->rr}}breaths/min</strong>
</div>

<div class="col-xs-3">
<small class="stats-label">RBS </small>
<strong> {{$ptdetails->rbs}}mmol/l </strong>
</div>
  </td>
</tr>
@endif

@if($gender == "Female")
@if($family_planning)

<?php
// $lmp= strtotime($ptdetails->lmp);
// $lmp1= date("jS", $lmp);
// $lmp2= date("D F Y", $lmp);

?>
<tr>
 <td colspan="4"><strong>PARITY/FAMILY PLANNING/LMP</strong><br>
 @if($family_planning->parity)<span class="mr-1">{{$family_planning->parity}}</span> @endif
 @if($family_planning->family_planning)<span class="mr-1">{{$family_planning->family_planning}}</span> @endif
</td>

</tr>

@endif
@endif

@if($summary)
<tr>
<td colspan="4"><strong>PRESENTING COMPLAINTS</strong><br>
@if($summary){{$summary->notes}} <br>@endif</td>
</tr>
@endif

@if($cmeds)
<tr>
<td colspan="4"></strong>CURRENT MEDICATION</strong><br>
@foreach($cmeds as $cmed)
    {{$cmed->drugs}} <br>
 @endforeach</td>
</tr>
@endif
@if($mcds)
<tr>
<td colspan="4"><strong>PAST MEDICAL HISTORY</strong><br>
@foreach($mcds as $mcs)
   <strong class="mr-1">{{$mcs->name}} </strong>  {{$mcs->status}}<br>
@endforeach</td>
</tr>
@endif
@if($allergies)
<tr>
<td colspan="4"><strong>ALLERGIES</strong><br>
@foreach($allergies as $allerg)
   <strong class="mr-1">{{$allerg->allergies}} </strong> {{$allerg->status}}<br>
@endforeach</td>
</tr>
@endif
@if($systemic)
<tr>
<td colspan="4"><strong>SYSTEMIC INQUIRY</strong><br>
@foreach($systemic as $syst)
   <p class="mr-1">{{$syst->name}}  @if($syst->description) <strong class="mr-1 ml-1">Description</strong> {{$syst->description}} @endif </p>
@endforeach</td>
</tr>
@endif
@if($fsummary)
<tr><td colspan="4"><strong>FATHER HISTORY</strong><br><p> {{$fsummary->notes}} </p></td></tr>
@endif
@if($msummary)
<tr><td colspan="4"><strong>MOTHER HISTORY</strong><br><p> {{$msummary->notes}} </p></td></tr>
@endif
@if($bsummary)
<tr><td colspan="4"><strong>BROTHER HISTORY</strong><br><p> {{$bsummary->notes}} </p></td></tr>
@endif
@if($ssummary)
<tr><td colspan="4"><strong>SISTER HISTORY</strong><br><p> {{$ssummary->notes}} </p></td></tr>
@endif

@if($ge)

<tr>
<td colspan="4"><strong>EXAMINATION FINDINGS</strong><br>
<div class="col-xs-3">
<small class="stats-label">GENERAL EXAMINATION</small><br>
<strong>{{$ge->g_examination}}</strong>
</div>
<div class="col-xs-3">
<small class="stats-label">CVS</small><br>
<strong>{{$ge->cvs}}</strong>
</div>
<div class="col-xs-3">
<small class="stats-label">RS</small><br>
<strong>{{$ge->rs}}</strong>
</div>
<div class="col-xs-3">
<small class="stats-label">PA</small><br>
<strong>{{$ge->pa}}</strong>
</div>
<div class="col-xs-3">
<small class="stats-label">CNS</small><br>
<strong>{{$ge->cns}}</strong>
</div>
<div class="col-xs-3">
<small class="stats-label">MSS</small><br>
<strong>{{$ge->mss}}</strong>
</div>
<div class="col-xs-3">
<small class="stats-label">PERIPHERIES</small><br>
<strong>{{$ge->peripheries}}</strong>
</div>
</td>
</tr>
@endif


@if($tstsshw)
<tr>
  <td colspan="4">
  TEST  <span class="pull-right">RESULTS  </span><br>
@foreach($tsts as $tst)
<?php   $imgs = DB::table('lab_images')->select('image')->where('patient_td_id', '=',$tst->ptdid)->get();
?>

{{$tst->tname}}<span class="pull-right">{{$tst->value}}  </span><hr>
@foreach($imgs as $img)
<a class="mr-1" href="{{ asset("$img->image") }}  "target="_blank">View Image</a></br>
@endforeach
@endforeach

</td>
</tr>
@endif
@if($radyshw)
<tr>
<td colspan="4">
  <strong>TEST</strong>  <span class="pull-right"><strong>RESULTS </strong> </span> <br>

@foreach($rady as $radst)
<?php
$test = '';
$result= '';
$rtdid = '';
if ($radst->test_cat_id== '9') {
$ct=DB::table('ct_scan')->where('id', '=',$radst->test) ->first();
$ctresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
$test = $ct->name;
$rtdid =$radst->patTdid;
if($ctresult){  $result = $ctresult->results; }
} elseif ($radst->test_cat_id== 10) {
$xray=DB::table('xray')->where('id', '=',$radst->test) ->first();
$xrayresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
$test = $xray->name;
$rtdid =$radst->patTdid;
if($xrayresult){  $result = $xrayresult->results; }
} elseif ($radst->test_cat_id== 11) {
$mri=DB::table('mri_tests')->where('id', '=',$radst->test)->first();
$mriresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
$test = $mri->name;
$rtdid =$radst->patTdid;
if($mriresult)  { $result = $mriresult->results; }
}elseif ($radst->test_cat_id== 12) {
$ultra=DB::table('ultrasound')->where('id', '=',$radst->test) ->first();
$ultraresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
$test = $ultra->name;
$rtdid =$radst->patTdid;
if($ultraresult) { $result = $ultraresult->results;  }
}elseif ($radst->test_cat_id== 13) {
$other=DB::table('other_tests')->where('id', '=',$radst->test) ->first();
$otherresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
$test = $other->name;
$rtdid =$radst->patTdid;
if($otherresult) { $result = $otherresult->results;}
}

?>


{{$test}}    <span class="pull-right">@if($result) {{$result}} @endif</span>
<hr>
<?php   $imgsrd = DB::table('radiology_images')->select('image')->where('radiology_td_id', '=',$rtdid)->get();  ?>
@foreach($imgsrd as $imgs)
<a class="mr-1" href="{{ asset("$imgs->image") }}  "target="_blank">View Image</a></br>
@endforeach
@endforeach
</td>
</tr>
@endif


@if($diagnosis)
<?php    $i=1; ?>

<tr>
<td colspan="4"><strong>DIAGNOSIS</strong><br>
   @foreach($diagnosis as $tst1)
  <strong class="mr-01">{{$i}}</strong>{{$tst1->disease_id}} <br>
  <?php $i++; ?>
  @endforeach</td>
</tr>
 @endif
@if($procedures)
<tr>
<td colspan="4"><strong>Procedures :</strong><br>
@foreach($procedures as $prc)
{{$prc->description}} <br>
@endforeach</td>
</tr>
@endif

@if($prescriptions)
<?php    $i=1; ?>
<tr>
<td colspan="4"><strong>Prescriptions :</strong><br>
@foreach($prescriptions as $prsc)
<strong class="mr-01">{{$i}}</strong>{{$prsc->drug_id}}<br>
 <?php $i++; ?>
@endforeach</td>
</tr>
@endif



@if($reccomendations)
<?php    $i=1; ?>
<tr>
<td colspan="4"><strong>Recommendation :</strong><br>
@foreach($reccomendations as $prsc)
<strong class="mr-01">{{$i}}</strong> {{$prsc->notes}}<br>
<?php $i++; ?>
@endforeach</td>
</tr>
@endif


@if($Referral)
<tr>
<td colspan="4"><strong>Referral</strong><br>

@if($Referral->facility_to)<span class="mr-01">Facility To :</span> {{$Referral->facility_to}}<br>@endif
@if($Referral->doc_to)<span class="mr-01">Doctor To :</span> {{$Referral->doc_to}}<br>@endif
@if($Referral->note)<span class="mr-01">Notes :</span> {{$Referral->note}}<br>@endif
</td>
</tr>
@endif
</table>
</div>
</div>

@endforeach

</div>
</div>
</div>
</div>



@endsection
@section('script-test')
<!-- slick carousel-->
<script src="{{ asset('js/plugins/slick/slick.min.js') }}" type="text/javascript"></script>

<!-- Additional style only for demo purpose -->
<script>
$(document).ready(function(){
$('.slick_demo_1').slick({
dots: true
});
});
</script>


@endsection
