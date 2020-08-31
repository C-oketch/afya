@extends('layouts.doctor_layout')
@section('title', 'Transfer')
@section('content')
<?php
$doc = (new \App\Http\Controllers\DoctorController);
$Docdatas = $doc->DocDetails();
foreach($Docdatas as $Docdata){


$Did = $Docdata->id;
$Name = $Docdata->name;
$Address = $Docdata->address;
$RegNo = $Docdata->regno;
$RegDate = $Docdata->regdate;
$Speciality = $Docdata->speciality;
$Sub_Speciality = $Docdata->subspeciality;


}


foreach ($patientD as $pdetails) {
// $patientid = $pdetails->pat_id;
//  $facilty = $pdetails->FacilityName;
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
//$name= $pdetails->firstname;

$now = time(); // or your date as well
$your_date = strtotime($dependantAge);
$datediff = $now - $your_date;
$dependantdays= floor($datediff / (60 * 60 * 24));


if ($dependantId =='Self') {
$dob=$AfyaUserAge;
$gender=$pdetails->gender;
$firstName = $pdetails->firstname;
$secondName = $pdetails->secondName;
$name =$firstName." ".$secondName;
}

else {    $dob=$dependantAge;
$gender=$pdetails->depgender;
$firstName = $pdetails->dep1name;
$secondName = $pdetails->dep2name;
$name =$firstName." ".$secondName;
}


$interval = date_diff(date_create(), date_create($dob));
$age= $interval->format(" %Y Year, %M Months, %d Days Old");



}
?>

@section('leftmenu')
@include('includes.doc_inc.leftmenu2')
@endsection
@include('includes.doc_inc.topnavbar_v2')

<div class="row wrapper border-bottom">
<div class="col-lg-12">
<div class="tabs-container">
<div id="transfer" class="panel-body">
{{ Form::open(array('route' => array('transfer'),'method'=>'POST')) }}
<!-- <div class="form-group col-md-8 col-md-offset-1">
<label for="presc" class="col-md-6">Facility:</label>
<select id="facility" name="facility_to" class="form-control facility1" style="width: 100%"></select>
</div> -->

<div class="form-group col-md-8 col-md-offset-1">
<label class="col-md-6">Facility:</label>
{{ Form::text('facility', null, array('class' => 'form-control')) }}
</div>
<div class="form-group col-md-8 col-md-offset-1">
<label class="col-md-6">Doctor:</label>
{{ Form::text('doc', null, array('class' => 'form-control')) }}
</div>

{{ Form::hidden ('facility_from',$fac_id, array('class' => 'form-control')) }}
{{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
{{ Form::hidden('doc_id',$doc_id, array('class' => 'form-control')) }}


<div class="form-group col-md-8 col-md-offset-1">
<label for="role" class="control-label">Doctor note</label>
{{ Form::textarea('doc_note', null, array('placeholder' => 'note..','class' => 'form-control col-lg-8')) }}
</div>


<div class="form-group  col-md-8 col-md-offset-1">
<button type="submit" class="btn btn-primary">Submit</button>  </td>
</div>
{{ Form::close() }}

</div><!--panel body-->
</div><!--tabs-container-->
</div><!--col12-->
</div>
<!--tabs-->

@endsection
