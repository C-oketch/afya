@extends('layouts.test')
@section('title', 'Tests')
@section('content')
<div class="content-page  equal-height">

		<div class="content">
				<div class="container">



					<div class="wrapper wrapper-content animated fadeInRight">
										<div class="row">
												<div class="col-lg-11">
												<div class="ibox float-e-margins">
														<div class="ibox-title">

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
															<div class="ibox float-e-margins">
																<div class="table-responsive ibox-content">
																<table class="table table-striped table-bordered table-hover dataTables-conditional" >
																	 <thead>
																<tr>
																 <th></th>
																	 <th>Weight </th>
																	 <th>Height</th>
																	 <th>Temperature</th>
																	 <th>Systolic BP</th>
																	 <th>Diastolic BP</th>
																	 <th>BMI</th>
																	 <th>Chief Compliant</th>
																	 <th>Observations</th>
																	 <th>Symptoms</th>
																	 <th>Nurse Notes</th>


																</tr>
																</thead>

																<tbody>
																<?php $i =1; ?>

																@foreach($tsts as $pdetails)
																	<tr>
																	<td>{{ +$i }}</td>
																 <td>{{$pdetails->current_weight}}</td>
																	<td>{{$pdetails->current_height}}</td>
																	<td>{{$pdetails->temperature}}</td>
																	<td>{{$pdetails->systolic_bp}}</td>
																	 <td>{{$pdetails->diastolic_bp}}</td>
																	 <td><?php $height=$pdetails->current_height; $weight=$pdetails->current_weight;
																							$bmi =$weight/($height*$height);
																							echo number_format($bmi, 2);
																					 ?></td>
																	 <td>{{$pdetails->chief_compliant}}</td>
																	 <td>{{$pdetails->observation}}</td>
																	 <td>{{$pdetails->symptoms}}</td>
																	 <td>{{$pdetails->nurse_notes}}</td>


																</tr>
																<?php $i++; ?>

																@endforeach

																</tbody>
																</table>
																</div>
																 </div>

																							 </div>
																					 </div>
																			 </div>

 <div class="ibox float-e-margins col-md-12">
 							 <div class="ibox-title">
 									 <h5>Chosen select <small>http://harvesthq.github.io/chosen/</small></h5>
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
 							 <p>
 									 With chosen select uesr can fase chose from large in select input.
 							 </p>
							 <form role="form" class="">
								 <div class="form-inline">
                            <div class="form-group col-md-3">
																	 <label for="exampleInputEmail2">Email address</label>
																	 <input type="email" placeholder="Enter email" id="exampleInputEmail2"
																					class="form-control">
															 </div>
															 <div class="form-group col-md-3">
																	 <label for="exampleInputPassword2">Password</label>
																	 <input type="password" placeholder="Password" id="exampleInputPassword2"
																					class="form-control">
															 </div>
									</div>
															 <div class="checkbox m-r-xs">
																	 <input type="checkbox" id="checkbox1">
																	 <label for="checkbox1">
																			 Remember me
																	 </label>
															 </div>
															 <button class="btn btn-white" type="submit">Sign in</button>
													 </form>
 							</div>
</div>
<div class="ibox float-e-margins col-md-6">
							 <div class="ibox-title">
									 <h5>Chosen select <small>http://harvesthq.github.io/chosen/</small></h5>
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
							 <p>
									 With chosen select uesr can fase chose from large in select input.
							 </p>
							 <div class="form-group ">
								<label for="role" class="control-label">Doctor note</label>
								 {{ Form::text('doc_note', null, array('placeholder' => 'note..','class' => 'form-control col-lg-8')) }}
						 </div>
							</div>



           </div>
			 </div>

</div>
@include('includes.default.footer')
				</div><!--content-->
		</div><!--content page-->

@endsection
