@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

           <div class="ibox-content">

           <form class="form-horizontal" role="form" method="POST" action="/createdependent" novalidate>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
           <div class="form-group">
          <label for="exampleInputEmail1">First Name</label>
          <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" name="first"  value="
           "  >
          </div>
          <div class="form-group">
         <label for="exampleInputEmail1">Second Name</label>
         <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" name="second"  value=""/>
         </div>
         <div class="form-group">
          <label for="exampleInputPassword1">Gender</label>
          <input type="radio" class="form-control" id="exampleInputPassword1" placeholder="" name="gender" value="1"  >Male <input type="radio" class="form-control" id="exampleInputPassword1" placeholder="" name="gender" value="2"  >Female
          </div>


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
                 <label for="exampleInputPassword1">Blood Type</label>
                 <input type="number" class="form-control" id="exampleInputPassword1" placeholder="" name="blood" value=""  >
                 </div>
                 <div class="form-group">
                  <label for="exampleInputPassword1">Place of Birth</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="pod" value=""  >
                  </div>
                  <div class="form-group">
                   <label for="exampleInputPassword1">Date if Birth</label>
                   <input type="number" class="form-control" id="exampleInputPassword1" placeholder="" name="dob" value=""  >
                   </div>
                <button type="submit" class="btn btn-primary btn-sm">Create Details</button>
                   {!! Form::close() !!}
                 </div>







@include('includes.default.footer')
</div>


</div>

@endsection
