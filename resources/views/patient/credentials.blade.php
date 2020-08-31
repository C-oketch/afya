@extends('layouts.patient')
@section('title', 'Patient')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                  <h2>Profile</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="#">Home</a>
                      </li>
                      <li class="active">
                          <strong>Change Credentials</strong>
                      </li>
                  </ol>
              </div>
              <div class="col-lg-2">

              </div>
          </div>
          <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-md-4">

                            <h2>NAME : {{$user->firstname}} {{$user->secondName}}</h2>
                            <h4>ROLE : {{$user->role}}</h4>

                      </div>

</div>
<div class="row">
  <div class="col-lg-12">
                  <div class="ibox float-e-margins">
                      <div class="ibox-title">
                          <h5>Inline form</h5>
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
                        {!! Form::open(array('url' => 'updatecred','method'=>'POST','class'=>'form-inline')) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden"  value="{{$user->id}}" name="user_id"  required>

                              <div class="form-group col-md-4">
                                  <label>Username</label>
                                  <input type="text" value="{{$user->name}}"  class="form-control" name='username' required>
                              </div>
                              <div class="form-group ">
                                  <label>Email/Phone</label>
                                  <input type="email" value="{{$user->email}}" name="email" class="form-control" required>
                              </div>
                              <br /><br />
                              <div class="form-group col-md-4">
                                  <label>Password</label>
                                  <input type="password" placeholder="Password" name="password" id="password" class="form-control" required>
                              </div>
                              <div class="form-group">
                                  <label>Confirm Password</label>
                                  <input type="password" placeholder="Password" name="password2" id="password2" class="form-control" required>
                              </div>

                              <button class="btn btn-white pull-right" type="submit">Submit</button>
                          </form>
                      </div>
                  </div>
              </div>
</div>
    </div>



<script>
var password = document.getElementById("password")
  , password2 = document.getElementById("password2");

function validatePassword(){
  if(password.value != password2.value) {
    password2.setCustomValidity("Passwords Don't Match");
  } else {
    password2.setCustomValidity('');
  }
}

password.onchange = validatePassword;
password2.onkeyup = validatePassword;
</script>
@endsection
