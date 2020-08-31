<div class="row">
												<div class="col-lg-11">
												<div class="ibox float-e-margins">
														<div class="ibox-title">
                              <h5> LABORATORY TESTS</h5>
																<div class="ibox-tools">

																		<a class="collapse-link">
																				<i class="fa fa-chevron-up"></i>
																		</a>
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
																												<th>Name</th>
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
						$age= $interval->format(" %Y Year, %M Months, %d Days Old");
						$date_created=$tst->date;
						$doctor=$tst->doc;
						$facility=$tst->fac;


?>
						<tr>
						<td>{{$i}}</td>
				 		<td>{{$pname}} </td>
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
@if($alternative)
<?php $i =$i;
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
				$age= $interval->format(" %Y Year, %M Months, %d Days Old");
				$date_created=$tst->date;
				$doctor=$tst->doc;
				$facility=$tst->fac;


?>
				<tr>
				<td>{{$i}}</td>
				<td>{{$pname}} </td>
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

@endif

	         </tbody>
         </table>
				</div>
     </div>
	 </div>
  </div>
</div>
