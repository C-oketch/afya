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
																												<th>Gender</th>
																												<th>Age</th>
																									</tr>
																								</thead>

	<tbody>

		<?php $i =1;
							foreach($dialledpatients as $tst)
						{
						$gender= $tst->gender;
						$dob=$tst->dob;
						$pname= $tst->firstname." ".$tst->secondName;
						$interval = date_diff(date_create(), date_create($dob));
						$age= $interval->format(" %Y Years Old");
?>
						<tr>
						<td><a href="{{route('testreg',$tst->id)}}">{{$i}}</td>
				 		<td><a href="{{route('testreg',$tst->id)}}">{{$pname}} </a></td>
				 		<td><a href="{{route('testreg',$tst->id)}}">{{$gender}}</a></td>
				 		<td><a href="{{route('testreg',$tst->id)}}">{{$age}}</a></td>
		       </tr>
					 <?php $i++; ?>
<?php }   ?>
         </tbody>
         </table>
				</div>
     </div>
	 </div>
  </div>
</div>
