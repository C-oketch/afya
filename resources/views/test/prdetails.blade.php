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
	$facilityId = $DataTests->FacilityCode;
	$TName = $firstname.' '.$secondName;


}
if($pdetails){

	$dependantId = $pdetails->persontreated;
	$afyauserId = $pdetails->afya_user_id;
	$ptid = $pdetails->ptid;
	$docname=$pdetails->docname;

}elseif($alternative){

	$dependantId = $alternative->persontreated;
	$afyauserId = $alternative->afya_user_id;
	$ptid = $alternative->ptid;
	$docname=$alternative->docname;
}


if ($dependantId =='Self')   {
	$afyadetails = DB::table('afya_users')
	->select('afya_users.*')
	->where('id', '=',$afyauserId)
	->first();

	$dob=$afyadetails->dob;
	$gender=$afyadetails->gender;
	$firstName = $afyadetails->firstname;
	$secondName = $afyadetails->secondName;
	$name =$firstName." ".$secondName;
}else{
	$deppdetails = DB::table('dependant')
	->select('dependant.*')
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

?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="content-page  equal-height">
		<div class="content">
			<div class="container">

				<div class="col-lg-6">
					<h2>{{$name}}</h2>
					<ol class="breadcrumb">
						<li><a>@if($gender==1){{"Male"}}@else{{"Female"}}@endif</a></li>
						<li><a>{{$age}}</a> </li>

					</ol>
				</div>
				<div class="col-lg-5">
					<h2>LAB: {{$facility}}</h2>
					<ol class="breadcrumb">
						<li class="active"><strong>Name: {{$docname}} </strong></li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="ibox float-e-margins">
	<div class="col-lg-12">
		<div class="tabs-container">
			<div class="wrapper wrapper-content animated fadeInRight">

				<div class="row">

					<div class="col-md-12">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Tests Requested Imaging</h5>
								<div class="ibox-tools">
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
							<div class="ibox-content" id="shttable">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
										<thead>
											<tr>
												<th>No</th>
												<th>Test Name</th>
												<!-- <th>Payment</th> -->
												<th>Category</th>
												<th>Clinical Information</th>
												<th>Date Created</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody>

											<?php $i =1; ?>

											@foreach($tsts as $tst)
											<?php 	$payment = DB::table('payments')
											->select('amount','status')
											->where([
												['imaging_id', '=',$tst->patTdid],
												['patient_test_id', '=',$tst->ptid],
											])
											->first(); ?>
											<?php
											if ($tst->test_cat_id== '9') {
												$ct=DB::table('ct_scan')->where('id', '=',$tst->test) ->first();
												$test = $ct->name;
												$report ='grapherct';
												$type ='perftestct';

											} elseif ($tst->test_cat_id== 10) {
												$xray=DB::table('xray')->where('id', '=',$tst->test) ->first();
												$test = $xray->name;
												$report ='grapherxray';
												$type ='perftestradio';
											} elseif ($tst->test_cat_id== 11) {
												$mri=DB::table('mri_tests')->where('id', '=',$tst->test) ->first();
												$test = $mri->name;
												$report ='graphermri';
												$type ='perftestmri';
											}elseif ($tst->test_cat_id== 12) {
												$ultra=DB::table('ultrasound')->where('id', '=',$tst->test) ->first();
												$test = $ultra->name;
												$report ='grapherultra';
												$type ='perftestultra';

										}elseif ($tst->test_cat_id== 13) {
											$ultra=DB::table('ultrasound')->where('id', '=',$tst->test) ->first();
											$test = $ultra->name;
											$report ='grapherultra';
											$type ='perftestultra';
										}

											?>
											<tr>
												<td>{{$i}}</td>
												<td>{{$test}}</td>
												<td>{{$tst->tcname}}</td>
												<td>{{$tst->clinicalinfo}}</td>
												<td>{{$tst->date}}</td>
												@if($payment)
												@if($tst->done ==0)
												<td class="btn btn-primary"><a href="{{route($type,$tst->patTdid)}}">Perform Test</a></td>
												@elseif($tst->done ==1)
												<td class="btn btn-primary"><a href="{{route($report,$tst->patTdid)}}">Report</a></td>
												@elseif($tst->done ==2)
												<td class="btn btn-info"><a href="#">Done</a></td>
												@endif

												@else
												<td class="btn btn-primary">Pending Payments</td>
												@endif
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
</div><!--content-->
@endsection
