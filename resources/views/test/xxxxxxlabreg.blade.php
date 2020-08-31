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
							foreach($directpatients as $tstd)
						{

						$tst = DB::table('afya_users')
						->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
            ->Join('patient_test', 'appointments.id', '=', 'patient_test.appointment_id')
						->leftJoin('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
						->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
						->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
						->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
						->select('afya_users.*','patient_test.id as ptid','patient_test.created_at as date',
						'patient_test.test_status','doctors.name as doc','facilities.FacilityName as fac',
						'appointments.persontreated',
						'dependant.firstName as depname','dependant.secondName as depname2',
						'dependant.gender as depgender','dependant.dob as depdob','patient_test_details.tests_reccommended')
						->where([
											 ['afya_users.id', '=',$tstd->id],  ])
						->first();
          if ($tst){
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
					}

					$direct = DB::table('afya_users')
					->Join('patient_test', 'afya_users.id', '=', 'patient_test.afya_user_id')
					->leftJoin('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
          ->leftJoin('dependant', 'patient_test.dependant_id', '=', 'dependant.id')
					->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
					->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
					->select('afya_users.*','patient_test.id as ptid','patient_test.created_at as date',
					'patient_test.test_status','doctors.name as doc','facilities.FacilityName as fac',
					'patient_test.dependant_id as persontreated',
					'dependant.firstName as depname','dependant.secondName as depname2',
					'dependant.gender as depgender','dependant.dob as depdob','patient_test_details.tests_reccommended')
					->where([
					           ['afya_users.id', '=',$tstd->id],  ])
					->first();
					if ($direct){
					  if ($direct->persontreated =='Self') {
					  $gender_d= $direct->gender;
					  $dob=$direct->dob;
						$pnamedd="Primary";
					  $dpname= $direct->firstname." ".$direct->secondName;
					  }else {
					  $gender_d= $direct->depgender;
					  $dob=$direct->depdob;
					  $pnamedd= $direct->depname." ".$direct->depname2;
					  $dpname= $direct->firstname;
					  }
						// $genderd="Male";
					  $interval = date_diff(date_create(), date_create($dob));
					  $aged= $interval->format(" %Y Year, %M Months, %d Days Old");
					  $date_createdd=$direct->date;
					  $doctord=$direct->doc;
					  $facilityd=$direct->fac;
					}
?>         @if($tst)
						<tr>
						<td>{{$i}}</td>
				 		<td>{{$pname}} </td>
				 		<td>{{$pnamed}}</td>
				 		<td>{{$gender}}</td>
				 		<td>{{$age}}</td>
				 		<td>{{$date_created}}</td>
				 		 <td>{{$doctor}} </td>
				 		 <td>{{$facility}}</td>
						 <td><a href="{{route('patientslct',$tstd->id)}}">Add Test</a></td>
             <td>@if($tst->tests_reccommended)<a href="{{route('labinvoice',$tst->ptid)}}">Pay</a> @endif</td>
		       </tr>
					 <?php $i++; ?>
					 @endif


						<!-- @if($direct)
						<?php $i=$i; ?>
						<tr>
						<td>{{$i}}</td>
						<td>{{$dpname}}   </td>
						<td>@if($direct) {{$pnamedd}}
							@else Pending @endif
							 </td>
						<td> {{$gender_d}}</td>
						<td>{{$aged}}</td>
						<td> {{$date_createdd}}</td>
						 <td> {{$doctord}}</td>
						 <td>{{$facilityd}}</td>
						 <td><a href="{{route('patientslct',$tstd->id)}}">Add Test</a></td>
						 <td>@if($direct->tests_reccommended)<a href="{{route('labinvoice',$direct->ptid)}}">Pay</a>@endif</td>
            </tr>
								 @endif
						<?php $i++; ?> -->
<?php }   ?>

	         </tbody>

			 </table>
				</div>
     </div>
	 </div>
  </div>
</div>
