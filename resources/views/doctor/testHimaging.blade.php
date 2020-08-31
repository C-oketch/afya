  <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                      <!--Test result tabs PatientController@testdone-->
                  <?php

if ($dependantId =='Self') {

  $radiology = DB::table('patient_test')
  ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
->select('radiology_test_details.*')
 ->where('appointments.afya_user_id', '=',$afyauserId)
  ->orderBy('radiology_test_details.created_at', 'desc')
  ->get();
}else{

  $radiology = DB::table('patient_test')
  ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
->select('radiology_test_details.*')
 ->where('appointments.persontreated', '=',$dependantId)
  ->orderBy('radiology_test_details.created_at', 'desc')
  ->get();

}
?>
<div class="table-responsive ibox-content">
  <h5>RADIOLOGY TESTS</h5>
<table class="table table-striped table-bordered table-hover dataTables-tests" >
                         <thead>
                      <tr>
                       <th></th>

                         <th>Date </th>
                        <th>Clinical Information</th>
                        <th>Test</th>
                        <th>Conclusion</th>
                        <th>Cat id</th>
                        <th>Action</th>

                    </tr>
                    </thead>

                      <tbody>
                        <?php $i =1; ?>
@foreach($radiology as $tstdn)

<?php
if ($tstdn->test_cat_id== '9') {
  $ct=DB::table('ct_scan')->where('id', '=',$tstdn->test) ->first();
  $test = $ct->name;
  $report  = 'ctreport';
} elseif ($tstdn->test_cat_id== 10) {
  $xray=DB::table('xray')->where('id', '=',$tstdn->test) ->first();
  $test = $xray->name;
    $report  = 'xrayreport';
} elseif ($tstdn->test_cat_id== 11) {
  $mri=DB::table('mri_tests')->where('id', '=',$tstdn->test) ->first();
  $test = $mri->name;
  $report  = 'mrireport';
}elseif ($tstdn->test_cat_id== 12) {
  $ultra=DB::table('ultrasound')->where('id', '=',$tstdn->test) ->first();
  $test = $ultra->name;
  $report  = 'ultrareport';
}
$cat=DB::table('test_categories')->where('id', '=',$tstdn->test_cat_id) ->first();
?>
                        <tr>
                        <td>{{ +$i }}</td>
                       <td>{{$tstdn->created_at}}</td>
                       <td>{{$tstdn->clinicalinfo}} </td>
                       <td>{{$test or ''}}</td>
                       <td>{{$tstdn->conclusion}}</td>
                       <td>{{$cat->name or ''}}</td>
                 @if($tstdn->confirm =='N')
                         @if($tstdn->done =='0')
                         <td>
                           {{ Form::open(['method' => 'DELETE','route' => ['Rady.deletes', $tstdn->id],'style'=>'display:inline']) }}
                            {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </td>

                         @else
                         <td>

                            {{ Form::open(array('route' => array($report),'method'=>'POST')) }}
                              {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
                              {{ Form::hidden('rtd_id',$tstdn->id, array('class' => 'form-control')) }}
                              <button class="btn btn-sm btn-primary  m-t-n-xs" type="submit"><strong>Confirm Diagnosis</strong></button>
                             {{ Form::close() }}
                         </td>
                          @endif
                    @else
                    <td> Confirmed</td>
                    @endif
                  </tr>
                      <?php $i++; ?>
                  @endforeach
                      </tbody>
                    </table>
          </div>
   </div>
</div>
