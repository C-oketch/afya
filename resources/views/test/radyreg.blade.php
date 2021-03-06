<?php
$tsts = DB::table('patient_test')
->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
->Join('radiology_test_details', 'patient_test.appointment_id', '=', 'radiology_test_details.appointment_id')
->Join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->select('afya_users.*','patient_test.id as tid','patient_test.created_at as date',
'patient_test.test_status','doctors.name as doc','facilities.FacilityName as fac',
'appointments.persontreated',
'dependant.firstName as depname','dependant.secondName as depname2',
'dependant.gender as depgender','dependant.dob as depdob')
->where([
					 ['afyamessages.test_center_code', '=',$facid->facilitycode],
					 ['radiology_test_details.done', '!=',2],
])
->whereNull('afyamessages.status')
->groupBy('appointments.id')
->get();


$directpatients = DB::table('afya_users')
->Join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
->select('afya_users.*')
->where('afyamessages.test_center_code', '=',$facid->facilitycode)
->where('afyamessages.patient_state', '=',20)
->whereNull('afyamessages.status')
->get();

?>
	<div class="row">
												<div class="col-lg-12">
												<div class="ibox float-e-margins">
														<div class="ibox-title">
                              <h5>RADIOLOGY TESTS</h5>
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
																												<th>Invoice</th>
																									</tr>
																								</thead>

																								<tbody>
																									<?php $i =1; ?>
																									<?php
																									$i=$i;
																									if(isset($tsts))
																									{
																										foreach($tsts as $tst)
																									{
																									if ($tst->persontreated=='Self') {
																									$gender= $tst->gender;
																									$dob=$tst->dob;
																									$pname= $tst->firstname." ".$tst->secondName;
																									}

																									else {
																									$gender= $tst->depgender;
																									$dob=$tst->depdob;
																									$pnamed= $tst->depname." ".$tst->depname2;
																									$pname= $tst->firstname." ".$tst->secondName;
																									}

																									if ($gender==1) {$gender='Male';}else{$gender='Female';}
																									$interval = date_diff(date_create(), date_create($dob));
																									$age= $interval->format(" %Y Year, %M Months, %d Days Old");
																									?>
																									<tr>
																									<td><a href="{{route('pradTests',$tst->tid)}}">{{$i}}</a></td>
																									<td><a href="{{route('pradTests',$tst->tid)}}">{{$pname}}</a></td>
																									<td>
																										@if($tst->persontreated=='Self')
																										Primary @else
																										<a href="{{route('pradTests',$tst->tid)}}">{{$pnamed}}</a>
                                                     @endif
																									</td>
																									<td>{{$gender}}</td>
																									<td>{{$age}}</td>
																									<td>{{$tst->date}}</td>
																									 <td>{{$tst->doc}}</td>
																									 <td>{{$tst->fac}}</td>
																									 <td> </td>
																									 <td><a href="{{route('radinvoice',$tst->tid)}}">Invoice</a></td>

																									</tr>
																									<?php $i++; ?>
																								<?php }
																							        } ?>


																											<?php
																											$i=$i;
																											if(isset($directpatients))
																											{
																												foreach($directpatients as $tstd)
																											{

																											$genderd= $tstd->gender;
																											$dobd=$tstd->dob;
																											$pnamed= $tstd->firstname." ".$tstd->secondName;

																											if ($genderd==1) {$genderd='Male';}else{$genderd='Female';}
																											$interval = date_diff(date_create(), date_create($dobd));
																											$aged= $interval->format(" %Y Year, %M Months, %d Days Old");


																											$directtests = DB::table('patient_test')
																											->leftJoin('dependant', 'patient_test.dependant_id', '=', 'dependant.id')
																											->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
																											->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
																											->select('patient_test.*','dependant.firstName','dependant.secondName','doctors.name as doc','facilities.FacilityName as fac')
																											->where('patient_test.afya_user_id',$tstd->id)
                                                       ->first();
                                                          ?>
																													@if($directtests)
																											<tr>
																											<td><a href="{{route('pradTests',$directtests->id)}}">{{$i}}</a></td>
                                                     <td><a href="{{route('pradTests',$directtests->id)}}">{{$pnamed}}</a></td>
                                                     @if($directtests->dependant_id =='Self')
																											<td>Primary</td>
																											<td>{{$genderd}}</td>
																											<td>{{$aged}}</td>
																											@else
																											<?php
																											$genderdep=$directtests->gender;
																											$dobdep=$directtests->dobdep;

																											if ($genderdep==1) {$depgender='Male';}else{$depgender='Female';}
																											$interval = date_diff(date_create(), date_create($dobdep));
																											$agedep= $interval->format(" %Y Year, %M Months, %d Days Old");
																											 ?>
                                                       <td>{{$directtests->firstName}}{{$directtests->secondName}}</td>
																											 <td>{{$doc}}</td>
 																											<td>{{$fac}}</td>
																											@endif

																											<td>{{$directtests->created_at}}</td>
																											 <td>Pending</td>
																											 <td>Pending</td>
																											 <td><a href="{{route('patientslct',$tstd->id)}}">AddTest</a></td>

																											 <td><a href="{{route('radinvoice',$directtests->id)}}">Invoice</a></td>

                                                       </tr>

                                                 @else
																											 <tr>
 																											<td><a href="{{route('patientslct',$tstd->id)}}"></a>{{$i}}</td>
 																											<td><a href="{{route('patientslct',$tstd->id)}}">{{$pnamed}}</a></td>
 																											<td>Pending</td>
 																											<td>{{$genderd}}</td>
 																											<td>{{$aged}}</td>
 																											<td>{{$tstd->created_at}}</td>
 																											 <td>Pending</td>
 																											 <td>Pending</td>
 																											 <td>Pending</td>
                                                        </tr>
																										@endif



																											<?php $i++; ?>
																										<?php }
																													} ?>

																								 </tbody>

																							 </table>
																									</div>

																							 </div>
																					 </div>
																			    </div>
																			 </div>
