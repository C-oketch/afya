@extends('layouts.doctor_layout')
@section('title', 'Patients')
@section('style')

@endsection

  @section('content')
            <?php
            $doc = (new \App\Http\Controllers\DoctorController);
            $Docdatas = $doc->DocDetails();
            foreach($Docdatas as $Docdata){
            $Did = $Docdata->id;
            $Name = $Docdata->name;
          }

  ?>
  @section('leftmenu')
  @include('includes.doc_inc.leftmenu')
  @endsection
@include('includes.doc_inc.topnavbar_v1')

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
<div id="div_print">

            <div class="ibox-title">
                <h5>Patients List</h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        {{$Name}}
                    </a>

                </div>
            </div>
            <div class="ibox-content">
              <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover dataTables-example" >
              <thead>
                      <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Appointment</th>
                             <th>Visit Type</th>
                            <!-- <th>Chief Complaint</th> -->
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Weight</th>
                            <th>Height</th>
                            <th>Temp</th>
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
                      $appid = $apatient->appid;

                      }else {
                      $appid = $apatient->appid;
                      $name = $apatient->Infname." ".$apatient->InfName;
                      $complain =$apatient->Infcompliant;
                      $gender=$apatient->Infgender;
                      $dob=$apatient->Infdob;
                      $weight=$apatient->Infweight;
                      $height= $apatient->Infheight;
                      $temp =$apatient->Inftemp;
                      $systo = $apatient->Infsysto;
                      $diasto = $apatient->Infdiasto;
                      }
                      $visit_type=$apatient->visit_type;


                      if ($apatient->last_app_id){
                        $appdt = DB::table('appointments')
                        ->select('appointment_date')->where('id', $apatient->last_app_id)
                        ->first();
                      if ($appdt->appointment_date) {$appointment = $appdt->appointment_date;}else{ $appointment ='None'; }


                    }else{ $appointment ='None'; }

                      $interval = date_diff(date_create(), date_create($dob));
                      $age= $interval->format(" %Y Years Old");

                        ?>
                      <tr>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$i}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$name}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$appointment}}</a></td>
                         <td><a href="{{route('showPatient',$apatient->appid)}}">{{$visit_type }}</a></td>
                          <!-- <td><a href="{{route('showPatient',$apatient->appid)}}">{{$complain}}</a></td> -->
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$gender}}</td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$age}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$weight}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$height}}</a></td>
                          <td><a href="{{route('showPatient',$apatient->appid)}}">{{$temp}}</a> </td>
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
       </div>
@endsection
@section('script')


@endsection
