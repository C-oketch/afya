@extends('layouts.test')
@section('title', 'Tests')
@section('content')

<div class="container">
  <div class="col-sm-6  col-sm-offset-2" style="text-align:left;">
  <div class="ibox-title">
      <h5>Dependant Details</h5>

  </div>
         <div class="ibox-content">
               <form class="form-horizontal" role="form" method="POST" action="/createdependenttest" novalidate>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" class="form-control" id="exampleInputEmail1"  value="{{$id}}" name="id"  required>
               <div class="form-group">
              <label for="exampleInputPassword1">First Name</label>
              <input type="name" class="form-control" id="exampleInputEmail1"  placeholder="" name="first" >
              </div>

              <div class="form-group">
             <label for="exampleInputPassword1">Second Name</label>
             <input type="name" class="form-control" id="exampleInputEmail1"  placeholder="" name="second"  value="
              "  >
             </div>
             <div class="form-group">
              <label for="exampleInputPassword1">Gender</label>
              <input type="radio" value="1"  name="gender"  />
                <label>Male</label>
                      <input type="radio" value="2"  name="gender" />
                    <label>Female</label>

              </div>


              <div class="form-group">
     <label for="exampleInputPassword1">Relationship</label>
    <select class="form-control" name="relationship">
    <?php  $kin = DB::table('kin')->get();?>
                  @foreach($kin as $kn)
                   <option value="{{$kn->relation}}">{{$kn->relation}}</option>
                 @endforeach
                </select>
    </div>
              <div class="form-group">
              <label for="exampleInputEmail1">Blood Group</label>
              <select class="form-control" name="blood">
              <option value="O +">O +</option>
              <option value="O -">O -</option>
              <option value="A +">A +</option>
              <option value="A -">A -</option>
              <option value="B +">B +</option>
              <option value="B -">B -</option>
              <option value="AB +">AB +</option>
              <option value="AB -">AB -</option>
              </select>
              </div>
               <div class="form-group">


  <div class="ui-widget">
  <label for="pod">Place of Birth: </label>
  <input type="text" id="tags" class="form-control" name="pob">
</div>
</div>
                <div class="form-group data_2" id="data_1">
                 <label for="exampleInputPassword1">Date of Birth</label>
                 <div class="input-group date">
                     <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                     <input type="text" class="form-control" name="dob" value="">
                 </div>
                 </div>
              <button type="submit" class="btn btn-primary btn-sm">Create Details</button>
                 {!! Form::close() !!}
               </div>



</form>
</div>
</div>
@endsection
