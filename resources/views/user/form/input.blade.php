<label for="">{{ $dataInput['title'] }}@if($dataInput['required'])<span class="required">{{ trans('common.required') }}</span>@endif</label>
<div class="row">
    <div class="col-xl-12 col-12">
        <input type="text" name="{{ $dataInput['name'] }}"
               onkeydown="return event.key != 'Enter';"
               class="form-control @error($dataInput['name']) input-invalid @enderror"
               value="{{ $dataInput['value'] }}" placeholder="{{ $dataInput['placeholder'] }}"
               @if(@$dataInput['maxlength']) maxlength="{{ $dataInput['maxlength'] }}" @endif
               @if($dataInput['required']) required @endif>
        @error($dataInput['name'])
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
