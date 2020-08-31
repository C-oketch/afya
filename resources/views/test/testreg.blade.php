@extends('layouts.test')
@section('title', 'Tests')
@section('content')
<?php
use Carbon\Carbon;


$interval = date_diff(date_create(), date_create($patients->dob));
$age2= $interval->format(" %Y Years Old");
 ?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-md-12">
     <br /><br />
      <div class="col-md-6">
        <address>
        <strong>PATIENT :</strong><br>
        Name: {{$patients->firstname}} {{$patients->secondName}}<br>
        Gender: {{$patients->gender}}<br>
        Age:  {{$age2}}
      </address>
      </div>
      <div class="col-md-6 text-right">
        <address>
          <br><br />
          <strong>DATE :</strong><br>
          {{Carbon::today()->toDateString()}}<br>

      </address>
      </div>
    </div>
</div>
<div class="content-page  equal-height">

		<div class="content">
				<div class="container">
         	<div class="wrapper wrapper-content animated fadeInRight">
						<div class="row">
																		<div class="col-lg-11">
																		<div class="ibox float-e-margins">
																				<div class="ibox-title">
						                              <h5> LABORATORY TESTS</h5>
																						<div class="ibox-tools">

                                              <a href="{{url('test')}}" class="btn btn-primary btn-sm pull-right">  <i class="fa fa-arrow-left"></i>Go Back</a>

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
																				<div class="ibox-content">

																						<div class="table-responsive">
																				<table class="table table-striped table-bordered table-hover dataTables-example" >
																				<thead>
																																<tr>
																																	<th>No</th>
																																	<th>Person Treated</th>
																																	<th>Gender</th>
																																	<th>Age</th>
																																	<th>Date Created</th>
																																	<th>Precribing Doctor</th>
																																	<th>Precribing Facility</th>
																																	<th>Add Test</th>
																																	<th>Payment</th>
																															</tr>
																														</thead>

							<tbody>

								<?php $i =1;
													foreach($dialledpatients as $tst)
												{
													if ($tst->persontreated =='Self') {
													$gender= $tst->gender;
													$dob=$tst->dob;
													$pnamed="Primary";
													$pname= $tst->firstname." ".$tst->secondName;
													}else {
													$gender= $tst->depgender;
													$dob=$tst->depdob;
													$pnamed= $tst->depname." ".$tst->depname2;
													$pname= $tst->firstname." ".$tst->secondName;
													}
							            $interval = date_diff(date_create(), date_create($dob));
													$age= $interval->format(" %Y Year, %M Months Old");
													$date_created=$tst->date;
													$doctor=$tst->doc;
													$facility=$tst->fac;
						?>
						<tr>
						<td>{{$i}}</td>
						<td>{{$pnamed}}</td>
						<td>{{$gender}}</td>
						<td>{{$age}}</td>
						<td>{{$date_created}}</td>
						 <td>{{$doctor}} </td>
						 <td>{{$facility}}</td>
						 <td><a href="{{route('patientslct',$tst->id)}}">Add Test</a></td>
						 <td>@if($tst->tests_reccommended)<a href="{{route('labinvoice',$tst->ptid)}}">Pay</a> @endif</td>

								       </tr>
											 <?php $i++; ?>
						<?php }   ?>

						<?php $i =1;
											foreach($alternative as $tst)
										{
											if ($tst->persontreated =='Self') {
											$gender= $tst->gender;
											$dob=$tst->dob;
											$pnamed="Primary";
											$pname= $tst->firstname." ".$tst->secondName;
											}else {
											$gender= $tst->depgender;
											$dob=$tst->depdob;
											$pnamed= $tst->depname." ".$tst->depname2;
											$pname= $tst->firstname." ".$tst->secondName;
											}
											$interval = date_diff(date_create(), date_create($dob));
											$age= $interval->format(" %Y Year, %M Months Old");
											$date_created=$tst->date;
											$doctor=$tst->doc;
											$facility=$tst->fac;
				?>
				<tr>
				<td>{{$i}}</td>
				<td>{{$pnamed}}</td>
				<td>{{$gender}}</td>
				<td>{{$age}}</td>
				<td>{{$date_created}}</td>
				 <td>{{$doctor}} </td>
				 <td>{{$facility}}</td>
				 <td><a href="{{route('patientslct',$tst->id)}}">Add Test</a></td>
				 <td>@if($tst->tests_reccommended)<a href="{{route('labinvoice',$tst->ptid)}}">Pay</a> @endif</td>

									 </tr>
									 <?php $i++; ?>
				<?php }   ?>
        <?php if(empty($dialledpatients) && empty($alternative)) { ?>
          <tr><td colspan="9" class="text-center"><a href="{{route('patientslct',$patients->id)}}">ADD TESTS</a></td></tr>
        <?php } ?>
						         </tbody>
						         </table>
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
