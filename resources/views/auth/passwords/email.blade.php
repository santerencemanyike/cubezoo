@extends('layouts.app')
@section('content')
<div class="row justify-content-center mx-1" style="background-color: black; opacity: 0.7;">
    <div class="col-md-8 text-center mt-4 pt-4" style="color: white; font-size: 14px;">
        Welcome to <b>STM Alanalytics!</b> Your premier destination for affordable and professional resume building solutions, where your career dreams come to life.
    </div>
    <div class="col-md-6 m-4">
        <div class="card mx-4 m-4">
            <div class="card-body p-4">
                <div class="text-center mb-1">
                    <img src="{{ asset('images/cubezoo_logo_primary.svg') }}" alt="Profile Image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                </div>

                <div class="text-center fs-2" style="color: #3c4b64;">
                    Welcome To {{ trans('panel.site_title') }}
                </div>

                <p class="text-muted">{{ trans('global.reset_password') }}</p>

                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.passsword.reset') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email') }}">

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
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required placeholder="New {{ trans('cruds.user.fields.password') }}">
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required placeholder="Repeat New {{ trans('cruds.user.fields.password') }}">
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-stm btn-flat btn-block mb-3">
                                {{ __('Reset Password') }}
                            </button>
                            <a class="btn btn-stm" href="{{ route('login') }}">
                                {{ __('Back To Login') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection