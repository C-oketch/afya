@extends('layouts.patient2')
@section('title', 'Patient')

@section('style')


@endsection
@section('content')
<?php
if($patient->constituency){
       $const=DB::table('constituency')->where('id',$patient->constituency)->first();
       $constituency=$const->Constituency;
     }else{
    $constituency='';
     }
 ?>
          <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                  <h2>Profile</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="#">Home</a>
                      </li>
                      <li class="active">
                          <strong>Nhif Status</strong>
                      </li>
                  </ol>
              </div>
              <div class="col-lg-2">

              </div>
          </div>
          <div class="wrapper wrapper-content">
            <div class="row">
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-success pull-right">REGISTRATION</span>
                                    <h5>NHIF</h5>
                                </div>
                                <div class="ibox-content">
                                  <ul class="todo-list m-t small-list">
                                      <li><a href="1" class="check-link"><i class="fa fa-square-o"></i> </a>
                                      <span class="m-l-xs">Employee Registration</span></li>
                                      <li><a href="2" class="check-link"><i class="fa fa-square-o"></i> </a>
                                      <span class="m-l-xs ">Self Employed Registration</span></li>
                                      <li><a href="3" class="check-link"><i class="fa fa-square-o"></i> </a>
                                      <span class="m-l-xs ">Employer Registration </span></li>
                                        </ul>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-info pull-right">REGISTRATION</span>
                                    <h5>DEPENDANTS</h5>
                                </div>
                                <div class="ibox-content">
                                  <ul class="todo-list m-t small-list">


                                      <li class="check-link"><i class="fa fa-check-square"></i><div class="stat-percent font-bold text-info">20</div>
                                      <span class="m-l-xs">Dependants </span></li>
                                      <li><a href="2" class="check-link"><i class="fa fa-square-o"></i> </a>
                                      <span class="m-l-xs ">Add Dependants</span></li>
                                      <li><a href="3" class="check-link"><i class="fa fa-square-o"></i> </a>
                                      <span class="m-l-xs ">Edit Dependants </span></li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-lg-3">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-primary pull-right">Today</span>
                                    <h5>visits</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">106,120</h1>
                                    <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                                    <small>New visits</small>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="col-lg-3">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-danger pull-right">Low value</span>
                                    <h5>User activity</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">80,600</h1>
                                    <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                                    <small>In first month</small>
                                </div>
                            </div>
                       </div> -->
            </div>
          </div>
          <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>NHIF REGISTRATION <small></small></h5>
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
                                    <div class="col-sm-4 b-r"><h3 class="m-t-none m-b">Personal Details</h3>
                                        <p>Fill accurately as possible.</p>

                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                         <div class="form-group">
                                         <label>First Name</label>
                                         <input type="text" class="form-control"  value="{{$patient->firstname}}"  readonly/>
                                        </div>

                                         <div class="form-group ">
                                         <label>Second Name</label>
                                         <input type="text" class="form-control" value="{{$patient->firstname}}"  readonly/>
                                         </div>

                                         <div class="form-group ">
                                         <label>Date of Birth</label>
                                         <input type="text" class="form-control" value="{{$patient->dob}}" name="dob" required/>
                                         </div>

                                         <div class="form-group ">
                                         <label>Gender</label>
                                         <input type="text" class="form-control" value="{{$patient->gender}}"  readonly/>
                                         </div>



																				 <div class="form-group">
																				<label>Marital Status</label>
																				<select class="form-control m-b" name="marital">
																						<option value="{{$patient->marital}}">{{$patient->marital}}</option>
																					<option value="">Please select one</option>
																					<option value="Single">Single</option>
																					<option value="Married">Married</option>
																					<option value="Divorced">Divorced</option>
																					<option value="Not Specified">Not Specified</option>

																			</select>
																		 </div>






                                    </div>
                                    <div class="col-sm-4 b-r"><h4></h4>

                                       <div class="form-group ">
                                          <label>Blood Type</label>
                                     <input type="text" class="form-control" value="{{$patient->blood_type}}"  readonly/>
                                       </div>

                                       <div class="form-group ">
                                          <label>Place of Birth</label>
                                     <input type="text" class="form-control" value="{{$patient->pob}}"  readonly/>
                                       </div>
                                       <div class="form-group ">
                                      <label>Constituency of Residence</label>
                                     <input type="text" class="form-control" value="{{$constituency}}"  readonly/>
                                       </div>

                                       <div class="form-group ">
                                      <label>NHIF Number</label>
                                     <input type="text" class="form-control" value="{{$patient->nhif}}"  readonly/>
                                       </div>
                                       <div class="form-group ">
                                      <label>Identification Document</label>
                                     <input type="text" class="form-control" value="{{$patient->id_doc}}"  readonly/>
                                       </div>
                                       <div class="form-group">
                                      <label>Identification Number</label>
                                     <input type="text" class="form-control" value="{{$patient->nationalId}}"  readonly/>
                                       </div>



                                    </div>
                                    <div class="col-sm-4"><h4></h4>


                                      <div class="form-group">
                                      <label for="exampleInputEmail1">K.R.A PIN</label>
                                      <input type="text" class="form-control"  value="{{$patient->kra_pin}}"  readonly />
                                      </div>
                                      <div class="form-group">
                                      <label for="exampleInputEmail1">Pone </label>
                                      <input type="text" class="form-control"  value="{{$patient->msisdn}}"  readonly />
                                      </div>
                                      <div class="form-group">
                                        <label>Email</label>
                                      <input type="text" class="form-control"  value="{{$patient->email}}"  readonly />
                                      </div>
                                      <div class="form-group">
                                      <label>Postal Address</label>
                                      <input type="text" class="form-control"  value="{{$patient->postal_address}}"  readonly />
                                      </div>
                                      <div class="form-group">
                                      <label>Postal Code</label>
                                      <input type="text" class="form-control"  value="{{$patient->postal_code}}"  readonly />
                                      </div>
                                      <div class="form-group">
                                      <label for="exampleInputEmail1">Town</label>
                                      <input type="text" class="form-control"  value="{{$patient->town}}"  readonly />
                                      </div>
                                   </div>
                                    </div>


                                  <div class="hr-line-dashed"></div>
                                   <div class="row">
                                     {!! Form::open(array('url' => 'nhifupload', 'files' => true, 'method'=>'POST')) !!}
                                <div class="col-sm-6 b-r"><h4>EMPLOYER DETAILS</h4>

                                  <div class="form-group">
                                  <label>Employer Code </label>
                                  <input type="hidden" class="form-control"  name="afya_user_id" value="{{$patient->id}}" />
                                  <input type="text" class="form-control"  name="employer_code" required/>
                                  <span class="help-block m-b-none">If Self Employed Write 'Self Employed'.</span>
                                  </div>
                                  <div class="form-group">
                                  <label>Employer Name </label>
                                  <input type="text" class="form-control"  name="employer_name" />
                                  </div>
                                  <div class="form-group">
                                  <label>Employer PIN</label>
                                  <input type="text" class="form-control"  name="employer_pin" />
                                  </div>
                                  <div class="form-group">
                                  <label>Nearest NIF Branch</label>
                                  <input type="text" class="form-control"  name="branch" />
                                  </div>

                                  </div>
                                  <div class="col-sm-6"><h4> Attachments</h4>
                                    <div class="form-group  {{$errors->has('id_image') ? 'has-error' : ''}}">
                                          <label>Upload File Identifictaion Documment (ID) :  </label>
                                        {!! Form::file('id_image', array('class' => 'form-control', 'required')) !!}
                                          <span class="text-danger">{{ $errors->first('id_image') }}</span>
                                    </div>

                                  <div class="form-group {{$errors->has('photo') ? 'has-error' : ''}}">
                                  <label>Passport Photo</label>
                                  {!! Form::file('photo', array('class' => 'form-control', 'required')) !!}
                                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                              </div>
                                <div class="form-group">
                                <label>Marriage Certificate</label>
                                {!! Form::file('marige', array('class' => 'form-control')) !!}
                                  <span class="text-danger">{{ $errors->first('mariage') }}</span>
                            </div>
                                <div class="text-right">
                                  <button class="btn btn-sm btn-primary" id="myBtn" type="submit"><strong>Submit</strong></button>

                                </div>

                                     {{ Form::close() }}

                                 </div>
                               </div>
                            </div>
                        </div>
                    </div>
                  </div>





              </div>


@endsection
@section('script')



@endsection
