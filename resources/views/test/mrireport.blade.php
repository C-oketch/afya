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


if($tsts1){
	$dependantId = $tsts1->persontreated;
	$afyauserId = $tsts1->afya_user_id;
	$ptdId = $tsts1->id;
	$docname= $tsts1->docname;

	$category=$tsts1->category;
	$tstname=$tsts1->tstname;
	$target=$tsts1->target;
	$clinicalinfo=$tsts1->clinicalinfo;
	$rtdid=$tsts1->rtdid;
	$ptId=$tsts1->ptId;
	$mriid=$tsts1->mriid;
	$technique=$tsts1->technique;

}elseif ($alternative1) {
	$dependantId = $alternative1->persontreated;
	$afyauserId = $alternative1->afya_user_id;
	$ptdId = $alternative1->id;
	$docname= $alternative1->docname;

	$category=$alternative1->category;
	$tstname=$alternative1->tstname;
	$target=$alternative1->target;
	$clinicalinfo=$alternative1->clinicalinfo;
	$rtdid=$alternative1->rtdid;
	$ptId=$alternative1->ptId;
	$mriid=$alternative1->mriid;
	$technique=$alternative1->technique;

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

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="row">
			<div class="col-md-11">

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
					Doctor: {{$docname}}<br>
					LAB: {{$facility}}<br>

				</address>
			</div>
		</div>
 </div>
</div>
<div class="row wrapper border-bottom white-bg">
    <div class="col-md-10">
			<h3 class="text-center">{{$category}} REPORT</h3>
  </div>
</div>

<div class="row wrapper border-bottom page-heading">
  <div class="content-page  equal-height">
		<div class="content">
           <div class="col-md-11">
		                    <div class="ibox float-e-margins">
		                        <div class="ibox-title">
		                            <h5>{{$category}} Test Request</h5>

		                        </div>
		                        <div class="ibox-content">
		                            <form class="form-horizontal">
																	<div class="text-center">
																		<h2>{{$tstname}}  {{$target}}</h2>
																	</div>
                                   <div>
																			<strong>Clinical Information</strong>
                                         <p>{{$clinicalinfo}}</p>
		                                </div>

		                            </form>
		                        </div>
		                    </div>
		                </div>
										<div class="col-md-11">
																			<div class="ibox float-e-margins">
																					<div class="ibox-title">
																							<h5>Images</h5>
																					</div>
																					<div class="ibox-content">
																							<form role="form" class="form-inline">
																								<?php $images=DB::table('radiology_images')->where('radiology_td_id',$id)->get(); ?>
																				@foreach($images as $image)
																				    <div class="form-group">
																							<a href="{{ asset("images/$image->image") }} "target="_blank">View Image</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					                                  </div>
																				@endforeach

																							</form>
																					</div>
																			</div>
																	</div>


<?php
// $rtdid = $tsts1->rtdid;

	$findings = DB::table('mri_findings')
->whereNotExists(function($query)use($rtdid)
		{
				$query->select(DB::raw(1))
							->from('radiology_test_result')
							->where('radiology_td_id', '=',$rtdid)
							->whereRaw('mri_findings.id = radiology_test_result.findings_id');
					 })
->where('mri_findings.mri_tests_id', '=',$mriid)
->select('mri_findings.id','mri_findings.findings',
 'mri_findings.results')
->get();
	?>


<div class="row">
	<div class="col-md-11">

   <div class="col-md-6">
		<div class="ibox float-e-margins">
				<div class="ibox-title">
						<h5>FINDINGS</h5>
				</div>
				<div class="ibox-content">


										<!-- <p>Sign in today for more expirience.</p> -->
								{{ Form::open(array('route' => array('mrifindings'),'method'=>'POST')) }}
												<div class="form-group"><label>Test</label><select class="test-multiple" name="findingsId"  style="width: 100%">
													@foreach($findings as $fh1test)
											 <option value='{{$fh1test->id}}'>{{$fh1test->findings}}</option>
												 @endforeach
												 </select>
											 </div>
												<div class="form-group"><label>Result</label><input type="text" name="result" class="form-control"></div>
											<input type="hidden" name="radiology_td_id" value="{{$rtdid}}" class="form-control" >


                           <div class="text-center">
														<button class="btn btn-sm btn-primary  m-t-n-xs" type="submit"><strong>SUBMIT</strong></button>
												</div>
										{{ Form::close() }}
             </div>
	    </div>
	</div>
	<div class="col-md-6">
	 <div class="ibox float-e-margins">
			 <div class="ibox-title">
					 <h5>Findings Report</h5>
			 </div>
			 <?php
				 $freport = DB::table('mri_findings')
		 ->leftJoin('radiology_test_result', 'mri_findings.id', '=', 'radiology_test_result.findings_id')
		 ->where([ ['mri_findings.mri_tests_id', '=',$mriid],['radiology_test_result.radiology_td_id', '=',$rtdid] ])
			 ->select('radiology_test_result.results','mri_findings.findings')
			 ->get();
				 ?>
			 <div class="ibox-content">

							 <!-- <p>Sign in today for more expirience.</p> -->
									 <form role="form">
										 @foreach($freport as $frpt)

											 <div class="form-group"><label>{{$frpt->findings}} :</label>{{$frpt->results}}</div>
									 @endforeach
									 </form>
							 </div>
			 </div>
	 </div>

 </div>
</div>
 <div class="row">
   <div class="col-md-11">
		<div class="ibox float-e-margins">
				<div class="ibox-title">
						<h5>IMPRESSION</h5>
				</div>
				<div class="ibox-content">


										<!-- <p>Sign in today for more expirience.</p> -->
											{{ Form::open(array('route' => array('imgreport'),'method'=>'POST')) }}
											<div class="col-md-6 b-r">
												<label>Technique</label><div class="form-group"><textarea rows="4" name="technique" cols="50">{{$technique}}</textarea></div>
											</div>
											<div class="col-md-6 ">
												<label>Impression</label>	<div class="form-group"><textarea rows="4" name="impression" cols="50">Normal {{$target}} {{$tstname}}</textarea></div>
											</div>
											<input type="hidden" name="patient_test_id" value="{{$ptId}}" class="form-control" >
                     <input type="hidden" name="radiology_td_id" value="{{$rtdid}}" class="form-control" >
										 <input type="hidden" name="afya_user_id" value="{{$afyauserId}}">
                   <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                 <div class="text-center">
											<button class="btn btn-sm btn-primary  m-t-n-xs" type="submit"><strong>SUBMIT</strong></button>
                  </div>
										{{ Form::close() }}

						</div>
				</div>
			</div>
	</div>




		</div><!--content-->
  </div><!--content page-->
</div>
@endsection
