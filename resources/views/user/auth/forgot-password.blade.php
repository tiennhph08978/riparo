@extends('user.layouts.login')

@section('title', trans('reset-password.forgot.section_title'))

@section('content')
    <div class="forgot-password-img">
        <img src="{{ asset("assets/img/bg-login.svg") }}" alt="bg-login" class="login-bg">
    </div>
    <div class="login-form-wrapper forgot-password">
        <div class="login-form">
            <img src="{{ asset("assets/img/main-logo.svg") }}" alt="logo" class="logo img-center">
            <div class="text-center login-form-title">
                {{ trans('reset-password.forgot.title') }}
            </div>
            <div class="text-center forgot-password-link-desc_pc">
                {{ trans(('reset-password.forgot.desc_first')) }}<br>
                {{ trans(('reset-password.forgot.desc_next')) }}<br>
                {{ trans(('reset-password.forgot.desc_last')) }}
            </div>
            <div class="text-center forgot-password-link-desc_tablet">
                {{ trans(('reset-password.forgot.desc')) }}
            </div>
            <div class="text-center forgot-password-link-desc__mobile">
                {{ trans(('reset-password.forgot.desc_first_m')) }}<br>
                {{ trans(('reset-password.forgot.desc_last_m')) }}
            </div>
            <form id="forgotPassword" action="{{ route("user.auth.forgot_password") }}" method="post">
                @csrf
                <div class="form-input">
                    <label for="email" class="login-label">{{ trans('reset-password.forgot.email') }}</label>
                    <input type="text" id="email" maxlength="64" class="form-control login-input login-placeholder @error('email') login-invalid @enderror" value="{{ old('email') }}" name="email" placeholder="{{ trans('reset-password.forgot.placeholder') }}">
                    @error('email')
                    <span id="email_error" class="valid-error">{{ $errors->first('email') }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-block login-btn btn-submit">{{ trans('reset-password.forgot.btn') }}</button>
            </form>
            <div class="form-note text-center"><a class="login-link" href="{{ route('user.auth.login') }}">{{ trans('reset-password.link') }}</a></div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        const email = document.querySelector('input[type="text"]');

        email.addEventListener('focus', (event) => {
            document.getElementById('email').classList.remove("login-invalid");
            document.getElementById('email_error').setAttribute('class', 'd-none');
        });

        $('.btn-submit').click(function(e) {
            e.preventDefault();
            $(this).attr('disabled', true).css({
                cursor: 'not-allowed',
                border: '1px solid #eee',
                color: '#ccc',
                background: '#eee',
            })
            if ($(this).attr('disabled')) {
                $('#forgotPassword').submit();
            }
        });
    </script>
@endpush
