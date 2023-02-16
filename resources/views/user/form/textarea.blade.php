<label for="">
    {{ $dataInput['title'] }}
    @if($dataInput['required'])<span class="required">{{ trans('common.required') }}</span>@endif
    @isset($dataInput['can_enter'])<span class="can-enter">{{ trans('common.can_enter') }}</span> @endisset
</label>
<div class="row">
    <div class="col-xl-12 col-12">
        <textarea name="{{ $dataInput['name'] }}" class="form-control @if($dataInput['name']) row-{{$dataInput['name']}} @endif
              @error($dataInput['name']) input-invalid @enderror"
              rows="{{ $dataInput['row'] }}" placeholder="{{ $dataInput['placeholder'] }}"
              @if(@$dataInput['maxlength']) maxlength="{{ $dataInput['maxlength'] }}" @endif
              @if($dataInput['required']) required @endif>{!! $dataInput['value'] !!}</textarea>
        @error($dataInput['name'])
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
