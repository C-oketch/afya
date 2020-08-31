<?php

$patients = DB::table('afya_users')
     ->join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
     ->leftjoin('triage_details', 'appointments.id', '=', 'triage_details.appointment_id')
     ->select('afya_users.*','triage_details.lmp')
     ->where([['afya_user_id',$afyauserId],['appointments.id',$app_id],])
     ->first();

$interval = date_diff(date_create(), date_create($patients->dob));
$age= $interval->format(" %Y Years Old");


 ?>
 @include('includes.doc_inc.topnavbar_v3')
<div class="row wrapper border-bottom white-bg page-heading">

            <div class="col-lg-7">
                <h2>Patient</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">{{$patients->firstname}}  {{$patients->secondName}}</a>
                    </li>
                    <li>
                      {{$patients->gender}}
                    </li>
                    <li class="active">
                        <strong>{{$age}}</strong>
                    </li>
                    @if($patients->gender == 'Female')
                    <li class="active">
                        <strong>LMP :</strong>{{$patients->lmp}}
                    </li>
                    @endif
                </ol>
            </div>

            <div class="col-lg-4">
              <?php
              $facility = DB::table('facility_doctor')
                             ->join('facilities', 'facilities.FacilityCode', '=', 'facility_doctor.facilitycode')
                             ->select('facility_doctor.facilitycode','facilities.set_up','facilities.FacilityName','facilities.Type')
                             ->where('facility_doctor.user_id', Auth::user()->id)
                             ->first();
              ?>
              <address>
                <br />
                <strong>FACILITY :</strong><br>
                <strong> Name :</strong>{{$facility->FacilityName}}<br>
                <strong> Type :</strong> {{$facility->Type}}<br>
              </address>

            </div>
            <div class="col-lg-1">
              <br>
              <!-- <a href="{{route('endvisit',$app_id)}}">
                  <i class="fa fa-close"></i> END VISIT
              </a> -->
  <a  href="{{route('endvisit',$app_id)}}" class="btn btn-primary btn-lg dim "><i class="fa fa-close"></i></a><br>
<small>END VISIT</small>

            </div>
        </div>
