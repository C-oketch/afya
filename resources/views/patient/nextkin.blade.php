@extends('layouts.patient')
@section('title', 'Patient')
@section('content')
<?php $const= $patient->constituency; $cons=DB::table('constituency')->where('id',$const)->first();
          if($const){
            // $county=DB::Table('county')->where('id',$cons->cont_id)->first();
            $constituent=$cons->Constituency;
          }


 $gender = $patient->gender;
 $blood = $patient->blood_type;
 $pob = $patient->pob;
 $nid = $patient->nationalId;
$nhif = $patient->nhif;
$phone  = $patient->msisdn;
$email = $patient->email;
$dob = $patient->dob;



$kin=DB::table('kin')->get();
$bloodtype=DB::table('blood_types')->get();
 $consty=DB::table('constituency')->get();
$bloodpat=DB::table('blood_types')->where('type',$blood)->first();

          ?>
          <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                  <h2>Profile</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="#">Home</a>
                      </li>
                      <li class="active">
                          <strong>Update Profile</strong>
                      </li>
                  </ol>
              </div>
              <div class="col-lg-2">

              </div>
          </div>


        <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                    <div class="col-lg-12">
                      <h2>Name : {{$patient->firstname}} {{$patient->secondName}}</h2>
                      <h4>Role : Patient</h4>
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Update Basic Details</small></h5>
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
                                    <div class="col-sm-4 b-r"><h3 class="m-t-none m-b">Contact Details</h3>
                                      {!! Form::open(array('url' => 'updateBasic','method'=>'POST')) !!}

                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <input type="hidden"  value="{{$patient->id}}" name="afya_user_id"  required>

                                          <div class="form-group {{$errors->has('afyaphone') ? 'has-error' : ''}}">
                                          <label for="exampleInputEmail1">Phone (2547---)</label>
                                          <input type="text" class="form-control" value="{{$phone}}" name="afyaphone" />
                                            <span class="text-danger">{{ $errors->first('afyaphone') }}</span>
                                          </div>
                                          <div class="form-group">
                                          <label>Email</label>
                                          <input type="email" class="form-control" placeholder="name@gmail.com" value="{{$email}}" name="email"/>
                                          </div>
                                          <div class="form-group">
                                          <label>Constituency of Residence</label>
                                          <select class="form-control m-b select2_demo_1"  name="constituency" >
                                          @if($const)<option value="{{$cons->id}}">{{$constituent}}</option>
                                          @else  <option value="">Please Select Constituency</option> @endif
                                           @foreach ($consty as $cost)
                                            <option value="{{$cost->id}}">{{$cost->Constituency}}</option>
                                            @endforeach
                                          </select>
                                          </div>
                                          <div class="form-group">
                                          <label>Place of Birth</label>
                                          <input type="text" class="form-control" name="pob" placeholder="Town" value="{{$pob}}" />
                                         </div>
                                    </div>
                                    <div class="col-sm-4 b-r"><h4>Basic Data</h4>

                                      <div class="form-group" id="data_1">
                                       <label for="exampleInputPassword1">Date of Birth</label>
                                       <div class="input-group date">
                                           <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                           <input type="text" class="form-control" value="{{$dob}}" name="dob" />
                                       </div>
                                       </div>

                                      <div class="form-group">
                                      <label>Blood Type</label>
                                      <select class="form-control m-b" name="bloodtype" required>
                                      @if($blood)<option value="{{$bloodpat->type}}">{{$bloodpat->type}}</option>
                                      @else<option value="">Select one</option> @endif
                                        @foreach ($bloodtype as $type)
                                        <option value="{{$type->type}}">{{$type->type}}</option>
                                        @endforeach
                                    </select>
                                   </div>
                                       <div class="form-group">
                                       <label>NHIF Number</label>
                                       <input type="text" class="form-control" value="{{$nhif}}" placeholder="268..." name="nhif"/>
                                       </div>
                                       <div class="form-group {{$errors->has('nationalId') ? 'has-error' : ''}}">
                                       <label>National Id</label>
                                       <input type="text" class="form-control" value="{{$nid}}" placeholder="2869...." name="nationalId" />
                                       <span class="text-danger">{{ $errors->first('nationalId') }}</span>
                                       </div>
                                    </div>

                                    <div class="col-sm-4"><h4>Next of Kin Details</h4>

                                      <?php
                                      if($nextkin){$kin_name = $nextkin->kin_name; }else{ $kin_name='';}
                                      if($nextkin){$phone_of_kin = $nextkin->phone_of_kin; }else{ $phone_of_kin='';}
                                      if($nextkin){ $nextrelation = $nextkin->relation; $kinid=$nextkin->kinid; }else{ $nextrelation='Please select one'; $kinid='';}
                                      if($nextkin){ $nextrelid = $nextkin->id;  }else{  $nextrelid='';} ?>

                                      <div class="form-group">
                                      <label for="exampleInputEmail1">Name</label>
                                      <input type="text" class="form-control" value="{{$kin_name}}" placeholder="Next Kin Name" name="kin_name">
                                      <input type="hidden"  value="{{$nextrelid}}"  name="nextrelid">
                                      </div>

                                      <div class="form-group">
                                      <label for="exampleInputPassword1">Relationship</label>
                                      <select class="form-control" name="relationship" required="">
                                    <option value="{{$kinid}}">{{$nextrelation}}</option>
                                      @foreach($kin as $kn)
                                      <option value="{{$kn->id}}">{{$kn->relation}}</option>
                                      @endforeach
                                      </select>
                                      </div>
                                      <div class="form-group">
                                      <label for="exampleInputPassword1">Phone Number</label>
                                      <input type="number" class="form-control" value="{{$phone_of_kin}}" placeholder="Next of Kin Phone" name="kin_phone"  required="" />
                                      </div>
                                      <br /><br />
                                      <div class="text-right">
                                        <button class="btn btn-sm btn-primary"  type="submit"><strong>Submit</strong></button>
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
