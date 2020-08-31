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
                            {!! Form::open(array('url' => 'boarding','method'=>'POST')) !!}
                             <input type="hidden" name="_token" value="{{ csrf_token() }}">


                              <div class="col-sm-4 b-r">
                                <div class="form-group {{$errors->has('first') ? 'has-error' : ''}}">
                                  <label>File Number</label>
                                  <input type="text" class="form-control" value="{{ old('file_no') }}" name="file_no" />
                                 </div>

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


                              <div class="form-group">
                              <label>Age</label>
                              <input type="text" class="form-control" name="age21" placeholder="" value="{{ old('age21') }}"  />
                             </div>
                          <div class="form-group">
                            <strong>Gender:</strong>
                            <select class="form-control m-b" name="gender">
                              <option value="">Please select one</option>
                              <option value="Female">Female</option>
                              <option value="Male">Male</option>
                              <option value="Male">Other</option>
                          </select>
                        </div>

                            </div>

                            <div class="col-sm-4 b-r"><h4></h4>
                              <div class="form-group">
                              <label>Postal Address</label>
                              <input type="text" class="form-control" name="paddress" placeholder="P.O.BOX" value="{{ old('paddress') }}" />
                              </div>

                              <div class="form-group">
                              <label>Postal Code</label>
                              <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="i.e 00100"/>
                              </div>

                              <div class="form-group">
                              <label>Town</label>
                              <input type="text" class="form-control" name="town"  value="{{ old('town') }}"/>
                              </div>
                              <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
                              <label for="exampleInputEmail1">Phone (2547---)</label>
                              <input type="text" class="form-control" value="{{ old('phone') }}" id="phone" name="phone" />
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                              </div>



                            <div class="form-group {{$errors->has('pob') ? 'has-error' : ''}}">
                            <label>Occupation</label>
                            <input type="text" class="form-control" name="occupation" placeholder="" value="{{ old('occupation') }}" />
                            <span class="text-danger">{{ $errors->first('occupation') }}</span>
                           </div>


                            </div>

                            <div class="col-sm-4"><h4>NEXT OF KIN DETAILS</h4>
                              <div class="form-group">
                              <label>Name</label>
                              <input type="text" class="form-control"   name="kin_name" value="{{ old('kin_name') }}"/>
                              </div>
                              <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone_of_kin" value="{{ old('phone_of_kin') }}" />
                              </div>
                              <div class="form-group" id="data_2">
                               <label for="exampleInputPassword1">File Date</label>
                               <div class="input-group date">
                                   <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                   <input type="text" class="form-control" name="filedate" value="{{ old('filedate') }}"/>
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
