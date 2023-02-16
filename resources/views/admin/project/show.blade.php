@extends('admin.layouts.index')

@section('title', $project->title)

@section('content')
    <div class="col-md pt-3">
        <div class="nav-tabs-custom project-show">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a id="info-tab" class="nav-link active" href="#info" data-toggle="tab" aria-controls="info" aria-selected="true">{{ trans('project.system.project_info') }}</a>
                </li>
                <li class="nav-item">
                    <a id="detail-tab" class="nav-link" href="#detail" data-toggle="tab" aria-controls="detail" aria-selected="false">{{ trans('project.system.project_detail') }}</a>
                </li>
            </ul>
            <div class="form-status">
                    <div class="d-flex">
                        @if($project->status != \App\Models\Project::STATUS_PENDING)
                                <button type="button" class="btn btn-status" data-toggle="modal" data-target="#modalStatusRecruiting">
                                    <span>{{ \App\Models\Project::showChangeBackListStatus()[\App\Models\Project::STATUS_RECRUITING] }}</span>
                                </button>
                                <div class="modal fade" id="modalStatusRecruiting" tabindex="-1" role="dialog" aria-labelledby="modalStatusRecruitingLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <span class="modal-title" id="modalStatusRecruitingLabel">{{ trans('project.project_status_title') }}</span>
                                            </div>
                                            <div class="modal-body">
                                                {{ trans('project.back_project_status_content') }}
                                            </div>
                                            <div class="modal-footer">
                                                <form id="change-status" class="mr-2" action="{{ route('admin.projects.change.status.recruiting', $project) }}" method="post">
                                                @csrf
                                                    <input type="hidden" name="tab_active" class="tab-active-input">
                                                    <button type="button" class="btn btn-outline-success" data-dismiss="modal">{{ trans('admin.modal.no') }}</button>
                                                    <button type="submit" class="btn btn-background-project" data-user="">{{ trans('common.button.yes') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
                        @if($project->status !== \App\Models\Project::STATUS_END)
                            <button
                                type="button"
                                class="btn btn-project-status"
                                id="btn-project-status"
                                @if($isProjectUserContract)
                                    disabled="disabled" title="{{ trans('project.tooltip') }}" data-toggle="tooltip" data-placement="bottom"
                                @else
                                    data-toggle="modal"
                                @endif
                                data-target="#modalUpdateStatus"
                            >
                                <span>{{ \App\Models\Project::showChangeListStatus()[$project->status] }}</span>
                            </button>
                            <div class="modal fade" id="modalUpdateStatus" tabindex="-1" role="dialog" aria-labelledby="modalUpdateStatusLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="modal-title" id="modalUpdateStatusLabel">{{ trans('project.project_status_title') }}</span>
                                        </div>
                                        <div class="modal-body">
                                            {{ trans('project.project_status')[$project->status] }}
                                        </div>
                                        <div class="modal-footer">
                                            <form id="change-status" action="{{ route('admin.projects.change.status', $project) }}" method="post">
                                            @csrf
                                                <input type="hidden" data="{{ $project->status }}">
                                                <input type="hidden" name="tab_active" class="tab-active-input">
                                                <button type="button" class="btn btn-outline-success" data-dismiss="modal">{{ trans('admin.modal.no') }}</button>
                                                <button type="submit" class="btn btn-background-project" data-user="">{{ trans('common.button.yes') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                <div class="show-status">
                    <span class="status-{{ $project->status }}">{{ \App\Models\Project::listStatus()[$project->status] }}</span>
                </div>
            </div>

            <div class="tab-content mb-3">
                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                    <div class="container-fluid bg-white border-top-0 pt-0 pb-0">
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="project-tool">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('admin.projects.index') }}"><i class="fa-solid fa-circle-arrow-left back-icon"></i></a>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="d-inline-block">
                                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-center align-middle detail"><i class="fa-solid fa-pen-to-square"></i></a>

                                            <a class="text-center align-middle delete delete-project" data-toggle="modal" data-target="#delete-{{ $project->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>

                                            @include('admin.project.form_delete_project')
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body position-relative pt-0 pb-0">
                                        <div class="project-title">
                                            <h3 class="title">
                                                <span class="text-title">{{ $project->title}}</span>
                                                @if (\App\Helpers\ProjectHelper::isNew($project))
                                                    <div class="div-new">
                                                        <span class="new">{{ trans('project.system.new') }}</span>
                                                    </div>
                                                @endif
                                            </h3>
                                            <div class="d-flex">
                                                <p class="m-0 mr-2 category">{{ trans('project.attribute.industry') }}:</p>
                                                <p class="m-0 type">{{ $project->industry }}</p>
                                            </div>
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
                                                             class="show-image {{ $project ? 'show-default-image' : '' }}"
                                                             src="{{ $project ? App\Helpers\FileHelper::getFullUrl($project->banner->url) : '' }}" alt="your image" />
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap m-0 detail-table table-project-info"
                                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <tbody>
                                            <tr>
                                                <th>{{ trans('project.system.info') }}</th>
                                                <td class="align-middle">
                                                    <div class="icon">
                                                        <div class="w-100">
                                                            <div class="row-info">
                                                                <div class="project-info-line short">
                                                                    <img src="{{ asset("assets/img/project/people-icon.svg") }}" alt="cover" class="project-icon">
                                                                    <div>
                                                                        <div class="project-info-title">{{ trans('project.attribute.recruitment_quantity') }}: </div>
                                                                        <div class="project-info-content">
                                                                            {{ $project->recruitment_quantity_min . trans('admin.common.people') }}〜{{ $project->recruitment_quantity_max . trans('admin.common.people') }}
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
                                                                <div class="row-info location">
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
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('project.attribute.work_content') }}</th>
                                                <td class="align-middle"><span>{!! \App\Helpers\StringHelper::formatContent($project->work_content) !!}</span></td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('project.attribute.work_desc') }}</th>
                                                <td class="align-middle"><span>{!! \App\Helpers\StringHelper::formatContent($project->work_desc) !!}</span></td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('project.attribute.special') }}</th>
                                                <td class="align-middle"><span>{!! \App\Helpers\StringHelper::formatContent($project->special) !!}</span></td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('project.attribute.business_development_incorporation') }}</th>
                                                <td class="align-middle"><span>{!! \App\Helpers\StringHelper::formatContent($project->business_development_incorporation) !!}</span></td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('project.attribute.employment_incorporation') }}</th>
                                                <td class="align-middle"><span>{!! \App\Helpers\StringHelper::formatContent($project->employment_incorporation) !!}</span></td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('project.system.available_date') }}</th>
                                                <td>
                                                    @foreach($project->availableDateEdit as $key => $date)
                                                        <div>
                                                            <span class="mr-2">{{ trans('project.system.available_date_option') }} {{ $key + 1 }} {{ trans('project.system.available_date_option_2') }}</span>
                                                            <span class="mr-2">{{ $date->date }}</span>
                                                            <span>{{ $date->startTime . ' 〜 ' . $date->endTime }}</span>
                                                        </div>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                    <div class="container-fluid bg-white border-top-0 mt-0 mb-0 pt-0">
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="project-tool">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('admin.projects.index') }}"><i class="fa-solid fa-circle-arrow-left back-icon"></i></a>
                                    </div>
                                </div>

                                <div class="page-title-box d-flex justify-content-between align-items-center project-total end-date">
                                    <div class="d-flex align-items-center">
                                        <span>{{ trans('project.system.end_date') }}</span>
                                        <span id="end-date-show">{{ $endDateEditFormat ?? trans('project.system.empty') }}</span>
                                        <div id="input-date" class="d-none">
                                            <form id="update-date-form" action="{{ route('admin.projects.update.end.date', $project) }}" method="post">
                                                @csrf
                                                <div class="d-flex" style="height: 37px">
                                                    <div class="mr-2">
                                                        <input class="form-control input-date"
                                                               type="text" lang="ja" name="date"
                                                               value="{{ $endDate }}"
                                                               min="{{ $startDate }}"
                                                               readonly='true'/>
                                                    </div>

                                                    <div class="d-flex">
                                                        <button id="no-change" type="button" class="btn btn-outline-success mr-2" style="min-width: 50px">{{ trans('admin.modal.no') }}</button>
                                                        <button id="update-date-submit" type="submit" class="btn btn-danger">{{ trans('admin.modal.yes') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                            @error('date')
                                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        @if ($project->status == \App\Models\Project::STATUS_ACTIVE)
                                            <button class="btn project-date">
                                                <span>{{ trans('project.system.update_date_btn') }}</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body position-relative">
                                        <div class="page-title-box d-flex align-items-center project-total">
                                            <span>{{ trans('project.list_member.title') }}</span>
                                        </div>
                                        <div class="overflow-auto">
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap m-0 overflow-auto table-user"
                                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th class="text-center align-middle">{{ trans('project.list_member.name') }}</th>
                                                    <th class="text-center align-middle">{{ trans('project.list_member.role') }}</th>
                                                    <th class="text-center align-middle">{{ trans('project.list_member.email') }}</th>
                                                    <th class="text-center align-middle">{{ trans('project.list_member.phone') }}</th>
                                                    <th class="text-center align-middle user-address">{{ trans('project.list_member.address') }}</th>
                                                    <th class="text-center align-middle">{{ trans('project.list_member.participation_status') }}</th>
                                                    <th class="text-center align-middle"></th>
                                                </tr>
                                                </thead>
                                                <tbody id="member-item-list">
                                                <tr>
                                                    <td class="align-middle">
                                                        <img src="{{ App\Helpers\FileHelper::getFullUrl($project->user->avatar) ?? asset("assets/img/default.png")}}" class="avatar">
                                                        <span class="align-middle">{{ $project->user->getFullNameAttribute() }}</span>
                                                    </td>
                                                    <td class="text-center align-middle text-title">{{ trans('project.list_member.founder') }}</td>
                                                    <td class="align-middle text-title">{{ $project->user->email }}</td>
                                                    <td class="text-center align-middle text-title">{{ $project->user->phone_number }}</td>
                                                    <td class="align-middle">
                                                        <span class="project-info-content">{{ $project->user->address }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($project->user->status !== \App\Models\User::STATUS_ACTIVATED)
                                                            <select name="participation_status" class="select-input-status form-control" disabled>
                                                                <option value="">{{ trans('project.participation_status.ban') }}</option>
                                                            </select>
                                                        @else
                                                            <select name="participation_status" class="select-input-status form-control" disabled>
                                                                <option value="{{ \App\Models\ProjectUser::PARTICIPATION_STATUS_ACTIVE }}">{{ trans('project.participation_status.in_action') }}</option>
                                                            </select>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center action-wrapper"></td>
                                                </tr>
                                                @if ($projectUsers->count())
                                                    @foreach ($project->projectUserInterview as $projectUser)
                                                        <tr>
                                                            <td class="align-middle">
                                                                <div class=" user-name">
                                                                    <img src="{{ App\Helpers\FileHelper::getFullUrl($projectUser->user->avatar) ?? asset("assets/img/default.png")}}" class="avatar">
                                                                    <div class="align-middle">{{ $projectUser->user->getFullNameAttribute() }}</div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center align-middle text-title">{{ trans('project.list_member.member') }}</td>
                                                            <td class="align-middle text-title">{{ $projectUser->user->email }}</td>
                                                            <td class="text-center align-middle text-title">{{ $projectUser->user->phone_number }}</td>
                                                            <td class="align-middle">
                                                                <span>{{ $projectUser->user->address }}</span>
                                                            </td>
                                                            <td>
                                                                @if ($projectUser->user->status !== \App\Models\User::STATUS_ACTIVATED)
                                                                    <select name="participation_status" class="select-input-status form-control" disabled>
                                                                        <option value="">{{ trans('project.participation_status.ban') }}</option>
                                                                    </select>
                                                                @else
                                                                    <select name="participation_status" class="select-input-status form-control" data-user="{{ $projectUser->id }}">
                                                                        @foreach(\App\Models\ProjectUser::listParticipationStatus() as $key => $item)
                                                                            <option value="{{ $key }}" {{ ($projectUser->participation_status === $key) ? 'selected' : '' }}>{{ $item }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                            </td>
                                                            <td class="align-middle text-center action-wrapper">
                                                                <div class="d-flex justify-content-center align-items-center">
                                                                    <a class="text-center align-middle delete kick-user" data-toggle="modal" data-target="#kick-user-{{ $projectUser->user->id }}">
                                                                        <img src="{{ asset('assets/icon/kick-member.svg') }}">
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            @include('admin.project.form_kick_user')
                                                        </tr>
                                                    @endforeach
                                                    @foreach ($project->projectUserApprove as $projectUser)
                                                        <tr>
                                                            <td class="align-middle">
                                                                <div class=" user-name">
                                                                    <img src="{{ App\Helpers\FileHelper::getFullUrl($projectUser->user->avatar) ?? asset("assets/img/default.png")}}" class="avatar">
                                                                    <div class="align-middle">{{ $projectUser->user->getFullNameAttribute() }}</div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center align-middle text-title">{{ trans('project.list_member.member') }}</td>
                                                            <td class="align-middle text-title">{{ $projectUser->user->email }}</td>
                                                            <td class="text-center align-middle text-title">{{ $projectUser->user->phone_number }}</td>
                                                            <td class="align-middle">
                                                                <span>{{ $projectUser->user->address }}</span>
                                                            </td>
                                                            <td>
                                                                @if ($projectUser->user->status !== \App\Models\User::STATUS_ACTIVATED)
                                                                    <select name="participation_status" class="select-input-status form-control" disabled>
                                                                        <option value="">{{ trans('project.participation_status.ban') }}</option>
                                                                    </select>
                                                                @else
                                                                    <select name="participation_status" class="select-input-status form-control" disabled>
                                                                        <option value="{{ \App\Models\ProjectUser::PARTICIPATION_STATUS_ACTIVE }}">{{ trans('project.participation_status.in_action') }}</option>
                                                                    </select>
                                                                @endif
                                                            </td>
                                                            <td class="align-middle text-center action-wrapper">
                                                                <div class="d-flex justify-content-center align-items-center">
                                                                    <a class="text-center align-middle delete kick-user" data-toggle="modal" data-target="#kick-user-{{ $projectUser->user->id }}">
                                                                        <img src="{{ asset('assets/icon/kick-member.svg') }}">
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            @include('admin.project.form_kick_user')
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                @if ($project->status === \App\Models\Project::STATUS_END)
                                                    @foreach ($project->projectUserEnd as $projectUser)
                                                        <tr>
                                                            <td class="align-middle">
                                                                <div class=" user-name">
                                                                    <img src="{{ App\Helpers\FileHelper::getFullUrl($projectUser->user->avatar) ?? asset("assets/img/default.png")}}" class="avatar">
                                                                    <div class="align-middle">{{ $projectUser->user->getFullNameAttribute() }}</div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center align-middle text-title">{{ trans('project.list_member.member') }}</td>
                                                            <td class="align-middle text-title">{{ $projectUser->user->email }}</td>
                                                            <td class="text-center align-middle text-title">{{ $projectUser->user->phone_number }}</td>
                                                            <td class="align-middle">
                                                                <span>{{ $projectUser->user->address }}</span>
                                                            </td>
                                                            <td>
                                                                @if ($projectUser->user->status !== \App\Models\User::STATUS_ACTIVATED)
                                                                    <select name="participation_status" class="select-input-status form-control" disabled>
                                                                        <option value="">{{ trans('project.participation_status.ban') }}</option>
                                                                    </select>
                                                                @else
                                                                    <select name="participation_status" class="select-input-status form-control" disabled>
                                                                        <option value="{{ \App\Models\ProjectUser::PARTICIPATION_STATUS_ACTIVE }}">{{ trans('project.participation_status.in_action') }}</option>
                                                                    </select>
                                                                @endif
                                                            </td>
                                                            <td class="align-middle text-center action-wrapper">
                                                                <div class="d-flex justify-content-center align-items-center">
                                                                    <a class="text-center align-middle delete kick-user" data-toggle="modal" data-target="#kick-user-{{ $projectUser->user->id }}">
                                                                        <img src="{{ asset('assets/icon/kick-member.svg') }}">
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            @include('admin.project.form_kick_user')
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                @if (($project->status === \App\Models\Project::STATUS_RECRUITING))
                                    <div class="card">
                                        <div class="card-body position-relative form-detail-founder">
                                            <div class="page-title-box d-flex align-items-center project-total">
                                                <span class="title-member-list">{{ trans('project.list_applicants') }}</span>
                                            </div>
                                            <div class="overflow-auto list-applicants-table member-list">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">{{ trans('project.list_member.name') }}</th>
                                                        <th scope="col">{{ trans('project.list_member.email') }}</th>
                                                        <th scope="col">{{ trans('project.list_member.phone') }}</th>
                                                        <th scope="col">{{ trans('project.list_member.address') }}</th>
                                                        <th scope="col">{{ trans('project.list_member.application_status') }}</th>
                                                        <th scope="col">{{ trans('project.list_member.action') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($project->projectUserPending as $projectUser)
                                                        <tr class="project-user-{{ $projectUser->id }}">
                                                            <td class="member-item-list">
                                                                <div class="d-flex table-detail-member member-item" data-toggle="modal" data-target="#modalDetailMember" data-user="{{ $projectUser->user_id }}">
                                                                    <img class="member-image" src="{{ $projectUser->user->avatar ? \App\Helpers\FileHelper::getFullUrl($projectUser->user->avatar) : asset('assets/img/icon_user.svg') }}" alt="">
                                                                    <span>{{ $projectUser->user->full_name }}</span>
                                                                </div>
                                                            </td>
                                                            <td>{{ $projectUser->user->email }}</td>
                                                            <td>{{ $projectUser->user->phone_number }}</td>
                                                            <td>{{ $projectUser->user->address }}</td>
                                                            <td>
                                                                <select name="application_status" class="select-input-application-status form-control" data-user="{{ $projectUser->id }}">
                                                                    @foreach(\App\Models\ProjectUser::listApplicationStatus() as $key => $item)
                                                                        <option value="{{ $key }}" {{ ($projectUser->application_status === $key) ? 'selected' : '' }}>{{ $item }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex button-action">
                                                                    <button type="button" class="btn btn-success btn-approval" data-user="{{ $projectUser->id }}" data-toggle="modal" data-target="#modalApproval">{{ trans('common.button.approval') }}</button>
                                                                    <button type="button" class="btn btn-outline-danger btn-reject" data-user="{{ $projectUser->id }}" data-toggle="modal" data-target="#modalReject">{{ trans('common.button.rejection') }}</button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div>
                                    <div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <span class="modal-title" id="modalRejectLabel">{{ trans('project.reject_title') }}</span>
                                                </div>
                                                <div class="modal-body">
                                                    {{ trans('project.reject_confirm') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.projects.project-user.delete') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="project_user_id" id="btn-reject-confirm">
                                                        <button type="button" class="btn btn-outline-success" data-dismiss="modal">{{ trans('admin.modal.no') }}</button>
                                                        <button type="submit" class="btn btn-danger" data-user="">{{ trans('common.button.yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modalApproval" tabindex="-1" role="dialog" aria-labelledby="modalApprovalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <span class="modal-title" id="modalApprovalLabel">{{ trans('project.approval_title') }}</span>
                                                </div>
                                                <div class="modal-body">
                                                    {{ trans('project.approval_confirm') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.projects.project-user.update') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="project_user_id" id="btn-approval-confirm">
                                                        <input type="hidden" name="status" value="{{ \App\Models\ProjectUser::STATUS_WAITING_INTERVIEW }}">
                                                        <button type="button" class="btn btn-outline-success" data-dismiss="modal">{{ trans('admin.modal.no') }}</button>
                                                        <button type="submit" class="btn btn-background-project" data-user="">{{ trans('common.button.yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (($project->status === \App\Models\Project::STATUS_ACTIVE) || $project->status === \App\Models\Project::STATUS_END)
                                    <div class="card">
                                        <div class="card-body position-relative">
                                            <div class="page-title-box d-flex align-items-center project-total">
                                                <span>{{ trans('project.profit.title') }}</span>
                                            </div>
                                            @if($project->target_amount != 0)
                                                <h6 class="contract-period-reach">{{ trans('project.profit.contract_period_reach', ['target_amount' => \App\Helpers\StringHelper::formatMoney($project->target_amount)]) }}</h6>
                                            @endif
                                            <div class="overflow-auto">
                                                <table id="datatable" class="table table-bordered dt-responsive nowrap m-0"
                                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center align-middle">{{ trans('project.profit.turnover') }}</th>
                                                        <th class="text-center align-middle">{{ trans('project.profit.cost') }}</th>
                                                        <th class="text-center align-middle">{{ trans('project.profit.profit') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center align-middle text-title">
                                                            <div class="d-flex justify-content-between font-weight-bold">
                                                                <div>
                                                                    <span id="total-turnover">{{ number_format(\App\Helpers\ProjectHelper::getTurnoverOrCost($project->turnovers)) }}</span>
                                                                    <span>{{ trans('project.cost.yen') }}</span>
                                                                </div>
                                                                @if($project->status === \App\Models\Project::STATUS_ACTIVE)
                                                                    <img class="image-edit button-active" id="image-edit" data-toggle="modal" data-target="#modalTurnover" src="{{ asset('assets/icon/icon_edit_active.svg') }}" alt="">
                                                                @else
                                                                    <img class="image-edit" src="{{ asset('assets/icon/icon_edit.svg') }}" alt="">
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-between font-weight-bold">
                                                                <div>
                                                                    <span id="total-cost">{{ number_format($project->totalCost) }}</span>
                                                                    <span>{{ trans('project.cost.yen') }}</span>
                                                                </div>
                                                                @if($project->status === \App\Models\Project::STATUS_ACTIVE)
                                                                    <img class="image-edit button-active" id="image-edit-cost" data-toggle="modal" data-target="#modalCost" src="{{ asset('assets/icon/icon_edit_active.svg') }}" alt="">
                                                                @else
                                                                    <img class="image-edit" src="{{ asset('assets/icon/icon_edit.svg') }}" alt="">
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-between font-weight-bold">
                                                                <div>
                                                                    <span id="total-sale">{{ number_format(\App\Helpers\ProjectHelper::getProfit($project->turnovers, $project->costs)) }}</span>
                                                                    <span>{{ trans('project.cost.yen') }}</span>
                                                                </div>
                                                                <div class="contract-period-reach-2">
                                                                    <div class="show-pc total-sale-note">
                                                                        {{ trans('project.profit.contract_period_reach_2',
                 ['value' => \App\Helpers\StringHelper::formatMoney(max($project->target_amount - \App\Helpers\ProjectHelper::getProfit($project->turnovers, $project->costs), 0))]) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="show-sp contract-period-reach total-sale-note">
                                                {{ trans('project.profit.contract_period_reach_2',
                 ['value' => \App\Helpers\StringHelper::formatMoney(max($project->target_amount - \App\Helpers\ProjectHelper::getProfit($project->turnovers, $project->costs), 0))]) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body position-relative">
                                            <div class="page-title-box d-flex align-items-center project-total">
                                                <span>{{ trans('project.dedication.title') }}</span>
                                            </div>

                                            <form id="dedication-form" class="d-flex justify-content-between mb-3">
                                                <div>
                                                    <select id="change-user-dedication" class="form-control select-input">
                                                        @foreach($project->projectUserApprove as $key => $value)
                                                            <option value="{{ $value->user_id }}">{{ $value->user->full_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-success button-report button-open-modal-dedication" data-toggle="modal" data-target="#modalDedication">{{ trans('project.button_report') }}</button>
                                                </div>
                                            </form> <div id="dedication-table-filter" class="report-table">
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
                                                                    <td class="text-center">
                                                                        @if($dedication->is_member_check)
                                                                            <img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
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
                                                                <td class="text-center">
                                                                    @if($dedication->is_member_check)
                                                                        <img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
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
                                            <div id="empty-dedication" class="d-none justify-content-center empty-table">
                                                <img src="{{ asset('assets/img/empty.svg') }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="card mb-0">
                                    <div class="card-body position-relative">
                                        <div class="page-title-box d-flex align-items-center project-total">
                                            <span>{{ trans('project.contract.title') }}</span>
                                        </div>

                                        <div class="contract">
                                            @if ($contracts->count())
                                                <a href="{{ asset('storage/contracts/' . $contracts->last()->name) }}" download="{{ $contracts->last()->origin_name }}" id="contract-link" class="contract-link">{{ $contracts->last()->origin_name }}</a>
                                            @endif
                                        </div>

                                        <form id="upload" enctype="multipart/form-data">
                                            @csrf
                                            <div class="d-flex align-items-center mt-3">
                                                <label for="pdf" class="mb-0 upload-loading mr-2">
                                                    <img src="{{ asset('assets/img/upload.svg') }}" class="upload-pdf"/>
                                                </label>
                                                <span class="upload-pdf-text">{{ trans('project.validation.pdf') }}</span>
                                            </div>
                                            <input id="pdf" type="file" name="pdf" class="d-none"><br/>
                                            <button id="pdf-submit" type="button" class="d-none"></button>
                                        </form>
                                        <div id="error-upload"></div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body position-relative">
                                        <div class="page-title-box d-flex align-items-center project-total">
                                            <span>{{ trans('project.contract.history') }}</span>
                                        </div>
                                        <div id="contract-gallery-show">
                                            @if ($contracts->count() > 1)
                                                <div id="contract-gallery">
                                                    @foreach($contracts->reverse() as $key => $item)
                                                        @if ($key != $contracts->count() - 1)
                                                            <div class="contract-gallery">
                                                                <div class="mr-3" style="min-width: 110px">{{ \App\Helpers\ProjectHelper::convertDateToJapan($item->created_at) }}</div>
                                                                <div id="contract-list">
                                                                    <a href="{{ asset('storage/contracts/' . $item->name) }}" download="{{ $item->origin_name }}" class="contract-link">{{ $item->origin_name }}</a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-center">
                                                    <img src="{{ asset('assets/img/empty.svg') }}">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (($project->status === \App\Models\Project::STATUS_END))
                                @if((\App\Helpers\ProjectHelper::getTurnoverOrCost($project->turnovers) - App\Helpers\ProjectHelper::getTurnoverOrCost($project->costs)) >= $project->target_amount)
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.project.form_cost')
        @include('admin.project.form_turnover')
        @include('admin.project.form_dedication')
    </div>
{{--    --}}

@endsection
@push('script')
    <script id="defaultRow" type="text/template">
    @include('admin.project.table_item_cost', ['dataInput' => [
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
    @include('admin.project.table_item_cost_sp', ['dataInput' => [
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
    @include('admin.project.table_item_turnover', ['dataInput' => [
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
    @include('admin.project.table_item_turnover_sp', ['dataInput' => [
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
    @include('admin.project.table_item_dedication', ['dataInput' => [
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
    @include('admin.project.table_item_dedication_sp', ['dataInput' => [
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
        var hash = window.location.hash;
        let tab = $('ul.nav a[href="' + hash + '"]')
        if (hash) {
            hash && tab.tab('show');
            $('ul.nav').find('a').removeClass('active');
            tab.addClass('active');
        }
        console.log(hash)
        $('.nav-tabs a').click(function () {
            location.hash = $(this).attr('href');
            setValueInputTabActive($(this).attr('href'));
        });

        $(document).ready(function() {
            let currentTab = window.location.hash;
            setValueInputTabActive(currentTab);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#pdf').change(function () {
                let pdf =  document.getElementById("pdf");
                const formData = new FormData(document.getElementById('upload'));
                if (pdf.files[0].size > 100000000) {
                    $('#error-upload').html('<span class="text-danger" id="error-upload-pdf">' + 'アップロード可能なファイルの拡張子はPDFで最大100MBです。再度選択してください。' + '</span>');
                    return;
                }
                $('.upload-pdf').addClass('d-none')
                $('.upload-loading').append('<div class="spinner-border" role="status"></div>')
                $.ajax({
                    method: 'post',
                    url: '{{ route('admin.projects.upload.contract', $project) }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        toastr.success('{{ trans('project.system.upload_success') }}')

                        $('#contract-link').remove()
                        $('#error-upload-pdf').remove()
                        $('.contract').append('<a href="{{ asset('storage/contracts/') }}'+ data.data.name_file +'" download="'+ data.data.name_file +'" id="contract-link" class="contract-link">'+ data.data.name_file +'</a>')
                        $('.spinner-border').remove()
                        $('.upload-pdf').removeClass('d-none')

                        if (data.data.contract_old != null) {
                            $('#contract-gallery-show').prepend('<div class="contract-gallery"><div class="mr-3" style="min-width: 110px">'+ data.now +'</div> <div id="contract-list"> <a href="{{ asset('storage/contracts/') }}'+data.data.contract_old.origin_name+'" download="'+data.data.contract_old.origin_name+'" class="contract-link">'+data.data.contract_old.origin_name+'</a> </div></div>')
                        }
                    },
                    error: function (data) {
                        $('.spinner-border').remove()
                        $('#error-upload-pdf').remove()
                        $('.upload-pdf').removeClass('d-none')
                        let response = JSON.parse(data.responseText);
                        toastr.error(response.message)
                    }
                });
            });

            $('.project-status').click(function(e) {
                $(this).prop('disabled', true);
                $('#change-status').submit();
            });

            $('.project-date').click(function(e) {
                $(this).prop('disabled', true);
                $('#end-date-show').addClass('d-none');
                $('#input-date').removeClass('d-none');
            });

            $('#no-change').click(function(e) {
                e.preventDefault()
                $('.project-date').prop('disabled', false);
                $('#end-date-show').removeClass('d-none');
                $('#input-date').addClass('d-none');
            });

            $('#update-date-submit').click(function(e) {
                $(this).prop('disabled', true);
                $('#update-date-form').submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function fetch_data(userDedications) {
                $.ajax({
                    url: '{{ route('admin.projects.user.dedications', $project) }}',
                    dataType: 'html',
                    data: {userDedications: userDedications},
                    cache: false,
                    processData: false,
                    success: (data) => {
                        let html = '';
                        if (userDedications.length === 0) {
                            $('#empty-dedication').addClass('d-flex');
                            $('#empty-dedication').removeClass('d-none');
                        } else {
                            $('#empty-dedication').removeClass('d-flex');
                            $('#empty-dedication').addClass('d-none');

                            $.each(userDedications, function (index, value) {
                                let date = '';
                                date += value.date.slice(0, 4) + '年';
                                date += value.date.slice(5, 7) + '月';
                                date += value.date.slice(8, 10) + '日';

                                html += '<tr>';
                                html += '<td class="text-center align-middle text-title">' + date + '</td>';
                                html += '<td class="text-center align-middle text-title">' + value.item + '</td>';
                                html += '<td class="text-center align-middle text-title">' + value.content + '</td>';
                                if (value.is_member_check === 1) {
                                    html += '<td class="text-center align-middle text-title"><i class="fa-solid fa-check checked-icon"></i></td>';
                                } else {
                                    html += '<td class="text-center align-middle text-title"></td>';
                                }
                                if (value.is_founder_check === 1) {
                                    html += '<td class="text-center align-middle text-title"><i class="fa-solid fa-check checked-icon"></i></td>';
                                } else {
                                    html += '<td class="text-center align-middle text-title"></td>';
                                }
                                html += '<tr>';
                            });
                        }
                        $('#dedication-table').html(html);
                    }
                });
            }

            $('#dedication').change(function (event) {
                $('#dedication').closest("form").submit();
            });

            $('#detail-tab').click(function (event) {
                $('#dedication-form').submit();
            });

            $('#dedication-form').submit(function (event) {
                $.ajax({
                    method: 'get',
                    url: '{{ route('admin.projects.user.dedications', $project) }}',
                    data: $('#dedication-form').serialize(),
                    cache: false,
                    processData: false,
                    success: (data) => {},
                });
                event.preventDefault();
            });

          $('.btn-reject').on('click', function() {
            $('#btn-reject-confirm').val($(this).data().user)
          });
          $('.btn-approval').on('click', function() {
            $('#btn-approval-confirm').val($(this).data().user)
          });
          $('#member-item-list').on('change', '.select-input-status',function() {
            let user = $(this).data().user
            let status = $(this).val()
            $.ajax({
              url : "{{ route('user.project.project-user.update', $project->id) }}",
              type : "post",
              data : {
                "_token": "{{ csrf_token() }}",
                project_user_id: user,
                participation_status: status
              },
              success : function (result){
                if (result.status) {
                  toastr.success(result.message);
                } else {
                  toastr.error(result.message);
                }
              }
            });
          });
          $('.select-input-application-status').on('change', function() {
            let user = $(this).data().user
            let status = $(this).val()
            $.ajax({
              url : "{{ route('user.project.project-user.update', $project->id) }}",
              type : "post",
              data : {
                "_token": "{{ csrf_token() }}",
                project_user_id: user,
                application_status: status
              },
              success : function (result){
                if (result.status) {
                  toastr.success(result.message);
                } else {
                  toastr.error(result.message);
                }
              }
            });
          });


        });

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
          $('.end-date').on('click', '.input-date', function(){
            $(this).datepicker({
              dateFormat: "yy-mm-dd",
              minDate: "{{ $startDate }}",
            }).focus();
            $(this).removeClass('input-date');
          });
          $('.modal').on('click', '.input-date', function(){
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
                                                    <td class="text-center">${dedication.is_member_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}</td>
                                                    <td class="text-center">${dedication.is_founder_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}</td>
                                </tr>`
                      htmlSp += ` <tr class="item-dedication item-dedication-table" id="${dedication.user_id}">
                                                    <td>
                                                        <div>${dedication.date}</div>
                                                        <div>${dedication.item || ''}</div>
                                                        <div class="content-dedication">${dedication.content || ''}</div>
                                                    </td>
                                                    <td class="text-center">${dedication.is_member_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}</td>
                                                    <td class="text-center">${dedication.is_founder_check ? '<img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">' : ''}</td>
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
            $('#image-edit-cost').click(function (event) {
              $('.button-edit-cost').css('display', 'block')
              $('.button-delete-cost').css('display', 'block')
              $('.button-save-cost').css('display', 'none')
              $('.button-cancel-cost').css('display', 'none')
              $('#modalCostSave').modal('hide')
                $('.show-edit').css('display', 'none')
                $('.show-detail').css('display', 'block')
            })
            $('#image-edit').click(function () {
                $('.button-edit-turnover').css('display', 'block')
                $('.button-delete-turnover').css('display', 'block')
                $('.button-save-turnover').css('display', 'none')
                $('.button-cancel-turnover').css('display', 'none')
                $('.show-edit').css('display', 'none')
                $('.show-detail').css('display', 'block')
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

            $('#close-button-cost').click('click', function() {
                let formData = $(this).parent().parent().parent()
                formData.find('[data-id=new]').remove()
            });
            $('#close-button-turnover').click('click', function() {
                let formData = $(this).parent().parent().parent()
                formData.find('[data-id=new]').remove()
            });
          $('#button-cancel-close').click(function () {
            $('#modalTurnoverSave').modal('hide')
          })
        });

        //check btn change status
        $(document).ready(function () {
            $('.select-input-status').click(function () {
                $.ajax({
                    url: '{{ route('admin.projects.is-contract', $project) }}',
                    dataType: 'json',
                    method: 'GET',
                }).done((data) => {
                    if (data.data !== null) {
                        $('#btn-project-status').attr({
                            disabled: 'disabled',
                            title: '{{ trans('project.tooltip') }}',
                            'data-toggle': 'tooltip',
                            'data-placement': 'bottom',
                        })
                    } else {
                        $('#btn-project-status').removeAttr('disabled title data-toggle data-placement');
                        $('#btn-project-status').attr('data-toggle', 'modal');
                    }
                });
            })
        });

        function setValueInputTabActive(value) {
            let list = document.getElementsByClassName('tab-active-input');
            let n;
            for (n = 0; n < list.length; ++n) {
                list[n].value = value;
            }
        }
    </script>
@endpush
