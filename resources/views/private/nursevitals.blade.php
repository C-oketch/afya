@extends('layouts.doctor_layout')
@section('title', 'Dashboard')

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
$Duser = $Docdata->user_id;
}

$app_id=$db->appid;
$gender=$db->gender;
$afyaId=$db->afyaId;
$condition = $db->condition;
$afyauserId =$db->id;


 ?>

 @section('leftmenu')
 @include('includes.doc_inc.leftmenu2')
 @endsection
 
 @include('includes.doc_inc.topnavbar_v2')
  @include('doctor.triage')


@endsection
