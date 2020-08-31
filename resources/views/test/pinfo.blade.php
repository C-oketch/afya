@extends('layouts.test')
@section('title', 'Tests')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight white-bg">
		<div class="row">
						<div class="col-lg-12">
							<div class="col-md-6">
								<address>
							<h2></h2><strong>Patient Details:</strong><br />
							<strong>NAME : </strong>{{$info->firstname}} {{$info->secondName}}<br />
							<strong>Gender :</strong> {{$info->gender}}<br />
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

			 <div class="wrapper wrapper-content animated fadeInRight">
					 <div class="row">
					 <div class="col-lg-7">
							 <div class="ibox float-e-margins">
									 <div class="ibox-title">
											 <h5>Update Patient Details</h5>
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
											 <div class="row">

												 <form  role="form" method="POST" action="/uppat" novalidate>
												 <input type="hidden" name="_token" value="{{ csrf_token() }}">
												 <input type="hidden" class="form-control" value="{{$info->id}}" name="afya_user_id" >
												 <div class="form-group " id="data_1">
													<label class="control-label">Date of Birth</label>
													<div class="input-group date  col-lg-6">
															<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															<input type="text" class="form-control" name="dob" value="">
													</div>
													</div>
												 <div class="form-group"><label class="control-label">NHIF:</label>
												 <div class="input-group col-lg-6"><input type="text" placeholder="Nhif" name="nhif" class="form-control"></div>
												 </div>
												 <div class="form-group"><label class="control-label">National Id No:</label>
												 <div class="input-group col-lg-6"><input type="text" placeholder="ID NO" name="nationalId" class="form-control"></div>
												 </div>
												 <div class="form-group">
												 <div class="col-lg-offset-2 col-lg-6">
												 <button class="btn btn-sm btn-primary" type="submit">Submit</button>
												 </div>
												 </div>
												 </form>

											 </div>
									 </div>
							 </div>
					 </div>
				 </div>
				</div>
@endsection
@section('script')
 <!-- Page-Level Scripts -->


@endsection
