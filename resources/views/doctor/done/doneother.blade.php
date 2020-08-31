@extends('layouts.doctor_layout')
@section('title', 'Ultrasound Tests')
@section('content')


@section('leftmenu')
@include('includes.doc_inc.leftmenu')
@endsection
<?php


$facility = $tsts1->FacilityName;
$dependantId = $tsts1->persontreated;
	$afyauserId = $tsts1->afya_user_id;
	$appId = $tsts1->appointment_id;
	$ptdId = $tsts1->id;


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
	           $age= $interval->format(" %Y Years Old");
?>
<?php
$frepo = DB::table('ultrasound_findings')
->leftJoin('radiology_test_result', 'ultrasound_findings.id', '=', 'radiology_test_result.findings_id')
->where('ultrasound_findings.ultrasound_id', '=',$tsts1->ultraid)
->select('radiology_test_result.created_at')
->first();
	?>


	<div class="row wrapper border-bottom white-bg page-heading">
					<div class="col-lg-8">
							<h2>TEST RESULTS</h2>
							<!-- <ol class="breadcrumb">
									<li>
											<a href="index.html">Home</a>
									</li>
									<li>
											Other Pages
									</li>
									<li class="active">
											<strong>Invoice</strong>
									</li>
							</ol> -->
					</div>
					<div class="col-lg-4">
							<div class="title-action">
								<a class="btn btn-primary " href="{{url('doctor.visit_details',$tsts1->appid)}}"><i class="fa fa-arrow-left"></i>GO BACK</a>
								<button name="b_print" class="btn btn-primary" type="button" onClick="printdiv('div_print');"> <i class="fa fa-paste"></i>PRINT</button>

							</div>
					</div>
			</div>
	<div id="div_print">
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="row">

			<div class="col-md-10 col-md-offset-1 white-bg">
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
					 {{$tsts1->docname}}<br>
					{{$tsts1->FacilityName}}<br>
        </address>
			</div>
		</div>
	</div>
		<div class="row">
	<div class="col-md-10">
				<h3 class="text-center">TEST REPORT</h3>
	      </div>
	</div>
<div class="row wrapper border-bottom page-heading">
  <div class="content-page  equal-height">
		<div class="content">
			<?php
			$freport = DB::table('radiology_test_result')
			->where('radiology_td_id', '=',$tsts1->rtdid)
			->select('results')
			->get();
				?>
             <div class="col-lg-11 col-md-offset-1">
		                    <div class="ibox float-e-margins">
		                        <div class="">
		        <h3>{{$tsts1->tstname}} @if($tsts1->target)-{{$tsts1->target}} @else @endif</h3>
		                        </div>
		                        <div class="ibox-content">
		                            <form class="form-horizontal">
																	<div class="form-group">
																		@if($tsts1->clinicalinfo)
																		<p><b>Clinical Information</b></p>
																		<p>{{$tsts1->clinicalinfo}}</p>
																		@endif

																			@if($tsts1->technique)
																		 <p><b>TECHNIQUE</b></p>
																		 <p>{{$tsts1->technique}}</p>
                                      @endif

																		@if($freport)
                                 <p><b>RESULTS</b></p>
																		 @foreach($freport as $frpt)
																		<p>{{$frpt->results}}</p>
																		 @endforeach
																		 @endif
		                            </form>
		                        </div>
		                    </div>
		                </div>

</div>
</div><!--content-->

  </div><!--content page-->
</div><!--content page-->
</div><!--content page-->
</div><!--printpage-->
@endsection
