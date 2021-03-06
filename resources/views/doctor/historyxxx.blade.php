@extends('layouts.doctor_layout')
@section('title', 'Patient History')
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
      $now = time(); // or your date as well
      $your_date = strtotime($dependantAge);
      $datediff = $now - $your_date;
      $dependantdays= floor($datediff / (60 * 60 * 24));


  $interval = date_diff(date_create(), date_create($dob));
  $age= $interval->format(" %Y Year, %M Months, %d Days Old");



}
?>
@include('includes.doc_inc.topnavbar_v2')


<!--tabs Menus-->
  @include('includes.doc_inc.headmenu')
<!--tabs Menus-->

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
      <th>Chief Compliant</th>
      <th>Observation</th>

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
      <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->chief_compliant}}</a></td>
      <td><a href="{{route('doctor.medica_report',$triage->appid)}}">Medical Report</a></td>
      </tr>
      <?php $i++; ?>
      @endforeach
      </tbody>
      </table>
      </div>
      </div>
<!-- TEST HISTORY ------------------------------------------------------------>

      <?php
      $i=1;
      $tstdone = DB::table('appointments')
      ->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
      ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
     ->select('facilities.FacilityName','doctors.name as docname','patient_test.created_at','patient_test.test_status'
      ,'patient_test.id as ptid','appointments.id as appid')
     ->where('appointments.afya_user_id', '=',$afyauserId)
      ->orderBy('created_at', 'desc')
      ->get();

         ?>
  <div class ="ibox-content">
      <h5>Patient Test Details</h5>
        <div class="table-responsive ibox-content">
         <table class="table table-striped table-bordered table-hover dataTables-conditional" >
           <thead>
             <tr>
               <th></th>
               <th>Date </th>
               <th>Facility</th>
               <th>Doctor</th>
              <th>Action</th>
             </tr>
           </thead>
     <tbody>
     @foreach($tstdone as $tstdn)
     <tr>
         <td><a href="{{route('visitDetails',$tstdn->appid)}}">{{$i}}</a></td>
         <td><a href="{{route('visitDetails',$tstdn->appid)}}">{{$tstdn->created_at}}</a></td>
         <td>{{$tstdn->FacilityName}}</td>
         <td>{{$tstdn->docname}}</td>
         <td><a href="{{route('tstdetails',$tstdn->ptid)}}">View</a></td>

     </tr>
     <?php $i++; ?>

     @endforeach

     </tbody>
     </table>
     </div>
   </div>
   <!-- Prescription HISTORY ------------------------------------------------------------>

     <?php
       $prescriptions = DB::table('appointments')
       ->Join('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
       ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
       ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('facilities.FacilityName','doctors.name as docname','prescriptions.created_at','prescriptions.filled_status'
       ,'prescriptions.id as prescid','appointments.id as appid')
    ->where('appointments.afya_user_id', '=',$afyauserId)
        ->orderBy('prescriptions.created_at', 'desc')
         ->get();
       ?>
<div class ="ibox-content">
     <h5>Prescription History</h5>
     <div class="table-responsive ibox-content">
     <table class="table table-striped table-bordered table-hover dataTables-conditional" >
     <thead>
       <tr>
         <th></th>
         <th>Date </th>
         <th>Facility</th>
         <th>Doctor</th>
        <th>Action</th>
       </tr>
     </thead>

     <tbody>
     <?php $i =1; ?>

     @foreach($prescriptions as $tstdn)
     <tr>
     <td><a href="{{route('visitDetails',$tstdn->appid)}}">{{ +$i }}</a></td>
     <td><a href="{{route('visitDetails',$tstdn->appid)}}">{{$tstdn->created_at}}</a></td>
     <td>{{$tstdn->FacilityName}}</td>
     <td>{{$tstdn->docname}}</td>
     <td><a href="{{route('prscdetails',$tstdn->prescid)}}">View</a></td>
     </tr>
     <?php $i++; ?>

     @endforeach

     </tbody>
     </table>
     </div>
</div>
<!-- Diagnosis HISTORY ------------------------------------------------------------>

  <?php
$diagnosis = DB::table('appointments')
->Join('patient_diagnosis', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
->Join('icd10_option', 'patient_diagnosis.disease_id', '=', 'icd10_option.id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->select('icd10_option.name','patient_diagnosis.date_diagnosed','facilities.FacilityName','appointments.id as appid')
->where('appointments.afya_user_id', '=',$afyauserId)
->orderBy('appointments.id', 'desc')
->get();
    ?>
<div class ="ibox-content">
  <h5>Diagnosis History</h5>
  <div class="table-responsive ibox-content">
  <table class="table table-striped table-bordered table-hover dataTables-conditional" >
  <thead>
    <tr>
      <th></th>
      <th>Date Diagnosed</th>
      <th>Condition</th>
      <th>Facility</th>
    </tr>
  </thead>

  <tbody>
  <?php $i =1; ?>

  @foreach($diagnosis as $diag)
  <tr>
  <td><a href="{{route('visitDetails',$diag->appid)}}">{{ +$i }}</a></td>
  <td><a href="{{route('visitDetails',$diag->appid)}}">{{$diag->date_diagnosed}}</a></td>
  <td>{{$diag->name}}</td>
  <td>{{$diag->FacilityName}}</td>
  </tr>
  <?php $i++; ?>

  @endforeach

  </tbody>
  </table>
  </div>
</div>

<!-- Procedure HISTORY ------------------------------------------------------------>

  <?php
  $procedures = DB::table('appointments')
  ->Join('patient_procedure', 'appointments.id', '=', 'patient_procedure.appointment_id')
  ->Join('procedures', 'patient_procedure.procedure_id', '=', 'procedures.id')
  ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->select('procedures.description','patient_procedure.procedure_date','patient_procedure.notes','facilities.FacilityName','appointments.id as appid')
  ->where('appointments.afya_user_id', '=',$afyauserId)
  ->orderBy('appointments.id', 'desc')
  ->get();
    ?>
<div class ="ibox-content">
  <h5>Procedure History</h5>
  <div class="table-responsive ibox-content">
  <table class="table table-striped table-bordered table-hover dataTables-conditional" >
  <thead>
    <tr>
      <th></th>
      <th>Procedure Date</th>
      <th>Condition</th>
      <th>Notes</th>
      <th>Facility</th>
    </tr>
  </thead>

  <tbody>
  <?php $i =1; ?>

  @foreach($procedures as $proc)
  <tr>
  <td><a href="{{route('visitDetails',$proc->appid)}}">{{ +$i }}</a></td>
  <td><a href="{{route('visitDetails',$proc->appid)}}">@if($proc->procedure_date){{$proc->procedure_date}}@else Not Set @endif</a></td>
  <td><a href="{{route('visitDetails',$proc->appid)}}">{{$proc->description}}</a></td>
  <td>{{$proc->notes}}</td>
  <td>{{$proc->FacilityName}}</td>
  </tr>
  <?php $i++; ?>

  @endforeach

  </tbody>
  </table>
  </div>
</div>

<!-- DEPENDANT STUFF ------------------------------------------------------------>

<?php     }else{

$i =1;
$triagedetails= DB::table('appointments')
->Join('triage_infants', 'appointments.id', '=', 'triage_infants.appointment_id')
->select('triage_infants.*','appointments.created_at as visitDate','appointments.id as appid')
->where('appointments.persontreated', '=',$dependantId)
->orderBy('visitDate', 'desc')
->get();
?>
<!-- Triage HISTORY ------------------------------------------------------------>

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
     <th>Chief Compliant</th>
     <th>Observation</th>
     <th>Notes</th>
  </tr>
  </thead>

  <tbody>

  @foreach($triagedetails as $triage)
    <tr>
   <td><a href="{{route('visitDetails',$triage->appid)}}">{{ +$i }}</a></td>
   <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->visitDate}}</a></td>
   <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->height}}</a></td>
   <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->weight}}</a></td>
   <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->temperature}}</a></td>
   <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->systolic_bp}}</a></td>
  <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->diastolic_bp}}</a></td>
  <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->chief_compliant}}</a></td>
  <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->observation}}</a></td>
  <td><a href="{{route('visitDetails',$triage->appid)}}">{{$triage->nurse_notes}}</a></td>

  </tr>
  <?php $i++; ?>

  @endforeach

  </tbody>
    </table>
     </div>
