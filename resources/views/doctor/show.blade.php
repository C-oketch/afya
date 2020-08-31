@extends('layouts.doctor_layout')
@section('title', 'Triage')
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
$set_up = $Docdata->set_up;
}
?>

<?php
foreach ($patientdetails as $pdetails) {

   $stat= $pdetails->status;
   $afyauserId= $pdetails->afya_user_id;
    $dependantId= $pdetails->persontreated;
    $app_id_prev= $pdetails->last_app_id;
    $app_id =  $pdetails->appid;
    $doc_id= $pdetails->doc_id;
    $fac_id= $pdetails->facility_id;
    $fac_setup= $pdetails->set_up;
    $dependantAge = $pdetails->depdob;
    $AfyaUserAge = $pdetails->dob;
    $condition = $pdetails->condition;



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

else {
     $dob=$dependantAge;
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

      <!-- @include('doctor.path') -->

<!--tabs Menus-->


  <div class="row wrapper border-bottom white-bg page-heading">
                  <div class="col-lg-4">
                      <h2>Actions</h2>
                      <ol class="breadcrumb">
                          <li>
                              <a href="index.html">Home</a>
                          </li>

                          <li class="active">
                              <strong>Patient Details</strong>
                          </li>
                      </ol>
                  </div>
                  <div class="col-lg-6">
                      <div class="title-action">
                        <a href="{{ route('doctor.histdetails',$app_id) }}" class="btn btn-primary"><i class="fa fa-print"></i> Edit Details </a>
                      </div>
                  </div>
              </div>

@include('doctor.first_time')

<!--tabs-->
@endsection
@section('script')


@endsection
