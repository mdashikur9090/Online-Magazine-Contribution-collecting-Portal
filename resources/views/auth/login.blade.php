@extends('layouts.app')

@section('content')


<!-- container start -->
    <div class="container-bg">
        <div class="login-box-new">
            <!-- form-group start -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

              <div class="form-group">
                <h2>Login</h2>
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <input class="control-form{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" value="" placeholder="Email" value="{{ old('email') }}" required autofocus>
              </div>
              <div class="form-group">
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
              </div>
              <div class="form-group group-wor">
                <i  class="fas fa-key" class="fa fa-envelope" aria-hidden="true"></i>
                <input class="control-form" type="password" name="password" value="" placeholder="Password">
              </div>
              <div class="form-group">
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
              </div>

                <button class="btn-color-f"><i class="fa fa-paper-plane send-fa" aria-hidden="true"></i>Login</button>
                <!-- button start -->
                <a href="#">  <button type="button" class="btn-bg-n">sign up </button></a>
                <!-- button finish -->

            </form>
            <!-- form-group finish-->
          </div>
    </div>
    <!-- container finish -->


@endsection
