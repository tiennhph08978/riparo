@extends('user.layouts.landing_page')

@section('title', trans('landing_page.landing_page'))

@section('content')
    <div class="landing-wrapper">
        <div class="row d-flex w-100 m-0">
            <div class="col p-0">
                <img src="{{ asset("assets/img/bg-landing.svg") }}" alt="bg-landing" class="landing-bg">
            </div>
            <div class="col p-0">
                <div class="landing-content">
                    <h3 class="main-title">{{ trans('landing_page.para_first.title') }}</h3>
                    <h3 class="title">{{ trans('landing_page.para_first.sub_title') }}</h3>
                    <div class="content-wrapper">
                        <p class="content">{{ trans('landing_page.para_first.content_1') }}</p>
                        <p class="content">{{ trans('landing_page.para_first.content_2') }}</p>
                    </div>
                    <div class="content-wrapper quick-content">
                        <div class="d-flex dot-content">
                            <div class="h-100">
                                <img src="{{ asset("assets/img/dot.svg") }}" alt="dot" class="dot-img">
                            </div>
                            <span class="content">{{ trans('landing_page.para_first.content_3') }}</span>
                        </div>
                        <div class="d-flex">
                            <div class="h-100">
                                <img src="{{ asset("assets/img/arrow.svg") }}" alt="arrow" class="arrow-img">
                            </div>
                            <span class="content shorter-content">{{ trans('landing_page.para_first.content_4') }}</span>
                        </div>
                    </div>
                    <div class="content-wrapper quick-content">
                        <div class="d-flex dot-content">
                            <div class="h-100">
                                <img src="{{ asset("assets/img/dot.svg") }}" alt="dot" class="dot-img">
                            </div>
                            <span class="content">{{ trans('landing_page.para_first.content_5') }}</span>
                        </div>
                        <div class="d-flex">
                            <div class="h-100">
                                <img src="{{ asset("assets/img/arrow.svg") }}" alt="arrow" class="arrow-img">
                            </div>
                            <span class="content shorter-content">{{ trans('landing_page.para_first.content_6') }}</span>
                        </div>
                    </div>
                    <div class="content-wrapper">
                        <p class="content">{{ trans('landing_page.para_first.content_7') }}</p>
                        <p class="content">{{ trans('landing_page.para_first.content_8') }}</p>
                        <p class="content">{{ trans('landing_page.para_first.content_9') }}</p>
                    </div>
                    <div class="button-landing">
                        <a href="{{ route("user.project.create") }}" class="landing-btn">{{ trans('landing_page.para_first.button') }}<img src="{{ asset("assets/img/arrow-2.svg") }}" alt="arrow-2" class="arrow-img-2"></a>
                        <a href="{{ route("user.project.list") }}" class="landing-btn">{{ trans('landing_page.para_first.button_view_all') }}<img src="{{ asset("assets/img/arrow-2.svg") }}" alt="arrow-2" class="arrow-img-2"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row w-100 m-0">
            <div class="col p-0">
                <div class="bottom-wrapper">
                    <div class="landing-content-bottom">
                        <h3 class="main-title">{{ trans('landing_page.para_second.title') }}</h3>
                        <div class="content-wrapper">
                            <p class="content">{{ trans('landing_page.para_second.content_1') }}</p>
                            <p class="content">{{ trans('landing_page.para_second.content_2') }}</p>
                        </div>
                        <div class="d-flex content-wrapper">
                            <div class="d-flex dot-content">
                                <div class="h-100">
                                    <img src="{{ asset("assets/img/dot.svg") }}" alt="dot" class="dot-img">
                                </div>
                                <span class="content">{{ trans('landing_page.para_second.content_4') }}</span>
                            </div>
                            <div class="d-flex">
                                <div class="h-100">
                                    <img src="{{ asset("assets/img/arrow.svg") }}" alt="arrow" class="arrow-img">
                                </div>
                                <span class="content longer-content">{{ trans('landing_page.para_second.content_5') }}</span>
                            </div>
                        </div>
                        <div class="d-flex content-wrapper">
                            <div class="d-flex dot-content">
                                <div class="h-100">
                                    <img src="{{ asset("assets/img/dot.svg") }}" alt="dot" class="dot-img">
                                </div>
                                <span class="content">{{ trans('landing_page.para_second.content_6') }}</span>
                            </div>
                            <div class="d-flex">
                                <div class="h-100">
                                    <img src="{{ asset("assets/img/arrow.svg") }}" alt="arrow" class="arrow-img">
                                </div>
                                <span class="content shorter-content">{{ trans('landing_page.para_second.content_7') }}</span>
                            </div>
                        </div>
                        <div class="content-wrapper">
                            <p class="content">{{ trans('landing_page.para_second.content_8') }}</p>
                            <p class="content">{{ trans('landing_page.para_second.content_9') }}</p>
                            <p class="content">{{ trans('landing_page.para_second.content_10') }}</p>
                            <p class="content">{{ trans('landing_page.para_second.content_11') }}</p>
                            <p class="content">{{ trans('landing_page.para_second.content_12') }}</p>
                        </div>
                        <div style="margin-top: 20px">
                            <a href="{{ route('user.project.list') }}" class="landing-btn">{{ trans('landing_page.para_second.button') }}<img src="{{ asset("assets/img/arrow-2.svg") }}" alt="arrow-2" class="arrow-img-2"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col p-0">
                <img src="{{ asset("assets/img/bg-landing-2.svg") }}" alt="bg-landing-2" class="landing-bg-2">
            </div>
        </div>
    </div>
@endsection
