@extends('layouts.app')
@section('content')
<div class="row justify-content-center mx-1" style="background-color: black; opacity: 0.7;" >
    <div class="col-md-8 text-center mt-4 pt-4" style="color: white; font-size: 14px;">
        Welcome to <b>Cubezoo!</b> Your premier destination for affordable and professional digital solutions, where your goals and dreams come to life.
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

                <p class="text-muted">{{ trans('global.login') }}</p>

                @if(session('message'))
                    <div class="alert alert-info" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>

                        <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">

                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>

                        <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">

                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-4 stm-text-grey">
                        <div class="form-check checkbox">
                            <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                            <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                {{ trans('global.remember_me') }}
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-stm">
                                {{ trans('global.login') }}
                            </button>
                        </div>
                        <div class="col-12 mt-3 text-right">
                            @if(Route::has('password.request'))
                                <a class="btn btn-stm" href="{{ route('password.request') }}">
                                    {{ trans('global.forgot_password') }}
                                </a>
                            @endif
                        </div>
                        <div class="col-12 mt-3 text-right">
                            <a class="btn btn-stm" href="{{ route('register') }}">
                                {{ __('Create New Account') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection