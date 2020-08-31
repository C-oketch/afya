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

if ($tsts1){
	$dependantId = $tsts1->persontreated;
	$afyauserId = $tsts1->afya_user_id;
	$appId = $tsts1->appointment_id;
	$ptdId = $tsts1->id;
	$ptId = $tsts1->ptid;
	$docname = $tsts1->docname;

	$cat=$tsts1->category;
	$subcategory=$tsts1->sub_category;
	$tname=$tsts1->tname;
	$testsId=$tsts1->tests_id;



}elseif ($alternative){
	$dependantId = $alternative->persontreated;
	$afyauserId = $alternative->afya_user_id;
	$ptdId = $alternative->id;
	$ptId = $alternative->ptid;
	$docname = $alternative->docname;
	$appId = '';
	$cat=$alternative->category;
	$subcategory=$alternative->sub_category;
	$tname=$alternative->tname;
	$testsId=$alternative->tests_id;

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
if ($gender == 1) { $gender = 'Male'; }else{ $gender = 'Female'; }
$specimen=$facilityId.''.$ptdId;
?>
<div class="row wrapper border-bottom white-bg page-heading">
<div class="content-page  equal-height">
		<div class="content">

			<div class="row">
					<div class="col-md-12">
						<div class="invoice-title">
						</div>
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
							Name : {{$docname}}<br>
							<strong>LAB :</strong><br>
							 {{$facility}}
						</address>

					</div>
				</div>
				</div>



			<div class="container">
				<div class="col-lg-10">
			<h3 class="text-center">{{$cat}} Test Transfer</h3>
				<div class="text-center">
				  {{$subcategory}}
				  </div>
				 </div>
       </div>



<div class="row">
<div class="col-lg-8">
  <div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>{{$tname}}</strong></h3>
			<h3 class="panel-title text-right"><strong>Specimen No:  {{$specimen}}</strong></h3>
		</div>
			<div class="panel-body">

{{ Form::open(array('route' => array('transfertest'),'method'=>'POST')) }}
  <div class="col-lg-6 b-r">
		 <div class="form-group"><label>Facility From :</label>
	    <input type="text" value="{{$facility}}" class="form-control" readonly></div>

  </div>

  <div class="form-group col-lg-6">
				<label  class="col-md-6">Facility To:</label>
				 <select id="facility" name="facility_to" class="form-control facility" style="width: 100%"></select>

				 <input type="hidden" name="ptid" value="{{$ptId}}" class="form-control">
	 		  <input type="hidden" name="facility_from" value="{{$facilityId}}" class="form-control">
	 			<input type="hidden" name="specimen" value="{{$specimen}}" class="form-control">
	 			<input type="hidden" name="ptdId" value="{{$ptdId}}" class="form-control">

  </div>


<div class="text-center">
<button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>SUBMIT</strong></button>
</div>
{{ Form::close() }}

    </div>
  </div>
 </div>
 </div><!-- row -->


@endsection
