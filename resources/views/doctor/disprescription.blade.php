@extends('layouts.show')
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
        $appStatue=$stat;
        if ($appStatue == 2) {
        $appStatue ='ACTIVE';
        } elseif ($stat == 3) {
        $appStatue='Discharged Outpatient';
        } elseif ($stat == 4) {
        $appStatue='Admitted';
        } elseif ($stat == 5) {
        $appStatue='Refered';
        }
        elseif ($stat == 6) {
        $appStatue='Discharged Intpatient';
        }

        }
        ?>
        <div class="row wrapper border-bottom white-bg page-heading">
                      <div class="col-lg-6">
                          <h2>{{$name }}</h2>
                          <ol class="breadcrumb">
                              <li><a>{{$gender}}</a></li>
                              <li><a>{{$age}}</a> </li>
                              <li>
                                  <strong> <button type="btn" class="btn btn-primary">{{$appStatue}}</button></strong>
                              </li>
                          </ol>
                      </div>
                      <div class="col-lg-6">
                          <h2>{{$pdetails->FacilityName}} </h2>
                          <ol class="breadcrumb">
                            <li class="active"><strong>{{$Name}} </strong></li>
                          </ol>
                      </div>
                  </div>

          <?php  $routem= (new \App\Http\Controllers\TestController);
                $routems = $routem->RouteM();
            ?>
          <?php $Strength= (new \App\Http\Controllers\TestController);
                $Strengths = $Strength->Strength();
            ?>
          <?php $frequency= (new \App\Http\Controllers\TestController);
                $frequent = $frequency->Frequency();
            ?>

            <!--tabs Menus-->
            <div class="row border-bottom">
            <nav class="navbar" role="navigation">
              <div class="navbar-collapse " id="navbar">
                    <ul class="nav navbar-nav">
                      <li><a role="button" href="{{route('showPatient',$app_id)}}">Today's Triage</a></li>
                      <li><a role="button" href="{{route('patienthistory',$app_id)}}">History</a></li>
                      <li><a role="button" href="{{route('testes',$app_id)}}">Tests</a></li>
                      <li><a role="button" href="{{route('diagnoses',$app_id)}}">Diagnosis</a></li>
                      <li><a role="button" href="{{route('medicines',$app_id)}}">Prescriptions</a></li>
                      <li><a role="button" href="{{route('procedure',$app_id)}}">Procedures</a></li>

                      @if ($condition =='Admitted')
                        <li class="active"><a role="button" href="{{route('discharge',$app_id)}}">Discharge</a></li>
                       @else
                        <li><a role="button" href="{{route('admit',$app_id)}}">Admit</a></li>@endif
                        <li><a role="button" href="{{route('transfering',$app_id)}}">Referral</a></li>
                       <li><a role="button" href="{{route('endvisit',$app_id)}}">End Visit</a></li>
                     </ul>
                 </div>
            </nav>
            <nav class="navbar" role="navigation">
              <div class="navbar-collapse " id="navbar">
                    <ul class="nav navbar-nav">
                      <li><a href="{{route('discharge',$app_id)}}"> Discharge Condition</a></li>
                      <li><a href="{{route('disdiagnosis',$app_id)}}"> Discharge Diagnosis</a></li>
                      <li class="active"><a href="{{route('disprescription',$app_id)}}">Discharge Prescription</a></li>
                    </ul>
                 </div>
            </nav>
            </div>
