
<!--Test result tabs PatientController@testdone-->
<?php

if ($dependantId =='Self') {
  $tstdone = DB::table('patient_test')
  ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
  ->leftJoin('facilities', 'patient_test_details.facility_done', '=', 'facilities.id')
  ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  // ->leftJoin('diseases', 'patient_test_details.conditional_diag_id', '=', 'diseases.id')
  ->select('patient_test_details.id as ptdid','patient_test_details.*','facilities.*','tests.name')
 ->where('appointments.afya_user_id', '=',$afyauserId)
 ->where('patient_test_details.deleted', '=',0)
  ->orderBy('patient_test_details.created_at', 'desc')
  ->get();

}else{
  $tstdone = DB::table('patient_test')
  ->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
  ->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
  ->leftJoin('facilities', 'patient_test_details.facility_done', '=', 'facilities.id')
  ->Join('tests', 'patient_test_details.tests_reccommended', '=', 'tests.id')
  // ->Join('diseases', 'patient_test_details.conditional_diag_id', '=', 'diseases.id')
  ->select('patient_test_details.id as ptdid','patient_test_details.*','facilities.*','tests.name')
  ->Where('appointments.persontreated', '=',$dependantId)
  ->where('patient_test_details.deleted', '=',0)
  ->orderBy('patient_test_details.created_at', 'desc')
  ->get();


}
?>

<!--lab test-->
<div id="tab-2" class="tab-pane">
  <div class="panel-body">

  <?php $i =1; ?>
        <div class="table-responsive ibox-content">
          <h5>LABORATORY TESTS</h5>
         <table class="table table-striped table-bordered table-hover dataTables-tests" >
           <thead>
        <tr>
         <th>No</th>
         <th>Date </th>
        <th>Test Name</th>
        <th>Result</th>
        <th>Note</th>
        <th>Action</th>

      </tr>
        </thead>

        <tbody>

        @foreach($tstdone as $tstdn)
    <?php    $ptdid =$tstdn->ptdid;
      $prescs=$tstdn->done;
      if (is_null($prescs)) {
        $prescs= 'N/A';
      }
      elseif ($prescs==0) {
        $prescs= 'Pending';
      } elseif($prescs==1) {
        $prescs= 'Complete';
      }
        ?>
          <tr>
          <td>{{$i}}</td>
         <td>{{$tstdn->created_at}}</td>
         <td>{{$tstdn->name}}</td>
      <td>@if($tstdn->results){{$tstdn->results}}@else{{$prescs}}@endif</td>
           <td>{{$tstdn->note}}</td>
           @if($tstdn->confirm =='N')
           @if($tstdn->done =='1')
          <td>
             {{ Form::open(array('route' => array('diaconf'),'method'=>'POST')) }}
               {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
               {{ Form::hidden('pat_details_id',$ptdid, array('class' => 'form-control')) }}
               <button class="btn btn-sm btn-primary  m-t-n-xs" type="submit"><strong>Confirm Diagnosis</strong></button>
              {{ Form::close() }}
          </td>
           @else
           <td>
             {{ Form::open(['method' => 'DELETE','route' => ['test.deletes', $tstdn->ptdid],'style'=>'display:inline']) }}
              {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
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
