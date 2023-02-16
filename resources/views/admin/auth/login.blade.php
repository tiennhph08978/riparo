<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Coderthemes">
    <title>Login - {{ config('app.name') }}</title>

    @vite(['resources/sass/admin/app.scss'])

    @yield('styles')
</head>
<body>
    <div class="account-pages container mt-5 mb-5">
        <div class="login">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mb-2">
                                <img src="{{ asset("assets/img/main-logo.svg") }}" class="main-logo">
                            </div>

                            <form action="{{ route('admin.login') }}" method="POST">
                                {!! csrf_field() !!}
                                <div class="form-group mb-10">
                                    <label for="email">{{ __('admin.login.email') }}</label>
                                    <img class="icon-email" src="{{ asset('assets/icon/icon-user.svg') }}">
                                    <input
                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        type="text"
                                        id="email"
                                        name="email"
                                        placeholder="{{ trans('auth.placeholder_email') }}"
                                        value="{{ old('email') }}"
                                        max="64"
                                        maxlength="64"
                                    >
                                    <span id="email-max" class="login-error d-none">{{ trans('auth.W001_E002_email_max') }}</span>
                                    @if ($errors->has('email'))
                                        <span id="email-error" class="help-block">
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        </span>
                                    @endif

                                </div>
                                <div class="form-group mb-10">
                                    <label for="password">{{ __('admin.login.password') }}</label>
                                    <img class="icon-password" src="{{ asset('assets/icon/icon-password.svg') }}">
                                    <input
                                        class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        value="{{ old('password') }}"
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="{{ trans('auth.placeholder_password') }}"
                                        min="8"
                                        max="16"
                                        maxlength="16"
                                        autocomplete="on"
                                    >
                                    <img id="show" src="{{ asset('assets/icon/eye-show.svg') }}" class="d-none show-btn" onclick="showPassword()">
                                    <img id="hide" src="{{ asset('assets/icon/eye-hide.svg') }}" class="show-btn hide-btn" onclick="showPassword()">
                                    @if ($errors->has('password'))
                                        <span id="password-error" class="help-block">
                                            <small class="text-danger">{{ $errors->first('password') }}</small>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" type="submit"> {{ __('admin.login.btn_login') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@vite([
'resources/assets/js/jquery.min.js',
])
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('submit', 'form', function() {
            $('button').attr('disabled', 'disabled');
        });
    });

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

    const email = document.querySelector('input[type="text"]');
    const password = document.querySelector('input[type="password"]');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');

    if (emailError != null) {
        email.addEventListener('focus', () => {
            emailError.classList.add('d-none');
            email.classList.remove('is-invalid');
        });
    }

    if (passwordError != null) {
        password.addEventListener('focus', () => {
            passwordError.classList.add('d-none');
            password.classList.remove('is-invalid');
        });
    }
</script>

</html>

