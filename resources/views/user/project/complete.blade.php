@extends('user.layouts.landing_page')

@section('title', trans('project.create'))

@section('content')
    <div class="complete-project">
        <div class="content-complete">
            <img class="image-complete" src="{{ asset('assets/img/project_mail.svg') }}" alt="">
            <div class="text-complete">{!! trans('project.project_complete') !!}</div>
            <a class="link-back-mypage" href="{{ route('user.my_page.index') }}">{{ trans('project.return_mypage') }}</a>
        </div>
    </div>
@endsection

@push('script')

@endpush
