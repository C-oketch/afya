@extends('layouts.patient')
@section('title', 'Patient')
@section('content')
<?php

	$dependantId = $tsts1->persontreated;
	$afyauserId = $tsts1->afya_user_id;
	$appId = $tsts1->appointment_id;
	$ptdId = $tsts1->id;
	$facility = $tsts1->FacilityName;

 if ($dependantId =='Self')   {
	 $afyadetails = DB::table('afya_users')
	 ->select('dob','gender','firstname','secondName')
	 ->where('id', '=',$afyauserId)
	 ->first();

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


$facility_done = DB::table('facilities')
->select('FacilityName')
->where('FacilityCode', '=',$tsts1->facility_done)
->first();
?>
<!-- <p>
<a class="btn btn-success btn-lg " href="{{route('tstdetails',$tsts1->ptid)}}"><i class="fa fa-arrow-left"></i>GO BACK</a>
<button name="b_print" class="btn btn-info btn-lg ipt" type="button" onClick="printdiv('div_print');"> <i class="fa fa-paste"></i>PRINT</button>
</p> -->
<div id="div_print">
<div class="row wrapper border-bottom white-bg page-heading">

	<div class="row">
			<div class="col-md-10 col-md-offset-1">
<br />
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
					Doctor: {{$tsts1->docname}}<br>
					Facility: {{$facility}}<br>
					Date: {{$tsts1->created_at}}<br>
					<strong>Done By : </strong><br>
       {{$facility_done->FacilityName}}<br>
				</address>
			</div>
		</div>
</div>







	<div class="row ">
	<div class="col-lg-10">
			<h3 class="text-center">{{$tsts1->category}} Report</h3>
				<div class="text-center">
				{{$tsts1->name}} // {{$tsts1->sub_category}}
				  </div>
				 </div>
  </div>




<!--TEST RESULT------------------------------------------------------------------------->
<?php $i=1;
		$fhresut=DB::table('test_results')
		->join('test_ranges','test_results.test_ranges_id','=','test_ranges.id')
		->join('tests','test_ranges.tests_id','=','tests.id')
	->where('test_results.ptd_id', '=',$tsts1->id)
	->select('test_results.*','test_ranges.*','tests.name as tname')
		->get(); ?>

    <div class="row">
    	<div class="col-md-10 col-md-offset-1">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class=""><strong>Test Result</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                      <tr>
        							<td class="text-center"><strong>TEST</strong></td>
        							<td class="text-center"><strong>VALUE</strong></td>
        							<td class="text-center"><strong>UNITS</strong></td>
                      <td class="text-center"><strong>REFERENCE RANGE</strong></td>
                      </tr>

    						</thead>
								<tbody>
					 @foreach($fhresut as $fhtest)

							<tr>
							<!-- <td class="thick-line text-center">{{$i}}</td> -->
							<td class="thick-line text-center">{{$fhtest->tname}}</td>
							@if($gender == 'Male')
							<?php if($fhtest->low_male <= $fhtest->value AND  $fhtest->value <= $fhtest->high_male) { ?>
							<td class=" thick-line text-center font-bold text-navy"> {{$fhtest->value}}</td>
							<?php }else{ ?>
							<td class="thick-line text-center font-bold text-danger"> {{$fhtest->value}}</td>
							<?php } ?>
							@else
							<?php if($fhtest->low_female <= $fhtest->value AND  $fhtest->value <= $fhtest->high_female) { ?>
							<td class="thick-line text-center font-bold text-navy"> {{$fhtest->value}}</td>
							<?php }else{ ?>
							<td class="thick-line text-center font-bold text-danger"> {{$fhtest->value}}</td>
							<?php } ?>
							@endif
							<td class="thick-line text-center">{{$fhtest->units}}</td>
							@if($gender == 'Male')
							<td class="thick-line text-center">{{$fhtest->low_male}}  {{$fhtest->high_male}}</td>
							@else
							<td class="thick-line text-center">{{$fhtest->low_female}}  {{$fhtest->high_female}}</td>
							@endif
							<?php $i ++ ?>
							</tr>
					      @endforeach

					    </tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>











		<!--TEST RESULT with ranges------------------------------------------------------------------------->


<!--Interpretations------------------------------------------------------------------------->

<?php $i=1; $fh2=DB::table('tests')
->Join('test_ranges', 'tests.id', '=', 'test_ranges.tests_id')
->Join('test_interpretations', 'test_ranges.id', '=', 'test_interpretations.test_ranges_id')
->where('tests.id', '=',$tsts1->tests_reccommended)
->select('test_interpretations.*')
->get(); ?>
@if($fh2)
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>Test Interpretation</strong></h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-condensed">
						<thead>
									<tr>
									<td class="text-center"><strong>#</strong></td>
									<td class="text-center"><strong>VALUE</strong></td>
									<td class="text-center"><strong>INTERPRETATIONS</strong></td>
									</tr>

						</thead>
						<tbody>
							@foreach($fh2 as $fhtest)
				 		 <tr>
				 		 <td class="thick-line text-center">{{$i}}</td>
				 		 <td class="thick-line text-center">{{$fhtest->value}}</td>
				 		 <td class="thick-line text-center">{{$fhtest->description}}</td>
				 		 <?php $i ++ ?>
				 		 </tr>
				 		 @endforeach
             </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
<!--Comments------------------------------------------------------------------------->
<div class="row">
<div class="col-lg-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><strong>Comments:</strong></h3>
<br />
<p>Results : {{$tsts1->results}}</p>
<br />
	<p>Other Comments : {{$tsts1->note}}</p>
</div>
</div>
</div>
</div>


  </div><!--content-->
</div><!--content page-->

@endsection
