@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-8">
                  <h2>Facility Users</h2>
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
                                    <h5><a href="{{ URL::to('facilityregister') }}">Registrar</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$reg}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>Total Registrars</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <!-- <span class="label label-info pull-right">{{$nurse}}</span> -->
                                    <h5><a href="{{ URL::to('facilitynurse') }}">Nurse</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$nurse}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>Total Nurses</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <!-- <span class="label label-primary pull-right">{{$doc}}</span> -->
                                    <h5><a href="{{ URL::to('facilitydoctor') }}">Doctors</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$doc}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>Total Doctors</small>
                                </div>
                            </div>
                        </div>
                        @if($co)
                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <!-- <span class="label label-success pull-right">{{$co}}</span> -->
                                    <h5><a href="{{ URL::to('facilityofficer') }}">Clinical Officers</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$co}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>Total Clinical Officers</small>
                                </div>
                            </div>
                        </div>
                          @endif
                        @if($finance)
                        <div class="col-lg-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <!-- <span class="label label-info pull-right">{{$finance}}</span> -->
                                    <h5><a href="{{ URL::to('facility-finance') }}">Finance</a></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{$finance}}</h1>
                                    <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                                    <small>Total Finance</small>
                                </div>
                            </div>
                        </div>
                      @endif



                      </div>
                    </div>
@endsection
