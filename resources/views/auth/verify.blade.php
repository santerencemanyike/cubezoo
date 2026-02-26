@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mx-1" style="background-color: #3c4b64; opacity: 0.7;">
        <div class="col-md-8 m-4">
            <div class="card m-4">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">

                    <div class="text-center mb-1">
                        <img src="{{ asset('images/cubezoo_logo_primary.svg') }}" alt="Profile Image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                    </div>
    
                    <div class="text-center fs-2" style="color: #3c4b64;">
                        Welcome To {{ trans('panel.site_title') }}
                    </div>
    
                    <p class="text-muted">{{ __('Verify') }}</p>
    
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-stm p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
