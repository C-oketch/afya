@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
              <br><br>
  <div class="col-sm-6  col-sm-offset-2">
  <div class="ibox-title">
      <h5>Add Facility Doctor</h5>

  </div>
   <?php $facilitycode=DB::table('facility_admin')
       ->Join('facilities', 'facility_admin.facilitycode', '=', 'facilities.FacilityCode')
       ->select('facilities.FacilityCode','facilities.set_up')
       ->where('user_id', Auth::id())
       ->first();

       $setup = $facilitycode->set_up;
       if($setup == 'Partial'){$role = 'Private';}else{$role = 'Doctor';}
       ?>

         <div class="ibox-content">
               <form class="form-horizontal" role="form" method="POST" action="/addfacilitydoctor" novalidate>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="facility" value="{{$facilitycode->FacilityCode}}">
              <input type="hidden" name="role" value="{{$role}}">

               <div class="form-group">
              <label for="exampleInputPassword1">Username</label>
              <input type="name" class="form-control" id="exampleInputEmail1"  placeholder="" name="name">
              </div>

              <div class="form-group">
             <label for="exampleInputPassword1">Email</label>
             <input type="email" class="form-control" id="exampleInputEmail1"  placeholder="" name="email"/>
             </div>
             <div class="form-group">
             <label for="exampleInputPassword1">Password</label>
             <input type="password" class="form-control" id="exampleInputEmail1"  placeholder="" name="password"/>
             </div>

            <div class="form-group">
                     <label >Doctors</label>
                     <select id="doc" name="doc" class="form-control doc" style="width:50%"></select>
                 </div>
                  <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}
    </div>
</div>



</div>
                   </div><!--container-->

@include('includes.default.footer')

@endsection
