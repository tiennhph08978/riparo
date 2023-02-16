@extends('admin.layouts.index')

@section('title', trans('admin.title.edit_email'))

@section('content')
<div class="card-body">
    <div class="card card-outline-secondary p-2">
        <div class="card-body">
            <form class="form" autocomplete="off" action="">
                @csrf
                <div class="form-group row mb-4">
                    <div class="col-lg-6 dropdown">
                        <select class="form-control" id="select_option">
                            <option class="dropdown-item">-- {{ trans('admin.edit_email.emails') }} --</option>
                            @foreach($results as $result)
                                <option class="dropdown-item" value="{{ $result->id }}">{{ trans('admin.subjects')[$result->type] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-lg-3 col-form-label form-control-label required">{{ trans('admin.edit_email.subject') }}:</label>
                    <div class="col-lg-9">
                        <input class="form-control input-lg subject" name="subject" type="text">
                        <span id="error-subject" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-lg-3 col-form-label form-control-label required">{{ trans('admin.edit_email.header') }}:</label>
                    <div class="col-lg-9">
                        {{ trans('admin.edit_email.username') }}
                        <textarea rows="1" class="form-control header" name="header" type="text"></textarea>
                        <span id="error-header" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-lg-3 col-form-label form-control-label required">{{ trans('admin.edit_email.content') }}:</label>
                    <div class="col-lg-9">
                        <textarea rows="4" class="form-control content" name="content"></textarea>
                        <span id="error-content" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-lg-3 col-form-label form-control-label required">{{ trans('admin.edit_email.contact') }}:</label>
                    <div class="col-lg-9">
                        <textarea rows="4" class="form-control contact" name="contact"></textarea>
                        <span id="error-contact" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-auto m-auto">
                        <input type="button" class="btn btn-primary submit" value="{{ trans('admin.edit_email.save') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
        const array_message = [
            {'error-subject' : '{{ trans('admin.array_message.error-subject') }}'},
            {'error-header' : '{{ trans('admin.array_message.error-header') }}'},
            {'error-content' : '{{ trans('admin.array_message.error-content') }}'},
            {'error-contact' : '{{ trans('admin.array_message.error-contact') }}'},
            {'success' : '{{ trans('admin.array_message.success') }}'},
        ];

        function emptyInput (arr) {
            arr.forEach(function (value) {
                var arr_name = 'error-'+value;
                for(const key in array_message) {
                    if(array_message[key][arr_name]) {
                        $('#'+arr_name).text(array_message[key][arr_name]);
                        $('.'+value).addClass('border border-danger');
                    }
                }
            });
        }

        function checkOption (form, input) {
            if ($.isNumeric( input )) {
                form.find('textarea').prop('disabled', false);
                form.find('input').prop('disabled', false);
            } else {
                form.find('textarea').prop('disabled', true);
                form.find('input').prop('disabled', true);
            }
        }

        $(document).ready(function () {
            var form = $('.form-group');

            form.find('textarea').prop('disabled', true);
            form.find('input').prop('disabled', true);

            form.on("focus", "input, textarea", function() {
                var name = $(this).attr('name');
                var idError = 'error-' + name;
                if($(this).find('span')) {
                    $('#'+idError).empty();
                    $('.'+name).removeClass('border border-danger');
                }
            });

            $('select').on('change', function (e) {
                var valueSelected = this.value;
                
                $(form).find('span').empty();
                $(form).find('input').removeClass('border border-danger');
                $(form).find('textarea').removeClass('border border-danger');

                checkOption(form, valueSelected);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url': 'edit-email/'+valueSelected,
                    'type': 'GET',
                    'data': {},

                    success: function(response){
                        $('input[name=subject]').val(response.subject);
                        $('textarea[name=header]').val(response.header);
                        $('textarea[name=content]').val(response.content);
                        $('textarea[name=contact]').val(response.contact);
                    },
                });
            });

            $('.submit').on('click', function(e) {
                let valueSelect = $('#select_option').find(':selected').val();
                $(this).attr('disabled', true);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: 'edit-email/'+valueSelect,
                    data: $('form').serialize(),
                    success: function(response)
                    {
                        setTimeout(() => {
                            $('.submit').attr('disabled', false);
                        }, 2500);

                        toastr.success(response.success);
                    },
                    error: function(response){
                        var errors = Object.keys(response.responseJSON.errors);
                        emptyInput(errors);

                        setTimeout(() => {
                            $('.submit').attr('disabled', false);
                        }, 1000);
                    }
                });
                e.preventDefault();
            });
        });
    </script>
@endpush
