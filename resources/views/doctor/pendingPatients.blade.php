@extends('layouts.doctor')
  @section('content')
            <?php
            $doc = (new \App\Http\Controllers\DoctorController);
            $Docdatas = $doc->DocDetails();
            foreach($Docdatas as $Docdata){
            $Did = $Docdata->id;
            $Name = $Docdata->name;
          }
?>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Patients List</h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        {{$Name}}
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <input type="text" class="form-control input-sm m-b-xs" id="filter"
                       placeholder="Search in table">

                <table class="footable table table-stripped" data-page-size="10" data-filter=#filter>
                    <thead>
                      <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Appointment</th>
                            <th>Chief Complaint</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Weight</th>
                            <th>Height</th>
                            <th>Temperature</th>
                            <th>Systolic BP</th>
                            <th>Diastolic BP</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  $i =1;?>
                      @foreach($patients as $apatient)
                      <?php

                       if ($apatient->persontreated=='Self'){
                      $name = $apatient->firstname." ".$apatient->secondName;
                      $complain =$apatient->chief_compliant;
                      $gender=$apatient->gender;
                      $dob=$apatient->dob;
                      $weight=$apatient->current_weight;
                      $height =$apatient->current_height;
                      $temp = $apatient->temperature;
                      $systo = $apatient->systolic_bp;
                      $diasto = $apatient->diastolic_bp;

                      }else {
                      $name = $apatient->Infname." ".$apatient->InfName;
                      $complain =$apatient->chief_compliant;
                      $gender=$apatient->Infgender;
                      $dob=$apatient->Infdob;
                      $weight=$apatient->Infweight;
                      $height= $apatient->Infheight;
                      $temp =$apatient->Inftemp;
                      $systo = $apatient->Infsysto;
                      $diasto = $apatient->Infdiasto;
                      }
                    
                      if ($apatient->appointment_made=='Y'){  $appointment = 'Yes';}else{ $appointment ='No'; }
                      $interval = date_diff(date_create(), date_create($dob));
                      $age= $interval->format(" %Y Ys, %M Ms, %d Ds Old");

                        ?>
                      <tr>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$i}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$name}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$appointment}}</td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$complain}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$gender}}</a></td>
                          <td class="tdwith"><a href="{{route('showPatient',$apatient->appid)}}">{{$age}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$weight}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$height}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$temp}} </a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$systo}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$diasto}}</a></td>
                      </tr>
                      <?php $i++; ?>
                    @endforeach

                  </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul class="pagination pull-right"></ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
       </div>
       @include('includes.default.footer')
@endsection
