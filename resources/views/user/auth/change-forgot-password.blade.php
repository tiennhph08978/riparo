@extends('user.layouts.login')

@section('title', trans('reset-password.forgot-change.section_title'))

@section('content')
    <div class="forgot-password-img">
        <img src="{{ asset("assets/img/bg-login.svg") }}" alt="bg-login" class="login-bg">
    </div>
    <div class="login-form-wrapper change-password">
        <div class="login-form">
            <img src="{{ asset("assets/img/main-logo.svg") }}" alt="logo" class="logo img-center">
            <div class="text-center login-title">
                {{ trans('reset-password.forgot-change.title') }}
            </div>
            <div class="text-center forgot-password-desc">
                {{ trans(('reset-password.forgot-change.desc')) }}
            </div>
            <form id="form-reset-password" action="{{ route("user.auth.change_forgot_password") }}" method="post">
                @csrf
                <input type="hidden" value="{{ $email }}" name="email">
                <input type="hidden" value="{{ $token }}" name="token">
                <div class="form-input">
                    <label for="password" class="login-label">{{ trans(('reset-password.forgot-change.password')) }}</label>
                    <input
                        type="password"
                        id="password"
                        maxlength="16"
                        class="form-control login-input login-placeholder @error('password') login-invalid @enderror"
                        value="{{ old('password') }}"
                        name="password"
                        placeholder="{{ trans('reset-password.forgot-change.password') }}"
                    >
                    <img src="{{ asset('assets/icon/eye-hide.svg') }}" class="show-pass" alt="" onclick="showPassword(this)">
                    @error('password')
                    <span id="passwordError" class="valid-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="passwordConfirmation" class="login-label">{{ trans(('reset-password.forgot-change.password-confirm')) }}</label>
                    <input
                        type="password"
                        id="passwordConfirmation"
                        maxlength="16"
                        class="form-control login-input login-placeholder @error('password_confirmation') login-invalid @enderror"
                        value="{{ old('password_confirmation') }}"
                        name="password_confirmation"
                        placeholder="{{ trans(('reset-password.forgot-change.password-confirm')) }}"
                    >
                    <img src="{{ asset('assets/icon/eye-hide.svg') }}" class="show-pass" alt="" onclick="showPasswordConfirm(this)">
                    @error('password_confirmation')
                    <span id="passwordConfirmationError" class="valid-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block login-btn btn-submit">{{ trans(('reset-password.forgot-change.btn')) }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('script')
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>

    <script>
        function showPassword(image){
            var pass = document.getElementById('password');
            if (pass.type === 'password') {
                image.src = '{{ asset('assets/icon/eye-show.svg') }}';
                pass.type = 'text';

            } else {
                pass.type = "password";
                image.src = '{{ asset('assets/icon/eye-hide.svg') }}';

            }
        }

        function showPasswordConfirm(image){
            var pass = document.getElementById('passwordConfirmation');
            if (pass.type === 'password') {
                image.src = '{{ asset('assets/icon/eye-show.svg') }}';
                pass.type = 'text';

            } else {
                pass.type = "password";
                image.src = '{{ asset('assets/icon/eye-hide.svg') }}';

            }
        }

        $( "input" ).focus(function() {
            $(this).next('span').css( "display", "none" );
            $(this).nextAll('#passwordError').css( "display", "none" );
            $(this).nextAll('#passwordConfirmationError').css( "display", "none" );
            $(this).removeClass('login-invalid');
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
                $('#form-reset-password').submit();
            }
        });
    </script>
@endpush
