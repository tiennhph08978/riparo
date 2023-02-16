@extends('admin.layouts.index')

@section('title', $project->title)

@section('content')
    <div class="col-md pt-3 create-project">
        <div class="bg-white p-4 card card-style1 border-0 mb-4 mb-sm-5">
            <form action="{{ route('admin.projects.update', $project->id) }}" id="form-project" method="post" enctype="multipart/form-data">
                <div class="header-banner">
                    <div class="title-page">
                        <a href="{{ route('admin.projects.detail', $project) }}"><i class="fa-solid fa-circle-arrow-left back-icon"></i></a>
                    </div>
                    <div class="show-pc">
                        <button type="submit" class="btn btn-success button-update submit-form-data">{{ trans('common.button.update') }}</button>
                    </div>
                </div>
                @include('admin.project.fields')
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success button-update button-update-end submit-form-data">{{ trans('common.button.update') }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script')
<script src="{{ asset('assets/js/user/project.js') }}"></script>
<script>
    function readURL(input, image) {
        if (input.files && input.files[0]) {
            if (input.files[0].size >= 5000000) {
                $(input).val('');
                toastr.error("{{ trans('validation.file_error') }}");
            } else {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + image).attr('src', e.target.result);
                    $('#' + image).show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    }
    $(document).ready(function() {
        function checkTextShare() {
            let min = $('input[name=recruitment_quantity_min]').val()
            let max = $('input[name=recruitment_quantity_max]').val()
            let number = $('input[name=recruitment_number]').val()
            let minValue = 100 - max * number - 9
            let maxValue = 100 - min * number - 9
            let textShare = `<span class="founder-share-ratio">{{ trans('project.attribute.founder_share_ratio') }}（${minValue}%〜${maxValue}%）</span>`
            if (minValue === maxValue) {
                textShare = `<span class="founder-share-ratio">{{ trans('project.attribute.founder_share_ratio') }}（${minValue}%）</span>`
            }
            $('#check-recruitment').val(1)
            if (minValue > maxValue) {
                textShare = '<span class="founder-share-ratio text-danger">{{ trans('validation.WORK011_E018') }}</span>'
                $('#check-recruitment').val(0)
            }
            if (minValue <= 0) {
                textShare = '<span class="founder-share-ratio text-danger">{{ trans('validation.WORK011_E019') }}</span>'
                $('#check-recruitment').val(0)
            }
            $('.founder-share-ratio').html(textShare)
        }
        checkTextShare()
        $('.change-recruitment').change(function () {
            checkTextShare()
        })
    });
</script>
@endpush
