<?php
$pat=$afyauserId;

   use Carbon\Carbon;
   $vaccines = DB::table('vaccination')->where('userId',$pat)->get();

      $smoking = DB::table('smoking_history')->where('afya_user_id', '=',$pat)->first();
      $alcohol = DB::table('alcohol_drug_history')->where('afya_user_id', '=',$pat)->first();
      $medication = DB::table('self_reported_medication')
      ->Select('drug_id as drugname','dosage','med_date')
      ->where('afya_user_id', '=',$pat)->get();
      $surgery = DB::table('self_reported_surgical_procedures')->where('afya_user_id', '=',$pat)->get();
      $abnm = DB::table('patient_abnormalities')->where('afya_user_id', '=',$pat)->get();
      $fam = DB::table('family_summary')->where('afya_user_id', '=',$pat)->first();


      $medicalH = DB::table('self_reported_medical_history')->where('afya_user_id', '=',$pat)->get();
      $allergies = DB::table('afya_users_allergy')->Select('allergies','status')
      ->where('afya_users_allergy.afya_user_id', '=',$pat)->get();

      $chronics = DB::table('patient_diagnosis')
      ->Select('disease_id','notes')
      ->where('patient_diagnosis.afya_user_id', '=',$pat)->get();

   $today = Carbon::today();
      $prescriptions =DB::table('appointments')
      ->join('prescriptions','appointments.id','=','prescriptions.appointment_id')
                   ->join('prescription_details','prescriptions.id','=','prescription_details.presc_id')
                   ->join('druglists','prescription_details.drug_id','=','druglists.id')
                   ->leftjoin('prescription_filled_status','prescription_details.id','=','prescription_filled_status.presc_details_id')
                   ->leftjoin('substitute_presc_details','prescription_filled_status.substitute_presc_id','=','substitute_presc_details.id')
                   ->select('druglists.drugname','prescription_filled_status.start_date','prescription_filled_status.end_date',
                   'substitute_presc_details.drug_id as subdrug', 'prescription_filled_status.substitute_presc_id as substitute')
                  ->where([['appointments.afya_user_id',$pat],['prescription_filled_status.end_date','>=',$today],])
                   ->get();
    ?>

   <div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
                                 <div class="col-lg-4">
                                     <div class="ibox float-e-margins">
                                         <div class="ibox-title">
                                             <h5>Medical History</h5>
                                             <div class="ibox-tools">
                                                 <a class="collapse-link">
                                                     <i class="fa fa-chevron-up"></i>
                                                 </a>
                                                 <a class="close-link">
                                                     <i class="fa fa-times"></i>
                                                 </a>
                                             </div>
                                         </div>
                                         <div class="ibox-content">
                                             <table class="table table-hover no-margins">
                                                 <thead>
                                                 <tr>
                                                     <th>Condition</th>
                                                     <th>Status</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody>
                                                   @if($medicalH)
                                                    @foreach($medicalH as $med)
                                                 <tr>
                                                  <td>{{$med->name}}</td>
                                                  <td>{{$med->status}}</td>
                                                 </tr>
                                                 @endforeach
                                                 @else
                                                 <tr>
                                                   <td class="text-navy">No Data Available </td>

                                                 </tr>
                                                   @endif
                                                 </tbody>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-4">
                                     <div class="ibox float-e-margins">
                                         <div class="ibox-title">
                                             <h5>Self Medication</h5>
                                             <div class="ibox-tools">
                                                 <a class="collapse-link">
                                                     <i class="fa fa-chevron-up"></i>
                                                 </a>
                                                 <a class="close-link">
                                                     <i class="fa fa-times"></i>
                                                 </a>
                                             </div>
                                         </div>
                                         <div class="ibox-content">
                                             <table class="table table-hover no-margins">
                                                 <thead>
                                                 <tr>
                                                     <th>Drug</th>
                                                     <th>Dosage</th>
                                                     <th>Date</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody>
                                                     @if($medication)
                                                     @foreach($medication as $med)
                                                 <tr>
                                                     <td>{{$med->drugname}}</td>
                                                     <td>{{$med->dosage}}</td>
                                                     <td>{{$med->med_date}}</td>
                                                 </tr>
                                                 @endforeach
                                                 @else
                                                 <tr>
                                                 <td class="text-navy">No Data Available </td>
                                                 </tr>
                                                 @endif
                                                 </tbody>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-4">
                                     <div class="ibox float-e-margins">
                                         <div class="ibox-title">
                                             <h5>Surgical Procedures</h5>
                                             <div class="ibox-tools">
                                                 <a class="collapse-link">
                                                     <i class="fa fa-chevron-up"></i>
                                                 </a>
                                                 <a class="close-link">
                                                     <i class="fa fa-times"></i>
                                                 </a>
                                             </div>
                                         </div>
                                         <div class="ibox-content">
                                             <table class="table table-hover no-margins">
                                                 <thead>
                                                 <tr>
                                                     <th>Procedure</th>
                                                     <th>Date</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody>

                                                         @foreach($surgery as $procd)
                                                  <tr>
                                                     <td>{{$procd->name_of_surgery}}</td>
                                                     <td></td>
                                                 </tr>
                                                 @endforeach

                                                 </tbody>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                               </div>
