@extends('layouts.doctor_layout')
@section('title', 'Tests')
  @section('content')
            <?php
            $dependantId = $pdetails->persontreated;
          	$afyauserId = $pdetails->afya_user_id;
            $app_id = $pdetails->appId;
            $condition = $pdetails->condition;


            if ($dependantId =='Self')   {
           	 $afyadetails = DB::table('afya_users')
           ->select('dob','gender','firstname','secondName')
           	->where('id', '=',$afyauserId)->first();

           	 $dob=$afyadetails->dob;
           	 $gender=$afyadetails->gender;
           	 $firstName = $afyadetails->firstname;
           	 $secondName = $afyadetails->secondName;
           	 $name =$firstName." ".$secondName;
           }else{
           	$deppdetails = DB::table('dependant')
             ->select('dob','gender','firstName','secondName')
           	->where('id', '=',$dependantId)
           	->first();

           	          $dob=$deppdetails->dob;
                       $gender=$deppdetails->gender;
                       $firstName = $deppdetails->firstName;
                       $secondName = $deppdetails->secondName;
                       $name =$firstName." ".$secondName;
           }
           $interval = date_diff(date_create(), date_create($dob));
           $age= $interval->format(" %Y Year, %M Months, %d Days Old");
           if ($gender == 1) { $gender = 'Male'; }else{ $gender = 'Female'; }

            ?>


<div class="wrapper wrapper-content animated fadeInRight">
  <!--tabs Menus-->
  <div class="row border-bottom">
  <nav class="navbar" role="navigation">
    <div class="navbar-collapse " id="navbar">
          <ul class="nav navbar-nav">
            <li><a role="button" href="{{route('showPatient',$app_id)}}">Today's Triage</a></li>
            <li class="active"><a role="button" href="{{route('patienthistory',$app_id)}}">History</a></li>
            <li><a role="button" href="{{route('alltestes',$app_id)}}">Tests</a></li>
            <li><a role="button" href="{{route('diagnoses',$app_id)}}">Diagnosis</a></li>
            <li><a role="button" href="{{route('medicines',$app_id)}}">Prescriptions</a></li>
            <li><a role="button" href="{{route('procedure',$app_id)}}">Procedures</a></li>

            @if ($condition =='Admitted')
              <li><a role="button" href="{{route('discharge',$app_id)}}">Discharge</a></li>
             @else
              <li><a role="button" href="{{route('admit',$app_id)}}">Admit</a></li>@endif
              <li><a role="button" href="{{route('transfering',$app_id)}}">Referral</a></li>
             <li><a role="button" href="{{route('endvisit',$app_id)}}">End Visit</a></li>
           </ul>
       </div>
  </nav>
  </div>
  <div class="row">

      <div class="col-md-11 white-bg">
<br /><br />
      <div class="col-md-6">
        <address>

        <strong>Patient:</strong><br>
        Name: {{$name}}<br>
        Gender: {{$gender}}<br>
        Age: {{$age}}
      </address>

      </div>
      <div class="col-md-6 text-right">
        <address>
          <strong>Requested By:</strong><br>
           {{$pdetails->docname}}<br>
          <strong>Facility :</strong><br>
          {{$pdetails->FacilityName}}<br>

        </address>
      </div>
    </div>
</div>

  <div class="row">
    <div class="col-md-11 white-bg">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
        <h5>Tests Requested </h5>
       </div>
        <div class="ibox-content">
          <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Test Name</th>
                                    <th>Category</th>
                                    <!-- <th>Conditional Diesease</th> -->
                                    <th>Date Created</th>
                                    <th>Action</th>

                                  </tr>
                            </thead>
                          <tbody>
                            <?php $i =1;

                        if($tsts){
                            ?>

                            @foreach($tsts as $tst)

                              <tr>
                              <td>{{$i}}</td>
                              <td>{{$tst->tname}}</td>
                              <td>{{$tst->tsname}}</td>
                              <!-- <td>{{$tst->dname }}</td> -->
                              <td>{{$tst->date}}</td>
                              <td class="btn btn-primary">
                           @if($tst->done==1)
                        <a href="{{route('viewtestdoc',$tst->patTdid)}}">View Test</a>
                       @else
                       Pending
                        @endif
                        </td>
                             </tr>
                            <?php $i++; ?>
                              @endforeach
                       <?php } ?>

                       <?php $i =$i;

                       if($rady){
                       ?>

                       @foreach($rady as $radst)
                       <?php
                       if ($radst->test_cat_id== '9') {
                         $ct=DB::table('ct_scan')->where('id', '=',$radst->test) ->first();
                         $test = $ct->name;
                         $type ='donectdoc';


                       } elseif ($radst->test_cat_id== 10) {
                         $xray=DB::table('xray')->where('id', '=',$radst->test) ->first();
                         $test = $xray->name;
                         $type ='donexraydoc';
                       } elseif ($radst->test_cat_id== 11) {
                         $mri=DB::table('mri_tests')->where('id', '=',$radst->test)->first();
                         $test = $mri->name;
                         $type ='donemridoc';
                       }elseif ($radst->test_cat_id== 12) {
                         $ultra=DB::table('ultrasound')->where('id', '=',$radst->test) ->first();
                         $test = $ultra->name;
                         $type ='doneultradoc';
                       }

                       ?>
                         <tr>
                         <td>{{$i}}</td>
                         <td>{{$test}}</td>
                         <td>{{$radst->tcname}}</td>
                         <!-- <td>{{$radst->clinicalinfo}}</td> -->
                         <td>{{$radst->date}}</td>
                       <td class="btn btn-primary">
                          @if($radst->done==0)
                          Pending
                         @else
                         <a href="{{route($type,$radst->patTdid)}}">View Test</a>

                          @endif
                       </td>
                       </tr>
                       <?php $i++; ?>
                         @endforeach
                       <?php } ?>

                             </tbody>
                      </table>

                               </div>

                           </div>
                       </div>
                   </div>
</div>
       </div>

@endsection
