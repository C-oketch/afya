<div class="row border-bottom">
  <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

    </div>
    <ul class="nav navbar-top-links navbar-right">
      <li>
        <span class="m-r-sm text-muted welcome-message">Welcome to Afyapepe.</span>
      </li>

      <li>
        <a class="right-sidebar-toggle ">
          <i class="fa fa-tasks"></i>
        </a>

        <!-- <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a> -->

      </li>
    </ul>
  </nav>
</div>
<?php

$lastapp = DB::table('appointments')
->leftjoin('triage_details', 'appointments.id', '=', 'triage_details.appointment_id')
->select('appointments.*')
->where([['appointments.afya_user_id',$afyauserId],['appointments.id','!=', $app_id],['appointments.status','!=', 0],])
->OrderBY('appointments.id','Desc')
->first();



if($lastapp) {
  $appointment =$lastapp->id;

  $lastimpression = DB::table('impression')->select('notes')
  ->where('appointment_id', $appointment)->get();

  $diagnosis = DB::table('patient_diagnosis')->select('disease_id')->where('appointment_id', '=',$appointment)
  ->orderBy('appointment_id', 'desc')
  ->get();

  $prescriptions =DB::table('prescriptions')
  ->join('prescription_details','prescriptions.id','=','prescription_details.presc_id')
  ->select('prescription_details.drug_id')
  ->where([['prescriptions.appointment_id',$appointment],['prescription_details.deleted',0],])
  ->get();

  $summary = DB::table('patient_summary')->select('notes')->where('appointment_id', '=',$appointment)->get();
  // $cmeds= DB::table('current_medication')->select('drugs')->where('appointment_id', '=',$appointment)->get();
  $lastrady = DB::table('patient_test')
  ->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
  ->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
  ->select('radiology_test_details.created_at as date','radiology_test_details.test',
  'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
  'radiology_test_details.id as patTdid','test_categories.name as tcname')
  ->where('patient_test.appointment_id', '=',$appointment)
  ->get();

  $lasttsts = DB::table('appointments')
  ->Join('patient_test', 'patient_test.appointment_id', '=', 'appointments.id')
  ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
  ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  ->leftJoin('test_results', 'patient_test_details.id', '=', 'test_results.id')
  ->select('tests.name as tname','test_results.value','patient_test_details.id as ptdid')
  ->where('appointments.id', '=',$appointment)
  ->get();
}


$impression = DB::table('impression')->select('notes')
->where('appointment_id', '=',$app_id)->get();

$diagnosist = DB::table('patient_diagnosis')->select('disease_id')->where('appointment_id', '=',$app_id)
->orderBy('appointment_id', 'desc')
->get();
$prescriptionst =DB::table('prescriptions')
->join('prescription_details','prescriptions.id','=','prescription_details.presc_id')
->select('prescription_details.drug_id')
->where([['prescriptions.appointment_id',$app_id],['prescription_details.deleted',0],])
->get();
$summaryt = DB::table('patient_summary')->select('notes')->where('appointment_id', '=',$app_id)->get();
// $cmedst= DB::table('current_medication')->select('drugs')->where('appointment_id', '=',$app_id)->get();


$famHistory = DB::table('family_summary')->select('family_members','notes')->where('afya_user_id', '=',$afyauserId)->get();
$allergies = DB::table('afya_users_allergy')->select('allergies','status')->where('afya_user_id', '=',$afyauserId)->get();
$mcds = DB::table('patient_diagnosis')->where('afya_user_id',$afyauserId)->get();

$rady = DB::table('patient_test')
->Join('radiology_test_details', 'patient_test.id', '=', 'radiology_test_details.patient_test_id')
->leftJoin('test_categories', 'radiology_test_details.test_cat_id', '=', 'test_categories.id')
->select('radiology_test_details.created_at as date','radiology_test_details.test',
'radiology_test_details.clinicalinfo','radiology_test_details.test_cat_id','radiology_test_details.done',
'radiology_test_details.id as patTdid','test_categories.name as tcname')
->where('patient_test.appointment_id', '=',$app_id)
->get();

$tsts = DB::table('appointments')
->Join('patient_test', 'patient_test.appointment_id', '=', 'appointments.id')
->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
->leftJoin('test_results', 'patient_test_details.id', '=', 'test_results.id')
->select('tests.name as tname','test_results.value','patient_test_details.id as ptdid')
->where('appointments.id', '=',$app_id)
->get();
?>

