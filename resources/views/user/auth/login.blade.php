@extends('user.layouts.login')

@section('title', trans('auth.login'))

@section('content')
    @include('sweetalert::alert')

    <div class="forgot-password-img">
        <img src="{{ asset("assets/img/bg-login.svg") }}" alt="bg-login" class="login-bg">
    </div>

    <div class="login-form-wrapper">
        <div class="login-form">
            <img src="{{ asset("assets/img/main-logo.svg") }}" alt="logo" class="logo img-center">

            <div class="text-center login-title">{{ trans('auth.login') }}</div>

            <form action="{{ route("user.auth.login") }}" method="post">
                @csrf
                <div class="form-input">
                    <label for="email" class="login-label">{{ trans('auth.email') }}</label>
                    <input id="email" type="text" onkeydown="return event.key != 'Enter';" class="form-control login-input login-placeholder @error('email') login-invalid @enderror" name="email" placeholder="{{ trans('auth.email') }}" value="{{ old('email') }}" max="64" maxlength="64">
                    <span id="email-max" class="login-error d-none">{{ trans('auth.W001_E002_email_max') }}</span>
                    @error('email')
                        <span id="email-error" class="login-error">{{ $errors->first('email') }}</span>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="password" class="login-label">{{ trans('auth.password') }}</label>
                    <input id="password" class="form-control login-input login-placeholder @error('password') login-invalid @enderror" type="password" name="password" placeholder="{{ trans('auth.password') }}" min="8" max="16" maxlength="16" autocomplete="on">
                    <img id="show" src="{{ asset('assets/icon/eye-show.svg') }}" class="d-none show-btn" onclick="showPassword()">
                    <img id="hide" src="{{ asset('assets/icon/eye-hide.svg') }}" class="show-btn hide-btn" onclick="showPassword()">
                    @error('password')
                        <span id="password-error" class="login-error">{{ $errors->first('password') }}</span>
                    @enderror
                </div>
                <input class="d-none" type="hidden" name="next_page_url" value="{{ request()->input('next_page_url') }}">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('user.auth.get_forgot_password') }}" class="login-link">{{ trans('auth.forgot') }}</a>
                </div>

                <div class="form-group m-0">
                    <button type="submit" class="btn btn-block login-btn">{{ trans('auth.login') }}</button>
                </div>
            </form>
            <div class="form-note text-center"><a class="login-link" href="{{ route('user.auth.register') }}">{{ trans('auth.register') }}</a></div>
        </div>
    </div>
@endsection

@push('script')
<script>
    function showPassword() {
        const showPass = document.getElementById('password');
        const hide = document.getElementById('hide');
        const show = document.getElementById('show');
        if (showPass.type === 'password') {
            showPass.type = 'text';
            hide.classList.add('d-none');
            show.classList.remove('d-none');
        } else {
            showPass.type = "password";
            show.classList.add('d-none');
            hide.classList.remove('d-none');
        }
    }
</script>

<script>
    const email = document.querySelector('input[type="text"]');
    const password = document.querySelector('input[type="password"]');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');

    if (emailError != null) {
        email.addEventListener('focus', () => {
            emailError.classList.add('d-none');
            email.classList.remove('login-invalid');
        });
    }

    if (passwordError != null) {
        password.addEventListener('focus', () => {
            passwordError.classList.add('d-none');
            password.classList.remove('login-invalid');
        });
    }
</script>
@endpush
