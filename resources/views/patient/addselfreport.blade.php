@extends('layouts.patient')
@section('title', 'Patient')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
          <div class="row">
          <div class="col-lg-10">
              <div class="ibox float-e-margins">
                  <div class="ibox-title">
                      <h5>Self Reporting Details <small>Confirm your entries before submitting</small></h5>
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
                          <div class="col-sm-6 b-r">


                              <form class="form-horizontal" role="form" method="POST" action="/createselfreport" novalidate>
                               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                               <input type="hidden" class="form-control" id="exampleInputEmail1"  value="{{$id}}" name="id"  required>
                                <div class="form-group">
                               <label for="exampleInputPassword1">Temperature</label>
                               <input type="number" class="form-control" id="exampleInputEmail1"  placeholder="" name="temperature" >
                               </div>
                               <div class="form-group">
                              <label for="exampleInputPassword1">Weight</label>
                              <input type="number" class="form-control" id="exampleInputEmail1"  placeholder="" name="weight">
                              </div>

                              <div class="form-group"><label for="exampleInputPassword1">BP</label>
                              <input type="text" class="form-control" id="exampleInputEmail1"  placeholder="" name="bp">
                             </div>

                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label for="exampleInputPassword1">Fasting Sugars</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"  placeholder="" name="fasting_sugars">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Before Meals Sugars</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"  placeholder="" name="before_meals_sugars">
                            </div>
                             <div class="form-group">
                            <label for="exampleInputPassword1">Postprondrial Sugars</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"  placeholder="" name="postprondrial_sugars">
                            </div>


                                          <button type="submit" class="btn btn-primary btn-block">SUBMIT</button>
                                             {!! Form::close() !!}
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
@endsection