<div id="right-sidebar">
  <div class="sidebar-container">

    <ul class="nav nav-tabs navs-3">
      <li class="active"><a data-toggle="tab" href="#tab-91"><small>Previous </small> </a></li>
      <li><a data-toggle="tab" href="#tab-93"><i class="fa fa-info"></i><small>Today</small></a></li>
      <li><a data-toggle="tab" href="#tab-92"><small>Patient</small></a></li>

    </ul>

    <div class="tab-content">


      <div id="tab-91" class="tab-pane active">
        @if($lastapp)
        <div class="sidebar-title">
          <h5>Visit Date : @if($lastapp) {{$lastapp->created_at}} @else Today @endif </h5>
        </div>

        <div>

          <div class="sidebar-message">
            <a href="#">
              <h3><strong>Presenting Complaints</strong></h3>
              <div class="media-body">
                @foreach($summary as $summ)
                {{$summ->notes}} <br>
                @endforeach
              </div>
            </a>
          </div>

          <div class="sidebar-message">
            <a href="#">
              <h3><strong>Impression</strong></h3>
              <div class="media-body">

                @foreach($lastimpression as $imprss)
                {{$imprss->notes}} <br>
                @endforeach
              </div>
            </a>
          </div>
          <div class="sidebar-message">
            <a href="#">
              <h3><strong>Tests</strong></h3>
              <div class="media-body">

                @foreach($lasttsts as $tst)
                <?php   $imgs = DB::table('lab_images')->select('image')->where('patient_td_id', '=',$tst->ptdid)->get();
                ?>
                <strong> {{$tst->tname}} </strong>  <br>
                {{$tst->value}}  <br>
                @foreach($imgs as $img)
                <a class="mr-1" href="{{ asset("$img->image") }}  "target="_blank">View Image</a></br>
                @endforeach
                @endforeach

                @foreach($lastrady as $radst)
                <?php
                $test = '';
                $result= '';
                $rtdid = '';
                if ($radst->test_cat_id== '9') {
                  $ct=DB::table('ct_scan')->where('id', '=',$radst->test) ->first();
                  $ctresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
                  $test = $ct->name;
                  $rtdid =$radst->patTdid;
                  if($ctresult){  $result = $ctresult->results; }
                } elseif ($radst->test_cat_id== 10) {
                  $xray=DB::table('xray')->where('id', '=',$radst->test) ->first();
                  $xrayresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
                  $test = $xray->name;
                  $rtdid =$radst->patTdid;

                  if($xrayresult){  $result = $xrayresult->results; }
                } elseif ($radst->test_cat_id== 11) {
                  $mri=DB::table('mri_tests')->where('id', '=',$radst->test)->first();
                  $mriresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
                  $test = $mri->name;
                  $rtdid =$radst->patTdid;

                  if($mriresult)  { $result = $mriresult->results; }
                }elseif ($radst->test_cat_id== 12) {
                  $ultra=DB::table('ultrasound')->where('id', '=',$radst->test) ->first();
                  $ultraresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
                  $test = $ultra->name;
                  $rtdid =$radst->patTdid;

                  if($ultraresult) { $result = $ultraresult->results;  }
                }elseif ($radst->test_cat_id== 13) {
                  $other=DB::table('other_tests')->where('id', '=',$radst->test) ->first();
                  $otherresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
                  $test = $other->name;
                  $rtdid =$radst->patTdid;

                  if($otherresult) { $result = $otherresult->results;}
                }

                ?>

                <strong>{{$test}} </strong>  <br>
                @if($result) {{$result}} @endif  <hr>
                <?php   $imgsrd = DB::table('radiology_images')->select('image')->where('radiology_td_id', '=',$rtdid)->get();  ?>
                @foreach($imgsrd as $imgs)
                <a class="mr-1" href="{{ asset("$imgs->image") }}  "target="_blank">View Image</a></br>
                @endforeach
                @endforeach
              </div>
            </a>
          </div>
          <div class="sidebar-message">
            <a href="#">
              <h3><strong>Diagnosis Made</strong></h3>
              <div class="media-body">
                @foreach($diagnosis as $tst1)
                {{$tst1->disease_id}} <br>
                @endforeach
              </div>
            </a>
          </div>


          <div class="sidebar-message">
            <a href="#">
              <h3><strong>Prescription Given</strong></h3>
              <div class="media-body">
                @foreach($prescriptions as $prsc)
                {{$prsc->drug_id}}<br>
                @endforeach
              </div>
            </a>
          </div>

        </div>
        @else
        <div class="sidebar-title">
          <h5>No Last visit</h5>
        </div>
        @endif
      </div>

      <div id="tab-92" class="tab-pane">

        <!-- <div class="sidebar-title">
        <h3> <i class="fa fa-cube"></i> Latest projects</h3>
        <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
      </div> -->

      <ul class="sidebar-list">
        <li>
          <a href="#">
            <div class="small pull-right m-t-xs"></div>
            <h4><strong>Allergies</strong></h4>
            @foreach($allergies as $allerg)
            <strong class="mr-1">{{$allerg->allergies}} </strong>  {{$allerg->status}}<br>
            @endforeach

          </a>
        </li>
        <li>
          <a href="#">
            <div class="small pull-right m-t-xs"></div>
            <h4><strong>Past Medical History</strong></h4>
            @foreach($mcds as $mcs)
            <strong class="mr-1">{{$mcs->disease_id}} </strong><br>
            @endforeach


          </a>
        </li>
        <li>
          <a href="#">
            <div class="small pull-right m-t-xs"></div>
            <h4><strong>Family History</strong></h4>
            @foreach($famHistory as $fam)
            <strong class="mr-1">{{$fam->family_members}}</strong>  <p>{{$fam->notes}}</p><br>
            @endforeach
          </a>
        </li>


      </ul>

    </div>

    <div id="tab-93" class="tab-pane">

      <div class="sidebar-title">
        <h3><strong>Today Visit Summary</strong></h3>
      </div>

      <div class="sidebar-message"><h3><strong>Presenting Complaints</strong></h3>
        @foreach($summaryt as $summ)
        {{$summ->notes}} <br>
        @endforeach
      </div>
      <div class="sidebar-message">
        <a href="#">
          <h3><strong>Impression</strong></h3>
          <div class="media-body">
            @foreach($impression as $imprsst)
            {{$imprsst->notes}} <br>
            @endforeach
          </div>
        </a>
      </div>

      <div class="sidebar-message">
        <a href="#">
          <h3><strong>Tests</strong></h3>
          <div class="media-body">

            @foreach($tsts as $tst)
            <?php   $imgs = DB::table('lab_images')->select('image')->where('patient_td_id', '=',$tst->ptdid)->get();
            ?>
            <strong> {{$tst->tname}} </strong>  <br>
            {{$tst->value}}  <br>
            @foreach($imgs as $img)
            <a class="mr-1" href="{{ asset("$img->image") }}  "target="_blank">View Image</a></br>
            @endforeach
            @endforeach

            @foreach($rady as $radst)
            <?php
            $test = '';
            $result= '';
            $rtdid = '';
            if ($radst->test_cat_id== '9') {
              $ct=DB::table('ct_scan')->where('id', '=',$radst->test) ->first();
              $ctresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
              $test = $ct->name;
              $rtdid =$radst->patTdid;
              if($ctresult){  $result = $ctresult->results; }
            } elseif ($radst->test_cat_id== 10) {
              $xray=DB::table('xray')->where('id', '=',$radst->test) ->first();
              $xrayresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
              $test = $xray->name;
              $rtdid =$radst->patTdid;

              if($xrayresult){  $result = $xrayresult->results; }
            } elseif ($radst->test_cat_id== 11) {
              $mri=DB::table('mri_tests')->where('id', '=',$radst->test)->first();
              $mriresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
              $test = $mri->name;
              $rtdid =$radst->patTdid;

              if($mriresult)  { $result = $mriresult->results; }
            }elseif ($radst->test_cat_id== 12) {
              $ultra=DB::table('ultrasound')->where('id', '=',$radst->test) ->first();
              $ultraresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
              $test = $ultra->name;
              $rtdid =$radst->patTdid;

              if($ultraresult) { $result = $ultraresult->results;  }
            }elseif ($radst->test_cat_id== 13) {
              $other=DB::table('other_tests')->where('id', '=',$radst->test) ->first();
              $otherresult=DB::table('radiology_test_result')->where('radiology_td_id', '=',$radst->patTdid) ->first();
              $test = $other->name;
              $rtdid =$radst->patTdid;

              if($otherresult) { $result = $otherresult->results;}
            }

            ?>

            <strong>{{$test}} </strong>  <br>
            @if($result) {{$result}} @endif  <hr>
            <?php   $imgsrd = DB::table('radiology_images')->select('image')->where('radiology_td_id', '=',$rtdid)->get();  ?>
            @foreach($imgsrd as $imgs)
            <a class="mr-1" href="{{ asset("$imgs->image") }}  "target="_blank">View Image</a></br>
            @endforeach
            @endforeach
          </div>
        </a>
      </div>
      <div class="sidebar-message"><h3><strong>Diagnosis Made</strong></h3>
        @foreach($diagnosist as $tst1)
        {{$tst1->disease_id}} <br>
        @endforeach
      </div>

      <div class="sidebar-message"><h3><strong> Prescription Given</strong></h3>
        @foreach($prescriptionst as $prsc)
        {{$prsc->drug_id}}<br>
        @endforeach

      </div>
    </div>

  </div>
</div>
</div>
