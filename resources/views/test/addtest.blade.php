@extends('layouts.test')
@section('title', 'Tests')
@section('styles')
<link rel="stylesheet" href="{{asset('css/custombuttons.css') }}" />
@endsection
@section('content')
<?php
$afya_user_id=$info->id;
?>
<div class="wrapper wrapper-content animated fadeInRight white-bg">
		<div class="row">
						<div class="col-lg-12">
							<div class="col-md-6">
								<address>
							<h2></h2><strong>Patient Details:</strong><br />
							<strong>NAME : </strong>{{$info->firstname}} {{$info->secondName}}<br />
							<strong>Gender :</strong> {{$info->gender}}<br />
							<?php $interval = date_diff(date_create(), date_create($info->dob));
							     $aged= $interval->format(" %Y Year, %M Months");
							?>
							<strong>Age:</strong> {{$aged}}
							</div>
							<div class="col-md-6 text-right">
								<address>
									<h2></h2><strong>Facility:</strong><br />
									{{$facid->FacilityName}}<br>
									<strong>{{$facid->speciality}} :</strong><br />
									{{$facid->firstname}} {{$facid->secondname}}<br>
                 </address>
							</div>
          </div>
       </div>
			</div>




<?php
use Carbon\Carbon;
$today = Carbon::today();
if($tstatus == 2){
$patTest =DB::table('patient_test')
 ->where([ ['afya_user_id',$info->id],
           ['created_at','>=',$today],
					 ['dependant_id','=','Self'],
				  ])
->first();

}elseif($tstatus == 1){
	$patTest = 'Test Has Appointment ID';
}
 ?>
<?php
if (is_null($patTest)) { ?>
<div class="row">
<div class="col-md-12 white-bg">
	<div class="col-lg-8 col-md-offset-2">
		<div class="panel panel-primary">
				<div class="panel-heading">
						Test Requested By:
				</div>
				<div class="panel-body">
	<form class="form-horizontal" role="form" method="POST" action="/postpatient" novalidate>
 <input type="hidden" name="_token" value="{{ csrf_token() }}">
 <input type="hidden" class="form-control"  name="afyaId" value="{{$info->id}}" >
 <div class="form-group col-md-8 col-md-offset-1">
 		<label  class="col-md-6">Prescribing Doctor:</label>
 		 <select id="doc" name="doc" class="form-control doctor" style="width: 100%"></select>
 </div>
	<div class="form-group col-md-8 col-md-offset-1">
			<label  class="col-md-6">Facility:</label>
			 <select id="facility" name="facility" class="form-control facility" style="width: 100%" required="required"></select>
	</div>

	<div class="col-lg-8">
		<button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>
	</div>
{!! Form::close() !!}
</div>
</div>
</div>
</div>
</div>
<?php }else{ ?>


@if($facid->department==='Laboratory')
@include(' test.labtest')
@elseif($facid->department==='Radiology')
@include(' test.imgntest')
@endif
<?php } ?>

    @endsection
    <!-- Section Body Ends-->
    @section('script')
     <!-- Page-Level Scripts -->
  <script src="{{ asset('js/addtest.js') }}"></script>
    @endsection
