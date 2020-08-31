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

<input name="b_print" type="button" class="ipt btn btn-info"   onClick="printdiv('div_print');" value=" Print ">
<div id="div_print">
<div class="row wrapper border-bottom white-bg page-heading">
<div class="content-page  equal-height">
		<div class="content">
				<div class="container">
          <div class="col-lg-6 ">
					<h3>Name: {{$name}}</h3>
					<h4>Gender: {{$gender}}</h4>
					<h4>Age: {{$age}}</h4>

					</div>
					<div class="col-lg-5 ">
					<h3>LAB: {{$facility}}</h3>
					<h3>Doctor: {{$tsts1->docname}}</h3>
					<h3>Date: {{$tsts1->created_at}}</h3>

					</div>
			</div>
			</div>
		</div>

	<div class="row wrapper border-bottom white-bg">
	<div class="content-page  equal-height">
		<div class="content">
			<div class="container">
				<div class="col-lg-10">
			<h3 class="text-center">{{$tsts1->category}} Report</h3>
				<div class="text-center">
				{{$tsts1->name}} // {{$tsts1->sub_category}}
				  </div>
				 </div>
       </div>
		</div>
  </div>
</div>



<div class="row wrapper border-bottom page-heading">
  <div class="content-page  equal-height">
		<div class="content">
      <div class="row">
				<!--TEST RESULT------------------------------------------------------------------------->
				<?php $i=1;
						$fhresut=DB::table('test_results')
						->join('test_ranges','test_results.test_ranges_id','=','test_ranges.id')
						->join('tests','test_ranges.tests_id','=','tests.id')
					->where('test_results.ptd_id', '=',$tsts1->id)
					->select('test_results.*','test_ranges.*','tests.name as tname')
						->get(); ?>
		<!--TEST RESULT with ranges------------------------------------------------------------------------->
@if ($fhresut)

       <div class="col-lg-8 col-md-offset-2">
      <div class="ibox float-e-margins">
     <div class="ibox-title">
        <h5> TEST RESULTS  </h5>
				<div class="ibox-tools">
          <a class="collapse-link">
					</a>
        </div>
     </div>
     <div class="ibox-content">
      <table class="table table-bordered">
      <thead>
      <tr>
      <th>#</th>
      <th>TEST</th>
      <th>VALUE</th>
      <th>UNITS</th>
      <th>REFERENCE RANGE</th>
      </tr>

      </thead>
      <tbody>
 @foreach($fhresut as $fhtest)

      <tr>
      <td>{{$i}}</td>
      <td>@if($fhtest->name){{$fhtest->name}}@else{{$fhtest->tname}}@endif</td>

@if($gender == 'Male')
  <?php if($fhtest->low_male <= $fhtest->value AND  $fhtest->value <= $fhtest->high_male) { ?>
   <td class="font-bold text-navy"> {{$fhtest->value}}</td>
    <?php }else{ ?>
   <td class="font-bold text-danger"> {{$fhtest->value}}</td>
   <?php } ?>


@else

   <?php if($fhtest->low_female <= $fhtest->value AND  $fhtest->value <= $fhtest->high_female) { ?>
   <td class="font-bold text-navy"> {{$fhtest->value}}</td>
    <?php }else{ ?>
   <td class="font-bold text-danger"> {{$fhtest->value}}</td>
   <?php } ?>

@endif

      <td>{{$fhtest->units}}</td>
       @if($gender == 'Male')
     <td>{{$fhtest->low_male}} - {{$fhtest->high_male}}</td>
       @else
     <td>{{$fhtest->low_female}} - {{$fhtest->high_female}}</td>
       @endif

      <?php $i ++ ?>
      </tr>
      @endforeach

    </tbody>
    </table>
      </div>
</div>
</div>
<!--TEST RESULT with no ranges------------------------------------------------------------------------->
@else

<?php $i=1;
		$fhresut2 =DB::table('test_results')
	->join('tests','test_results.tests_id','=','tests.id')
	->where('test_results.ptd_id', '=',$tsts1->id)
	->select('test_results.*','tests.name as tname')
		->get(); ?>
	 <div class="col-lg-8 col-md-offset-2">
	<div class="ibox float-e-margins">
 <div class="ibox-title">
		<h5> TEST RESULTS  </h5>
		<div class="ibox-tools">
			<a class="collapse-link">
			</a>
		</div>
 </div>
 <div class="ibox-content">
	<table class="table table-bordered">
	<thead>
	<tr>
	<th>#</th>
	<th>TEST</th>
	<th>VALUE</th>
	<th>UNITS</th>
	</tr>

	</thead>
	<tbody>
@foreach($fhresut2 as $fhtest)

	<tr>
	<td>{{$i}}</td>
	<td>{{$fhtest->tname}}</td>
  <td>{{$fhtest->value}}</td>
  <td>{{$fhtest->units}}</td>
	<?php $i ++ ?>
	</tr>
	@endforeach

</tbody>
</table>
	</div>
</div>
</div>
@endif
<!--Interpretations------------------------------------------------------------------------->

<?php $i=1; $fh2=DB::table('tests')
->Join('test_ranges', 'tests.id', '=', 'test_ranges.tests_id')
->Join('test_interpretations', 'test_ranges.id', '=', 'test_interpretations.test_ranges_id')
->where('tests.id', '=',$tsts1->tests_reccommended)
->select('test_interpretations.*')
->get(); ?>
              @if($fh2)
          <div class="col-lg-6 col-md-offset-2">
           <div class="ibox float-e-margins">
             <div class="ibox-title">
               <h5>Interpretations</h5>
             </div>
           <div class="ibox-content">
           <table class="table table-bordered">
           <thead>
           <tr>
           <th>#</th>
           <th>Values</th>
           <th>Interpretations</th>
           </tr>
           </thead>
           <tbody>

           @foreach($fh2 as $fhtest)
           <tr>
           <td>{{$i}}</td>
           <td>{{$fhtest->value}}</td>
           <td>{{$fhtest->description}}</td>
           <?php $i ++ ?>
           </tr>
           @endforeach

           </tbody>
           </table>
           </div>
           </div>
           </div>
           @endif
<!--Comments------------------------------------------------------------------------->

  <div class="col-lg-6 col-md-offset-2">
       <div class="ibox float-e-margins">
         <div class="ibox-title">
           <h5>Comments</h5>
         </div>
        <div class="ibox-content">

		<p>Results : {{$tsts1->results}}</p>
		<p>Other Comments : {{$tsts1->note}}</p>
		 </div>
   </div>
</div>


</div>
         </div>
       </div>
		</div>
  </div><!--content-->
</div><!--content page-->

@endsection
