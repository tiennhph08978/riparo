@extends('user.layouts.landing_page')

@section('title', trans('project.edit'))

@section('content')
    <div class="container create-project">
        <form id="form-project" action="{{ route('user.project.update', $project->id) }}" method="post" enctype="multipart/form-data">
            <div class="header-banner">
                <div class="title-page">
                    <span class="personal-page"><a href="{{ route('user.my_page.index') }}">{{ trans('common.title.personal_page') }}</a>・</span>
                    <span class="text-subtitle">{{ trans('project.edit') }}</span>
                </div>
                <div class="show-pc">
                    <button type="submit" class="btn btn-success submit-form-data">{{ trans('common.button.save') }}</button>
                </div>
            </div>
            @include('user.project.fields')
            <div class="show-pc">
                <div class="d-flex justify-content-center" >
                    <button type="submit" class="btn btn-success submit-form-data">{{ trans('common.button.save') }}</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('script')
<script id="defaultRow" type="text/template">
{{-- Default Row --}}
    @include('user.project.default_worktime_row', ['dataInput' => [ 'id' => 'new', 'date' => \Carbon\Carbon::now()->isoFormat('Y年MM月DD日'), 'startTime' => 10, 'endTime' => 18]])
</script>
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
