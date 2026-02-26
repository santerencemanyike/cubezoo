@extends('layouts.app')
@section('content')
<div class="row justify-content-center mx-1" style="background-color: #3c4b64; opacity: 0.7;">
    <div class="col-md-6 m-4">
        <div class="text-center m-4" style="color: white; font-size: 14px;">
            Welcome to <b>STM Alanalytics,</b> your go-to destination for affordable and professional resume building solutions.
        </div>
        <div class="card mx-4 m-4">
            <div class="card-body p-4">
                <div class="text-center mb-1">
                    <img src="{{ asset('images/cubezoo_logo_primary.svg') }}" alt="Profile Image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                </div>

                <div class="text-center fs-2" style="color: #3c4b64;">
                    Welcome To {{ trans('panel.site_title') }}
                </div>

                <p class="text-muted">{{ trans('global.reset_password') }}</p>

                <form method="POST" action="{{ route('password.request') }}">
                    @csrf

                    <input name="token" value="{{ $token }}" type="hidden">

                    <div class="form-group">
                        <input id="email" type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ $email ?? old('email') }}">

                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" name="password" class="form-control" required placeholder="{{ trans('global.login_password') }}">

                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" name="password_confirmation" class="form-control" required placeholder="{{ trans('global.login_password_confirmation') }}">
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-stm btn-block btn-flat">
                                {{ trans('global.reset_password') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection