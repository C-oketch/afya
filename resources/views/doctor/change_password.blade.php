@extends('layouts.private')
  @section('content')
  <div class="col-sm-8">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Change Password</h5>

      </div>
<div class="ibox-content">
  {!! Form::open(array('url' => 'change_password','method'=>'POST','class'=>'form-horizontal')) !!}

  <input type="hidden" name="_token" value="{{ csrf_token() }}">


    @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif


@if(isset($new_message))
<div class="alert alert-success">
    <ul>
    <li>{{$new_message}}</li>
    </ul>
    </div>
@endif


<div class="form-group"><label class="col-lg-4 control-label">Current Password :</label>
<div class="col-lg-6">
  <input type="password" value="" class="form-control m-b" name="current_password" >
</div>
</div>

<div class="form-group"><label class="col-lg-4 control-label">New Password :</label>
<div class="col-lg-6">
  <input type="password" value="" class="form-control m-b" name="new_password" >
</div>
</div>

<div class="form-group"><label class="col-lg-4 control-label">Confirm Password :</label>
<div class="col-lg-6">
  <input type="password" value="" class="form-control m-b" name="confirm_password" >
</div>
</div>

<div class="form-group">
  <div class="col-sm-6">
      <button type="submit" name="submit" class="btn btn-primary btn-sm ">Submit</button>
    </div>
  </div>

      {!! Form::close() !!}
      </div>
    </div>
  </div>


       @include('includes.default.footer')
@endsection
