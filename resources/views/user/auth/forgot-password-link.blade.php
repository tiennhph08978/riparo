@extends('user.layouts.login')

@section('title', 'Forgot Password')

@section('content')
    <div class="forgot-password-img">
        <img src="{{ asset("assets/img/bg-login.svg") }}" alt="bg-login" class="login-bg">
    </div>
    <div class="login-form-wrapper forgot-password-link">
        <div class="login-form">
            <img src="{{ asset("assets/img/main-logo.svg") }}" alt="logo" class="logo img-center">
            <div class="text-center login-form-title">
                {{ trans('reset-password.forgot-link.title') }}
            </div>
            <div class="text-center forgot-password-desc">
                {{ trans('reset-password.forgot-link.desc_before') }} <span>{{$email}}</span> {{ trans('reset-password.forgot-link.desc_after') }}
            </div>
            <div class="form-note text-center"><a class="login-link" href="{{ route('user.auth.login') }}">{{ trans('reset-password.link') }}</a></div>
        </div>
    </div>
@endsection
