@extends('user.layouts.landing_page')

@section('title', $project->title)

@section('content')
<div class="wrapper detail-product-founder-wrapper">
    @include('sweetalert::alert')
    <div class="project-detail-wrapper detail-product-founder">
        <div class="link-wrapper">
            <a href="{{ route('user.my_page.index') }}">{{ trans('common.title.personal_page') }} ・ </a>
            <span>{{ $project->title }}</span>
        </div>
        <div class="content-wrapper">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item-cus active">
                    <a class="nav-link active" id="project-management-tab" data-toggle="tab" href="#project-management" role="tab" aria-controls="project-management" aria-selected="true">
                        {{ trans('project.project_management') }}
                    </a>
                </li>
                <li class="nav-item-cus">
                    <a class="nav-link" id="recruitment-info-tab" data-toggle="tab" href="#recruitment-info" role="tab" aria-controls="recruitment-info" aria-selected="false">
                        {{ trans('project.recruitment_info') }}
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="recruitment-info" role="tabpanel" aria-labelledby="recruitment-info-tab">
                    <div class="project-detail-title">
                        <div class="project-title">
                            <h3 class="title">{{ $project->title }}</h3>
                            <div class="d-flex">
                                <p class="m-0 category">{{ trans('project.attribute.industry') }}:</p>
                                <p class="m-0 category type">{{ $project->industry }}</p>
                            </div>
                        </div>
                    </div>
                    @if($project->banner)
                        @if(count($project->detailImages))
                            <div class="import-image row">
                                <div class="image-banner input-image col col-md-9 col-sm-12">
                                    <img id="upload-banner-image"
                                         class="show-image {{ $project ? 'show-default-image' : '' }}"
                                         src="{{ $project ? App\Helpers\FileHelper::getFullUrl($project->banner->url) : '' }}" alt="your image" />
                                </div>
                                <div class="col col-md-3 col-sm-12 form-image-detail">
                                <div class="row list-image-detail">
                                    <div class="input-image col col-md-12 col-sm-4">
                                        <img id="upload-deatail1-image"
                                             class="show-image {{ $project ? (@$project->detailImages[0] ? 'show-default-image' : '') : '' }}"
                                             src="{{ $project ? (@$project->detailImages[0] ? App\Helpers\FileHelper::getFullUrl($project->detailImages[0]->url) : '') : '' }}" alt="your image" />
                                    </div>
                                    <div class="input-image col col-md-12 col-sm-4 input-image-center">
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
                            </div>
                        @else
                            <div class="import-image import-image-only row">
                                <div class="image-banner input-image col col-md-12 col-sm-12">
                                    <img id="upload-banner-image"
                                         class="show-image {{ $project ? 'show-default-image' : '' }}"
                                         src="{{ $project ? App\Helpers\FileHelper::getFullUrl($project->banner->url) : '' }}" alt="your image" />
                                </div>
                            </div>
                        @endif
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
                                                            {{ $project->recruitment_quantity_min }}{{ trans('common.person') }}〜{{ $project->recruitment_quantity_max }}{{ trans('common.person') }}
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
                            <div class="info-row">
                                <div class="title">{{ trans('project.attribute.employment_incorporation') }}</div>
                                <div class="content">
                                    <div class="text">{!! \App\Helpers\StringHelper::formatContent($project->employment_incorporation) !!}</div>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="title">{{ trans('project.attribute.available_date_work') }}</div>
                                <div class="content">
                                    @foreach($project->availableDateEdit as $key => $date)
                                        <div class="text text-available-date">
                                            {{ trans('project.attribute.candidate_first') . ' ' . ($key + 1) . ' '. trans('project.attribute.candidate_last') }}
                                            &nbsp;&nbsp;{{ $date->date }}&nbsp;{{ $date->startTime . ' 〜 ' . $date->endTime }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="project-management" role="tabpanel" aria-labelledby="project-management-tab">
                    @if($project->user->status === \App\Models\User::STATUS_INACTIVATED)
                        <div class="show-success">
                            <div class="show-ban-founder">
                                <img src="{{ asset('assets/img/icon_info.svg') }}" alt="">
                                <span>{!! trans('project.note_success.ban_founder') !!}</span>
                            </div>
                        </div>
                    @else
                        @if (($project->status === \App\Models\Project::STATUS_END))
                            @if(($project->totalTurnover - $project->totalCost) >= $project->target_amount)
                                <div class="show-success">
                                    <div class="content-success">
                                        <img class="banner-success" src="{{ asset('assets/img/success_project.svg') }}" alt="">
                                        <img class="title-success" src="{{ asset('assets/img/success_title.svg') }}" alt="">
                                        <div class="list-note-success">
                                            <div class="d-flex">
                                                <img src="{{ asset('assets/icon/checked.svg') }}" alt="">
                                                <span>{{ trans('project.note_success.incorporation') }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <img src="{{ asset('assets/icon/checked.svg') }}" alt="">
                                                <span>{!! trans('project.note_success.company_operation') !!}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="close-project">
                                </div>
                            @endif
                        @elseif($project->result ===  \App\Models\Project::RESULT_LEGALIZATION)
                            <div class="close-project">
                            </div>
                        @endif
                    @endif

                    <div class="close-project show-disabled">
                    </div>
                    <div class="show-pc">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="title-member-list">
                                    {{ trans('project.participant_list') }}
                                </div>
                                @if ($project->status === \App\Models\Project::STATUS_RECRUITING)
                                    <div class="contract-period-reach">
                                        {{ trans('project.text_notice_status_confirm') }}
                                    </div>
                                @endif
                                @if ($project->checkBeforeEnd)
                                    <div class="contract-before-end">
                                        {{ trans('project.end_date_time') . $project->endDate }}<br />
                                        {{ trans('project.contact_before_end', ['email' => $project->emailAdmin]) }}
                                    </div>
                                @endif

                                <div class="member-list member-item-list">
                                    <div class="d-flex">
                                        <div class="position-relative">
                                            @if($project->user->status === \App\Models\User::STATUS_INACTIVATED)
                                                <div class="ban-user">
                                                    <img src="{{ asset('assets/img/icon_ban.svg') }}" alt="">
                                                </div>
                                            @endif
                                            <div class="member-item manager-item {{ $project->user->status === \App\Models\User::STATUS_INACTIVATED ? 'ban-user-show' : '' }}" data-toggle="modal" data-target="#modalDetailMember" data-user="{{ $project->user_id }}">
                                                <img class="member-image" src="{{ $project->user->avatar ? \App\Helpers\FileHelper::getFullUrl($project->user->avatar) : asset('assets/img/icon_user.svg') }}" alt="">
                                                <div class="member-text">
                                                    <span class="member-name">{{ $project->user->full_name }}</span>
                                                    <span class="member-position">{{ trans('project.position.founder') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="member-item-list">
                                        @if($project->status === \App\Models\Project::STATUS_RECRUITING)
                                            @foreach($project->projectUserInterview as $projectUser)
                                                <div class="d-inline-block position-relative">
                                                    @if($projectUser->user->status === \App\Models\User::STATUS_INACTIVATED)
                                                        <div class="ban-user">
                                                            <img src="{{ asset('assets/img/icon_ban.svg') }}" alt="">
                                                        </div>
                                                    @endif
                                                    <div class="member-item {{ $projectUser->user->status === \App\Models\User::STATUS_INACTIVATED ? 'ban-user-show' : '' }}" data-toggle="modal" data-target="#modalDetailMember" data-user="{{ $projectUser->user_id }}">
                                                        <img class="member-image" src="{{ $projectUser->user->avatar ? \App\Helpers\FileHelper::getFullUrl($projectUser->user->avatar) : asset('assets/img/icon_user.svg') }}" alt="">
                                                        <div class="member-text">
                                                            <span class="member-name">{{ $projectUser->user->full_name }}</span>
                                                            <span class="member-position">{{ trans('project.position.member') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @elseif ($project->status === \App\Models\Project::STATUS_ACTIVE)
                                            @foreach($project->projectUserApprove as $projectUser)
                                                <div class="d-inline-block position-relative">
                                                    @if($projectUser->user->status === \App\Models\User::STATUS_INACTIVATED)
                                                        <div class="ban-user">
                                                            <img src="{{ asset('assets/img/icon_ban.svg') }}" alt="">
                                                        </div>
                                                    @endif
                                                    <div class="member-item {{ $projectUser->user->status === \App\Models\User::STATUS_INACTIVATED ? 'ban-user-show' : '' }}" data-toggle="modal" data-target="#modalDetailMember" data-user="{{ $projectUser->user_id }}">
                                                        <img class="member-image" src="{{ $projectUser->user->avatar ? \App\Helpers\FileHelper::getFullUrl($projectUser->user->avatar) : asset('assets/img/icon_user.svg') }}" alt="">
                                                        <div class="member-text">
                                                            <span class="member-name">{{ $projectUser->user->full_name }}</span>
                                                            <span class="member-position">{{ trans('project.position.member') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            @foreach($project->projectUserEnd as $projectUser)
                                                <div class="d-inline-block position-relative">
                                                    @if($projectUser->user->status === \App\Models\User::STATUS_INACTIVATED)
                                                        <div class="ban-user">
                                                            <img src="{{ asset('assets/img/icon_ban.svg') }}" alt="">
                                                        </div>
                                                    @endif
                                                    <div class="member-item {{ $projectUser->user->status === \App\Models\User::STATUS_INACTIVATED ? 'ban-user-show' : '' }}" data-toggle="modal" data-target="#modalDetailMember" data-user="{{ $projectUser->user_id }}">
                                                        <img class="member-image" src="{{ $projectUser->user->avatar ? \App\Helpers\FileHelper::getFullUrl($projectUser->user->avatar) : asset('assets/img/icon_user.svg') }}" alt="">
                                                        <div class="member-text">
                                                            <span class="member-name">{{ $projectUser->user->full_name }}</span>
                                                            <span class="member-position">{{ trans('project.position.member') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="show-sp">
                        <div class="">
                            <div class="title-member-list">
                                {{ trans('project.participant_list') }}
                            </div>
                            @if ($project->status === \App\Models\Project::STATUS_RECRUITING)
                                <div class="contract-period-reach">
                                    {{ trans('project.text_notice_status_confirm') }}
                                </div>
                            @endif
                            @if ($project->checkBeforeEnd)
                                <div class="contract-before-end">
                                    {{ trans('project.end_date_time') . $project->endDate }}<br />
                                    {{ trans('project.contact_before_end', ['email' => $project->user->email]) }}
                                </div>
                            @endif
                            <div class="member-list">
                                <div class="d-flex">
                                    <div class="d-inline-block position-relative">
                                        @if($project->user->status === \App\Models\User::STATUS_INACTIVATED)
                                            <div class="ban-user">
                                                <img src="{{ asset('assets/img/icon_ban.svg') }}" alt="">
                                            </div>
                                        @endif
                                        <div class="member-item manager-item {{ $project->user->status === \App\Models\User::STATUS_INACTIVATED ? 'ban-user-show' : '' }}" data-toggle="modal" data-target="#modalDetailMember" data-user="{{ $project->user_id }}">
                                            <img class="member-image" src="{{ $project->user->avatar ? \App\Helpers\FileHelper::getFullUrl($project->user->avatar) : asset('assets/img/icon_user.svg') }}" alt="">
                                            <div class="member-text">
                                                <span class="member-name">{{ $project->user->full_name }}</span>
                                                <span class="member-position">{{ trans('project.position.founder') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @if($project->status === \App\Models\Project::STATUS_RECRUITING)
                                        @foreach($project->projectUserInterview as $projectUser)
                                            <div class="d-inline-block position-relative">
                                                @if($projectUser->user->status === \App\Models\User::STATUS_INACTIVATED)
                                                    <div class="ban-user">
                                                        <img src="{{ asset('assets/img/icon_ban.svg') }}" alt="">
                                                    </div>
                                                @endif
                                                <div class="member-item {{ $projectUser->user->status === \App\Models\User::STATUS_INACTIVATED ? 'ban-user-show' : '' }}" data-toggle="modal" data-target="#modalDetailMember" data-user="{{ $projectUser->user_id }}">
                                                    <img class="member-image" src="{{ $projectUser->user->avatar ? \App\Helpers\FileHelper::getFullUrl($projectUser->user->avatar) : asset('assets/img/icon_user.svg') }}" alt="">
                                                    <div class="member-text">
                                                        <span class="member-name">{{ $projectUser->user->full_name }}</span>
                                                        <span class="member-position">{{ trans('project.position.member') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @elseif($project->status === \App\Models\Project::STATUS_ACTIVE)
                                        @foreach($project->projectUserApprove as $projectUser)
                                            <div class="d-inline-block position-relative">
                                                @if($projectUser->user->status === \App\Models\User::STATUS_INACTIVATED)
                                                    <div class="ban-user">
                                                        <img src="{{ asset('assets/img/icon_ban.svg') }}" alt="">
                                                    </div>
                                                @endif
                                                <div class="member-item {{ $projectUser->user->status === \App\Models\User::STATUS_INACTIVATED ? 'ban-user-show' : '' }}" data-toggle="modal" data-target="#modalDetailMember" data-user="{{ $projectUser->user_id }}">
                                                    <img class="member-image" src="{{ $projectUser->user->avatar ? \App\Helpers\FileHelper::getFullUrl($projectUser->user->avatar) : asset('assets/img/icon_user.svg') }}" alt="">
                                                    <div class="member-text">
                                                        <span class="member-name">{{ $projectUser->user->full_name }}</span>
                                                        <span class="member-position">{{ trans('project.position.member') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($project->projectUserEnd as $projectUser)
                                            <div class="d-inline-block position-relative">
                                                @if($projectUser->user->status === \App\Models\User::STATUS_INACTIVATED)
                                                    <div class="ban-user">
                                                        <img src="{{ asset('assets/img/icon_ban.svg') }}" alt="">
                                                    </div>
                                                @endif
                                                <div class="member-item {{ $projectUser->user->status === \App\Models\User::STATUS_INACTIVATED ? 'ban-user-show' : '' }}" data-toggle="modal" data-target="#modalDetailMember" data-user="{{ $projectUser->user_id }}">
                                                    <img class="member-image" src="{{ $projectUser->user->avatar ? \App\Helpers\FileHelper::getFullUrl($projectUser->user->avatar) : asset('assets/img/icon_user.svg') }}" alt="">
                                                    <div class="member-text">
                                                        <span class="member-name">{{ $projectUser->user->full_name }}</span>
                                                        <span class="member-position">{{ trans('project.position.member') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-detail-founder">
                        <div class="title-member-list">{{ trans('project.profit.title') }}</div>
                        @if ($project->target_amount != 0)
                            <div class="contract-period-reach">{{ trans('project.profit.contract_period_reach', ['target_amount' => \App\Helpers\StringHelper::formatMoney($project->target_amount ?: 0)]) }}</div>
                        @endif
                        <div class="list-applicants-table table-profit">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">{{ trans('project.profit.turnover') }}</th>
                                    <th scope="col">{{ trans('project.profit.cost') }}</th>
                                    <th scope="col">{{ trans('project.profit.profit') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between font-weight-bold">
                                                <div>
                                                    <span id="total-turnover">{{ number_format($project->totalTurnover) }}</span>
                                                    <span>{{ trans('project.cost.yen') }}</span>
                                                </div>
                                                @if($isFounder)
                                                    @if($project->status === \App\Models\Project::STATUS_ACTIVE)
                                                        <img class="image-edit button-active" data-toggle="modal" data-target="#modalTurnover" src="{{ asset('assets/icon/icon_edit_active.svg') }}" alt="">
                                                    @else
                                                        <img class="image-edit" src="{{ asset('assets/icon/icon_edit.svg') }}" alt="">
                                                    @endif
                                                @else
                                                    @if($project->status === \App\Models\Project::STATUS_ACTIVE)
                                                        <img class="image-edit button-active" data-toggle="modal" data-target="#modalTurnover" src="{{ asset('assets/icon/icon_show_active.svg') }}" alt="">
                                                    @else
                                                        <img class="image-edit" src="{{ asset('assets/icon/icon_show.svg') }}" alt="">
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between font-weight-bold">
                                                <div>
                                                    <span id="total-cost">{{ number_format($project->totalCost) }}</span>
                                                    <span>{{ trans('project.cost.yen') }}</span>
                                                </div>
                                                @if($isFounder)
                                                    @if($project->status === \App\Models\Project::STATUS_ACTIVE)
                                                        <img class="image-edit button-active" data-toggle="modal" data-target="#modalCost" src="{{ asset('assets/icon/icon_edit_active.svg') }}" alt="">
                                                    @else
                                                        <img class="image-edit" src="{{ asset('assets/icon/icon_edit.svg') }}" alt="">
                                                    @endif
                                                @else
                                                    @if($project->status === \App\Models\Project::STATUS_ACTIVE)
                                                        <img class="image-edit button-active" data-toggle="modal" data-target="#modalCost" src="{{ asset('assets/icon/icon_show_active.svg') }}" alt="">
                                                    @else
                                                        <img class="image-edit" src="{{ asset('assets/icon/icon_show.svg') }}" alt="">
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between font-weight-bold">
                                                <div>
                                                    <span id="total-sale">{{ number_format($project->totalTurnover - $project->totalCost) }}</span>
                                                    <span>{{ trans('project.cost.yen') }}</span>
                                                </div>
                                                <div class="contract-period-reach-2">
                                                    <div class="show-pc total-sale-note">
                                                        {{ trans('project.profit.contract_period_reach_2',
 ['value' => \App\Helpers\StringHelper::formatMoney(($project->target_amount - ($project->totalTurnover - $project->totalCost)) > 0 ? ($project->target_amount - ($project->totalTurnover - $project->totalCost)) : 0)]) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="show-sp contract-period-reach total-sale-note">
                            {{ trans('project.profit.contract_period_reach_2', ['value' => \App\Helpers\StringHelper::formatMoney(($project->target_amount - ($project->totalTurnover - $project->totalCost)) > 0 ? ($project->target_amount - ($project->totalTurnover - $project->totalCost)) : 0)]) }}
                        </div>
                        @if(((($project->totalTurnover - $project->totalCost) >= $project->target_amount) && $isFounder) && $project->status == \App\Models\Project::STATUS_ACTIVE)
                            <form action="{{ route('user.project.legalization', $project->id) }}" method="POST">
                                @csrf
                                <div class="banner-total-sale">
                                    <img class="image-close-banner-success" src="{{ asset('assets/img/close.svg') }}" alt="">
                                    <div class="button-sale">
                                        <div class="banner-title">{{ trans('project.banner_proceed') }}</div>
                                        <button class="btn btn-success">{{ trans('project.button_proceed') }}</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                    <div class="form-detail-founder">
                        <div class="title-member-list">{{ trans('project.dedication.title') }}</div>
                        @if(in_array($project->status, [\App\Models\Project::STATUS_ACTIVE, \App\Models\Project::STATUS_END]))
                            <div class="form-member-report">
                                @if($isFounder)
                                    <div class="report-header">
                                        <div>
                                            <select id="change-user-dedication" class="form-control">
                                                @foreach($project->projectUserApprove as $key => $value)
                                                    <option value="{{ $value->user_id }}">{{ $value->user->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <button class="btn btn-success button-report button-open-modal-dedication" data-toggle="modal" data-target="#modalDedication">{{ trans('project.button_report') }}</button>
                                        </div>
                                    </div>
                                    <div id="dedication-table-filter" class="report-table">
                                        <div class="show-pc">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{ trans('project.dedication.date') }}</th>
                                                    <th scope="col">{{ trans('project.dedication.item') }}</th>
                                                    <th scope="col">{{ trans('project.dedication.desc') }}</th>
                                                    <th class="text-center" scope="col">{{ trans('project.dedication.member_check') }}</th>
                                                    <th class="text-center" scope="col">{{ trans('project.dedication.founder_check') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($project->dedications as $dedication)
                                                    @if ($isFounder || ($dedication->user_id === \Illuminate\Support\Facades\Auth::id()))
                                                        <tr class="item-dedication item-dedication-table" id="{{ $dedication->user_id }}">
                                                            <td>{{ \App\Helpers\DateTimeHelper::formatDateJapan($dedication->date) }}</td>
                                                            <td>{{ $dedication->item }}</td>
                                                            <td class="content-dedication">{{ $dedication->content }}</td>
                                                            <td>
                                                                @if($dedication->is_member_check)
                                                                    <img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($dedication->is_founder_check)
                                                                    <img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="show-sp">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{ trans('project.dedication.desc') }}</th>
                                                    <th class="text-center" scope="col">{{ trans('project.dedication.member_check_sp') }}</th>
                                                    <th class="text-center" scope="col">{{ trans('project.dedication.founder_check_sp') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($project->dedications as $dedication)
                                                    <tr class="item-dedication item-dedication-table" id="{{ $dedication->user_id }}">
                                                        <td>
                                                            <div>{{ \App\Helpers\DateTimeHelper::formatDateJapan($dedication->date) }}</div>
                                                            <div>{{ $dedication->item }}</div>
                                                            <div class="content-dedication">{{ $dedication->content }}</div>
                                                        </td>
                                                        <td>
                                                            @if($dedication->is_member_check)
                                                                <img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($dedication->is_founder_check)
                                                                <img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <div id="dedication-table-filter" class="report-table mt-4">
                                        <div class="show-pc">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col" width="140px" >{{ trans('project.dedication.date') }}</th>
                                                    <th scope="col" width="125px" >{{ trans('project.dedication.item') }}</th>
                                                    <th scope="col">{{ trans('project.dedication.desc') }}</th>
                                                    <th scope="col" width="140px" >{{ trans('project.dedication.member_check') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($project->dedications as $dedication)
                                                    @if ($isFounder || ($dedication->user_id === \Illuminate\Support\Facades\Auth::id()))
                                                        <tr class="item-dedication item-dedication-table" id="{{ $dedication->user_id }}">
                                                            <td>{{ \App\Helpers\DateTimeHelper::formatDateJapan($dedication->date) }}</td>
                                                            <td>{{ $dedication->item }}</td>
                                                            <td class="content-dedication">{{ $dedication->content }}</td>
                                                            <td class="form-checkbox-custom-dedication">
                                                                <div class="input-form-checkbox text-center">
                                                                    <input class="input-checkbox-custom input-member-check"
                                                                           type="checkbox"
                                                                           name="is_member_check"
                                                                           value="1"
                                                                           data-label="id_check_member"
                                                                           data-id="{{ $dedication->id }}"
                                                                           data-user_id="{{ $dedication->user_id }}"
                                                                           @if($dedication->is_member_check) checked @endif
                                                                    >
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="show-sp">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{ trans('project.dedication.desc') }}</th>
                                                    <th scope="col">{{ trans('project.dedication.member_check_sp') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($project->dedications as $dedication)
                                                    <tr class="item-dedication item-dedication-table" id="{{ $dedication->user_id }}">
                                                        <td>
                                                            <div>{{ \App\Helpers\DateTimeHelper::formatDateJapan($dedication->date) }}</div>
                                                            <div>{{ $dedication->desc }}</div>
                                                            <div class="content-dedication">{{ $dedication->content }}</div>
                                                        </td>
                                                        <td class="form-checkbox-custom-dedication">
                                                            <div class="input-form-checkbox text-center">
                                                                <input class="input-checkbox-custom input-member-check"
                                                                       type="checkbox"
                                                                       name="is_member_check"
                                                                       value="1"
                                                                       data-label="id_check_member"
                                                                       data-id="{{ $dedication->id }}"
                                                                       data-user_id="{{ $dedication->user_id }}"
                                                                       @if($dedication->is_member_check) checked @endif
                                                                >
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="no-data">
                                <img src="{{ asset('assets/img/empty-profit.svg') }}" alt="">
                                <div>{{ trans('common.no_data') }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="form-detail-founder">
                        <div class="title-member-list">{{ trans('project.dedication.title_member') }}</div>
                        @if(count($project->contracts))
                            <div class="mt-4">
                                <a href="{{ asset('/storage/contracts/'. $project->contracts[0]->name) }}" download="{{ $project->contracts[0]->origin_name }}">
                                    {{ $project->contracts[0]->origin_name }}
                                </a>
                            </div>
                        @else
                            <div class="no-data">
                                <img src="{{ asset('assets/img/empty-profit.svg') }}" alt="">
                                <div>{{ trans('common.no_data') }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if (($project->status !== \App\Models\Project::STATUS_END) && ($project->user->status === \App\Models\User::STATUS_ACTIVATED))
                <div class="modal fade" id="modalDetailMember" tabindex="-1" role="dialog" aria-labelledby="modalDetailMemberLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="modal-title" id="modalRejectLabel">{{ trans('project.detail_member_title') }}</span>
                                <button id="close-button-cost" type="button" data-dismiss="modal" class="close" aria-label="Close">
                                    <img src="{{ asset('assets/icon/close-modal.svg') }}" alt="">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex">
                                    <div>
                                        <img class="member-detail-avatar" src="{{ asset('assets/img/icon_user.svg') }}" alt="">
                                    </div>
                                    <div>
                                        <div class="d-flex">
                                            <span class="member-detail-name"></span>
                                            <span class="member-detail-name-kana"></span>
                                        </div>
                                        <div class="d-flex">
                                            <div class="member-detail-info">
                                                <img src="{{ asset('assets/img/icon_email.svg') }}" alt="">
                                                <span class="member-detail-email"></span>
                                            </div>
                                            <div class="member-detail-info">
                                                <img src="{{ asset('assets/img/icon_phone.svg') }}" alt="">
                                                <span class="member-detail-phone"></span>
                                            </div>
                                            <div class="member-detail-info">
                                                <img src="{{ asset('assets/img/icon_address.svg') }}" alt="">
                                                <span class="member-detail-address"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="member-detail-desc"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalRecruiting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{ route('user.project.recruiting', $project->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <span class="modal-title" id="exampleModalLabel">{{ trans('project.member_interview') }}</span>
                                </div>
                                <div class="modal-body">
                                    {{ trans('project.member_interview_confirm') }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-success" data-dismiss="modal">{{ trans('common.button.close') }}</button>
                                    <button type="submit" class="btn btn-success">{{ trans('common.button.confirmation') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @include('user.project.form_cost')
                @include('user.project.form_turnover')
                @include('user.project.form_dedication')
            @endif
        </div>
    </div>
    @include('user.project.form')
</div>
@endsection

@push('script')
<script id="defaultRow" type="text/template">
    @include('user.project.table_item_cost', ['dataInput' => [
        'id' => '',
        'data-id' => 'new',
        'project_id' => $project->id,
        'date' => \Carbon\Carbon::now()->isoFormat('Y年MM月DD日'),
        'quantity' => '',
        'name' => '',
        'unit_price' => '',
        'total' => '',
    ]])
</script>
<script id="defaultRowCostSp" type="text/template">
    @include('user.project.table_item_cost_sp', ['dataInput' => [
        'id' => '',
        'data-id' => 'new',
        'project_id' => $project->id,
        'date' => \Carbon\Carbon::now()->isoFormat('Y年MM月DD日'),
        'quantity' => '',
        'name' => '',
        'unit_price' => '',
        'total' => '',
    ]])
</script>
<script id="defaultRowTurnover" type="text/template">
    @include('user.project.table_item_turnover', ['dataInput' => [
        'id' => '',
        'data-id' => 'new',
        'project_id' => $project->id,
        'date' => \Carbon\Carbon::now()->isoFormat('Y年MM月DD日'),
        'quantity' => '',
        'name' => '',
        'unit_price' => '',
        'total' => '',
    ]])
</script>
<script id="defaultRowTurnoverSp" type="text/template">
    @include('user.project.table_item_turnover_sp', ['dataInput' => [
        'id' => '',
        'data-id' => 'new',
        'project_id' => $project->id,
        'date' => \Carbon\Carbon::now()->isoFormat('Y年MM月DD日'),
        'quantity' => '',
        'name' => '',
        'unit_price' => '',
        'total' => '',
    ]])
</script>
<script id="defaultRowDedication" type="text/template">
    @include('user.project.table_item_dedication', ['dataInput' => [
        'id' => '',
        'data-id' => 'new',
        'project_id' => $project->id,
        'date' => \Carbon\Carbon::now()->isoFormat('Y年MM月DD日'),
        'item' => '',
        'content' => '',
        'is_member_check' => 0,
        'is_founder_check' => 0,
    ]])
</script>
<script id="defaultRowDedicationSp" type="text/template">
    @include('user.project.table_item_dedication_sp', ['dataInput' => [
        'id' => '',
        'data-id' => 'new',
        'project_id' => $project->id,
        'date' => \Carbon\Carbon::now()->isoFormat('Y年MM月DD日'),
        'item' => '',
        'content' => '',
        'is_member_check' => 0,
        'is_founder_check' => 0,
    ]])
</script>
<script>
    $(document).ready(function () {
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');

        $('.nav-tabs a').click(function (e) {
            $(this).tab('show');
        });
        $('.nav-tabs a').click(function () {
            location.hash = $(this).attr('href');
        })

        $('.detail-product-founder').on('keydown', "input[type=number]", function(event) {
            if (event.ctrlKey) {
                return;
            }
            if (!([46, 8, 37, 38, 39, 40].includes(event.keyCode))) {
                if (!((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode > 95 && event.keyCode < 106))) {
                    event.preventDefault();
                    return;
                }
                if ($(this).val().length >= $(this).attr('maxlength')) {
                    event.preventDefault();
                    return;
                }
            }
        });
        $('.detail-product-founder').on('keydown', "input", function(event) {
            if (event.ctrlKey) {
                return;
            }
            if (!([46, 8, 37, 38, 39, 40].includes(event.keyCode))) {
                if ($(this).val().length >= $(this).attr('maxlength')) {
                    event.preventDefault();
                    return;
                }
            }
        });
        $('.detail-product-founder').on('change', "input[type=number]", function(event) {
            let data = $(this).val()
            if (data.length >= $(this).attr('maxlength')) {
                $(this).val(data.slice(0 , $(this).attr('maxlength')))
                return;
            }
        });

        $('.detail-product-founder').on('click', '.button-active', function(event) {
            let idModal = $(this).attr('data-target')
            let modal = $(`${idModal}`)
            modal.find('[data-id=new]').remove()
            modal.find('.show-detail').css('display', 'block')
            modal.find('.show-edit').css('display', 'none')
        });

        $('.btn-approval').on('click', function() {
		    let user = $(this).data().user
		    $.ajax({
			    url : "{{ route('user.project.project-user.update', $project->id) }}",
			    type : "post",
			    data : {
				    "_token": "{{ csrf_token() }}",
				    project_user_id: user,
				    status: {{ \App\Models\ProjectUser::STATUS_WAITING_INTERVIEW }}
			    },
			    success : function (result){
				    if (result.status) {
					    $(`.project-user-${user}`).remove()
					    let html = `<div class="d-inline-block"><div class="member-item" data-toggle="modal" data-target="#modalDetailMember" data-user="${result.data.id}">
                                                <img class="member-image" src="${result.data.avatar ? result.data.avatar : '{{ asset('assets/img/icon_user.svg') }}'}" alt="">
                                                <div class="member-text">
                                                    <span class="member-name">${result.data.first_name + ' ' + result.data.last_name}</span>
                                                    <span class="member-position">{{ trans('project.position.member') }}</span>
                                                </div>
                                            </div></div>`
					    $('#member-item-list').append(html)
					    $('.button-interview').removeAttr('disabled')
					    $('.button-interview').attr('data-toggle', 'modal')
					    $('.button-interview').attr('data-target', '#modalRecruiting')
					    toastr.success(result.message);
				    } else {
					    toastr.error(result.message);
				    }
			    }
		    });
	    });
	    $('.btn-reject').on('click', function() {
		    $('#btn-reject-confirm').val($(this).data().user)
	    });
	    $('.btn-reject-confirm').on('click', function() {
		    let userId = $('#btn-reject-confirm').val()
		    $.ajax({
			    url : "{{ route('user.project.project-user.delete', $project->id) }}",
			    type : "post",
			    data : {
				    "_token": "{{ csrf_token() }}",
				    project_user_id: userId,
			    },
			    success : function (result){
				    if (!(result.project_user_id)) {
					    $(`.project-user-${userId}`).remove()
					    toastr.success(result.message);
				    } else {
					    toastr.error(result.message);
				    }
			    }
		    });
	    });
        $(document).on('click', '.input-date', function(){
            $(this).datepicker({
                dateFormat: "yy年mm月dd日"
            }).focus();
            $(this).removeClass('input-date');
        });
        $('.member-item-list').on('click', '.member-item',function () {
            $.ajax({
                url : "{{ route('user.project.project-user.detail', $project->id) }}",
                type : "get",
                data : {user_id: $(this).data().user},
                success : function (result){
                    if (result.status) {
                        $('.member-detail-avatar').attr('src', result.data.avatar ? result.data.avatar : '{{ asset('assets/img/icon_user.svg') }}')
                        $('.member-detail-name').text(`${result.data.first_name} ${result.data.last_name}`)
                        $('.member-detail-name-kana').text(' (' + result.data.first_name_furigana + ' ' + result.data.last_name_furigana + ') ')
                        $('.member-detail-email').text(result.data.email)
                        $('.member-detail-phone').text(result.data.phone_number)
                        $('.member-detail-address').text(result.data.full_address)
                        $('.member-detail-desc').html(`${result.data.desc !== null ? result.data.desc : ''}`)
                    } else {
                        toastr.error(result.message);
                    }
                }
            });
        })
        const form = $('.recruitment-form');
        const btn = $('.link');
        const span = $('.close');

        btn.click(function () {
            form.show();
            event.preventDefault();
        });
        span.click(function () {
            form.hide();
        });
        $(window).on('click', function (e) {
            if ($(e.target).is('.recruitment-form')) {
                form.hide();
            }
        });
        $('#modalRecruiting').on('click', '.btn-success', function () {
            $(this).attr('disabled', 'disabled')
            $(this).parent().parent().submit()
        })
        $('.image-close-banner-success').on('click', function () {
            $(this).parent().parent().hide()
        })

        $('.banner-total-sale').on('click', '.btn', function () {
            $('.show-disabled').css('display', 'block')
            $(this).parent().parent().parent().submit()
        })
        $('#modalDedication').on('click', '.input-founder-check', function (evt) {
            let user_id = $(this).data().user_id
            let checked = $(this).is(':checked')
            let formData = $(this).parent().parent().parent()
            $.ajax({
                url : "{{ route('user.project.update.dedication-founder', $project->id) }}",
                type : "post",
                data : {
                    id: $(this).data().id,
                    "_token": "{{ csrf_token() }}",
                    is_founder_check: checked ? 1 : 0
                },
                success : function (result){
                    if (result.status) {
                        toastr.success(result.message);
                        if (checked) {
                            formData.find('.form-data-founder-check').html('<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">')
                        }
                        getDataDedication(user_id)
                    } else {
                        toastr.error(result.message);
                    }
                }
            });
        })
        @if($isFounder)
            $('#change-user-dedication').on('change', function() {
                getDataDedication(this.value)
            });
            getDataDedication({{ count($project->projectUserApprove) ? $project->projectUserApprove->first()->user_id : '' }})
            function getDataDedication(user_id) {
                $.ajax({
                    url : "{{ route('user.project.dedication.list', $project->id) }}",
                    type : "get",
                    data : { user_id: user_id },
                    success : function (result){
                        if (result.status) {
                            let htmlPc = `<div class="show-pc"><table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ trans('project.dedication.date') }}</th>
                                                <th scope="col">{{ trans('project.dedication.item') }}</th>
                                                <th scope="col">{{ trans('project.dedication.desc') }}</th>
                                                <th class="text-center" scope="col">{{ trans('project.dedication.member_check') }}</th>
                                                <th class="text-center" scope="col">{{ trans('project.dedication.founder_check') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>`
                            let htmlSp = `<div class="show-sp"><table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ trans('project.dedication.desc') }}</th>
                                                <th scope="col">{{ trans('project.dedication.member_check_sp') }}</th>
                                                <th scope="col">{{ trans('project.dedication.founder_check_sp') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>`
                            if (result.data.length) {
                                result.data.forEach((dedication) => {
                                    htmlPc += ` <tr class="item-dedication item-dedication-table" id="${dedication.user_id}">
                                                    <td>${dedication.date}</td>
                                                    <td>${dedication.item || ''}</td>
                                                    <td class="content-dedication">${dedication.content || ''}</td>
                                                    <td>${dedication.is_member_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}</td>
                                                    <td>${dedication.is_founder_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}</td>
                                </tr>`
                                    htmlSp += ` <tr class="item-dedication item-dedication-table" id="${dedication.user_id}">
                                                    <td>
                                                        <div>${dedication.date}</div>
                                                        <div>${dedication.item || ''}</div>
                                                        <div class="content-dedication">${dedication.content || ''}</div>
                                                    </td>
                                                    <td>${dedication.is_member_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}</td>
                                                    <td>${dedication.is_founder_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}</td>
                                </tr>`
                                })
                                htmlPc += `  </tbody></table></div>`
                                htmlSp += `  </tbody></table></div>`
                            } else {
                                htmlPc = `<div class="no-data">
                                    <img src="{{ asset('assets/img/empty-profit.svg') }}" alt="">
                                    <div>{{ trans('common.no_data') }}</div>
                                </div>`
                                htmlSp = ``
                            }
                            $('#dedication-table-filter').html(htmlPc + htmlSp)
                        } else {
                            toastr.error(result.message);
                        }
                    }
                });
            }
        @else
            $('.input-member-check').click(function (evt) {
                $.ajax({
                    url : "{{ route('user.project.update.dedication-member', $project->id) }}",
                    type : "post",
                    data : {
                        id: $(this).data().id,
                        "_token": "{{ csrf_token() }}",
                        is_member_check: $(this).is(':checked') ? 1 : 0
                    },
                    success : function (result){
                        if (result.status) {
                            toastr.success(result.message);
                        } else {
                            toastr.error(result.message);
                        }
                    }
                });
            })
        @endif

        $('#change-user-dedication-form').on('change', function() {
            getDataDedicationForm(this.value)
        });
        $('.button-open-modal-dedication').click(function() {
            getDataDedicationForm($('#change-user-dedication-form').val())
        });
        function getDataDedicationForm(user_id) {
            $.ajax({
                url : "{{ route('user.project.dedication.list', $project->id) }}",
                type : "get",
                data : { user_id: user_id },
                success : function (result){
                    if (result.status) {
                        let html = ''
                        let htmlSp = ''
                        if (result.data.length) {
                            result.data.forEach((dedication) => {
                                html += `
                                    <tr class="item-dedication" data-id="${dedication.id}">
                                    @csrf
                                <input type="hidden" value="${dedication.id}" name="id">
                                        <input type="hidden" value="${dedication.project_id}" name="project_id">
                                        <td class="table-edit-dedication">
                                            <div>
                                                <input class="form-control show-edit input-date" readonly value="${dedication.date}" type="text" name="date" />
                                                <span class="show-detail form-data-date">${dedication.date}</span>
                                            </div>
                                        </td>
                                        <td class="table-edit-dedication">
                                            <div>
                                                <input class="show-edit form-control" maxlength="16" value="${dedication.item || ''}" type="text" name="item" />
                                                <span class="show-detail form-data-item">${dedication.item || ''}</span>
                                            </div>
                                        </td>
                                        <td class="table-edit-dedication">
                                            <div>
                                                <input class="show-edit form-control" maxlength="255" value="${dedication.content || ''}" type="text" name="content">
                                                <span class="show-detail form-data-content">${dedication.content || ''}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-data-member-check">
                                                    ${dedication.is_member_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class=" d-flex justify-content-center">
                                                <div class="show-detail form-checkbox-custom-dedication">
                                                    <div class="input-form-checkbox text-center">
                                                        <input class="input-checkbox-custom input-founder-check"
                                                            type="checkbox"
                                                            name="is_member_check"
                                                            value="1"
                                                            data-label="id_check_member"
                                                            data-id="${dedication.id}"
                                                            data-user_id="${dedication.user_id}"
                                                            ${dedication.is_founder_check ? 'checked' : ''}
                                                        >
                                                    </div>
                                                </div>
                                                <div class="show-edit form-data-founder-check">
                                                    ${dedication.is_founder_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <img class="button-edit-dedication show-detail" src="{{ asset('assets/img/icon_edit.svg') }}" alt="">
                                                <img class="button-delete-dedication show-detail" src="{{ asset('assets/img/icon_delete.svg') }}" alt="" data-toggle="modal" data-target="#modalDedicationDelete">
                                                <img class="button-save-dedication show-edit" src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                                                <img class="button-cancel-dedication show-edit" src="{{ asset('assets/img/icon_cancel.svg') }}" alt="">
                                            </div>
                                        </td>
                                    </tr>`
	                            htmlSp += `
                                    <div class="item-dedication-sp form-content-modal" data-id="${dedication.id}">
                                    @csrf
                                        <input type="hidden" value="${dedication.id}" name="id">
                                        <input type="hidden" value="${dedication.project_id}" name="project_id">
                                        <div class="d-flex justify-content-between table-edit-cost-sp">
                                            <div class="d-flex">
                                                <span class="text-bold">{{ trans('project.dedication.date') }}:</span>
                                                <div>
                                                    <input class="form-control show-edit input-date" readonly value="${dedication.date}" type="text" name="date" />
                                                    <span class="show-detail form-data-date">${dedication.date}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between button-action-img">
                                                <img class="button-edit-dedication show-detail" src="{{ asset('assets/img/icon_edit.svg') }}" alt="">
                                                <img class="button-delete-dedication show-detail" src="{{ asset('assets/img/icon_delete.svg') }}" alt="" data-toggle="modal" data-target="#modalDedicationDelete">
                                                <img class="button-save-dedication show-edit" src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                                                <img class="button-cancel-dedication show-edit" src="{{ asset('assets/img/icon_cancel.svg') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="d-flex table-edit-cost-sp">
                                            <span class="text-bold">{{ trans('project.dedication.item') }}:</span>
                                            <div>
                                                <input class="show-edit form-control" maxlength="16" value="${dedication.item}" type="text" name="item" />
                                                <span class="show-detail form-data-item">${dedication.item}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex table-edit-cost-sp">
                                            <span class="text-bold title-mobile">{{ trans('project.dedication.desc') }}:</span>
                                            <div>
                                                <input class="show-edit form-control" maxlength="255" value="${dedication.content}" type="text" name="content">
                                                <span class="show-detail form-data-content">${dedication.content}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex table-edit-cost-sp">
                                            <span class="text-bold">{{ trans('project.dedication.member_check') }}:</span>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-data-member-check">
                                                    ${dedication.is_member_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex table-edit-cost-sp">
                                            <span class="text-bold">{{ trans('project.dedication.founder_check') }}:</span>
                                            <div class="d-flex justify-content-center">
                                                <div class="show-detail form-checkbox-custom-dedication">
                                                    <div class="input-form-checkbox text-center">
                                                        <input class="input-checkbox-custom input-founder-check"
                                                               type="checkbox"
                                                               name="is_founder_check"
                                                               value="1"
                                                               data-label="is_founder_check"
                                                               data-id="${dedication.id}"
                                                               data-user_id="${dedication.user_id}"
                                                                ${dedication.is_founder_check ? 'checked' : ''}
                                                                    >
                                                        </div>
                                                    </div>
                                                <div class="show-edit form-data-founder-check">
                                                    ${dedication.is_founder_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}
                                                </div>
                                            </div>
                                        </div>
                                    </div>`
                            })
                        }
                        $('#dedication-table-modal-pc').html(html)
                        $('#form-content-dedication').html(htmlSp)
                    } else {
                        toastr.error(result.message);
                    }
                }
            });
        }
        //dedication
        $(document).ready(function () {
            let template = $('#defaultRowDedication').html()
            template += '<\/script>';
            $('#addRowDedication').click(function() {
                $('#dedication-table-modal-pc').append(template);
                let dataItem = $('tr[data-id=new]')
                dataItem.find('.show-detail').css('display', 'none')
                dataItem.find('.show-edit').css('display', 'block')
                dataItem.attr('data-state', 'edit')
            });
            let templateSp = $('#defaultRowDedicationSp').html()
            templateSp += '<\/script>';
            $('#addRowDedicationSp').click(function() {
                $('#form-content-dedication').append(templateSp);
                let dataItem = $('div[data-id=new]')
                dataItem.find('.show-detail').css('display', 'none')
                dataItem.find('.show-edit').css('display', 'block')
                dataItem.attr('data-state', 'edit')
            });
            $('#dedication-table-modal').on('click', '.button-save-dedication',function() {
                let formData = $(this).parent().parent().parent()
                let dataArray = formData.find('input');
                let data = {};
                for(let i=0;i<dataArray.length;i++){
                    data[dataArray[i].name] = dataArray[i].value;
                }
                data.user_id = $('#change-user-dedication-form').val()
                $.ajax({
                    url : "{{ route('user.project.update.dedication', $project->id) }}",
                    type : "post",
                    data : data,
                    success : function (result){
                        if (result.status) {
                            if (data.id === '') {
                                formData.attr('data-id', result.data.id)
                                formData.find('input[name=id]').val(result.data.id)
                            }
                            $('#total-dedication-table').html(result.data.total_dedication)
                            $('#total-dedication').html(result.data.total_dedication)
                            $('#modalDedicationSave').modal('hide')
                            formData.find('.show-detail').css('display', 'block')
                            formData.find('.show-edit').css('display', 'none')
                            formData.find('.form-data-date').html(result.data.date)
                            formData.find('.form-data-item').html(result.data.item)
                            formData.find('.form-data-content').html(result.data.content)
                            formData.find('.input-founder-check').attr('data-id', result.data.id)
                            formData.find('.input-founder-check').attr('data-user_id', result.data.user_id)
                            if (result.data.is_member_check) {
                                formData.find('.form-data-member-check').html('<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">')
                            }
                            if (result.data.is_founder_check) {
                                formData.find('.form-data-founder-check').html('<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">')
                            }
                            getDataDedication($('#change-user-dedication').val())
                            toastr.success(result.message);
                        } else {
                            toastr.error(result.message);
                        }
                    }
                });
            });
            $('#dedication-table-modal').on('click', '.button-delete-dedication',function() {
                let formData = $(this).parent().parent().parent()
                $('#form-dedication-delete-id').val(formData.data().id)
            });
            $('#button-delete-dedication').click(function() {
                let data = {};
                let dataArray = $('#form-delete-dedication').serializeArray();
                for(let i=0;i<dataArray.length;i++){
                    data[dataArray[i].name] = dataArray[i].value;
                }
                $.ajax({
                    url : "{{ route('user.project.delete.dedication', $project->id) }}",
                    type : "delete",
                    data : data,
                    success : function (result){
                        if (result.status) {
                            $('#total-dedication-table').html(result.data.total_dedication)
                            $('#total-dedication').html(result.data.total_dedication)
                            let dataItem = $('#dedication-table-modal').find('tr[data-id='+ data.id +']')
                            dataItem.css('display', 'none')
	                        $('#dedication-table-modal').find('tr[id='+ data.id +']').css('display', 'none')
                            let dataItemSp = $('#dedication-table-modal').find('div[data-id='+ data.id +']')
	                        dataItemSp.css('display', 'none')
	                        getDataDedication(data.user_id)
                        } else {
                            toastr.error(result.message);
                        }
                    }
                });
            });
            $('#modalDedicationDelete').on('hidden.bs.modal', function () {
                $('body').addClass('modal-open')
            });
            $('#modalDedicationSave').on('hidden.bs.modal', function () {
                $('body').addClass('modal-open')
            });
            $('#dedication-table-modal').on('click', '.button-edit-dedication',function() {
                let formData = $(this).parent().parent().parent()
                formData.attr('data-state', 'edit')
                formData.find('.show-detail').css('display', 'none')
                formData.find('.show-edit').css('display', 'block')
                let dataEdit = formData.find('input.show-edit')
                dataEdit.each(function () {
                    let name = $(this).attr('name')
                    let dataHtml = formData.find(`.form-data-${name}`).html()
                    if ($(this).attr('type') === 'number') {
                        dataHtml = dataHtml.split(',').join('')
                    }
                    $(this).val(dataHtml)
                })
            });
            $('#dedication-table-modal').on('click', '.button-cancel-dedication',function() {
                let formData = $(this).parent().parent().parent()
                if (formData.data().id === 'new') {
                    formData.remove()
                } else {
                    formData.removeAttr('data-state')
                    formData.find('.show-detail').css('display', 'block')
                    formData.find('.show-edit').css('display', 'none')
                }
            });
            $('#button-cancel-close').click(function () {
                $('#modalDedicationSave').modal('hide')
            })
        });
    });
    function openModal(id) {
        $('body').addClass('modal-open')
    }
    //costs
    $(document).ready(function () {
        let template = $('#defaultRow').html()
        template += '<\/script>';
        $('#addRowDefault').click(function() {
            $('#button-add-cost').before(template);
            let dataItem = $('tr[data-id=new]')
            dataItem.find('.show-detail').css('display', 'none')
            dataItem.find('.show-edit').css('display', 'block')
            dataItem.attr('data-state', 'edit')
	    });
	    let templateSp = $('#defaultRowCostSp').html()
	    templateSp += '<\/script>';
        $('#addRowCostDefaultSp').click(function() {
            $('#form-content-cost').append(templateSp);
            let dataItem = $('div[data-id=new]')
            dataItem.find('.show-detail').css('display', 'none')
            dataItem.find('.show-edit').css('display', 'block')
            dataItem.attr('data-state', 'edit')
	    });
        $('#cost-table-modal').on('click', '.button-save-cost',function() {
            let formData = $(this).parent().parent().parent()
            let dataArray = formData.find('input');
            let data = {};
            for(let i=0;i<dataArray.length;i++){
                data[dataArray[i].name] = dataArray[i].value;
            }
            $.ajax({
                url : "{{ route('user.project.update.cost', $project->id) }}",
                type : "post",
                data : data,
                success : function (result){
                    if (result.status) {
                        console.log(result.data.total_sale_note)
                        if (data.id === '') {
	                        formData.attr('data-id', result.data.id)
                            formData.find('input[name=id]').val(result.data.id)
                        }
                        $('#total-cost-table').html(result.data.total_cost)
                        $('#total-cost-table-sp').html(result.data.total_cost)
                        $('#total-cost').html(result.data.total_cost)
                        $('#total-turnover').html(result.data.total_turnover)
                        $('#total-sale').html(result.data.total_sale)
                        $('.total-sale-note').html(result.data.total_sale_note)
                        $('#modalCostSave').modal('hide')
                        formData.find('.show-detail').css('display', 'block')
                        formData.find('.show-edit').css('display', 'none')
                        formData.find('.form-data-date').html(result.data.date)
                        formData.find('.form-data-name').html(result.data.name)
                        formData.find('.form-data-quantity').html(result.data.quantity)
                        formData.find('.form-data-unit_price').html(result.data.unit_price)
                        formData.find('.form-data-total').html(result.data.total)
                        toastr.success(result.message);
                    } else {
                        toastr.error(result.message);
                    }
                }
            });
        });
        $('#cost-table-modal').on('click', '.button-delete-cost',function() {
            let formData = $(this).parent().parent().parent()
            $('#form-cost-delete-id').val(formData.data().id)
        });
	    $('#button-delete-cost').click(function() {
            let data = {};
            let dataArray = $('#form-delete-cost').serializeArray();
            for(let i=0;i<dataArray.length;i++){
                data[dataArray[i].name] = dataArray[i].value;
            }
            $.ajax({
                url : "{{ route('user.project.delete.cost', $project->id) }}",
                type : "delete",
                data : data,
                success : function (result){
                    if (result.status) {
	                    $('#total-cost-table').html(result.data.total_cost)
	                    $('#total-cost-table-sp').html(result.data.total_cost)
                        $('#total-cost').html(result.data.total_cost)
                        $('#total-turnover').html(result.data.total_turnover)
                        $('#total-sale').html(result.data.total_sale)
                        $('.total-sale-note').html(result.data.total_sale_note)
                        let dataItem = $('#cost-table-modal').find('tr[data-id='+ data.id +']')
                        dataItem.css('display', 'none')
                        let dataItemSp = $('#cost-table-modal').find('div[data-id='+ data.id +']')
	                    dataItemSp.css('display', 'none')
                    } else {
                        toastr.error(result.message);
                    }
                }
            });
        });
        $('#modalCostDelete').on('hidden.bs.modal', function () {
            $('body').addClass('modal-open')
        });
        $('#modalCostSave').on('hidden.bs.modal', function () {
            $('body').addClass('modal-open')
        });
        $('#cost-table-modal').on('click', '.button-edit-cost',function() {
            let formData = $(this).parent().parent().parent()
            formData.attr('data-state', 'edit')
            formData.find('.show-detail').css('display', 'none')
            formData.find('.show-edit').css('display', 'block')
            let dataEdit = formData.find('input.show-edit')
            dataEdit.each(function () {
                let name = $(this).attr('name')
                let dataHtml = formData.find(`.form-data-${name}`).html()
                if ($(this).attr('type') === 'number') {
                    dataHtml = dataHtml.split(',').join('')
                }
                $(this).val(dataHtml)
            })
        });
        $('#cost-table-modal').on('click', '.button-cancel-cost',function() {
            let formData = $(this).parent().parent().parent()
            if (formData.data().id === 'new') {
                formData.remove()
            } else {
                formData.removeAttr('data-state')
                formData.find('.show-detail').css('display', 'block')
                formData.find('.show-edit').css('display', 'none')
            }
        });
        $('#close-button-cost').click(function (event) {
            if ($('tr[data-state=edit]').length) {
                event.preventDefault()
                $('#modalCostSave').modal('show')
            } else {
                $('#button-form-cost').trigger('click')
            }
        })
        $('#button-cancel-close').click(function () {
            $('#modalCostSave').modal('hide')
        })
    });
    function openModal(id) {
        $('body').addClass('modal-open')
    }
    //turnover
    $(document).ready(function () {
        let template = $('#defaultRowTurnover').html()
        template += '<\/script>';
        $('#addRowTurnover').click(function() {
            $('#button-add-turnover').before(template);
            let dataItem = $('tr[data-id=new]')
            dataItem.find('.show-detail').css('display', 'none')
            dataItem.find('.show-edit').css('display', 'block')
            dataItem.attr('data-state', 'edit')
        });
	    let templateSp = $('#defaultRowTurnoverSp').html()
	    templateSp += '<\/script>';
	    $('#addRowTurnoverSp').click(function() {
		    $('#form-content-turnover').append(templateSp);
		    let dataItem = $('div[data-id=new]')
		    dataItem.find('.show-detail').css('display', 'none')
		    dataItem.find('.show-edit').css('display', 'block')
		    dataItem.attr('data-state', 'edit')
	    });
        $('#turnover-table-modal').on('click', '.button-save-turnover',function() {
            let formData = $(this).parent().parent().parent()
            let dataArray = formData.find('input');
            let data = {};
            for(let i=0;i<dataArray.length;i++){
                data[dataArray[i].name] = dataArray[i].value;
            }
            $.ajax({
                url : "{{ route('user.project.update.turnover', $project->id) }}",
                type : "post",
                data : data,
                success : function (result){
                    if (result.status) {
                        if (data.id === '') {
	                        formData.attr('data-id', result.data.id)
	                        formData.find('input[name=id]').val(result.data.id)
                        }
                        $('#total-turnover-table').html(result.data.total_turnover)
                        $('#total-turnover-table-sp').html(result.data.total_turnover)
                        $('#total-cost').html(result.data.total_cost)
                        $('#total-turnover').html(result.data.total_turnover)
                        $('#total-sale').html(result.data.total_sale)
                        $('.total-sale-note').html(result.data.total_sale_note)
                        $('#modalTurnoverSave').modal('hide')
                        formData.find('.show-detail').css('display', 'block')
                        formData.find('.show-edit').css('display', 'none')
                        formData.find('.form-data-date').html(result.data.date)
                        formData.find('.form-data-name').html(result.data.name)
                        formData.find('.form-data-quantity').html(result.data.quantity)
                        formData.find('.form-data-unit_price').html(result.data.unit_price)
                        formData.find('.form-data-total').html(result.data.total)
                        toastr.success(result.message);
                    } else {
                        toastr.error(result.message);
                    }
                }
            });
        });
        $('#turnover-table-modal').on('click', '.button-delete-turnover',function() {
            let formData = $(this).parent().parent().parent()
            $('#form-turnover-delete-id').val(formData.data().id)
        });
        $('#button-delete-turnover').click(function() {
            let data = {};
            let dataArray = $('#form-delete-turnover').serializeArray();
            for(let i=0;i<dataArray.length;i++){
                data[dataArray[i].name] = dataArray[i].value;
            }
            $.ajax({
                url : "{{ route('user.project.delete.turnover', $project->id) }}",
                type : "delete",
                data : data,
                success : function (result){
                    if (result.status) {
                        $('#total-turnover-table').html(result.data.total_turnover)
                        $('#total-turnover-table-sp').html(result.data.total_turnover)
                        $('#total-cost').html(result.data.total_cost)
                        $('#total-turnover').html(result.data.total_turnover)
                        $('#total-sale').html(result.data.total_sale)
                        $('.total-sale-note').html(result.data.total_sale_note)
                        let dataItem = $('#turnover-table-modal').find('tr[data-id='+ data.id +']')
                        dataItem.css('display', 'none')
                        let dataItemSp = $('#turnover-table-modal').find('div[data-id='+ data.id +']')
	                    dataItemSp.css('display', 'none')
                    } else {
                        toastr.error(result.message);
                    }
                }
            });
        });
        $('#modalTurnoverDelete').on('hidden.bs.modal', function () {
            $('body').addClass('modal-open')
        });
        $('#modalTurnoverSave').on('hidden.bs.modal', function () {
            $('body').addClass('modal-open')
        });
        $('#turnover-table-modal').on('click', '.button-edit-turnover',function() {
            let formData = $(this).parent().parent().parent()
            formData.attr('data-state', 'edit')
            formData.find('.show-detail').css('display', 'none')
            formData.find('.show-edit').css('display', 'block')
            let dataEdit = formData.find('input.show-edit')
            dataEdit.each(function () {
                let name = $(this).attr('name')
                let dataHtml = formData.find(`.form-data-${name}`).html()
                if ($(this).attr('type') === 'number') {
                    dataHtml = dataHtml.split(',').join('')
                }
                $(this).val(dataHtml)
            })
        });
        $('#turnover-table-modal').on('click', '.button-cancel-turnover',function() {
            let formData = $(this).parent().parent().parent()
            if (formData.data().id === 'new') {
                formData.remove()
            } else {
                formData.removeAttr('data-state')
                formData.find('.show-detail').css('display', 'block')
                formData.find('.show-edit').css('display', 'none')
            }
        });
        $('#button-cancel-close').click(function () {
            $('#modalTurnoverSave').modal('hide')
        })
    });

</script>
@endpush
