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
<div class="content-page  equal-height">
		<div class="content">
				<div class="container">
          <div class="col-lg-6 ">
					<h2>Name: {{$name}}</h2>
					<ol class="breadcrumb">
					<li><a>Gender {{$gender}}</a></li>
					<li><a>Age {{$age}}</a> </li>

					</ol>
					</div>
					<div class="col-lg-5 ">
					<h2 class="">LAB: {{$facility}}</h2>
					<ol class="breadcrumb">
					<li class="active">Name: {{$docname}}</li>
					</ol>
					</div>
			</div>
			</div>
		</div>
	</div>
	<div class="row wrapper border-bottom white-bg">
	<div class="content-page  equal-height">
		<div class="content">
			<div class="container">
				<div class="col-lg-10">
			<h3 class="text-center">{{$category}} TESTS</h3>

				 </div>
       </div>
		</div>
  </div>
</div>
<div class="row wrapper border-bottom page-heading">
  <div class="content-page  equal-height">
		<div class="content">

			<div class="col-lg-7">
		<div class="ibox float-e-margins">
				<div class="ibox-title">
						 <h5>{{$category}} Test Request</h5>
				</div>
				<div class="ibox-content">
						<div class="row">

									<form role="form">
												<div class="form-group"><label>Test</label> <input type="text" value="{{$tstname}} -{{$target}}" class="form-control" readonly=""></div>
												<div class="form-group"><label>Clinical Information</label> <textarea rows="4" cols="60" readonly=""> {{$clinicalinfo}}</textarea></div>

                 </form>


						</div>
				</div>
		</div>
</div>

<div class="col-lg-5">
		<div class="ibox float-e-margins">
				<div class="ibox-title">
						<h5>UPLOAD FILE:</h5>

				</div>
				<div class="ibox-content">
						<div class="row">

										<p>Please upload only images with relevant Information.</p>
										@if (count($errors) > 0)
										<div class="alert alert-danger">
										     <strong>Whoops!</strong> There were some problems with your input.<br><br>
										<ul>
										@foreach ($errors->all() as $error)
										        <li>{{ $error }}</li>
										      @endforeach
										  </ul>
										</div>
										@endif
										{!! Form::open(array('url' => 'fileUploads','files'=>true)) !!}
												<div class="form-group"><label>Choose file:</label><input type="file" name="image[]" multiple="multiple" class="form-control"></div>
												<div class="form-group"><input type="hidden" name="radiology_td_id" value="{{$rtdid}}"></div>
                        <div class="form-group"><input type="hidden" name="patient_test_id" value="{{$ptId}}"></div>
												<div class="form-group"><input type="hidden" name="user_id" value="{{Auth::user()->id}}"></div>

												<div>
														<button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>SUBMIT</strong></button>

												</div>
										{!! Form::close() !!}
						</div>
				</div>
		</div>
</div>



		</div><!--content-->
  </div><!--content page-->
</div>
@endsection