<!-- TEST HISTORY ------------------------------------------------------------>
      <?php
      $i=1;
      $tstdone = DB::table('appointments')
      ->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
      ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
     ->select('facilities.FacilityName','doctors.name as docname','patient_test.created_at','patient_test.test_status'
      ,'patient_test.id as ptid','appointments.id as appid')
       ->Where('appointments.persontreated', '=',$dependantId)
      ->orderBy('created_at', 'desc')
      ->get();
         ?>
<div class ="ibox-content">
       <h5>Patient Test Details</h5>
         <div class="table-responsive ibox-content">
          <table class="table table-striped table-bordered table-hover dataTables-conditional" >
            <thead>
              <tr>
                <th></th>
                <th>Date </th>
                <th>Facility</th>
                <th>Doctor</th>
               <th>Action</th>
              </tr>
            </thead>
      <tbody>
    @foreach($tstdone as $tstdn)
      <tr>
          <td><a href="{{route('visitDetails',$tstdn->appid)}}"> {{$i}}</a></td>
          <td><a href="{{route('visitDetails',$tstdn->appid)}}"> {{$tstdn->created_at}}</a></td>
          <td>{{$tstdn->FacilityName}}</td>
          <td>{{$tstdn->docname}}</td>
          <td><a href="{{route('tstdetails',$tstdn->ptid)}}">View</a></td>

      </tr>
      <?php $i++; ?>

      @endforeach

      </tbody>
      </table>
      </div>
      </div>
      <!-- Prescription HISTORY ------------------------------------------------------------>

      <?php

        $prescriptions = DB::table('appointments')
        ->Join('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
        ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
        ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
       ->select('facilities.FacilityName','doctors.name as docname','prescriptions.created_at','prescriptions.filled_status'
        ,'prescriptions.id as prescid','appointments.id as appid')
       ->Where('appointments.persontreated', '=',$dependantId)
         ->orderBy('prescriptions.created_at', 'desc')
          ->get();
        ?>
<div class ="ibox-content">
      <h5>Prescription History</h5>
      <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-conditional" >
      <thead>
        <tr>
          <th></th>
          <th>Date </th>
          <th>Facility</th>
          <th>Doctor</th>
         <th>Action</th>
        </tr>
      </thead>

      <tbody>
      <?php $i =1; ?>

      @foreach($prescriptions as $tstdn)
      <tr>
      <td><a href="{{route('visitDetails',$tstdn->appid)}}">{{ +$i }}</a></td>
      <td><a href="{{route('visitDetails',$tstdn->appid)}}">{{$tstdn->created_at}}</a></td>
      <td>{{$tstdn->FacilityName}}</td>
      <td>{{$tstdn->docname}}</td>
      <td><a href="{{route('prscdetails',$tstdn->prescid)}}">View</a></td>
      </tr>
      <?php $i++; ?>
     @endforeach

      </tbody>
      </table>
      </div>
   </div>

   <!-- Diagnosis HISTORY ------------------------------------------------------------>

     <?php
       $diagnosisd = DB::table('appointments')
       ->Join('patient_diagnosis', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
       ->Join('icd10_option', 'patient_diagnosis.disease_id', '=', 'icd10_option.id')
       ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
    ->select('icd10_option.name','patient_diagnosis.date_diagnosed','facilities.FacilityName','appointments.id as appid')
      ->Where('appointments.persontreated', '=',$dependantId)
       ->orderBy('appointments.id', 'desc')
         ->get();
       ?>
   <div class ="ibox-content">
     <h5>Diagnosis History</h5>
     <div class="table-responsive ibox-content">
     <table class="table table-striped table-bordered table-hover dataTables-conditional" >
     <thead>
       <tr>
         <th></th>
         <th>Date Diagnosed</th>
         <th>Condition</th>
         <th>Facility</th>
       </tr>
     </thead>

     <tbody>
     <?php $i =1; ?>

     @foreach($diagnosisd as $diag)
     <tr>
     <td><a href="{{route('visitDetails',$diag->appid)}}">{{ +$i }}</a></td>
     <td><a href="{{route('visitDetails',$diag->appid)}}">{{$diag->date_diagnosed}}</a></td>
     <td>{{$diag->name}}</td>
     <td>{{$diag->FacilityName}}</td>
     </tr>
     <?php $i++; ?>

     @endforeach

     </tbody>
     </table>
     </div>
   </div>


   <!-- Procedure HISTORY ------------------------------------------------------------>

     <?php
       $proceduresd = DB::table('appointments')
       ->Join('patient_procedure', 'appointments.id', '=', 'patient_procedure.appointment_id')
       ->Join('procedures', 'patient_procedure.procedure_id', '=', 'procedures.id')
       ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
    ->select('procedures.description','patient_procedure.procedure_date','patient_procedure.notes','facilities.FacilityName','appointments.id as appid')
      ->Where('appointments.persontreated', '=',$dependantId)
       ->orderBy('appointments.id', 'desc')
         ->get();
       ?>
   <div class ="ibox-content">
     <h5>Procedure History</h5>
     <div class="table-responsive ibox-content">
     <table class="table table-striped table-bordered table-hover dataTables-conditional" >
     <thead>
       <tr>
         <th></th>
         <th>Procedure Date</th>
         <th>Condition</th>
         <th>Notes</th>
         <th>Facility</th>
       </tr>
     </thead>

     <tbody>
     <?php $i =1; ?>

     @foreach($proceduresd as $proc)
     <tr>
     <td><a href="{{route('visitDetails',$proc->appid)}}"> {{ +$i }}</a></td>
     <td><a href="{{route('visitDetails',$proc->appid)}}"> @if($proc->procedure_date){{$proc->procedure_date}}@else Not Set @endif</a></td>
      <td><a href="{{route('visitDetails',$proc->appid)}}"> {{$proc->description}}</a></td>
     <td>{{$proc->notes}}</td>
     <td>{{$proc->FacilityName}}</td>
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
