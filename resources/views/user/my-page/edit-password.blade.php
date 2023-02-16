@extends('user.layouts.landing_page')

@section('title', 'パスワードを変更')
@section('content')
    @include('sweetalert::alert')
    <div class="breadcrumb">
        <div class="">
            <a href="{{ route('user.my_page.index') }}">{{ trans('my-page.title') }}</a>
            <span class="dot">&nbsp;&#8226;&nbsp;</span>
            <a href="{{ route('user.my_page.edit_personal') }}">{{ trans('my-page.edit_info') }}</a>
            <span class="dot">&nbsp;&#8226;&nbsp;</span>
            <span class="personal-header__list-link">{{ trans('my-page.edit_password') }}</span>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 offset-md-3">
        <div class="edit-password input-edit-password">
            <form action="{{ route('user.my_page.update_password') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">{{ trans('my-page.edit_pass.current_pass') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                    <div class="row">
                        <div class="col-12">
                            <input
                                type="password"
                                id="passwordOld"
                                class="form-control input-register @error('current_password')input-valid-error @enderror"
                                placeholder="{{ trans('my-page.edit_pass.current_pass') }}"
                                name="current_password"
                                onfocus="remoteError(this)"
                                maxlength="16"
                            >
                            <img src="{{ asset('assets/icon/eye-hide.svg') }}" class="fa-eye-custom" alt="" onclick="showPasswordOld(this)">
                            @error('current_password')
                                <span class="valid-error current_password">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">{{ trans('my-page.edit_pass.new_pass') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                    <div class="row">
                        <div class="col-12">
                            <input
                                type="password"
                                id="passwordNew"
                                class="form-control input-register @error('new_password')input-valid-error @enderror"
                                placeholder="{{ trans('my-page.edit_pass.new_pass') }}"
                                name="new_password"
                                onfocus="remoteError(this)"
                                maxlength="16"
                            >
                            <img src="{{ asset('assets/icon/eye-hide.svg') }}" class="fa-eye-custom" alt="" onclick="showPasswordNew(this)">
                            @error('new_password')
                                <span class="valid-error new_password">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">{{ trans('my-page.edit_pass.new_pass_confirm') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                    <div class="row">
                        <div class="col-12">
                            <input
                                type="password"
                                id="passwordConfirm"
                                class="form-control input-register @error('confirm_password')input-valid-error @enderror"
                                placeholder="{{ trans('my-page.edit_pass.new_pass_confirm') }}"
                                name="confirm_password"
                                onfocus="remoteError(this)"
                                maxlength="16"
                            >
                            <img src="{{ asset('assets/icon/eye-hide.svg') }}" class="fa-eye-custom" alt="" onclick="showPasswordConfirm(this)">
                            @error('confirm_password')
                                <span class="valid-error confirm_password">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <button class="button-submit" type="submit">{{ trans('my-page.edit_pass.btn_submit') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function showPasswordOld(image){
            var pass = document.getElementById('passwordOld');
            if (pass.type === 'password') {
                image.src = '{{ asset('assets/icon/eye-show.svg') }}';
                pass.type = 'text';

            } else {
                pass.type = "password";
                image.src = '{{ asset('assets/icon/eye-hide.svg') }}';

            }
        }

        function showPasswordNew(image){
            var pass = document.getElementById('passwordNew');
            if (pass.type === 'password') {
                image.src = '{{ asset('assets/icon/eye-show.svg') }}';
                pass.type = 'text';

            } else {
                pass.type = "password";
                image.src = '{{ asset('assets/icon/eye-hide.svg') }}';

            }
        }

        function showPasswordConfirm(image){
            var pass = document.getElementById('passwordConfirm');
            if (pass.type === 'password') {
                image.src = '{{ asset('assets/icon/eye-show.svg') }}';
                pass.type = 'text';

            } else {
                pass.type = "password";
                image.src = '{{ asset('assets/icon/eye-hide.svg') }}';

            }
        }

        function remoteError(input) {
            $(input).removeClass('input-valid-error');
            let className = $(input).attr("name");
            $("." + className).remove();
        }
    </script>
@endpush
