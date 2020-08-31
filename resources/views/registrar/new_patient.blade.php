@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')

@section('style')
@endsection

@section('content')
@include('includes.registrar.topnavbar_v1')
          <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Patients Details <small>New User</small></h5>
                                <div class="ibox-tools">
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                            {!! Form::open(array('url' => 'registeruser','method'=>'POST')) !!}
                             <input type="hidden" name="_token" value="{{ csrf_token() }}">
                             <div class="form-group col-md-12">
                               <div class="col-md-4 col-md-offset-4">
                             <label>File Number</label>
                             <input type="text" class="form-control" value="{{ old('file_no') }}" name="file_no" />
                              </div>

                              <div class="form-group" id="data_2">
                               <label for="exampleInputPassword1">File Date</label>
                               <div class="input-group date">
                                   <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                   <input type="text" class="form-control" name="filedate" />
                                </div>
                               </div>
                              </div>

                              <div class="col-sm-4 b-r">
                             <div class="form-group {{$errors->has('first') ? 'has-error' : ''}}">
                             <label>First Name</label>
                             <input type="text" class="form-control" name="first" placeholder="first name" value="{{ old('first') }}"  required=""/>
                             <span class="text-danger">{{ $errors->first('first') }}</span>
                              </div>
                             <div class="form-group {{$errors->has('second') ? 'has-error' : ''}}">
                             <label>Second Name</label>
                             <input type="text" class="form-control" placeholder="surname/Second Name" value="{{ old('second') }}" name="second"  required=""/>
                             <span class="text-danger">{{ $errors->first('second') }}</span>
                             </div>
                             <div class="form-group {{$errors->has('pob') ? 'has-error' : ''}}">
                             <label>Place of Birth</label>
                             <input type="text" class="form-control" name="pob" placeholder="" value="{{ old('pob') }}" />
                             <span class="text-danger">{{ $errors->first('pob') }}</span>
                            </div>

                             <div class="form-group {{$errors->has('age') ? 'has-error' : ''}}" id="data_2">
                              <label for="exampleInputPassword1">Date of Birth</label>
                              <div class="input-group date">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" class="form-control" value="{{ old('age') }}" name="age" />
                                  <span class="text-danger">{{ $errors->first('age') }}</span>
                               </div>
                              </div>
                              <div class="form-group">
                              <label>Age</label>
                              <input type="text" class="form-control" name="age21" placeholder=""  />
                             </div>
                          <br /><br />
                               <div class="form-group">
                               <label class="col-md-4">Gender</label>
                               <input type="radio" value="Male"  name="gender" required="" />
                               <label>Male</label>
                               <input type="radio" value="Female"  name="gender" required="" />
                               <label>Female</label>
                               <input type="radio" value="others"  name="gender" required="" />
                               <label>Other</label>
                               </div>

                             <div class="form-group">
                             <label>Marital Status</label>
                             <select class="form-control m-b select2_demo_1" name="marital">
                               <option value="">Please select one</option>
                               <option value="Single">Single</option>
                               <option value="Married">Married</option>
                               <option value="Divorced">Divorced</option>
                               <option value="Not Specified">Not Specified</option>
                              </select>
                              </div>

                              <?php  $blood=DB::table('blood_types')->get();
                                     $const=DB::table('constituency')->get();
                               ?>


                              <div class="form-group">
                              <label>Blood Type</label>
                              <select class="form-control m-b select2_demo_1" name="bloodtype" >
                                <option value="">Please select one</option>
                                @foreach ($blood as $type)
                                <option value="{{$type->type}}">{{$type->type}}</option>
                                @endforeach
                            </select>
                           </div>

                            </div>

                            <div class="col-sm-4 b-r"><h4></h4>

                              <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
                              <label for="exampleInputEmail1">Phone (2547---)</label>
                              <input type="text" class="form-control" value="{{ old('phone') }}" id="phone" name="phone" />
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                              </div>
                              <div class="form-group">
                            <label>Identification Document</label>
                            <select class="form-control m-b select2_demo_1" name="id_doc">
                              <option value="">Please select one</option>
                              <option value="Kenyan ID">Kenyan Identity Card</option>
                              <option value="Alien Id">Alien Identity Card</option>
                              </select>
                             </div>

                              <div class="form-group {{$errors->has('nationalId') ? 'has-error' : ''}}">
                              <label>Identification Number</label>
                              <input type="text" class="form-control" value="{{ old('nationalId') }}" placeholder="2869...." name="nationalId" />
                              <span class="text-danger">{{ $errors->first('nationalId') }}</span>
                              </div>

                            <div class="form-group {{$errors->has('nhif') ? 'has-error' : ''}}">
                            <label>NHIF Number</label>
                            <input type="text" class="form-control" value="{{ old('nhif') }}" placeholder="268..." name="nhif"/>
                            <span class="text-danger">{{ $errors->first('nhif') }}</span>
                            </div>
                            <div class="form-group {{$errors->has('pob') ? 'has-error' : ''}}">
                            <label>Occupation</label>
                            <input type="text" class="form-control" name="occupation" placeholder="" value="{{ old('occupation') }}" />
                            <span class="text-danger">{{ $errors->first('occupation') }}</span>
                           </div>
                            <div class="form-group">
                            <label>Constituency of Residence</label>
                            <select class="form-control m-b select2_demo_1"  name="constituency" >
                            <option value="">Select Constituency</option>
                             @foreach ($const as $cost)
                              <option value="{{$cost->id}}">{{$cost->Constituency}}</option>
                              @endforeach
                            </select>
                            </div>
                              <div class="form-group">
                              <label for="exampleInputEmail1">K.R.A PIN</label>
                              <input type="text" class="form-control"  id="kra" name="kra" />
                              </div>
                            </div>

                            <div class="col-sm-4"><h4></h4>

                                <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="name@gmail.com" value="{{ old('email') }}" name="email"/>
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>

                                <div class="form-group">
                                <label>Postal Address</label>
                                <input type="text" class="form-control" name="paddress" placeholder="P.O.BOX" value="" />
                               </div>

                               <div class="form-group">
                               <label>Postal Code</label>
                               <input type="text" class="form-control" name="code" placeholder="i.e 00100"/>
                              </div>

                              <div class="form-group">
                              <label>Town</label>
                              <input type="text" class="form-control" name="town" />
                             </div>

                             <div class="form-group">
                              <label for="exampleInputPassword1">Are you covered by insurance?</label>
                               <input type="radio" value="yes"  name="is_insured" onclick="show1();">Yes
                                <input type="radio" value="no"  name="is_insured" onclick="show2();">No
                              </div>

                            <div id="two" style="display:none">
                                <div class="form-group">
                                  <?php  $insurances=DB::table('insurance_companies')->get();
                                   ?>
                                <label>Insurance company</label>
                                <select class="form-control m-b select2_demo_1" name="insurance_company" >
                                  <option selected disabled value="">Select insurance company</option>
                                  @foreach ($insurances as $insurance)
                                  <option value="{{$insurance->id}}">{{$insurance->company_name}}</option>
                                  @endforeach
                                </select>
                                </div>

                                <div class="form-group">
                                <label>Policy No</label>
                                <input type="text" class="form-control" name="policy_no" />
                               </div>
                            </div>
                                  <div class="form-group">
                                  <label>Do you have a smartphone?</label>
                                  <input type="radio" value="yes"  name="smartphone">Yes
                                   <input type="radio" value="no"  name="smartphone">No
                                 </div>

                                    </div>
