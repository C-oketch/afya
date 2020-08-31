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
	$ptid = $tsts1->ptid ;

	$docname=$tsts1->docname;
	$tname=$tsts1->tname;
	$category=$tsts1->category;
	$sub_category=$tsts1->sub_category;
}elseif($alternative){
	$dependantId = $alternative->persontreated;
	$afyauserId = $alternative->afya_user_id;
	$appId = '';
	$ptdId = $alternative->id;
	$ptid = $alternative->ptid ;

	$docname=$alternative->docname;
	$tname=$alternative->tname;
	$category=$alternative->category;
	$sub_category=$alternative->sub_category;
}
 if ($dependantId =='Self')   {
	 $afyadetails = DB::table('afya_users')
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
$specimen=$facilityId.''.$ptdId;
?>


<div class="row wrapper border-bottom white-bg page-heading">


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

	</div>
	<div class="row wrapper border-bottom white-bg">
	<div class="content-page  equal-height">
		<div class="content">
			<div class="container">
				<div class="col-lg-10">
			<h3 class="text-center">{{$category}} Report</h3>
				<div class="text-center">
				{{$tname}} // {{$sub_category}}
				  </div>
				 </div>
       </div>
		</div>
  </div>
</div>

<?php $i=1;
		$fhresut=DB::table('test_results')
		->join('test_ranges','test_results.test_ranges_id','=','test_ranges.id')
		->join('tests','test_ranges.tests_id','=','tests.id')
	->where([ ['test_results.ptd_id', '=',$ptdId],
						['test_results.patient_test', '=',$ptid], ])
	->select('test_results.*','test_ranges.*','tests.name as tname')
		->get(); ?>

<div class="row wrapper border-bottom page-heading">
  <div class="content-page  equal-height">
		<div class="content">

      <!--Update------------------------------------------------------------------------->
  <div class="row">
      <div id="Tupdate" class="col-lg-12 ficha">
      <div class="col-lg-12 white-bg">
        <div class="col-md-6 col-md-offset-3">
       <div class="ibox float-e-margins">
         <div class="">
           <h5>Update</h5>
         </div>

        <div class="ibox-content">
      {{ Form::open(array('route' => array('testRupdt'),'method'=>'POST')) }}

          <div class="form-group">
              <label for="tag_list" class="">Test:</label>
                   <select class="test-multiple" name="test_rid"  style="width: 100%">
                     <?php $fh1=DB::table('test_results')
                       ->Join('test_ranges', 'test_results.test_ranges_id', '=', 'test_ranges.id')
      								 ->Join('tests', 'test_ranges.tests_id', '=', 'tests.id')
                     ->where([['test_results.patient_test', '=',$ptid],
                             ['test_results.ptd_id', '=',$ptdId],])
      							->Select('test_results.id','test_ranges.tests_id','tests.name as tname')
      							->get();
      							?>
                     @foreach($fh1 as $fh1test)
                            <option value='{{$fh1test->id}}'>{{$fh1test->tname}}</option>
                     @endforeach
                     </select>


        </div>

      <div class="form-group"><label>Value</label>
      <input type="text" name="value" placeholder="Enter Value" class="form-control"></div>
      <input type="hidden" name="ptd_id" value="{{$ptdId}}" class="form-control">

      <div class="text-center">
      		<button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>SUBMIT</strong></button>
      		</div>
      {{ Form::close() }}

          </div>
        </div>
       </div>
      </div>
      </div>
</div>
				<!--TEST RESULT------------------------------------------------------------------------->
      <div class="row">
       <div class="col-lg-6">
      <div class="ibox float-e-margins">
     <div class="ibox-title">
        <h5> TEST RESULTS  </h5>
				<div class="ibox-tools">
          <a class="collapse-link">
						<button class="btn btn-sm btn-primary m-t-n-xs" id ="upresult"><strong>UPDATE TEST RESULT</strong></button>
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
      @if($gender == 'Male')
      <th><button type="button" class="btn btn-primary">NORMAL MALE</button></th>
      @elseif($gender == 'Female')
      <th><button type="button" class="btn btn-primary">NORMAL FEMALE</button></th>
      @endif
      </tr>

      </thead>
      <tbody>
 @foreach($fhresut as $fhtest)

      <tr>
      <td>{{$i}}</td>
      <td>{{$fhtest->tname}}</td>

@if($gender == 'Male')
  <?php if($fhtest->low_male <= $fhtest->value AND  $fhtest->value <= $fhtest->high_male) { ?>
   <td class="font-bold text-navy"> {{$fhtest->value}}</td>
    <?php }else{ ?>
   <td class="font-bold text-danger"> {{$fhtest->value}}</td>
   <?php } ?>


@elseif($gender == 'Female')
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

<!--Comments------------------------------------------------------------------------->

  <div id="Uclose">
  <div class="col-lg-6">
       <div class="ibox float-e-margins">
         <div class="ibox-title">
           <h5>Comments</h5>
         </div>
        <div class="ibox-content">
{{ Form::open(array('route' => array('testfilm'),'method'=>'POST')) }}

     <div class="form-group">
        <label  class="">Comments:</label>
        <select class="form-control" name="comments" required >
        <option value=''>Choose one ..</option>
        <option value='Normal'>Normal</option>
        <option value='Severe'>Severe</option>
        <option value='High'>High</option>
        <option value='Efficient'>Efficient</option>
        <option value='Inefficient'>Inefficient</option>
        <option value='Borderline neutropenia'>Borderline neutropenia</option>
        <option value='Normal peripherial blood picture'>Normal peripherial blood picture</option>
        </select>
      </div>

    <div class="form-group">
        <label>Other Comments</label>
        <textarea name="comments2" rows="2" placeholder="Any other notes" class="form-control"></textarea>
    </div>

      <input type="hidden" name="ptd_id" value="{{$ptdId}}" class="form-control">
      <input type="hidden" name="facility" value="{{$facilityId}}" class="form-control">
			<input type="hidden" name="ptid" value="{{$ptid}}" class="form-control">

      <button class="btn btn-sm btn-primary m-t-n-xs pull-right" type="submit"><strong>SUBMIT</strong></button>
  <br /><br />
       {{ Form::close() }}
     </div>
   </div>
</div>
</div>


         </div>
    </div>
  </div><!--content-->
</div><!--content page-->

@endsection
