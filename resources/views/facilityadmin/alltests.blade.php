@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-8">
                  <h2>Facility Tests</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="index.html">Home</a>
                      </li>

                      <li class="active">
                          <strong>Add</strong>
                      </li>
                  </ol>
              </div>
              <div class="col-lg-4">
                  <div class="title-action">

                  </div>
              </div>
          </div>
          <div class="wrapper wrapper-content">
            <div class="row">
                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-success pull-right"></span>
                                    <h5><a href="{{ URL::to('testprices') }}">Laboratory Test Prices</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$lab}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>No of Laboratory Test</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><a href="{{ URL::to('testpricesct') }}">CT-Scan Prices</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$ct}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>No of CT-Scan Tests</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><a href="{{ URL::to('testpricesxray') }}">Xray Prices</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$xray}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>No of Xray Tests</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><a href="{{ URL::to('testpricesotherIm') }}">Other Imaging Prices</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$other}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>No of Other Imaging Tests</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><a href="{{ URL::to('testpricesultra') }}">Ultrasound Prices</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$ultra}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>No of Ultrasound Tests</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><a href="{{ URL::to('testpricesmri') }}">MRI Prices</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$mri}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>No of MRI Prices</small>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><a href="{{ URL::to('testpricescardiac') }}">Cardiac</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$card}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>No of Cardiac</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><a href="{{ URL::to('testpricesneurology') }}">Neurology</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$neuro}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>No of Neurology </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><a href="{{ URL::to('testpricesprocedure') }}">Procedures </a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$proc}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>No of Procedures </small>
                                </div>
                            </div>
                        </div>


                      </div>
                    </div>
@endsection
