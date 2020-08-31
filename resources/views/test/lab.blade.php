<?php
$tsts = DB::table('patient_test')
->Join('appointments', 'patient_test.appointment_id', '=', 'appointments.id')
->Join('afya_users', 'appointments.afya_user_id', '=', 'afya_users.id')
->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
->Join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
->leftJoin('dependant', 'appointments.persontreated', '=', 'dependant.id')
->Join('facilities', 'appointments.facility_id', '=', 'facilities.FacilityCode')
->Join('doctors', 'appointments.doc_id', '=', 'doctors.id')
->Join('payments', 'patient_test.id', '=', 'payments.patient_test_id')

->select('afya_users.*','patient_test.id as tid','patient_test.created_at as date',
'patient_test.test_status','doctors.name as doc','facilities.FacilityName as fac',
'appointments.persontreated',
'dependant.firstName as depname','dependant.secondName as depname2',
'dependant.gender as depgender','dependant.dob as depdob')
->where([  ['patient_test_details.done', '=',0],
['patient_test.test_status', '!=',1],
['patient_test_details.deleted', '=',0],
['afyamessages.test_center_code', '=',$facid->facilitycode],

])
// ->whereNull('afyamessages.status')
->groupBy('appointments.id')
->get();


$alternative = DB::table('patient_test')
->Join('patient_test_details', 'patient_test.id', '=', 'patient_test_details.patient_test_id')
->Join('afya_users', 'patient_test.afya_user_id', '=', 'afya_users.id')
->Join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
->Join('payments', 'patient_test.id', '=', 'payments.patient_test_id')
->leftJoin('dependant', 'patient_test.dependant_id', '=', 'dependant.id')
->leftJoin('facilities', 'patient_test.facility_from', '=', 'facilities.FacilityCode')
->leftJoin('doctors', 'patient_test.doc_id', '=', 'doctors.id')
->select('afya_users.*','patient_test.id as tid','patient_test.created_at as date',
'patient_test.test_status','doctors.name as doc','facilities.FacilityName as fac',
'patient_test.dependant_id as persontreated',
'dependant.firstName as depname','dependant.secondName as depname2',
'dependant.gender as depgender','dependant.dob as depdob')
->where([  ['patient_test_details.done', '=',0],
           ['patient_test.test_status', '!=',1],
           ['patient_test_details.deleted', '=',0],
           ['afyamessages.test_center_code', '=',$facid->facilitycode],

])
->whereNull('afyamessages.status')
->get();
?>
<div class="row">
	<div class="col-lg-12">
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

							</tr>
						</thead>

						<tbody>
							<?php $i =1; ?>

							<?php
							if(isset($tsts))
							{
								foreach($tsts as $tst)
								{
									if($tst->persontreated=='Self') {
										$gender= $tst->gender;
										$dob=$tst->dob;
										$pname= $tst->firstname." ".$tst->secondName;
									}else {
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
										<td><a href="{{route('patientTests',$tst->tid)}}"></a>{{$i}}</td>
										<td><a href="{{route('patientTests',$tst->tid)}}">{{$pname}}</a></td>
										<td>
											@if($tst->persontreated=='Self')
											Primary @else
											<a href="{{route('patientTests',$tst->tid)}}">{{$pnamed}}</a>
											@endif
										</td>
										<td>{{$gender}}</td>
										<td>{{$age}}</td>
										<td>{{$tst->date}}</td>
										<td>{{$tst->doc}}</td>
										<td>{{$tst->fac}}</td>
										<?php $i++; ?>
									</tr>

								<?php } } ?>
                <?php $i=$i; ?>
							<?php
							if(isset($alternative))
							{
								foreach($alternative as $tst)
								{
									if($tst->persontreated=='Self') {
										$gender= $tst->gender;
										$dob=$tst->dob;
										$pname= $tst->firstname." ".$tst->secondName;
									}else {
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
										<td><a href="{{route('patientTests',$tst->tid)}}"></a>{{$i}}</td>
										<td><a href="{{route('patientTests',$tst->tid)}}">{{$pname}}</a></td>
										<td>
											@if($tst->persontreated=='Self')
											Primary @else
											<a href="{{route('patientTests',$tst->tid)}}">{{$pnamed}}</a>
											@endif
										</td>
										<td>{{$gender}}</td>
										<td>{{$age}}</td>
										<td>{{$tst->date}}</td>
										<td>{{$tst->doc}}</td>
										<td>{{$tst->fac}}</td>

										<?php $i++; ?>
									<?php } } ?>
                 </tr>
            </tbody>
           </table>
				</div>
       </div>
		</div>
	</div>
</div>