<?php $kin = DB::table('kin')->get();  ?>

                                    <div class="col-sm-12"><h4>NEXT OF KIN DETAILS</h4>
                                    <div class="col-sm-6 b-r">
                                        <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control"   name="kin_name" />
                                      </div>
                                      <div class="form-group">
                                        <label>Relation</label>
                                        <select class="form-control m-b select2_demo_1"  name="relation" >
                                          @foreach ($kin as $cost)
                                          <option value="{{$cost->id}}">{{$cost->relation}}</option>
                                          @endforeach
                                        </select>
</div>                                      </div>
<div class="col-sm-6 b-r">
                                        <div class="form-group">
                                          <label>Phone</label>
                                          <input type="text" class="form-control" name="phone_of_kin" />
                                        </div>
                                        <div class="form-group">
                                          <label>Postal Address</label>
                                          <input type="text" class="form-control" name="kin_postal" />
                                        </div>
</div>
                                    </div>

                                    <div class="text-right col-md-12">
                                      <button class="btn btn-sm btn-primary" id="myBtn" type="submit"><strong>Submit</strong></button>
                                     </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>


            @include('includes.default.footer')
            @endsection
            @section('script-reg')
            <script>
            $(".select2_demo_1").select2();
            </script>
            <script>
            function show1()
            {
              document.getElementById('two').style.display ='block';
            }
            function show2()
            {
              document.getElementById('two').style.display ='none';
            }
            </script>
            <script>
            $('#data_2 .input-group.date').datepicker({
                        startView: 1,
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        forceParse: false,
                        autoclose: true,
                        format: "yyyy-mm-dd"
                    });

            </script>


            @endsection
