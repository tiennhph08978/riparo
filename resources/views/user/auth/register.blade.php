@extends('user.layouts.landing_page')

@section('title', trans('edit-personal.title_register'))
@section('content')
    @include('sweetalert::alert')
    <div class="form-register">
        <p class="text-center title-register">アカウント作成</p>
        <p class="text-center text-register">下記の内容をご入力の上、お進みください。</p>
        <form action="{{ route('user.auth.postRegister') }}" id="registerForm" method="post">
            @csrf
            <div class="form-group">
                <label for="">{{ trans('edit-personal.form.name') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                <div class="row">
                    <div class="col-xl-6 col-6 div-padding-right">
                        <input type="text" onkeydown="return event.key != 'Enter';" name="first_name" maxlength="16" class="form-control @error('first_name') login-invalid @enderror input-register" value="{{old('first_name')}}" placeholder="{{ trans('edit-personal.form.name') }}（姓）">
                        @error('first_name')
                        <span id="first_name" class="valid-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-xl-6 col-6 div-padding-left">
                        <input type="text" onkeydown="return event.key != 'Enter';" name="last_name" maxlength="16" value="{{ old('last_name') }}" class="form-control @error('last_name') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.name') }}（名）">
                        @error('last_name')
                        <span class="valid-error" id="last_name">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">{{ trans('edit-personal.form.name') }}（フリガナ）<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                <div class="row">
                    <div class="col-xl-6 col-6 div-padding-right">
                        <input type="text" onkeydown="return event.key != 'Enter';" name="first_name_furigana" maxlength="24" value="{{ old('first_name_furigana') }}" class="form-control @error('first_name_furigana') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.name') }}（セイ）">
                        @error('first_name_furigana')
                        <span id="first_name_furigana" class="valid-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-xl-6 col-6 div-padding-left">
                        <input type="text" onkeydown="return event.key != 'Enter';" name="last_name_furigana" maxlength="24" value="{{ old('last_name_furigana') }}" class="form-control @error('last_name_furigana') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.name') }}（メイ）">
                        @error('last_name_furigana')
                        <span id="last_name_furigana" class="valid-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">{{ trans('edit-personal.form.email_address') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                <div class="row">
                    <div class="col-12">
                        <input type="text" onkeydown="return event.key != 'Enter';" name="email" maxlength="64" value="{{ old('email') }}" class="form-control @error('email') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.email_address') }}">
                        @error('email')
                        <span id="email" class="valid-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">{{ trans('edit-personal.form.password') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                <div class="row">
                    <div class="col-12">
                        <input type="password" name="password" maxlength="16" value="{{ old('password') }}" id="showPass" class="form-control @error('password') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.password') }}">
                        @error('password')
                        <span id="password" class="valid-error">{{ $message }}</span>
                        @enderror
                        <img src="{{ asset('assets/icon/eye-hide.svg') }}" class="fa-eye-custom" alt="" onclick="showPassword(this)">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">{{ trans('edit-personal.form.password_confirm') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                <div class="row">
                    <div class="col-12">
                        <input type="password" name="password_confirmation" maxlength="16" value="{{ old('password_confirmation') }}" id="showConfirm" class="form-control @error('password_confirmation') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.password_confirm') }}">
                        @error('password_confirmation')
                        <span id="password_confirmation" class="valid-error">{{ $message }}</span>
                        @enderror
                        <img src="{{ asset('assets/icon/eye-hide.svg') }}" class="fa-eye-custom" alt="" onclick="showPasswordConfirm(this)">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">{{ trans('edit-personal.form.number_phone') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                <div class="row">
                    <div class="col-md-7 col-7">
                        <input type="text" onkeydown="return event.key != 'Enter';" name="phone_number" maxlength="11" class="form-control @error('phone_number') login-invalid @enderror input-register" value="{{ old('phone_number') }}" placeholder="09012341234">
                    </div>
                </div>
                @error('phone_number')
                <span id="phoneNumber" class="valid-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">{{ trans('edit-personal.form.post_code') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                <div class="row">
                    <div class="col-6 col-lg-4 col-xl-3 col-md-3 d-flex div-padding-right code-padding-right">
                        <div class="d-flex align-items-center mr-3 text-code">〒</div>
                        <input id="zipcode" type="text" onkeydown="return event.key != 'Enter';" name="post_code"
                               class="form-control @error('post_code') login-invalid @enderror input-register" value="{{ old('post_code') }}" placeholder="000-0000">
                    </div>
                    <div class="col-6 col-lg-5 col-xl-4 col-md-4 div-padding-left code-padding-left">
                        <button type="button" class="btn btn-register" id="getAddress">{{ trans('edit-personal.btn_zipcode') }}</button>
                    </div>
                </div>
                <span id="postNumber" class="valid-error post_code"></span>
                @error('post_code')
                <span id="postCode" class="valid-error post_code">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">{{ trans('edit-personal.form.address') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                <div class="row">
                    <input id="address1" type="hidden" onkeydown="return event.key != 'Enter';" name="city" class="form-control input-register" value="{{ old('city') }}" readonly placeholder="{{ trans('edit-personal.form.placeholder_city') }}">
                    <div class="col-12">
                        <input id="address3" type="text" onkeydown="return event.key != 'Enter';" name="address" maxlength="32" value="{{ old('address') }}" class="form-control @error('address') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.placeholder_address') }}">
                        @error('address')
                        <span id="address" class="valid-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-register-submit">{{ trans('edit-personal.form.btn_submit') }}</button>
            </div>
            <div class="text-center register-link-login">
                <a href="{{ route('user.auth.login') }}">{{ trans('edit-personal.form.link') }}</a>
            </div>
        </form>
    </div>
@endsection
@push('script')
    <script>
        function showPassword(image){
            var pass = document.getElementById('showPass');
            if (pass.type === 'password') {
                image.src = '{{ asset('assets/icon/eye-show.svg') }}';
                pass.type = 'text';

            } else {
                pass.type = "password";
                image.src = '{{ asset('assets/icon/eye-hide.svg') }}';

            }
        }

        function showPasswordConfirm(image){
            var pass = document.getElementById('showConfirm');
            if (pass.type === 'password') {
                image.src = '{{ asset('assets/icon/eye-show.svg') }}';
                pass.type = 'text';

            } else {
                pass.type = "password";
                image.src = '{{ asset('assets/icon/eye-hide.svg') }}';

            }
        }

        $(document).ready(function() {
            $('#zipcode').blur(function () {
                $('#address1').val('');
                $('#address3').val('');
            })

            $('#getAddress').click(function () {
                var zipCode = $('#zipcode').val();
                $('#postCode').css('display', 'none');
                if (zipCode.length === 0){
                    $('#postNumber').html('{{ trans('validation.W002_E018_required_post_code') }}');
                    $('#zipcode').css('border', '1px solid #FF3030');
                    $(this).parents('.row').nextAll('#postNumber').css( "display", "block" );
                } else if (zipCode.replaceAll(/_/g, "").replace('-', '').length !== 7){
                    $('#postNumber').html('{{ trans('validation.W002_E019_type_post_code') }}');
                    $('#zipcode').css('border', '1px solid #FF3030');
                    $(this).parents('.row').nextAll('#postNumber').css( "display", "block" );
                } else {
                    $.ajax({
                        url: "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" + zipCode,
                        dataType: 'jsonp',
                    }).done((data) => {
                        if (data.results) {
                            let result = data.results[0];
                            let dataAddress = ''
                            if (result.address1) {
                              dataAddress += (result.address1)
                            }
                            $('#address1').val(result.address1)
                            if (result.address2) {
                              dataAddress += (' ' + result.address2)
                            }
                            if (result.address3) {
                              dataAddress += (' ' + result.address3)
                            }

                            $('#address3').val(dataAddress);
                        } else {
                            $("#address1").val('');
                            $("#address3").val('');
                            $('#postNumber').html('{{ trans('validation.W002_E022_not_exist') }}');
                            $('#zipcode').css('border', '1px solid #FF3030');
                            $(this).parents('.row').nextAll('#postNumber').css( "display", "block" );
                        }
                    });
                }
            })
        });

        $('.btn-register-submit').click(function(e) {
            e.preventDefault();
            $(this).attr('disabled', true).css({
                cursor: 'not-allowed',
                border: '1px solid #eee',
                color: '#ccc',
                background: '#eee',
            })
            if ($(this).attr('disabled')) {
                $('#registerForm').submit();
            }
        });
        $('#zipcode').mask('000-0000', {
            reverse: true,
        });

        $( "#zipcode" ).focus(function() {
            $(this).css('border-color', '#13B67B');
        })

        $( "input" ).focus(function() {
            $(this).next('span').css( "display", "none" );
            $(this).parents('.row').next('#phoneNumber').css( "display", "none" );
            $(this).parents('.row').nextAll('.post_code').css( "display", "none" );
            $(this).removeClass('login-invalid');
        });
    </script>
@endpush
