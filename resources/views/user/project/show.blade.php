@extends('user.layouts.landing_page')

@section('title', $project->title)

@section('content')
<div class="wrapper">
    @include('sweetalert::alert')

    <div class="project-detail-wrapper detail-project">
        <div class="link-wrapper">
            <a href="{{ route('user.index') }}">{{ trans('project.system.index') }} ・ </a>
            <span>{{ $project->title }}</span>
        </div>

        <div class="content-wrapper">
            <div class="project-detail-title">
                <div class="project-title">
                    <h3 class="title">
                        <span class="text-title">{{ $project->title }}</span>
                        @if (\App\Helpers\ProjectHelper::isNew($project))
                            <div class="div-new">
                                <span class="new">{{ trans('project.system.new') }}</span>
                            </div>
                        @endif
                    </h3>
                    <div class="d-flex">
                        <p class="m-0 category">{{ trans('project.attribute.industry') }}:</p>
                        <p class="category type mb-0">{{ ' ' . $project->industry }}</p>
                    </div>
                </div>

                @if($user)
                    @if(\App\Helpers\ProjectHelper::getProjectRole($project, $user) == \App\Models\ProjectUser::ROLE_GUEST)
                        <a id="{{ $project->id }}" href="{{ '?recruitment-' . $project->id }}" class="link link-short recruitment-link">{{ trans('project.system.recruitment') }}</a>
                    @endif
                @else
                    <a id="{{ $project->id }}" href="{{ route('user.auth.login') . '?next_page_url=' . \App\Helpers\UrlHelper::getProjectUrl($project) . '?recruitment-' . $project->id }}" class="link link-short">{{ trans('project.system.recruitment') }}</a>
                @endif
            </div>
            @if($project->banner)
                <div class="import-image img-wrapper row" style="@if(!count($project->detailImages)) height: 720px @endif">
                    @if($project && count($project->detailImages))
                        <div class="image-banner input-image image-main col col-md-9 col-sm-12">
                            <img id="upload-banner-image"
                                 class="show-image {{ $project ? 'show-default-image' : '' }}"
                                 src="{{ $project ? App\Helpers\FileHelper::getFullUrl($project->banner->url) : '' }}" alt="your image" />
                        </div>

                        <div class="col col-md-3 col-sm-12 form-image-detail">
                            <div class="row list-image-detail image-sub">
                                <div class="input-image col col-md-12 col-sm-4">
                                    <img id="upload-deatail1-image"
                                         class="show-image {{ $project ? (@$project->detailImages[0] ? 'show-default-image' : '') : '' }}"
                                         src="{{ $project ? (@$project->detailImages[0] ? App\Helpers\FileHelper::getFullUrl($project->detailImages[0]->url) : '') : '' }}" alt="your image" />
                                </div>
                                <div class="input-image col col-md-12 col-sm-4">
                                    <img id="upload-deatail2-image"
                                         class="show-image {{ $project ? (@$project->detailImages[1] ? 'show-default-image' : '') : '' }}"
                                         src="{{ $project ? (@$project->detailImages[1] ? App\Helpers\FileHelper::getFullUrl($project->detailImages[1]->url) : '') : '' }}"
                                         alt="your image" />
                                </div>
                                <div class="input-image col col-md-12 col-sm-4">
                                    <img id="upload-deatail3-image"
                                         class="show-image {{ $project ? ( @$project->detailImages[2] ? 'show-default-image' : '') : '' }}"
                                         src="{{ $project ? (@$project->detailImages[2] ? App\Helpers\FileHelper::getFullUrl($project->detailImages[2]->url) : '') : '' }}"/>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="input-image single-img col h-100">
                            <img id="upload-banner-image"
                                 class="show-image w-100 {{ $project ? 'show-default-image' : '' }}"
                                 src="{{ $project ? App\Helpers\FileHelper::getFullUrl($project->banner->url) : '' }}" alt="your image" />
                        </div>
                    @endif
                </div>
            @endif
            <div>
                <div class="project-detail-info">
                    <div class="info-row">
                        <div class="title">{{ trans('project.system.info') }}</div>
                            <div class="content">
                                <div class="icon">
                                    <div>
                                        <div class="row-info">
                                            <div class="project-info-line short">
                                                <img src="{{ asset("assets/img/project/people-icon.svg") }}" alt="cover" class="project-icon">
                                                <div>
                                                    <div class="project-info-title">{{ trans('project.attribute.recruitment_quantity') }}: </div>
                                                    <div class="project-info-content">
                                                        {{ $project->recruitment_quantity_min }}人〜{{ $project->recruitment_quantity_max }}人
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="project-info-line long">
                                                <img src="{{ asset("assets/img/target_amount.svg") }}" alt="calendar" class="project-icon">
                                                <div>
                                                    <div class="project-info-title">{{ trans('project.attribute.target_amount') }}: </div>
                                                    <div class="project-info-content">
                                                        {{ \App\Helpers\StringHelper::formatMoney($project->target_amount ?: 0) }}{{ trans('project.profit.unit') }} (<span class="contact_period">{{ trans('project.contact_period') }}</span> {{ $project->contactPeriod->name }})
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-info">
                                                <div class="project-info-line">
                                                    <img src="{{ asset("assets/img/project/location-icon.svg") }}" alt="location" class="project-icon">
                                                    <div>
                                                        <div class="project-info-title">{{ trans('project.attribute.address') }}: </div>
                                                        <span class="project-info-content">{{ config('master_data.provinces.' . $project->city_id) }}</span>
                                                        <span class="project-info-content">{{ $project->address }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row-info">
                                            <div class="project-info-line short">
                                                <img src="{{ asset("assets/img/project/percent-icon.svg") }}" alt="percent" class="project-icon">
                                                <div>
                                                    <div class="project-info-title">{{ trans('project.attribute.recruitment_number') }}: </div>
                                                    <div class="project-info-content">{{ $project->recruitment_number }}%</div>
                                                </div>
                                            </div>
                                            <div class="project-info-line longest">
                                                <img src="{{ asset("assets/img/project/time-icon.svg") }}" alt="time" class="project-icon">
                                                <div>
                                                    <div class="project-info-title">{{ trans('project.attribute.work_time') }}: </div>
                                                    <div class="project-info-content content-icon">{{ $project->work_time }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="title">{{ trans('project.attribute.work_content') }}</div>
                            <div class="content">
                                <div class="text">{!! \App\Helpers\StringHelper::formatContent($project->work_content) !!}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="title">{{ trans('project.attribute.work_desc') }}</div>
                            <div class="content">
                                <div class="text">{!! \App\Helpers\StringHelper::formatContent($project->work_desc) !!}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="title">{{ trans('project.attribute.special') }}</div>
                            <div class="content">
                                <div class="text">{!! \App\Helpers\StringHelper::formatContent($project->special) !!}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="title">{{ trans('project.attribute.business_development_incorporation') }}</div>
                            <div class="content">
                                <div class="text">{!! \App\Helpers\StringHelper::formatContent($project->business_development_incorporation) !!} </div>
                            </div>
                        </div>
                        <div class="info-row info-row-last">
                            <div class="title">{{ trans('project.attribute.employment_incorporation') }}</div>
                            <div class="content">
                                <div class="text">{!! \App\Helpers\StringHelper::formatContent($project->employment_incorporation) !!}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="title"></div>
                            <div class="content">
                                <div class="text text-link">
                                    @if($user)
                                        @if(\App\Helpers\ProjectHelper::getProjectRole($project, $user) == \App\Models\ProjectUser::ROLE_GUEST)
                                            <a id="{{ $project->id }}" href="{{ '?recruitment-' . $project->id }}" class="link link-long recruitment-link">{{ trans('project.system.recruitment') }}</a>
                                        @endif
                                    @else
                                        <a id="{{ $project->id }}" href="{{ route('user.auth.login') . '?next_page_url=' . \App\Helpers\UrlHelper::getProjectUrl($project) . '?recruitment-' . $project->id}}" class="link link-long">{{ trans('project.system.recruitment') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @include('user.project.form')
</div>
@endsection

@push('script')
<script>
    const fullUrl = $(location).attr('href');
    const link = document.createElement('a');
    link.href = fullUrl;
    const path = link.pathname;
    const search = link.search;
    const span = $('.close');

    $(document).ready(function() {
        const formClass = $('.' + search.slice(1));

        if (search.slice(1, 12) === 'recruitment') {
            formClass.addClass('d-flex');

            span.click(function () {
                formClass.removeClass('d-flex');
                window.history.replaceState(null, null, path);
            });
            $(window).on('click', function (e) {
                if ($(e.target).is('.recruitment-form')) {
                    formClass.removeClass('d-flex');
                    window.history.replaceState(null, null, path);
                }
            });
        }
    });

    $('.recruitment-link').click(function(e) {
        let projectId = $(this).attr('id');
        $('.recruitment-' + projectId).addClass('d-flex');
        window.history.replaceState(null, null, '?recruitment-' + projectId);

        span.click(function () {
            $('.recruitment-' + projectId).removeClass('d-flex');
            window.history.replaceState(null, null, path);
        });
        $(window).on('click', function (e) {
            if ($(e.target).is('.recruitment-form')) {
                $('.recruitment-' + projectId).removeClass('d-flex');
                window.history.replaceState(null, null, path);
            }
        });
        e.preventDefault();
    });

    $('.submit-recruitment').click(function(e) {
        e.preventDefault()
        $(this).prop('disabled', true)
        $('#recruitment-form-' + $(this).attr('id')).submit()
        window.history.replaceState(null, null, $(location).attr('origin') + path);
    });
</script>
@endpush
