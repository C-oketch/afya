<?php

 if($dependantId=='Self'){
   $pat=$afyauserId;
   $smoking = DB::table('smoking_history')->where('afya_user_id', '=',$pat)->first();
   $alcohol = DB::table('alcohol_drug_history')->where('afya_user_id', '=',$pat)->first();
   $medication = DB::table('self_reported_medication')
   ->join('druglists','self_reported_medication.drug_id', '=', 'druglists.id')
   ->Select('druglists.drugname','self_reported_medication.med_date')
   ->where('afya_user_id', '=',$pat)->get();
   $surgery = DB::table('self_reported_surgical_procedures')->where('afya_user_id', '=',$pat)->get();
   $medicalH = DB::table('self_reported_medical_history')->where('afya_user_id', '=',$pat)->first();

 }else{
    $pat=$dependantId;
 }
 ?>
<div class="row  border-bottom white-bg dashboard-header">



        <div class="col-lg-12">
          <h4>Self Reported</h4>
          <!-- Self reported Medical History -->
              <div class="col-md-3">
                  <h4>Medical History</h4>
                  @if($medicalH)
                  <ul class="list-group clear-list m-t">
                      <li class="list-group-item fist-item">
                          <span class="pull-right">
                              {{$medicalH->hypertension}}
                          </span>
                      Hypertension
                      </li>
                      <li class="list-group-item fist-item">
                          <span class="pull-right">
                              {{$medicalH->diabetes}}
                          </span>
                    Diabetes
                      </li>
                      <li class="list-group-item fist-item">
                          <span class="pull-right">
                              {{$medicalH->heart_attack}}
                          </span>
                    Heart Attack
                      </li>
                      <li class="list-group-item fist-item">
                          <span class="pull-right">
                              {{$medicalH->stroke}}
                          </span>
                    Stroke
                      </li>
                      <li class="list-group-item fist-item">
                          <span class="pull-right">
                              {{$medicalH->liver_disease}}
                          </span>
                    Liver Disease
                      </li>
                      <li class="list-group-item fist-item">
                          <span class="pull-right">
                              {{$medicalH->lung_disease}}
                          </span>
                    Lung Disease
                      </li>
                      <li class="list-group-item fist-item">
                          <span class="pull-right">
                              {{$medicalH->bowel_disease}}
                          </span>
                    Bowel Disease
                      </li>
                    </ul>
                    @else
                    <ul class="list-group clear-list m-t">
                        <li class="list-group-item fist-item">
                      No Data Available
                        </li>
                          </ul>
                      @endif
              </div>
              <!-- Self reported Medical History -->

@if($medicalH)
                          <div class="col-md-3">
                              <h4>Medical History</h4>
                              <ul class="list-group clear-list m-t">
                                <li class="list-group-item fist-item">
                                    <span class="pull-right">
                                        {{$medicalH->eye_disease}}
                                    </span>
                              Eye Disease
                                </li>
                                  <li class="list-group-item fist-item">
                                      <span class="pull-right">
                                          {{$medicalH->skin_problems}}
                                      </span>
                                Skin Problems
                                  </li>
                                  <li class="list-group-item fist-item">
                                      <span class="pull-right">
                                          {{$medicalH->pyschological_problems}}
                                      </span>
                                Pyschological Problems
                                  </li>
                                  <li class="list-group-item fist-item">
                                      <span class="pull-right">
                                          {{$medicalH->arthritis_joint_disease}}
                                      </span>
                                Arthritis Joint Disease
                                  </li>
                                  <li class="list-group-item fist-item">
                                      <span class="pull-right">
                                          {{$medicalH->gyneocological_disease}}
                                      </span>
                                Gyneocological Disease
                                  </li>
                                  <li class="list-group-item fist-item">
                                      <span class="pull-right">
                                          {{$medicalH->thyroid_disease}}
                                      </span>
                                Thyroid Disease
                                  </li>
                                </ul>
                          </div>
                          @endif
                          <!-- patient Drinking History Data -->

                          <div class="col-md-3">
                            <h4>Alcohol/Drugs History</h4>
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

  <!-- patient Smocking History Data -->
<div class="col-md-3">
  <h4>Smoking History (Cigarretes)</h4>
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
      <span class="pull-right">
        {{$smoking->stop_date}}
      </span><li class="list-group-item fist-item">
      <span class="pull-right">
        {{$smoking->period_smoked}}
      </span>
      Period Smoked
    </li>
      <span class="label label-primary"></span> Stop Date
    </li>
    <li class="list-group-item fist-item">
      <span class="pull-right">
        {{$smoking->period_smoked}}
      </span>
      Period Smoked
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
<!-- Smoking Ends Here-->


<!-- Self reported Medication-->

  <div class="col-md-3">
      <h4>Self Medication</h4>

      <ul class="list-group clear-list m-t">
        @if($medication)
        @foreach($medication as $med)
          <li class="list-group-item ">
              <span class="pull-right">
                {{$med->med_date}}
              </span>
            {{$med->drugname}}
          </li>
          @endforeach
       </ul>
       @else
       <ul class="list-group clear-list m-t">
           <li class="list-group-item fist-item">
         No Data Available
           </li>
             </ul>
       @endif
  </div>

<!-- Self reported SURGICAL PROCEDURE -->

<div class="col-md-3">
    <h4>Surgical Procedures</h4>
@if($surgery)
    <ul class="list-group clear-list m-t">
      @foreach($surgery as $procd)
        <li class="list-group-item ">
            <span class="pull-right">
              {{$procd->surgery_date}}
            </span>
          {{$procd->name_of_surgery}}
        </li>
        @endforeach
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
