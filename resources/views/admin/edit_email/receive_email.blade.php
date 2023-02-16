@extends('admin.layouts.index')

@section('title', trans('admin.title.receive_email'))

@section('content')
<div class="card-body">
    <div class="card card-outline-secondary p-2">
        <div class="card-body">
            <form class="form" autocomplete="off" action="{{ route('admin.receive-email.update') }}" method="POST">
                {{ csrf_field()}}
                <div class="form-group row mb-4">
                    <label class="col-lg-2 col-form-label form-control-label required">{{ trans('admin.title.receive') }}:</label>
                    <div class="col-lg-10">
                        <input class="form-control input-lg {{ $errors->has('receive_email') ? 'order border-danger' : '' }}"
                            value="{{ old('receive_email', $result) }}" name="receive_email" type="text" max="64" maxlength="64">
                        @if ($errors->has('receive_email'))
                            <span id="password-error" class="help-block">
                                <p class="text-danger">{{ $errors->first('receive_email') }}</p>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-auto m-auto">
                        <input type="submit" class="btn btn-primary submit" value="{{ trans('admin.edit_email.save') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('submit', 'form', function() {
                $('.btn').attr('disabled', 'disabled');
            });
        });
    </script>
@endpush
