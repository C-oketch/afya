@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')




  <div class="col-sm-6  col-sm-offset-2" style="text-align:left;">
  <div class="ibox-title">
      <h5>Dependant Details</h5>

  </div>
  <div class="ibox-content">
      <form class="form-horizontal" role="form" method="POST" action="/createdependent" >
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" class="form-control" id="exampleInputEmail1"  value="{{$id}}" name="id"  required>

              <div class="form-group">
              <label for="exampleInputPassword1">First Name</label>
              <input type="name" class="form-control" id="exampleInputEmail1"  placeholder="" name="first" required="" />
              </div>

              <div class="form-group">
             <label for="exampleInputPassword1">Second Name</label>
             <input type="name" class="form-control" id="exampleInputEmail1"  placeholder="" name="second" required="" />
             </div>

             <div class="form-group">
              <label for="exampleInputPassword1">Gender</label>
              <input type="radio" value="Male"  name="gender" required="" />
              <label>Male</label>
              <input type="radio" value="Female"  name="gender" />
              <label>Female</label>
              </div>


              <div class="form-group">
               <label for="exampleInputPassword1">Relationship</label>
              <select class="form-control" name="relationship" required="">
              <option value="" selected disabled>Select relationship</option>
              <?php
              $kin = DB::table('kin')->get();
              ?>
                  @foreach($kin as $kn)
                   <option value="{{$kn->relation}}">{{$kn->relation}}</option>
                 @endforeach
                </select>
              </div>

              <div class="form-group">
              <label for="exampleInputEmail1">Blood Group</label>
              <select class="form-control" name="blood" required="">
              <option value="" selected disabled>Select blood type</option>
              <?php
              $blood_types = DB::table('blood_types')->distinct()->get(['type']);
              ?>
              @foreach($blood_types as $blood_type)
              <option value='{{$blood_type->type}}'>{{$blood_type->type}}</option>
              @endforeach
              </select>
              </div>

            <div class="form-group">
            <!-- <div class="ui-widget"> -->
            <label for="pod">Place of Birth: </label>
            <input type="text"  class="form-control" name="pob" required="" />
            <!-- </div> -->
            </div>

            <div class="form-group" id="data_2">
             <label for="exampleInputPassword1">Date of Birth</label>
             <div class="input-group date">
                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                 <input type="text" class="form-control" name="dob" value="" required="" />
             </div>
             </div>

              <button type="submit" class="btn btn-primary btn-sm">Create Details</button>
                 {!! Form::close() !!}
               </div>



</form>
</div>

            @include('includes.default.footer')
             </div>


            @endsection
