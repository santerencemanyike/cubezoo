@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mx-1" style="background-color: black; opacity: 0.7;">
        <div class="col-md-8 text-center mt-4 pt-4" style="color: white; font-size: 14px;">
            Welcome to <b>STM Alanalytics!</b> Your premier destination for affordable and professional resume building solutions, where your career dreams come to life.
        </div>
        <div class="col-md-6 m-4">
            <div class="card m-4">
                <div class="card-body p-4">
                    <div class="text-center mb-1">
                        <img src="{{ asset('images/cubezoo_logo_primary.svg') }}" alt="Profile Image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                    </div>
    
                    <div class="text-center fs-2" style="color: #3c4b64;">
                        Welcome To {{ trans('panel.site_title') }}
                    </div>
    
                    <p class="text-muted">{{ __('Register') }}</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Name') }}">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ trans('global.login_email') }}" placeholder="{{ __('E-Mail Address') }}">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                        </div>

                        <button type="submit" class="btn btn-stm mb-3">
                            {{ __('Create Account') }}
                        </button>

                        <a class="btn btn-stm" href="{{ route('login') }}">
                            {{ __('Back To Login') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
