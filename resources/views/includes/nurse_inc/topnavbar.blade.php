<?php
$interval = date_diff(date_create(), date_create($patient->dob));
$age= $interval->format(" %Y Years, %M Months, Old");

 ?>
<div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>Patient</h2>

                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">{{$patient->firstname}}  {{$patient->secondName}}</a>
                    </li>
                    <li>
                      {{$patient->gender}}
                    </li>
                    <li class="active">
                        <strong>{{$age}}</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-4">
              <?php
              $facility = DB::table('facility_nurse')
                             ->join('facilities', 'facilities.FacilityCode', '=', 'facility_nurse.facilitycode')
                             ->select('facility_nurse.facilitycode','facilities.set_up','facilities.FacilityName','facilities.Type')
                             ->where('facility_nurse.user_id', Auth::user()->id)
                             ->first();
              ?>
              <address>
                <br />
                <strong>FACILITY :</strong><br>
                <strong> Name :</strong>{{$facility->FacilityName}}<br>
                <strong> Type :</strong> {{$facility->Type}}<br>
              </address>

            </div>
        </div>
