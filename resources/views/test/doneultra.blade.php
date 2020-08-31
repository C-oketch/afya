@extends('layouts.test')
@section('title', 'Tests')
@section('content')
<?php
$test = (new \App\Http\Controllers\TestController);
$testdet = $test->TDetails();
foreach($testdet as $DataTests){
$facility = $DataTests->FacilityName;
$firstname = $DataTests->firstname;
$secondName = $DataTests->secondname;
$TName = $firstname.' '.$secondName;
$facilityId = $DataTests->FacilityCode;

}


	$dependantId = $tsts1->persontreated;
	$afyauserId = $tsts1->afya_user_id;
	$appId = $tsts1->appointment_id;
	$ptdId = $tsts1->id;

 if ($dependantId =='Self')   {
	 $afyadetails = DB::table('appointments')
	 ->leftJoin('triage_details', 'appointments.id', '=', 'triage_details.appointment_id')
	 ->leftJoin('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
	 ->select('triage_details.*','afya_users.*')
	 ->where('appointments.id', '=',$appId)
	 ->first();

	 $dob=$afyadetails->dob;
	 $gender=$afyadetails->gender;
	 $firstName = $afyadetails->firstname;
	 $secondName = $afyadetails->secondName;
	 $name =$firstName." ".$secondName;
}else{
	$deppdetails = DB::table('appointments')
	->leftJoin('triage_infants', 'appointments.id', '=', 'triage_infants.appointment_id')
	->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
	->select('triage_infants.*','dependant.*')
	->where('appointments.id', '=',$appId)
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
<?php
$frepo = DB::table('ultrasound_findings')
->leftJoin('radiology_test_result', 'ultrasound_findings.id', '=', 'radiology_test_result.findings_id')
->where('ultrasound_findings.ultrasound_id', '=',$tsts1->ultraid)
->select('radiology_test_result.created_at')
->first();
	?>
<input name="b_print" type="button" class="btn btn-primary ipt"   onClick="printdiv('div_print');" value=" Print ">
<div id="div_print">
<div class="row wrapper border-bottom white-bg page-heading">
<div class="content-page  equal-height">
		<div class="content">
				<div class="container">
          <div class="col-lg-6 ">
					<h1></h1>
					<h4>Name: {{$name}}</h4>
					<h4>Gender: {{$gender}}</h4>
					<h4>Age: {{$age}}</h4>

					</div>

					<div class="col-lg-5 ">
					<h1></h1>
					<h4>LAB: {{$facility}}</h4>
					<h4>Doctor: {{$tsts1->docname}}</h4>
					<h4>Date: {{$frepo->created_at}}</h4>
          </div>
			</div>
			</div>
		</div>

	<div class="row">
	<div class="content-page  equal-height">
		<div class="content">
			<div class="container">
				<div class="col-lg-10">
			<h3 class="text-center">{{$tsts1->category}} REPORT</h3>




				 </div>
       </div>
		</div>
  </div>
</div>
<div class="row wrapper border-bottom page-heading">
  <div class="content-page  equal-height">
		<div class="content">

             <div class="col-lg-11 col-md-offset-1">
		                    <div class="ibox float-e-margins">
		                        <div class="ibox-title">
		                            <h5>TEST : {{$tsts1->tstname}} @if($tsts1->target)-{{$tsts1->target}} @else @endif</h5>

		                        </div>
		                        <div class="ibox-content">
		                            <form class="form-horizontal">
																	<div class="form-group">
																		<p><b>Clinical Information</b></p><p>{{$tsts1->clinicalinfo}}</p>
																		 <p><b>TECHNIQUE</b></p><p>{{$tsts1->technique}}</p>

		                            </form>
		                        </div>
		                    </div>
		                </div>



<div class="col-lg-12">
		<div class="ibox float-e-margins">
				<div class="ibox-title">
						<h5>Findings </h5>
				</div>

				<div class="ibox-content">
						<div class="row">
								<!-- <p>Sign in today for more expirience.</p> -->
										<form role="form">
											<?php
											$freport = DB::table('ultrasound_findings')
											->leftJoin('radiology_test_result', 'ultrasound_findings.id', '=', 'radiology_test_result.findings_id')
											->where('ultrasound_findings.ultrasound_id', '=',$tsts1->ultraid)
											->select('radiology_test_result.results','ultrasound_findings.findings')
											->get();
												?>
											@foreach($freport as $frpt)
                 <div class="form-group"><label>{{$frpt->findings}} :</label>{{$frpt->results}}</div>
                    @endforeach
										</form>
								</div>
				</div>
		</div>
</div>
<div class="col-lg-12">
		<div class="ibox float-e-margins">
				<div class="ibox-title">
						<h5>IMPRESSION</h5>
				</div>
				<div class="ibox-content">

						<p>{{$tsts1->target}} {{$tsts1->tstname}}</p>
        </div>
		</div>




		</div><!--content-->
  </div><!--content page-->
</div><!--content page-->
</div><!--content page-->
</div><!--printpage-->
@endsection
