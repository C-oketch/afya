@extends('layouts.doctor_layout')
@section('title', 'LAB Tests')
@section('content')
<?php

	$dependantId = $usedetails->persontreated;
	$afyauserId = $usedetails->afya_user_id;
	$facility = $usedetails->FacilityName;
	$app_id = $usedetails->appid;

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


?>
<p>
<a class="btn btn-success btn-lg " href="{{route('patienthistory',$app_id)}}"><i class="fa fa-arrow-left"></i>GO BACK</a>
<button name="b_print" class="btn btn-info btn-lg ipt" type="button" onClick="printdiv('div_print');"> <i class="fa fa-paste"></i>PRINT</button>
</p>
<div id="div_print">
<div class="row wrapper border-bottom white-bg page-heading">

	<div class="row">
			<div class="col-md-12">
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
					Doctor: {{$usedetails->docname}}<br>
					Facility: {{$facility}}<br>
					Date: {{$usedetails->created_at}}<br>

				</address>
			</div>
		</div>
</div>

<div class="row">
	<div class="col-md-12">
<div class ="ibox-content">
	     <h5>Prescription History</h5>
	     <div class="table-responsive ibox-content">
	     <table class="table table-striped table-bordered table-hover dataTables-example" >
	     <thead>
	       <tr>
	         <th>No</th>
	         <th>Drug</th>
					 <th>Substituted By</th>
	         <th>Start Date</th>
	         <th>End Date</th>
					 <th>Dose Given</th>
					 <th>Quantity</th>
					 <th>Strength</th>
					 <th>Routes</th>
					 <th>Frequency</th>
					 <th>Pharmacy</th>

	       </tr>
	     </thead>

	     <tbody>
	     <?php $i =1; ?>

	     @foreach($prescriptions as $tstdn)
			 <?php
		if($tstdn->substitute_presc_id)	{
 $subdrug=DB::table('druglists')->select('drugname')->where('id',$tstdn->subdrug_id)
	->first();     }

			  ?>
	     <tr>
	     <td>{{ +$i }}</td>
	     <td>{{$tstdn->drugname}}</td>
			 <td>@if($tstdn->substitute_presc_id){{$subdrug->drugname}} @else None @endif</td>
	     <td>{{$tstdn->start_date}}</td>
	     <td>{{$tstdn->end_date}}</td>
			 <td>{{$tstdn->dose_given}}</td>
			 <td>{{$tstdn->quantity}}</td>
@if($tstdn->substitute_presc_id)
			 <td>{{$tstdn->substrength}}  {{$tstdn->substrength_unit}}</td>
			 <td>{{$tstdn->subroutes}}</td>
			  <td>{{$tstdn->subfrequency}}</td>
@else
				<td>{{$tstdn->strength}}  {{$tstdn->strength_unit}}</td>
			  <td>{{$tstdn->routes}}</td>
			 	<td>{{$tstdn->frequency}}</td>
@endif
	<td>{{$tstdn->pharmacy}}</td>
	     </tr>
	     <?php $i++; ?>

	     @endforeach

	     </tbody>
	     </table>
	     </div>
	</div>
</div>
</div>

  </div><!--content-->
</div><!--content page-->

@endsection
