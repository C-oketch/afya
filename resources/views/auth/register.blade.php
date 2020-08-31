@extends('layouts.welcome')
@section('title', 'register')
@section('content')

<div class="middle-box text-center loginscreen   animated fadeInDown">
      <div>
          <div>

              <h1 class="logo-name">IN+</h1>

          </div>
          <h3>Register to IN+</h3>
          <p>Create account to see it in action.</p>
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="name" class="col-md-4 control-label">Name</label>

                  <div class="col-md-8">
                      <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                      @if ($errors->has('name'))
                          <span class="help-block">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
              <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                  <label for="role" class="col-md-4 control-label">Role</label>
                  <div class="col-md-8"><select class="form-control m-b" name="role" id="role" >
                        <option value='Admin'>Admin</option>
                        <option value='Doctor'>Doctor</option>
                        <option value='Nurse'>Nurse</option>
                        <option value='Pharmacy_admin'>Pharmacy Admin</option>
                        <option value='Test'>Test Center</option>
                        <option value='Manufacturer'>Manufacturer</option>
                        <option value='Patient'>Patient</option>
                        <option value='Registrar'>Registrar</option>
                        <option value='Pharmacy_manager'>Pharmacy Manager</option>
                        <option value='Pharmacy_store_keeper'>Pharmacy Store Keeper</option>
                        </select>
                      @if ($errors->has('role'))
                          <span class="help-block">
                              <strong>{{ $errors->first('role') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>



              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="email" class="col-md-4 control-label">E-Mail Address/Phone No:</label>

                  <div class="col-md-8">
                      <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">

                      @if ($errors->has('email'))
                          <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label for="password" class="col-md-4 control-label">Password</label>

                  <div class="col-md-8">
                      <input id="password" type="password" class="form-control" name="password">

                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                  <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                  <div class="col-md-8">
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                      @if ($errors->has('password_confirmation'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
              <div class="form-group">
                      <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
              </div>
              <div class="form-group">
                  <div class="col-md-6 col-md-offset-6">
                      <button type="submit" class="btn btn-primary">
                          <i class="fa fa-btn fa-user"></i> Register
                      </button>
                  </div>
              </div>
              <p class="text-muted text-center"><small>Already have an account?</small></p>
              <a class="btn btn-sm btn-white btn-block" href="{{ url('/login') }}">Login</a>
          </form>
          <p class="m-t"> <small>afyapepe.co.ke &copy; 2014</small> </p>
          </form>
        </div>
        </div>

@endsection