<div class="row">
                    
                                 <!-- <div class="col-lg-8"> -->
                                 <div class="col-lg-4">
                                     <div class="ibox float-e-margins">
                                         <div class="ibox-title">
                                             <h5>Chronic Disease</h5>
                                             <div class="ibox-tools">
                                                 <a class="collapse-link">
                                                     <i class="fa fa-chevron-up"></i>
                                                 </a>
                                                 <a class="close-link">
                                                     <i class="fa fa-times"></i>
                                                 </a>
                                             </div>
                                         </div>
                                         <div class="ibox-content">
                                             <ul class="todo-list m-t small-list">
                                               @if($chronics)
                                               @foreach($chronics as $chro)
                                               <li>{{$chro->disease_id}}  &nbsp;&nbsp;&nbsp;&nbsp;{{$chro->notes}}</li>
                                               @endforeach
                                               @else
                                               <li>No Data Available</li>
                                               @endif
                                             </ul>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-4">
                                     <div class="ibox float-e-margins">
                                         <div class="ibox-title">
                                             <h5>Family History</h5>
                                             <div class="ibox-tools">
                                                 <a class="collapse-link">
                                                     <i class="fa fa-chevron-up"></i>
                                                 </a>
                                                 <a class="close-link">
                                                     <i class="fa fa-times"></i>
                                                 </a>
                                             </div>
                                         </div>
                                         <div class="ibox-content">
                                             @if($fam)<p> {{$fam->notes}}</p>@endif
                                         </div>
                                     </div>
                                 </div>

                          </div>
