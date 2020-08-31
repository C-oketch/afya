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
			<h3 class="text-center">{{$cat}} Test Report</h3>
				<div class="text-center">
				  {{$subcategory}}
				  </div>
				 </div>
       </div>


			<div class="row">
				<div class="col-md-12">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><strong>{{$tname}}</strong></h3>
							<h3 class="panel-title text-right"><strong>Specimen No:  {{$specimen}}</strong></h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-condensed">
									<thead>
																	<tr>
												<td><strong>#</strong></td>
												<td><strong>TEST</strong></td>
												<td><strong>VALUE</strong></td>
												<td><strong>UNITS</strong></td>
												</tr>

									</thead>
									<tbody>
										<!-- foreach ($order->lineItems as $line) or some such thing here -->
										<?php
										$i=1;

										$tgrps=DB::table('test_groups')
										->where('main_test', '=',$testsId)
										->first();
                   if($tgrps){
										$fh01=DB::table('test_groups')
									->Join('tests', 'test_groups.sub_test', '=', 'tests.id')
									->leftJoin('test_ranges', 'tests.id', '=', 'test_ranges.tests_id')
									 ->where('test_groups.main_test', '=',$testsId)
									 ->select('tests.id as tests_id','tests.name as tname','test_ranges.*',
									 'test_ranges.id as testranges','test_groups.sub_test')
									 ->get();
								 }else{
								   $fh01=DB::table('tests')
								  ->leftJoin('test_ranges', 'tests.id', '=', 'test_ranges.tests_id')
								  ->where('tests.id', '=',$testsId)
								  ->select('tests.id as tests_id','tests.name as tname','test_ranges.*',
								  'test_ranges.id as testranges')
								  ->get();
								 }
										 ?>
										 @foreach($fh01 as $fhtest)
                     <?php  $fhresut=DB::table('test_results')
									 ->where([ ['test_results.ptd_id', '=',$ptdId],
														 ['test_results.test_ranges_id', '=',$fhtest->testranges],
														 ['test_results.patient_test', '=',$ptId], ])

									 ->first(); ?>

										<tr>
										<td>{{$i}}</td>
										<td> {{$fhtest->tname}}</td>


									    @if($gender == 'Male')
										 @if(($fhresut))
                        <?php if($fhtest->low_male <= $fhresut->value AND  $fhresut->value <= $fhtest->high_male) { ?>
											 <td class="font-bold text-navy"> {{$fhresut->value}}</td>
												<?php }else{ ?>
											 <td class="font-bold text-danger"> {{$fhresut->value}}</td>
											 <?php } ?>
												@else<td>Pending</td>
									@endif
                  @else
								 @if(($fhresut))
								 <?php if($fhtest->low_female <= $fhresut->value AND  $fhresut->value <= $fhtest->high_female) { ?>
								 <td class="font-bold text-navy"> {{$fhresut->value}}</td>
									<?php }else{ ?>
								 <td class="font-bold text-danger"> {{$fhresut->value}}</td>
								 <?php } ?>
								 @else<td>Pending</td>
								@endif
							@endif
							<td>{{$fhtest->units}}</td>

										<?php $i ++ ?>
										</tr>
										@endforeach

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
<?php
$i=1; $fh04=DB::table('patientNotes')
->where([['ptd_id', '=',$ptdId],['target', '=', 'Test']])
->select('note')
->get();
?>
@if($fh04)
<div class="col-lg-4">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><strong>Doctor Notes :</strong></h3>
<br />
@foreach($fh04 as $fh041)
{{$fh041->note}}<br />
@endforeach
</div>
</div>
</div>
@endif


</div><!-- col 12 -->
</div><!-- row -->
<div class="row">
<div class="col-lg-8">
  <div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>ENTER TEST VALUES</strong></h3>
			</div>
			<div class="panel-body">

{{ Form::open(array('route' => array('testResult'),'method'=>'POST')) }}
  <div class="col-lg-6 b-r">
    <div class="form-group">
        <label for="tag_list" class="">Test:</label>
             <select class="test-multiple" name="testrangesId"  style="width: 100%">
  <?php
	if($tgrps){
                $fh02=DB::table('test_groups')
                ->Join('tests', 'test_groups.sub_test', '=','tests.id' )
								->leftJoin('test_ranges', 'tests.id', '=', 'test_ranges.tests_id')
								->whereNotExists(function($query)use($ptdId,$ptId)
                {
										$query->select(DB::raw(1))
										->from('test_results')
										->where([ ['test_results.ptd_id', '=',$ptdId],
										['test_results.patient_test', '=',$ptId], ])
										->whereRaw('test_ranges.id = test_results.test_ranges_id');
                     })
            ->where('test_groups.main_test', '=',$testsId)
            ->select('tests.id as tests_id','tests.name as tname',
            'test_ranges.id as testranges','test_ranges.units')
            ->get();
					}else{
						$fh02=DB::table('test_ranges')
						->leftJoin('tests', 'test_ranges.tests_id', '=','tests.id' )
						->whereNotExists(function($query)use($ptdId,$ptId)
						{
								$query->select(DB::raw(1))
								->from('test_results')
								->where([ ['test_results.ptd_id', '=',$ptdId],
								['test_results.patient_test', '=',$ptId], ])
								->whereRaw('test_ranges.id = test_results.test_ranges_id');
								 })
				->where('test_ranges.tests_id', '=',$testsId)
				->select('tests.id as tests_id','tests.name as tname',
				'test_ranges.id as testranges','test_ranges.units')
				->get();

					}
              ?>
                @foreach($fh02 as $fh1test)
      <option value='{{$fh1test->testranges}}'>{{$fh1test->tname}} {{$fh1test->units}}</option>
               @endforeach
               </select>
         </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group"><label>Value</label>
    <input type="text" name="test_value" placeholder="Enter Value" class="form-control"></div>
  </div>
  <input type="hidden" name="ptid" value="{{$ptId}}" class="form-control">
  <input type="hidden" name="ptd_id" value="{{$ptdId}}" class="form-control">
  <input type="hidden" name="facility" value="{{$facilityId}}" class="form-control">
	<input type="hidden" name="test_id" value="{{$testsId}}" class="form-control">


<div class="text-center">
<button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>SUBMIT</strong></button>
</div>
{{ Form::close() }}

    </div>
  </div>
 </div>
 </div><!-- row -->


@endsection