<div class="row wrapper border-bottom">
 <div class="ibox float-e-margins">
  <div class="col-lg-12">
    <div class="tabs-container">
      <div class="row">
          <div class="col-lg-12">
              <div class="tabs-container">
                  <ul class="nav nav-tabs">
                    <div class="col-lg-6">
                    <a class="btn btn-primary btn-lg btn-block" data-toggle="tab" href="#tab-1"><i class=""></i>PRESCRIPTIONS</a>
                    </div>
                    <div class="col-lg-6">
                    <a class="btn btn-primary btn-lg btn-block" data-toggle="tab" href="#tab-2"><i class="fa fa-database"></i>PRESCRIPTIONS HISTORY </a>
                    </div>
                   </ul>

                    <div class="tab-content">
                      <div id="tab-1" class="tab-pane active">
                          <div class="panel-body">
                            <div class="col-sm-5 b-r">
                            <div class="table-responsive ibox-content">
                            <table class="table table-striped table-bordered table-hover " >
                            <thead>
                            <tr>
                            <th>Diagnosis</th>
                            <th>Level</th>
                            <th>Severity</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($Pdiagnosis as $tstdn)
                            <tr>
                            <td>{{$tstdn->name}}</td>
                            <td>{{$tstdn->level}}</td>
                            <td>{{$tstdn->severity}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                            </table>
                            </div>
                            </div>

                    <div class="col-sm-7">
                    <div class="ibox-content">
                      {{ Form::open(array('route' => array('prescription.store'),'method'=>'POST')) }}

                    <div class="form-group">
                    <label for="dosage" class="col-md-4">Prescription For:</label></td>
                    <select class="form-control m-b col-md-8" name="disease_id" id="example-getting-started" style="width: 50%">
                    <?php $druglists=DB::table('druglists')->distinct()->get(['DosageForm']); ?>
                    @foreach($Pdiagnosis as $tstdn)
                    <option value='{{$tstdn->id}}'>{{$tstdn->name}}</option>
                    @endforeach
                    </select>
                    </div>
                    <div class="form-group">
                   <label for="presc" class="col-md-4">Prescription:</label>
                    <select id="presc" name="prescription" class="form-control presc1" style="width: 50%"></select>
                    </div>

                    <div class="form-group">
                    <label for="dosage" class="col-md-4">Dosage Form</label></td>
                    <select class="form-control m-b col-md-4" name="dosageform" id="example-getting-started" style="width: 50%">
                    <?php $druglists=DB::table('druglists')->distinct()->get(['DosageForm']); ?>
                    @foreach($druglists as $druglist)
                    <option value='{{$druglist->DosageForm}}'>{{$druglist->DosageForm}}</option>
                    @endforeach
                    </select>
                    </div>

                    <div class="form-group">
                    <label for="dosage" class="col-md-4 control-label">Strength</label></td>
                    <select class="form-control" id="testsj" name="strength" style="width: 25%">
                    @foreach($Strengths as $Strengthz)
                    <option value="{{$Strengthz->strength}}">{{ $Strengthz->strength  }}  </option>
                    @endforeach
                    </select>
                    </div>

                    <div class="form-group">
                    <label for="dosage" class="col-md-4 control-label">Strength Unit</label></td>
                    <input type="radio" name="strength_unit" value="ml"> Ml
                    &nbsp;&nbsp;<input type="radio" name="strength_unit" value="mg"> Mg
                    </div>


                    <div class="form-group">
                    <label for="dosage" class="col-md-4 control-label">Route</label></td>
                    <select class="form-control" name="routes" style="width: 50%">
                    @foreach($routems as $routemz)
                    <option value="{{$routemz->id }}">{{ $routemz->abbreviation }}----{{ $routemz->name  }} </option>
                    @endforeach
                    </select>
                    </div>

                    <div class="form-group">
                    <label for="dosage" class="col-md-4 control-label">Frequency</label></td>
                    <select class="form-control"  name="frequency" style="width: 50%">
                    @foreach($frequent as $freq)
                    <option value="{{$freq->id }}">{{ $freq->abbreviation }}----{{ $freq->name  }} </option>
                    @endforeach
                    </select>
                    </div>
                    {{ Form::hidden('state','Discharge', array('class' => 'form-control')) }}
                    {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
                    {{ Form::hidden('doc_id',$doc_id, array('class' => 'form-control')) }}
                     <div class="form-group  text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>  </td>
                    </div>
                    {{ Form::close() }}
                    </div>
                    </div>
                          </div>
                      </div>
                      <div id="tab-2" class="tab-pane">
                          <div class="panel-body">
                            <?php $i =1;
                            if ($dependantId =='Self') {
                              $tstdone = DB::table('appointments')
                              ->leftJoin('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
                              ->leftJoin('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
                              ->leftJoin('diagnoses', 'prescription_details.diagnosis', '=', 'diagnoses.id')
                              ->leftJoin('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
                              ->leftJoin('frequency', 'prescription_details.frequency', '=', 'frequency.id')
                              ->leftJoin('route', 'prescription_details.routes', '=', 'route.id')
                              ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                              ->select('diagnoses.name','druglists.drugname','frequency.name as frequency','prescriptions.created_at','prescription_details.created_at as dater',
                              'route.name as route','prescription_filled_status.start_date','prescription_filled_status.end_date')
                              ->where('appointments.afya_user_id', '=',$afyauserId)
                              ->orderBy('dater', 'desc')
                              ->get();

                            }else {

                              $tstdone = DB::table('appointments')
                              ->leftJoin('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
                              ->leftJoin('prescription_details', 'prescriptions.id', '=', 'prescription_details.presc_id')
                              ->leftJoin('diagnoses', 'prescription_details.diagnosis', '=', 'diagnoses.id')
                              ->leftJoin('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
                              ->leftJoin('frequency', 'prescription_details.frequency', '=', 'frequency.id')
                              ->leftJoin('route', 'prescription_details.routes', '=', 'route.id')
                              ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                              ->select('diagnoses.name','druglists.drugname','frequency.name as frequency','prescriptions.created_at','prescription_details.created_at as dater',
                              'route.name as route','prescription_filled_status.start_date','prescription_filled_status.end_date')
                              ->where('appointments.persontreated', '=',$dependantId)
                              ->orderBy('dater', 'desc')
                              ->get();
                            }
                            ?>
                            <div class="ibox float-e-margins">
                            <div class="ibox-content ">
                            <h5>Prescription History</h5>
                            <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-conditional" >
                            <thead>
                            <tr>
                            <th></th>
                            <th>Diagnosis</th>
                            <th>Drug Name</th>
                            <th>Start Date</th>
                            <th>Stop Date</th>
                            <th>Frequeny</th>
                            <th>Route</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $i =1; ?>

                            @foreach($tstdone as $tstdn)
                            <tr>
                            <td>{{ +$i }}</td>
                            <td>{{$tstdn->name}}</td>
                            <td>{{$tstdn->drugname}}</td>
                            <td>{{$tstdn->start_date}}</td>
                            <td>{{$tstdn->end_date}}</td>
                            <td>{{$tstdn->frequency}}</td>
                            <td>{{$tstdn->route}}</td>

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
             </div>
          </div>
      </div>

          </div>
        </div>
      </div>
  </div>
                    @endsection
