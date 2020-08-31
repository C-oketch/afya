@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-md-6">
    <address>
      <br />
      <strong>FACILITY :</strong><br>
      <strong> Name :</strong>{{$facility->FacilityName}}<br>
      <strong> Type :</strong> {{$facility->Type}}<br>
    </address>
  </div>
  <div class="col-md-6 text-right">
    <address>
      <br /><br />
      <strong>DATE :</strong><br>
      {{date("l jS \of F Y ")}}
    </address>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                          <div class="col-lg-11">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                        <h4>Appointments List</h4>

                              </div>
                              <div class="ibox-content">


                              <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>
                                                      <tr>
                                                          <th>No</th>
                                                          <th>Name</th>
                                                           <th>Gender</th>
                                                          <th>Age</th>
                                                          <th>Appointment Date</th>
                                                          <th>Appointment Time</th>
                                                          <th>Doctor</th>
                                                  </thead>

                                                  <tbody>
                                                    <?php $i =1; ?>
                                                 @foreach($patients as $patient)
  <tr>
    <td>{{$i}}</td>
@if($patient->persontreated==="Self")

<td>{{$patient->first}} {{$patient->second}}</td>

<td>{{$patient->gender}}</td>
<td>
  <?php

  if($patient->dob){
  $interval = date_diff(date_create(), date_create($patient->dob));
  $age = $interval->format(" %Y Yrs");
  }elseif ($patient->age) {
  $age =$patient->age;
  }else{
  $age ='Not Set';
  }

$timestamp = $patient->appointment_date;
$datetime = explode(" ",$timestamp);
$date = $datetime[0];
//$time = $datetime[1];
?>
 {{$age}}

</td>
@else

<!-- dependants data---------------------->

<td>{{$patient->dfirst}} {{$patient->dsecond}}</td>

<td>{{$patient->dgender}}</td>
<td>
  <?php
$ddob=$patient->ddob;
$intervals = date_diff(date_create(), date_create($patient->ddob));
$dage= $intervals->format(" %Y Year, %M Months, %d Days Old");

?>
{{$dage}}</td>
@endif

<td>{{$patient->appointment_date}}</td>
<td>{{$patient->appointment_time}}</td>
<td>{{$patient->doc_name}}</td>

  </tr>
            <?php $i++; ?>

         @endforeach

         </tbody>

       </table>
           </div>



       </div>
   </div>
</div>
</div>
</div>
@include('includes.default.footer')


@endsection
