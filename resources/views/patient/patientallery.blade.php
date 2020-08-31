@extends('layouts.patient')
@section('title', 'Patient Details')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profile</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li class="active">
                <strong>Patient Details</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-md-6">

  <h2>{{$patient->firstname}} {{$patient->secondName}}</h2>
  <h4>Patient</h4>

            </div>
            <div class="col-md-6 pul-right">
<br />
                          <address class="">
                        <strong>Contact Details : </strong><br>
                      Phone : <strong>{{$patient->msisdn}} </strong><br>
                      Email : <strong>{{$patient->email}} </strong><br>
                    </address>
                    </div>

</div>
</div>
  <div class="content-page  equal-height">
      <div class="content">
          <div class="container">

  <div class="wrapper wrapper-content animated fadeInRight">
  <div class="panel-body">

     <div class="col-lg-12">
            <div class="tabs-container">
              <!-- <div class="col-lg-12 tbg"> -->
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1">Your Allergy List</button></a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2">Your Vaccinations List</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3">Triage History</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-4">Your  Tests</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-5">Your  Prescriptions</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-6">Your Hospital Admission</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-7">Diagnosis History</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-8">Procedure History</a></li>

                </ul>
                <br>
         <div class="tab-content">
                      <div id="tab-1" class="tab-pane active">

            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Allergy List</h5>
                        <div class="ibox-tools">
                          @role('Patient')
                           <a class="collapse-link">

                          </a>  @endrole
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
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

                        <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover dataTables-example" >
      <thead>
       <tr>
      <th>No</th>
  <th>Allery Type</th>
  <th>Allery Name</th>
   <th>Date </th>
  </tr>
      </thead>

      <?php $i =1;  $allergies=DB::table('afya_users_allergy')->Where('afya_user_id','=',$patient->id)
    ->get(); ?>
     <tbody>
       @foreach($allergies as $allergy)

      <tr>
      <td>{{$i}}</td>
       <td>{{$allergy->allergies}}</td>
      <td>{{$allergy->status}}</td>
       <td>{{$allergy->created_at}}</td>
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
      <div id="tab-2" class="tab-pane">
       <div class="wrapper wrapper-content animated fadeInRight">
                 <div class="row">
                     <div class="col-lg-12">
                     <div class="ibox float-e-margins">
                         <div class="ibox-title">
                             <h5>Vaccinations List</h5>
                         </div>
                         <div class="ibox-content">
                             <div class="table-responsive">
                         <table class="table table-striped table-bordered table-hover dataTables-example" >
                         <thead>
                             <tr>
                                 <th>No</th>
                                 <th>Antigen</th>
                                <th>Vaccinations Name</th>
                                <th>Location(Facility)</th>
                                 <th>Date </th>
                                </tr>
                         </thead>

                         <tbody>
                         <?php $i=1;
                         $vaccines=DB::table('vaccination')->where('userId',$patient->id)
                         ->Orderby('created_at','desc')->get();
                         ?>
                         @foreach($vaccines as $vaccine)
                         <tr>
                         <td>{{$i}}</td>
                         <td>{{$vaccine->disease_id}}</td>
                         <td>{{$vaccine->vaccine_name}}</td>
                         <!-- <td>St Jude's Huruma Community Health Services</td>
                          <td>{{ date('d -m- Y', strtotime($vaccine->yesdate)) }}</td> -->

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
      <!-- TRIAGE HISTORY ------------------------------------------------------------>
      <div id="tab-3" class="tab-pane">
       <div class="wrapper wrapper-content animated fadeInRight">
                 <div class="row">
                   <?php
                         $i =1;
                              $triagedetails= DB::table('appointments')
                              ->Join('triage_details', 'appointments.id', '=', 'triage_details.appointment_id')
                              ->select('triage_details.*','appointments.created_at as visitDate')
                              ->where('appointments.afya_user_id', '=',$patient->id)
                              ->orderBy('visitDate', 'desc')
                              ->get();
                         ?>

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
                               <th>Notes</th>
                               </tr>
                               </thead>

                               <tbody>

                               @foreach($triagedetails as $triage)
                               <tr>
                               <td>{{ +$i }}</td>
                               <td>{{$triage->visitDate}}</td>
                               <td>{{$triage->current_height}}</td>
                               <td>{{$triage->current_weight}}</td>
                               <td>{{$triage->temperature}}</td>
                               <td>{{$triage->systolic_bp}}</td>
                               <td>{{$triage->diastolic_bp}}</td>
                               <td>{{$triage->chief_compliant}}</td>
                               <td>{{$triage->observation}}</td>
                               <td>{{$triage->nurse_notes}}</td>
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
      <!-- TEST HISTORY ------------------------------------------------------------>

      <div id="tab-4" class="tab-pane">
       <div class="wrapper wrapper-content animated fadeInRight">
                 <div class="row">

                         <?php
                         $i=1;
                         $tstdone = DB::table('appointments')
                         ->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
                         ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                         ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                        ->select('facilities.FacilityName','doctors.name as docname','patient_test.created_at','patient_test.test_status'
                         ,'patient_test.id as ptid')
                        ->where('appointments.afya_user_id', '=',$patient->id)
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
                            <td>{{$i}}</td>
                            <td>{{$tstdn->created_at}}</td>
                            <td>{{$tstdn->FacilityName}}</td>
                            <td>{{$tstdn->docname}}</td>
                            <td><a href="{{route('pattstdetails',$tstdn->ptid)}}">View</a></td>

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
      <!-- Prescription HISTORY ------------------------------------------------------------>

      <div id="tab-5" class="tab-pane">
       <div class="wrapper wrapper-content animated fadeInRight">
                 <div class="row">

                     <?php
                       $prescriptions = DB::table('appointments')
                       ->Join('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
                       ->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
                       ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
                      ->select('facilities.FacilityName','doctors.name as docname','prescriptions.created_at','prescriptions.filled_status'
                       ,'prescriptions.id as prescid')
                    ->where('appointments.afya_user_id', '=',$patient->id)
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
                     <td>{{ +$i }}</td>
                     <td>{{$tstdn->created_at}}</td>
                     <td>{{$tstdn->FacilityName}}</td>
                     <td>{{$tstdn->docname}}</td>
                     <td><a href="{{route('prscdetailspat',$tstdn->prescid)}}">View</a></td>
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
  <div id="tab-6" class="tab-pane">
      <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Hospital Admission</h5>
                            <div class="ibox-tools">
                              @role('Patient')
                               <a class="collapse-link">

                              </a>  @endrole
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
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

                            <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date of Admission</th>
                                <th>Date of Discharge</th>
                                <th>Chief Complaint</th>
                                <th>Diagnosis</th>
                                <th>Discharge Summary</th>

                                <!-- <th>Constituency of Residence</th> -->

                          </tr>
                        </thead>

                        <tbody>

                           <?php $i=1;
              $admits=DB::table('patient_admitted')
              ->join('appointments','appointments.id','=','patient_admitted.appointment_id')
              ->join('prescriptions','prescriptions.appointment_id','=','appointments.id')
              ->join('prescription_details','prescription_details.presc_id','=','prescriptions.id')
              ->Join('icd10_option','icd10_option.id','=','prescription_details.diagnosis')
              ->Join('triage_details','triage_details.appointment_id','=','appointments.id')
              ->select('patient_admitted.*','icd10_option.name as name','triage_details.chief_compliant as triage')
              ->where('appointments.afya_user_id',$patient->id)
              ->get();
             ?>
             @foreach($admits as $admit)
             <tr>
               <td>{{$i}}</td>
               <td>{{$admit->date_admitted}}</td>
               <td>{{$admit->date_discharged}}</td>
               <td>{{$admit->triage}}</td>
               <td>{{$admit->name}}</td>
                <td>{{$admit->condition}}</td>
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
           <!-- Diagnosis HISTORY ------------------------------------------------------------>

<div id="tab-7" class="tab-pane">
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
  <?php
    $diagnosis = DB::table('appointments')
    ->Join('patient_diagnosis', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
    ->Join('icd10_option', 'patient_diagnosis.disease_id', '=', 'icd10_option.id')
    ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
  ->select('icd10_option.name','patient_diagnosis.date_diagnosed','facilities.FacilityName')
   ->where('appointments.afya_user_id', '=',$patient->id)
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
  <td>{{ +$i }}</td>
  <td>{{$diag->date_diagnosed}}</td>
  <td>{{$diag->name}}</td>
  <td>{{$diag->FacilityName}}</td>
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


<!-- Procedure HISTORY ------------------------------------------------------------>

<div id="tab-8" class="tab-pane">
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">

    <?php
      $procedures = DB::table('appointments')
      ->Join('patient_procedure', 'appointments.id', '=', 'patient_procedure.appointment_id')
      ->Join('procedures', 'patient_procedure.procedure_id', '=', 'procedures.id')
      ->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
      ->select('procedures.description','patient_procedure.procedure_date','patient_procedure.notes','facilities.FacilityName')
     ->where('appointments.afya_user_id', '=',$patient->id)
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
    <td>{{ +$i }}</td>
    <td>@if($proc->procedure_date){{$proc->procedure_date}}@else Not Set @endif</td>
    <td>{{$proc->description}}</td>
    <td>{{$proc->notes}}</td>
    <td>{{$proc->FacilityName}}</td>
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
<!-- Procedure HISTORY ------------------------------------------------------------>





  </div>
                      </div>
                      <br><br>

         </div><!--container-->
      </div><!--content-->
      </div><!--content page-->


@endsection
