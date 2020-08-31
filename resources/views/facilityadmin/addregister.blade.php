@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-8">
                  <h2>Facility Registrars</h2>
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
                      <!-- <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                      <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a>
                      <a href="#" class="btn btn-primary"><i class="fa fa-print"></i> Add Registrar </a> -->
                  </div>
              </div>
          </div>
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">


               <div class="row">
                <div class="col-md-8  col-md-offset-2" id="addreg">
                  <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add Registrar</h5>
                        </div>

            <div class="ibox-content">
                <?php $facilitycode=DB::table('facility_admin')->where('user_id', Auth::id())->first(); ?>

                <div>
                <form class="form-horizontal" role="form" method="POST" action="/addfacilityregistrar">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="name" required/>
                </div>
                <div class="form-group">
                <label for="exampleInputEmail1">RegNo</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="regno"/>
                </div>
                <input type="hidden" name="role" value="Registrar">
                <input type="hidden" name="facility" value="{{$facilitycode->facilitycode}}">
                <div class="form-group">
                <label for="exampleInputPassword1">Email</label>
                <input type="email" class="form-control" id="exampleInputPassword1"  name="email"  required>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">password</label>
                <input type="password" class="form-control" id="exampleInputPassword1"  name="password" required >
                </div>
<?php
$practice = DB::table('practice')->get();
?>
                <div class="form-group">
                <label>Department Practice</label>
                <select class="form-control m-b select2_demo_1" name="practice" required="required" />
                  <option value="">Select practice</option>
                  @foreach ($practice as $pact)
                <option value="{{$pact->id}}">{{$pact->name}}</option>
                @endforeach
                </select>
                </div>

                <input type="submit" class="btn btn-primary" name="submit" value="Add" >
                </form>
                </div>
                </div>
                </div>
              </div>

                                </div>



     </div>
   </div>
</div><!--container-->

@endsection
