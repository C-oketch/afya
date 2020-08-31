@extends('layouts.patient')
@section('title', 'Patient Details')
@section('content')
  <div class="content-page  equal-height">
      <div class="content">
          <div class="container">

  <div class="wrapper wrapper-content animated fadeInRight">
  <div class="panel-body">
  <div class="col-lg-4">
                     <div class="widget navy-bg ">

                                <h2>
                                    {{$patient->firstname}} {{$patient->secondName}}
                                </h2>
                        <ul class="list-unstyled m-t-md">
                            <li>
                                <span class="fa fa-users m-r-xs"></span>
                                <label>Age:</label>
                                {{$patient->age}}
                            </li>
                            
                            <li>
                                <span class="fa  fa-genderless m-r-xs"></span>
                                <label>Gender:</label>
                                @if($patient->gender==1){{"Male"}}@else{{"Female"}}@endif
                            </li>
                             <li>
                                <span class="fa  fa-medkit m-r-xs"></span>
                                <label>Blood Type:</label>
                                {{$patient->blood_type}}
                            </li>

                           <li>
                                <span class="fa  fa-map m-r-xs"></span>
                                <label>Constituency:</label>
                                <?php $const=$patient->constituency; $cons=DB::table('constituency')->where('const_id',$const)->first();?>{{$cons->Constituency}}
                            </li>
                             <li>
                                <span class="fa  fa-map m-r-xs"></span>
                                <label>County:</label>
                                <?php $county=DB::Table('county')->where('id',$cons->cont_id)->first();?> {{$county->county}}
                            </li>
                             <li>
                                <span class="fa  fa-phone m-r-xs"></span>
                                <label>Phone:</label>
                                {{$patient->msisdn}}
                            </li>
                        </ul>

                    </div>

          </div>

     <div class="col-lg-12">
            <div class="tabs-container">
              <!-- <div class="col-lg-12 tbg"> -->
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1">Your Allergy List</button></a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2">Your Vaccinations List</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3">Your History</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-4">Your  Tests</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-5">Your  Prescriptions</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-6">Your Hospital Admission</a></li>
                    
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

      <?php $i =1;  $allergies=DB::table('afya_users_allergy')
    ->Join('allergies_type','allergies_type.id','=','afya_users_allergy.allergies_type_id')
    ->Join('allergies','allergies.id','=','allergies_type.allergies_id')
    ->Select('allergies_type.name','allergies.name as Allergy','afya_users_allergy.created_at')
    ->Where('afya_users_allergy.afya_user_id','=',$patient->id)
    ->get(); ?>
     <tbody>
       @foreach($allergies as $allergy)
   
      <tr>
      <td>{{$i}}</td>
       <td>{{$allergy->Allergy}}</td>
      <td>{{$allergy->name}}</td>   
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
                                 <th>Antigen</th>
                                <th>Vaccinations Name</th>
                                <th>Location(Facility)</th>
                                 <th>Date </th>

                                 <!-- <th>Constituency of Residence</th> -->

                           </tr>
                         </thead>

                         <tbody>
                         <?php $i=1;
                         $vaccines=DB::table('vaccination')->
                         join('vaccine','vaccine.id','=','vaccination.diseaseId')->
                         select('vaccine.*','vaccination.*')
                         ->where('vaccination.userId',$patient->id)
                         ->where('vaccination.yes','=','yes')->
                         Orderby('yesdate','desc')->get();
                         ?>
                         @foreach($vaccines as $vaccine)
                         <tr>
                         <td>{{$i}}</td>
                         <td>{{$vaccine->antigen}}</td>
                         <td>{{$vaccine->vaccine_name}}</td>
                         <td>St Jude's Huruma Community Health Services</td>
                          <td>{{ date('d -m- Y', strtotime($vaccine->yesdate)) }}</td>
                         
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
      <div id="tab-3" class="tab-pane">
      <div class="wrapper wrapper-content animated fadeInRight">
                 <div class="row">
                     <div class="col-lg-12">
                     <div class="ibox float-e-margins">
                         <div class="ibox-title">
                             <h5>Patient History</h5>
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
            <th>Date</th>
            <th>Weight</th>
           <th>Height</th>
           <th>BMI</th>
           <th>Temperature</th>
           <th>Systolic_bp</th>
           <th>Diastolic_bp</th>
           <th>Chief Compliant</th>

                                 <!-- <th>Constituency of Residence</th> -->

                           </tr>
                         </thead>

                         <tbody>
                         <?php $i=1;
                         $triages=DB::table('triage_details')->join('appointments','appointments.id','=','triage_details.appointment_id')
                         ->select('triage_details.*')->where('appointments.afya_user_id',$patient->id)->Orderby('triage_details.updated_at','desc')->get();
                        ?>
                        @foreach($triages as $triage)
                        <tr>
                         <td>{{$i}}</td>
            <td>{{$triage->updated_at}}</td>
           
           <td>{{$triage->current_weight}}</td>
           <td>{{$triage->current_height}}</td>
            <td><?php $height=$triage->current_height; $weight=$triage->current_weight;
               $bmi =$weight/($height*$height);
               echo number_format($bmi, 2);
            ?></td>
           <td>{{$triage->temperature}}</td>
          <td>{{$triage->systolic_bp}}</td>
         <td>{{$triage->diastolic_bp}}</td>
         <td>{{$triage->chief_compliant}}</td>
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
            <div id="tab-4" class="tab-pane">
            <div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                          <div class="col-lg-12">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                  <h5>Patient Tests</h5>
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
                                      <th>Date</th>

                                      <th>Test Type</th>
                                      <th>Test</th>
                                      <th>Doctor Name</th>
                                      <th>Status</th>
                                     

                                      <!-- <th>Constituency of Residence</th> -->

                                </tr>
                              </thead>

                              <tbody>
                              <?php $i=1; 
                              $tests=DB::table('patient_test_details')->join('patient_test','patient_test.id','=','patient_test_details.patient_test_id')->select('patient_test.*','patient_test_details.*')->where('patient_test_details.afya_user_id',$patient->id) ->get(); ?>

                         
                              @foreach($tests as $test)
                              <tr>
                              <td>{{$i}}</td>
                              <td>{{$test->created_at}}</td>
                                <td><?php $labtest=DB::table('lab_test')->where('id',$test->tests_reccommended)->first();
                               $testname=DB::table('test_type')->where('id',$labtest->test_type_id)->first();?>{{$testname->test_category}}</td>
                              <td>{{$labtest->name}}</td>
                              <td><?php $user=DB::table('doctors')->where('id',$test->doc_id)->first(); ?>{{$user->name}}</td>
                              <td><?php $status=$test->test_status; if($status==0){ echo "Not Done";} else { echo "Done";}?></td>
                           
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
                 <div id="tab-5" class="tab-pane">
                 <div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                          <div class="col-lg-12">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                  <h5>Patient Prescriptions</h5>
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
                                      <th>Date</th>
                                      <th>Diagnosis</th>
                                      <th>State</th>
                                      <th>Drug</th>
                                      <th>Doctor Name</th>
                                     

                                      <!-- <th>Constituency of Residence</th> -->

                                </tr>
                              </thead>

                              <tbody>
                               <?php $i=1; 
                              $prescs=DB::table('prescription_details')->Join('diagnoses','diagnoses.id','=','prescription_details.diagnosis')->join('druglists','druglists.id','=','prescription_details.drug_id')->join('prescriptions','prescriptions.id','=','prescription_details.presc_id')->select('prescription_details.*','diagnoses.name as name','druglists.drugname as drugname','prescriptions.doc_id as doc')
                              ->where('prescription_details.afya_user_id',$patient->id)->get(); ?>
                         
                              @foreach($prescs as $presc)
                              <tr>
                              <td>{{$i}}</td>
                              <td>{{$presc->created_at}}</td>
                              <td>{{$presc->name}}</td>
                              
                              <td>{{$presc->state}}</td>
                              <td>{{$presc->drugname}}</td>
                              <td><?php $doc=DB::table('doctors')->where('id',$presc->doc)->first();?>{{$doc->name}}</td>

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
                         $admits=DB::table('patient_admitted')->join('appointments','appointments.id','=','patient_admitted.appointment_id')->join('prescriptions','prescriptions.appointment_id','=','appointments.id')->join('prescription_details','prescription_details.presc_id','=','prescriptions.id')->Join('diagnoses','diagnoses.id','=','prescription_details.diagnosis')->Join('triage_details','triage_details.appointment_id','=','appointments.id')
                         ->select('patient_admitted.*','diagnoses.name as name','triage_details.chief_compliant as triage')->where('appointments.afya_user_id',$patient->id)->get();
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
                      </div>
                      <br><br>
      
         </div><!--container-->
      </div><!--content-->
      </div><!--content page-->


@endsection
