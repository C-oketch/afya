@extends('layouts.welcome')
@section('title', 'login')
@section('content')

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">A+</h1>

        </div>
        <h3>Welcome to Afyapepe+</h3>
        <p> </p>


          <form class="m-t" role="form" method="POST" action="{{ url('/login') }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
              <input id="email" type="text" class="form-control" name="email" placeholder="Email/Phone NO:" value="{{ old('email') }}">

              @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif

            </div>
              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" placeholder="Password" name="password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

            <a href="{{ url('/password/reset') }}">Forgot Your Password?</a>
            <p class="text-muted text-center"><small>Do not have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="{{ url('/register') }}">Create an account</a>
        </form>
        <p class="m-t"> <small>afyapepe &copy; 2017</small> </p>
    </div>
</div>

@endsection