<div class="row">
                             <div class="col-lg-6">
                                 <div class="ibox float-e-margins">
                                     <div class="ibox-title">
                                         <h5>Vaccination Details</h5>
                                         <div class="ibox-tools">
                                             <a class="collapse-link">
                                                 <i class="fa fa-chevron-up"></i>
                                             </a>
                                             <a class="close-link">
                                                 <i class="fa fa-times"></i>
                                             </a>
                                         </div>
                                     </div>
                                     <div class="ibox-content">
                                   <table class="table table-hover no-margins">
                                               <thead>
                                               <tr>
                                                   <th>Disease</th>
                                                   <th>Vaccine Name</th>
                                                   <th>Date</th>
                                               </tr>
                                               </thead>
                                               <tbody>
                                                 @if($vaccines)
                                                 @foreach($vaccines as $vac)

                                               <tr>
                                                   <td>{{$vac->diseaseId}}</td>
                                                   <td>{{$vac->vaccine_name}}</td>
                                                  <td></td>
                                               </tr>
                                               @endforeach
                                               @else
                                               <tr>
                                               <td class="text-navy">No Data Available </td>
                                               </tr>
                                               @endif
                                               </tbody>
                                           </table>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-lg-6">
                                 <div class="ibox float-e-margins">
                                     <div class="ibox-title">
                                         <h5>Patient Allergies</h5>
                                         <div class="ibox-tools">
                                             <a class="collapse-link">
                                                 <i class="fa fa-chevron-up"></i>
                                             </a>
                                             <a class="close-link">
                                                 <i class="fa fa-times"></i>
                                             </a>
                                         </div>
                                     </div>
                                     <div class="ibox-content">

                                     <table class="table table-hover no-margins">
                                                 <thead>
                                                 <tr>
                                                     <th>Allergy</th>
                                                     <th>Description</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody>
                                                   @if($allergies)
                                                   @foreach($allergies as $alleg)

                                                 <tr>
                                                     <td>{{$alleg->allergies}}</td>
                                                     <td>{{$alleg->status}}</td>
                                                 </tr>
                                                 @endforeach
                                                 @else
                                                 <tr>
                                                 <td class="text-navy">No Data Available </td>
                                                 </tr>
                                                 @endif
                                                 </tbody>
                                             </table>

                                     </div>
                                 </div>
                             </div>


   </div>
   <div class="row">
               <div class="col-lg-4">
                   <div class="ibox float-e-margins">
                       <div class="ibox-title">
                           <!-- <span class="label label-success pull-right">Monthly</span> -->
                           <h5>Alcohol/Drugs History</h5>
                       </div>
                       <div class="ibox-content">
                         @if($alcohol)
                         <ul class="list-group clear-list m-t">
                           @if($alcohol->drink=='YES')
                           <li class="list-group-item fist-item">
                             <span class="pull-right">  {{$alcohol->drink}}</span>
                             Drinking
                           </li>
                           <li class="list-group-item ">
                             <span class="pull-right">  {{$alcohol->drinking_frequency}}</span>
                             Drinking Frequency
                           </li>
                           @elseif($alcohol->drink=='NO')
                           <li class="list-group-item ">
                             <span class="pull-right"> Non-Drinker</span>
                             Drinking
                           </li>
                           @endif
                           @if($alcohol->used_recreational_drugs=='YES')
                           <li class="list-group-item ">
                             <span class="pull-right">  {{$alcohol->used_recreational_drugs}}</span>
                             Recreational Drugs
                           </li>
                           <li class="list-group-item">
                             <span class="pull-right">  {{$alcohol->drug_type}}</span>
                             Drug Type
                           </li>
                           @elseif($alcohol->used_recreational_drugs=='NO')
                           <li class="list-group-item">
                             <span class="pull-right"> None</span>
                             Recreational Drugs
                           </li>
                           @endif
                           @if($alcohol->caffeine_liquids=='YES')
                           <li class="list-group-item">
                             <span class="pull-right"> {{$alcohol->caffeine_liquids}}</span>
                             Caffeine Liquids
                           </li>
                           @endif
                          </ul>
                          @else
                          <ul class="list-group clear-list m-t">
                              <li class="list-group-item fist-item">
                            No Data Available
                              </li>
                                </ul>
                            @endif
                       </div>
                   </div>
               </div>
               <div class="col-lg-4">
                   <div class="ibox float-e-margins">
                       <div class="ibox-title">
                           <!-- <span class="label label-info pull-right">Annual</span> -->
                           <h5>Smoking History (Cigarretes)</h5>
                       </div>
                       <div class="ibox-content">
                         @if($smoking)
                         <ul class="list-group clear-list m-t">
                           @if($smoking->smoker=='YES')
                           <li class="list-group-item fist-item">
                           <span class="pull-right">  {{$smoking->smoker}}</span>
                           A Smoker
                           </li>
                           <li class="list-group-item">
                           <span class="pull-right">  {{$smoking->cigarretes_per_day}}</span>
                           Cigarette Per day
                           </li>
                           <li class="list-group-item">
                           <span class="pull-right">
                           {{$smoking->period_smoked}}
                           </span>
                           Period Smoked (Years)
                           </li>

                           @elseif($smoking->smoker=='NO')
                           @if($smoking->ever_smoked=='YES')
                           <li class="list-group-item fist-item">
                             <span class="pull-right">
                               {{$smoking->ever_smoked}}
                             </span>
                             <span class="label label-info"></span> Ever Smoked
                           </li>


                           <li class="list-group-item">
                             <span class="pull-right">{{$smoking->stop_date}}
                             </span>
                             <span class="label label-primary"></span> Stop Date
                           </li>
                           <li class="list-group-item">
                             <span class="pull-right">
                               {{$smoking->period_smoked}} Years
                             </span>
                             Period Smoked
                           </li>
                           <li class="list-group-item">

                           </li>
                           @elseif($smoking->ever_smoked=='NO')
                           <li class="list-group-item fist-item">
                             <span class="pull-right">
                               None Smoker
                             </span>
                             Patient is
                           </li>
                           @endif
                           @endif
                         </ul>
                         @else
                         <ul class="list-group clear-list m-t">
                             <li class="list-group-item fist-item">
                           No Data Available
                             </li>
                               </ul>
                           @endif
                       </div>
                   </div>
               </div>
               <div class="col-lg-4">
                   <div class="ibox float-e-margins">
                       <div class="ibox-title">
                           <!-- <span class="label label-primary pull-right">Today</span> -->
                           <h5>Current Medication</h5>
                       </div>
                       <div class="ibox-content">

                         <table class="table table-hover no-margins">
                             <thead>
                             <tr>
                                 <th>Drug</th>
                                 <th>Start Date</th>
                                 <th>End Date</th>
                             </tr>
                             </thead>
                             <tbody>
                                @if($prescriptions)
                                     @foreach($prescriptions as $presc)
                                     <?php
                                     $subdrug = DB::table('druglists')->select('drugname')->where('id', '=',$presc->subdrug)->first();

                                     ?>
                              <tr>
                                 <td>@if($presc->substitute){{$subdrug->drugname}} @else {{$presc->drugname}} @endif</td>
                                 <td>{{$presc->start_date}}</td>
                                 <td>{{$presc->end_date}}</td>
                             </tr>
                             @endforeach
                             @else

                             <tr><td>  No Data Available</tr></td>

                               @endif


                             </tbody>
                         </table>
                       </div>
                   </div>
               </div>

   </div>


 </div>

   <!-- <div class="row wrapper wrapper-content border-bottom white-bg">
     <div class="row">
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
                         <a href="{{ route('pathistory.show',$pat) }}" class="btn btn-primary"><i class="fa fa-print"></i> Edit Details </a>
                         <a href="{{ route('details',$pat) }}" class="btn btn-primary"><i class="fa fa-print"></i> Triage Details </a>
                       </div>
                   </div>
               </div>
 </div> -->
