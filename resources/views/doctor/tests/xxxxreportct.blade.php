@extends('layouts.show')
@section('title', 'Test')
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


}

   $stat= $patientD->status;
         $afyauserId= $patientD->afya_user_id;
          $dependantId= $patientD->persontreated;
          $app_id =  $patientD->id;
          $doc_id= $patientD->doc_id;
          $fac_id= $patientD->facility_id;
          $fac_setup= $patientD->set_up;
          $condition  = $patientD->condition;


 if ($dependantId =='Self') {
          $dob=$patientD->dob;
          $gender=$patientD->gender;
          $firstName = $patientD->firstname;
          $secondName = $patientD->secondName;
          $name =$firstName." ".$secondName;

   }else {
           $dependantId=$patientD->persontreated;
//Dependant data to be here

      }


  $interval = date_diff(date_create(), date_create($dob));
  $age= $interval->format(" %Y Year, %M Months, %d Days Old");




?>


        <!--tabs Menus-->
        <div class="row border-bottom">
        <nav class="navbar" role="navigation">
          <div class="navbar-collapse " id="navbar">
                <ul class="nav navbar-nav">
                  <li><a role="button" href="{{route('showPatient',$app_id)}}">Today's Triage</a></li>
                  <li><a role="button" href="{{route('patienthistory',$app_id)}}">History</a></li>
                  <li class="active"><a role="button" href="{{route('testes',$app_id)}}">Tests</a></li>
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

     <div class="row wrapper border-bottom white-bg page-heading">

     	<div class="row">
     			<div class="col-md-10 col-md-offset-1">

     			<div class="col-md-6">
     				<address>
              <br />
     				<strong>Patient:</strong><br>
     				Name: {{$name}}<br>
     				Gender: {{$gender}}<br>
     				Age: {{$age}}
           </address>

     			</div>
     			<div class="col-md-6 text-right">
     				<address>
              <br />
     					<strong>Requested By:</strong><br>
     					Doctor: <br>
     					LAB:  <br>


     				</address>
     			</div>
     		</div>
     </div>
     <div class="row">
        <div class="col-md-11">
          <div class="col-md-8 col-md-offset-2">
               <div class="ibox float-e-margins">
                   <div class="text-center">
                       <h3>TEST REPORT</h3>
                   </div>
                   <div class="ibox-content">
                       <div class="list-group">
                         <h4>Images</h4>

                         <form role="form" class="form-inline">
                           <?php $images=DB::table('radiology_images')->where('radiology_td_id',$tsts1->rtdid)->get(); ?>
                    @foreach($images as $image)
                        <div class="form-group">
                          <a href="{{ asset("images/$image->image") }} "target="_blank">View Image</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    @endforeach

                          </form>

                   </div>
               </div>
           </div>
         </div>
      </div>
</div>
<div class="row">
     <div class="col-md-11">
       <div class="col-md-8 col-md-offset-2">

                  <div class="ibox-content">
                      <div class="list-group">

                          <a class="list-group-item">
                              <h3 class="list-group-item-heading">CLINICAL INFORMATION : </h3>

                              <p class="list-group-item-text">{{$tsts1->clinicalinfo}} </p>
                          </a>

                          <a class="list-group-item" href="#">
                              <h3 class="list-group-item-heading">TECHNIQUE :</h3>
                              <p class="list-group-item-text">{{$tsts1->technique}}</p>
                          </a>
                          <?php
                        // $freport = DB::table('mri_findings')
                        // ->Join('radiology_test_result', 'mri_findings.id', '=', 'radiology_test_result.findings_id')
                        //   ->where([['mri_findings.mri_tests_id', '=',$tsts1->ctid],['radiology_td_id', '=',$tsts1->rtdid],])
                        //   ->select('radiology_test_result.results','mri_findings.findings')
                        //   ->get();
                            ?>
                          <!-- <a class="list-group-item" href="#">
                              <h3 class="list-group-item-heading">FINDINGS :</h3>
                              @foreach($freport as $frpt)
                             <p class="list-group-item-text"><label>{{$frpt->findings}} :</label>&nbsp;&nbsp;{{$frpt->results}}</p>
                                     @endforeach
                          </a> -->


                          <a class="list-group-item" href="#">
                              <h3 class="list-group-item-heading">IMPRESSION : </h3>
                            <p class="list-group-item-text">{{$tsts1->conclusion}}</p>

                          </a>
                          <a class="list-group-item" href="#">
                              <h3 class="list-group-item-heading">DONE BY : </h3>
                            <p class="list-group-item-text"><strong>DR.</strong> {{$tsts1->firstname}} {{$tsts1->secondname}}</p>
                            <p class="list-group-item-text"><strong>RADIOLOGIST</strong></p>
                            <p class="list-group-item-text"><strong>FACILITY: </strong> {{$tsts1->FacilityName}}</p>
                          </a>

                  </div>
              </div>
          </div>
        </div>
</div>







    <div class="col-md-8 col-md-offset-2">
              <div class="ibox float-e-margins">
                  <div class="ibox-title">
                      <h5>Diagnosis</h5>
                  </div>
                  <div class="ibox-content">
                      <div class="list-group">
                        {{ Form::open(array('route' => array('confradiology'),'method'=>'POST')) }}
                              <div class="col-md-6 b-r">

                              <div class="form-group">
                                <label>Diagnosis :</label>
                                <input type="text" name="radiology" value="{{$tsts1->conclusion}}" class="form-control">
                              </div>
                               </div>
                               <div class="col-sm-6">
                                 <div class="form-group">
                                   <label>Any Other notes :</label>
                                   <textarea rows="4" name="note" cols="50"></textarea>
                                 </div>

                               {{ Form::hidden('state','Normal', array('class' => 'form-control')) }}
                               {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
                               {{ Form::hidden('rtdid',$tsts1->rtdid, array('class' => 'form-control')) }}

                               </div>
                               <div class="col-md-offset-5">
                               <button class=" mtop btn btn-sm btn-primary  m-t-n-xs" type="submit"><strong>Submit</strong></button>
                               </div>
                               {{ Form::close() }}

                  </div>
              </div>
          </div>
        </div>

</div>





@endsection
