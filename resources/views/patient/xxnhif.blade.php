@extends('layouts.patient2')
@section('title', 'Patient')

@section('style')
<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
	<!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/" rel="stylesheet" /> -->

  <link rel="stylesheet" href="{{asset('css/material-bootstrap-wizard.css') }}" />

@endsection
@section('content')
<?php
       $const=DB::table('constituency')->where('id',$patient->constituency)->first();
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
                                         <input type="text" class="form-control" value="{{$patient->dob}}" readonly/>
                                         </div>

                                         <div class="form-group ">
                                         <label>Gender</label>
                                         <input type="text" class="form-control" value="{{$patient->gender}}"  readonly/>
                                         </div>

                                         <div class="form-group ">
                                         <label>Marital Status</label>
                                         <input type="text" class="form-control" value="{{$patient->marital}}"  readonly/>
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
                                     <input type="text" class="form-control" value="{{$const->Constituency}}"  readonly/>
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





                  <div class="row">
  <div class="col-sm-8 col-sm-offset-2">
      <!--      Wizard container        -->
      <div class="wizard-container">
          <div class="card wizard-card" data-color="green" id="wizardProfile">
              <form action="" method="">
          <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->

                <div class="wizard-header">
                    <h3 class="wizard-title">
                       Build Your Profile
                    </h3>
        <h5>This information will let us know more about you.</h5>
                </div>
      <div class="wizard-navigation">
        <ul>
                        <li><a href="#about" data-toggle="tab">About</a></li>
                        <li><a href="#account" data-toggle="tab">Account</a></li>
                        <li><a href="#address" data-toggle="tab">Address</a></li>
                    </ul>
      </div>

                  <div class="tab-content">
                      <div class="tab-pane" id="about">
                        <div class="row">
                            <h4 class="info-text"> Let's start with the basic information (with validation)</h4>
                            <div class="col-sm-4 col-sm-offset-1">
                                <div class="picture-container">
                                    <div class="picture">
                                      <img src="assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title=""/>
                                        <input type="file" id="wizard-picture">
                                    </div>
                                    <h6>Choose Picture</h6>
                                </div>
                            </div>
                            <div class="col-sm-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">face</i>
                </span>
                <div class="form-group label-floating">
                                      <label class="control-label">First Name <small>(required)</small></label>
                                      <input name="firstname" type="text" class="form-control">
                                    </div>
              </div>

              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">record_voice_over</i>
                </span>
                <div class="form-group label-floating">
                  <label class="control-label">Last Name <small>(required)</small></label>
                  <input name="lastname" type="text" class="form-control">
                </div>
              </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-1">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">email</i>
                </span>
                <div class="form-group label-floating">
                                        <label class="control-label">Email <small>(required)</small></label>
                                        <input name="email" type="email" class="form-control">
                                    </div>
              </div>
                            </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="account">
                          <h4 class="info-text"> What are you doing? (checkboxes) </h4>
                          <div class="row">
                              <div class="col-sm-10 col-sm-offset-1">
                                  <div class="col-sm-4">
                                      <div class="choice" data-toggle="wizard-checkbox">
                                          <input type="checkbox" name="jobb" value="Design">
                                          <div class="icon">
                                              <i class="fa fa-pencil"></i>
                                          </div>
                                          <h6>Design</h6>
                                      </div>
                                  </div>
                                  <div class="col-sm-4">
                                      <div class="choice" data-toggle="wizard-checkbox">
                                          <input type="checkbox" name="jobb" value="Code">
                                          <div class="icon">
                                              <i class="fa fa-terminal"></i>
                                          </div>
                                          <h6>Code</h6>
                                      </div>
                                  </div>
                                  <div class="col-sm-4">
                                      <div class="choice" data-toggle="wizard-checkbox">
                                          <input type="checkbox" name="jobb" value="Develop">
                                          <div class="icon">
                                              <i class="fa fa-laptop"></i>
                                          </div>
                                          <h6>Develop</h6>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="tab-pane" id="address">
                          <div class="row">
                              <div class="col-sm-12">
                                  <h4 class="info-text"> Are you living in a nice area? </h4>
                              </div>
                              <div class="col-sm-7 col-sm-offset-1">
                                  <div class="form-group label-floating">
                                    <label class="control-label">Street Name</label>
                                  <input type="text" class="form-control">
                                  </div>
                              </div>
                              <div class="col-sm-3">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Street Number</label>
                                      <input type="text" class="form-control">
                                  </div>
                              </div>
                              <div class="col-sm-5 col-sm-offset-1">
                                  <div class="form-group label-floating">
                                      <label class="control-label">City</label>
                                      <input type="text" class="form-control">
                                  </div>
                              </div>
                              <div class="col-sm-5">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Country</label>
                                      <select name="country" class="form-control">
                  <option disabled="" selected=""></option>
                                          <option value="Afghanistan"> Afghanistan </option>
                                          <option value="Albania"> Albania </option>
                                          <option value="Algeria"> Algeria </option>
                                          <option value="American Samoa"> American Samoa </option>
                                          <option value="Andorra"> Andorra </option>
                                          <option value="Angola"> Angola </option>
                                          <option value="Anguilla"> Anguilla </option>
                                          <option value="Antarctica"> Antarctica </option>
                                          <option value="...">...</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="wizard-footer">
                      <div class="pull-right">
                          <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='Next' />
                          <input type='button' class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='Finish' />
                      </div>

                      <div class="pull-left">
                          <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                      </div>
                      <div class="clearfix"></div>
                  </div>
              </form>
          </div>
      </div> <!-- wizard container -->
  </div>
</div><!-- end row -->
              </div>


@endsection
@section('script')
<!--  Plugin for the Wizard -->
<script src="{{ asset('js/material-bootstrap-wizard.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->


@endsection
