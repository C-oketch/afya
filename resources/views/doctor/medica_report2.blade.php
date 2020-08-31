@extends('layouts.doctor_layout')
@section('title', 'Patient History')
@section('content')



<?php
use Carbon\Carbon;
$doc = (new \App\Http\Controllers\DoctorController);
$Docdatas = $doc->DocDetails();
foreach($Docdatas as $Docdata){
$Did = $Docdata->id;
$Name = $Docdata->name;

}
$afyauserId = $user->afyaId;
$apps = DB::table('appointments')
->orderBy('id', 'desc')
->where('afya_user_id', '=',$afyauserId)->first();
$app_id = $apps->id;


$condition = $user->condition;
if($user->persontreated == 'Self'){
  $name = $user->firstname ." ". $user->secondName;
  $gender = $user->gender;
  $dob = $user->dob;
  $age = $user->age;
  $occupation = $user->occupation;
}
if($dob){
$interval = date_diff(date_create(), date_create($dob));
$age= $interval->format(" %Y Years Old");
}else{
$age=$age;
}
$date1=$ptdetails->created_at;

// ('l jS \\of F Y h:i:s A');

$timestamp = strtotime($ptdetails->created_at);
$date1= date("jS", $timestamp);
$date2= date("D F y", $timestamp);

$nextvisit = DB::table('appointments')
->select('appointment_date')
->where([['afya_user_id',$afyauserId],['status','=',0],])
->whereDate('appointment_date','>=',$ptdetails->created_at)
->first();
if($nextvisit){
$timestampnv = strtotime($nextvisit->appointment_date);
$datenv1= date("jS", $timestampnv);
$datenv2= date("D F y", $timestampnv);
}


$height1 =$ptdetails->current_height;
if($height1){
$height =$height1/100;
$BMI2 =$ptdetails->current_weight/($height*$height);
$BMI =number_format((float)$BMI2, 2, '.', '');
}else{
  $BMI ='';
}

$timestampt1 = strtotime($doct->created_at);
$timestampt2 = strtotime($doct->updated_at);
$Time1= date("h:i:s A", $timestampt1);

$intervalT = date_diff(date_create($doct->updated_at), date_create($doct->created_at));
$Time2= $intervalT->format("%h Hour :%i mins");


// $Time2= date("h:i:s A", $timestampt2);

  ?>
@section('leftmenu')
@include('includes.doc_inc.leftmenu')
@endsection

<div class="row wrapper white-bg page-heading">
              <div class="col-lg-6">
                  <h2>PATIENT</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="#">  <strong>Name:</strong> {{$name}}</a>
                      </li>
                      <li>
                          <strong>Gender:</strong> {{$gender}}<br>

                      </li>
                      <li class="active">
                          <strong>Age:</strong> {{$age}}
                      </li>
                  </ol>
              </div>
              <div class="col-lg-6">
                  <div class="title-action">

                      <a href="{{url('doctor.patient_history',$user->appid)}}"  class="btn btn-primary"><i class="fa fa-angle-double-left"></i> BACK </a>
                      <a href="{{url('doctor.edithistory2',$user->appid)}}"  class="btn btn-primary"><i class="fa fa-edit"></i> EDIT </a>
            <input name="b_print" type="button" class="btn btn-primary"   onClick="printdiv('div_print');" value="PRINT">
            <a href="{{url('doctor.slideshow',$afyauserId)}}"  class="btn btn-primary"><i class="fa fa-edit"></i> SLIDE SHOW </a>

                  </div>
              </div>
          </div>





<div class="wrapper wrapper-content">
  <div class="row"  id="div_print">

    <div class="col-lg-10">
      <div class="ibox float-e-margins">
        <div class="ibox-content">
             <table class="table table-bordered">
<tr> <td width="10%"><h3> {{$date1}}</h3> {{$date2}}</td>
  <td width="40%">{{$doct->name}}  <br> {{$doct->FacilityName}} <br>At {{$Time1}} for {{$Time2}} </td>
  <td width="15%">Next Visit @if($nextvisit)<h3>{{$datenv1}} </h3>{{$datenv2}}  @else <br>N/A @endif</td>
<td  width="50%"> <p class="pull-right">{{$name}} <br> {{$gender}} <br> {{$age}}</p></td>
</tr>

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

@if($gender == "Female")
@if($family_planning)
<?php
// $lmp= strtotime($ptdetails->lmp);
// $lmp1= date("jS", $lmp);
// $lmp2= date("F Y", $lmp); ?>
<tr>
 <td colspan="4"><strong>PARITY/FAMILY PLANNING/LMP</strong><br>
 @if($family_planning->parity)<span class="mr-1">{{$family_planning->parity}}</span> @endif
 @if($family_planning->family_planning)<span class="mr-1">{{$family_planning->family_planning}}</span> @endif
 @if($ptdetails->lmp){{$ptdetails->lmp}}@endif</td>

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

<tr><td colspan="4"><strong>FAMILY HISTORY</strong><br>
@if($fsummary)  <p>Father : {{$fsummary->notes}} </p>@endif
@if($msummary)  <p>Mother : {{$msummary->notes}} </p>@endif
@if($bsummary)  <p>Brother : {{$bsummary->notes}} </p>@endif
@if($ssummary) <p> Sister : {{$ssummary->notes}} </p>@endif
</td></tr>

@if($ge)

<tr>
<td colspan="4"><strong>EXAMINATION FINDINGS</strong><br>
  <p><strong class="stats-label">GENERAL EXAMINATION</strong>  {{$ge->g_examination}}</p>

    <p><strong class="stats-label">CVS</strong>{{$ge->cvs}}</p>


    <p><strong class="stats-label">RS</strong>
  {{$ge->rs}}</p>

    <p><strong class="stats-label">PA</strong>
  {{$ge->pa}}</p>

    <p><strong class="stats-label">CNS</strong>
  {{$ge->cns}}</p>

    <p><strong class="stats-label">MSS</strong>
  {{$ge->mss}}</p>

    <p><strong class="stats-label">PERIPHERIES</strong>
      {{$ge->peripheries}}</p>
</td>
</tr>
@endif


@if($tsts)
<tr>
<td colspan="4">
  @foreach($tsts as $tst)
<?php   $imgs = DB::table('lab_images')->select('image')->where('patient_td_id', '=',$tst->ptdid)->get();
?>

TEST  <span class="pull-right">RESULTS  </span><br>
{{$tst->tname}}<span class="pull-right">{{$tst->value}}  </span><br>

  @foreach($imgs as $img)
  <a class="mr-1" href="{{ asset("$img->image") }}  "target="_blank">View Image</a></br>
  @endforeach
  @endforeach
</td>
</tr>
@endif
  @if($rady)
  <tr>
  <td colspan="4">
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

<strong>TEST</strong>  <span class="pull-right"><strong>RESULTS </strong> </span> <br>

{{$test}}    <span class="pull-right">@if($result) {{$result}} @endif</span><hr>

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
    </div>


  </div>

</div>

    @endsection
    @section('script-test')


    @endsection
