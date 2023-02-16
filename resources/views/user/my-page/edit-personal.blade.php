@extends('user.layouts.landing_page')

@section('title', trans('edit-personal.title'))

@section('content')
    @include('sweetalert::alert')
    <div class="main">
        <div class="information-detail">
            <form id="registerForm" action="{{ route('user.my_page.update_personal') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="information-detail-header">
                    <div class="information-detail-header__list">
                        <a href="{{ route('user.my_page.index') }}">{{ trans('edit-personal.header.list_text') }}</a><span>&#8226;</span>
                        <span class="information-detail-header__list-link">{{ trans('edit-personal.header.list_link') }}</span>
                    </div>
                </div>
                <div class="information-detail-content">
                    <div class="information-detail-content__img">
                        <div class="d-inline-block avatar-form">
                            @if ($user->avatar)
                                <img src="{{ \App\Helpers\FileHelper::getFullUrl($user->avatar) }}" alt="" id="filePreview" width="100%">
                            @else
                                <img src="{{ asset('assets/img/default.png') }}" alt="" id="filePreview" width="100%">
                            @endif

                            @error('avatar')
                            <span class="valid-error avatar-error">{{ $message }}</span>
                            @enderror
                            <div class="d-block">
                                <input type="file" name="avatar" id="fileChangeImage">
                                @error('avatar')
                                <div class="valid-error avatar-error-mobile">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="change-avatar" for="fileChangeImage"><img src="{{ asset('assets/icon/add_image.svg') }}" alt=""></label>
                        </div>
                    </div>
                    <div class="information-detail-content-form">
                        <div class="form-group">
                            <label for="">{{ trans('edit-personal.form.name') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                            <div class="row">
                                <div class="col-6 div-padding-right">
                                    <input type="text" maxlength="16" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control @error('first_name') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.name') }}{{ trans('edit-personal.form.placeholder.first_name') }}">
                                    @error('first_name')
                                    <span id="first_name" class="valid-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6  div-padding-left">
                                    <input type="text" maxlength="16" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control @error('last_name') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.name') }}{{ trans('edit-personal.form.placeholder.last_name') }}">
                                    @error('last_name')
                                    <span class="valid-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">{{ trans('edit-personal.form.name') }}{{ trans('edit-personal.form.furigana') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                            <div class="row">
                                <div class="col-6 div-padding-right ">
                                    <input type="text" name="first_name_furigana" maxlength="24" value="{{ old('first_name_furigana', $user->first_name_furigana) }}" class="form-control @error('first_name_furigana') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.name') }}{{ trans('edit-personal.form.placeholder.furigana') }}">
                                    @error('first_name_furigana')
                                    <span class="valid-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6  div-padding-left">
                                    <input type="text" name="last_name_furigana" maxlength="24" value="{{ old('last_name_furigana', $user->last_name_furigana) }}" class="form-control @error('last_name_furigana') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.name') }}{{ trans('edit-personal.form.placeholder.furigana') }}">
                                    @error('last_name_furigana')
                                    <span class="valid-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">{{ trans('edit-personal.form.email_address') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                            <input type="text" value="{{ $user->email }}" readonly class="address1 form-control input-register" placeholder="{{ trans('edit-personal.form.email_address') }}">
                        </div>
                        <div class="form-group">
                            <label for="">{{ trans('edit-personal.form.number_phone') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                            <div class="row">
                                <div class="col-7">
                                    <input type="text" maxlength="11" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="form-control @error('phone_number') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.placeholder_number') }}">
                                </div>
                            </div>
                            @error('phone_number')
                            <span class="valid-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">{{ trans('edit-personal.form.post_code') }}<span class="required">{{ trans('edit-personal.form.required_span') }}</span></label>
                            <div class="row">
                                <div class="col-6 col-lg-3 col-xl-3 d-flex div-padding-right code-padding-right">
                                    <div class="d-flex align-items-center mr-3 text-code">〒</div>
                                    <input id="zipcode" type="text" maxlength="8" name="post_code"
                                           class="form-control @error('post_code') login-invalid @enderror input-register"
                                           value="{{ old('post_code', $user->post_code) }}" placeholder="{{ trans('edit-personal.form.placeholder_code') }}">
                                </div>

                                <div class="col-6 col-lg-4 col-xl-4 div-padding-left code-padding-left">
                                    <button type="button" class="btn btn-register" id="getAddress">{{ trans('edit-personal.form.btn_post_code') }}</button>
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
                                <input id="address1" type="hidden" name="city" class="form-control input-register" value="{{ old('city', $cityName) }}" readonly placeholder="{{ trans('edit-personal.form.placeholder_city') }}">
                                <div class=" col-12 mt-input-address">
                                    <input type="text" name="address" maxlength="32" value="{{ old('address', $user->address) }}" class="form-control @error('address') login-invalid @enderror input-register" placeholder="{{ trans('edit-personal.form.placeholder_address') }}">
                                    @error('address')
                                    <span id="address" class="valid-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <label for="">{{ trans('edit-personal.form.birthday') }}</label>
                                    <input class="form-control input-date"
                                           data-date=""
                                           data-date-format="YYYY年MM月DD日"
                                           type="text" lang="ja" name="birth"
                                           value="{{ old('birth', $user->birth) }}"
                                           readonly='true'/>
                                    @error('birth')
                                    <span id="birthday" class="valid-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label for="">{{ trans('edit-personal.form.gender') }}</label>
                                    <select class="form-control" name="gender">
                                        @foreach(\App\Models\User::getListGender() as $key => $type)
                                            <option value="{{ $key }}" @if($key == (old('gender') ? old('gender') : @$user->gender)) selected @endif>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">{{ trans('edit-personal.form.desc') }}</label>
                            <textarea  class="personal-detail form-control" maxlength="1000" name="desc" placeholder="{{ trans('edit-personal.form.placeholder_desc') }}">{{ old('desc', $user->desc) ?? '' }}</textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-submit" id="btnSubmit">{{ trans('edit-personal.header.action_btn') }}</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const uploadInput = document.querySelector('#fileChangeImage');
        const previewImg = document.querySelector('#filePreview');
        uploadInput.addEventListener('change', e => {
            if (e.target.files.length > 0) {
	            if (e.target.files[0].size >= 5000000) {
		            $(e.target).val('');
		            toastr.error("{{ trans('validation.file_error') }}");
	            } else  {
		            const url = URL.createObjectURL(e.target.files[0]);
		            previewImg.src = url;
                }
            }
        });
        $(document).ready(function() {
            $(document).on('click', '.input-date', function(){
                $(this).datepicker({
                  dateFormat: "yy年mm月dd日"
                }).focus();
                $(this).removeClass('input-date');
            });
              var zipCodeDefault = $('#zipcode').val();

              $.ajax({
                url: "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" + zipCodeDefault,
                dataType: 'jsonp',
              }).done((data) => {
                if (data.results) {
                  let result = data.results[0];
                  $('#address1').val(result.address1);
                } else {
                  $("#address1").val('');
                }
              });
            $('#zipcode').blur(function () {
                $('#address1').val('');
                $('#address3').val('');
            })

            $('#getAddress').click(function () {
                var zipCode = $('#zipcode').val();
                $('#postCode').css('display', 'none');
                if (zipCode.length === 0){
                    $('#postNumber').html('{{trans('validation.W002_E018_required_post_code')}}');
                    $('#zipcode').css('border', '1px solid #FF3030');
                    $(this).parents('.row').nextAll('#postNumber').css( "display", "block" );
                    $("#address1").val('');
                    $("#address3").val('');
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
                          $('#address1').val(result.address1);
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

        $('.btn-submit').click(function(e) {
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

        $( "#zipcode" ).focus(function() {
            $(this).css('border-color', '#13B67B');
        })

        $( "input" ).focus(function() {
            $(this).next('span').css( "display", "none" );
            $(this).parents('.row').next('#postNumber').css( "display", "none" );
            $(this).parents('.row').nextAll('.post_code').css( "display", "none" );
            $(this).removeClass('login-invalid');
        });

        $('#zipcode').mask('000-0000', {
            reverse: true,
        });
    </script>
@endpush
