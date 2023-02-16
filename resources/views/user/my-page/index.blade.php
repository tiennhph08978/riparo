@extends('user.layouts.landing_page')

@section('title', '個人ページ画面')

@section('content')
    <div class="main">
        <div class="information-detail">
        <div class="information row">
            <div class="information__img  text-center col-xl-3 col-md-3 col-sm-3">
                @if ($user->avatar)
                    <img src="{{ \App\Helpers\FileHelper::getFullUrl($user->avatar) }}" alt="" id="file-preview" width="100%">
                @else
                    <img src="{{ asset('assets/img/default.png') }}" alt="" id="file-preview" width="100%">
                @endif
            </div>
            <div class="information__img-mobile d-none col-12 row">
                <div class="col-5">
                    @if ($user->avatar)
                        <img src="{{ \App\Helpers\FileHelper::getFullUrl($user->avatar) }}" alt="" id="file-preview" width="100%">
                    @else
                        <img src="{{ asset('assets/img/default.png') }}" alt="" id="file-preview" width="100%">
                    @endif
                </div>
                <div class="information__img-mobile-title col-7">
                    <div class="title">{{ $user->full_name }}<span>（{{ $user->full_name_furigana }}）</span></div>
                    <a href="{{ route('user.my_page.edit_personal') }}" class="btn btn-color">{{ trans('my-page.information_btn_edit') }}</a>
                </div>
            </div>
            <div class="information-contact col-xl-9 col-md-9 col-sm-9 col-12">
                <div class="information-contact__title d-flex flex-wrap">
                    <div class="title">{{ $user->full_name }}</div>
                    <div class="title-desc">（{{ $user->full_name_furigana }}）</div>
                    <div class="information__img">
                        <a href="{{ route('user.my_page.edit_personal') }}" class="btn btn-color">{{ trans('my-page.information_btn_edit') }}</a>
                    </div>
                </div>
                <div class="information-contact-list flex-wrap">
                    <div class="information-contact-list__content d-flex">
                        <img src="{{ asset('assets/icon/icon-email.svg') }}" alt="">
                        <div style="word-break: break-all">{{ $user->email }}</div>
                    </div>
                    <div class="information-contact-list__content-phone d-flex">
                        <img src="{{ asset('assets/icon/icon-phone.svg') }}" alt="">
                        <div>{{ $user->phone_number }}</div>
                    </div>
                    <div class="information-contact-list__content d-flex">
                        <img src="{{ asset('assets/icon/icon-address.svg') }}" alt="">
                        <div>{{ $user->full_address }}</div>
                    </div>
                </div>
                <div class="information-contact__intro">
                    {!! \App\Helpers\StringHelper::formatContent($user->desc) !!}
                </div>
            </div>
        </div>
        <div class="project">
            <div class="project__title d-flex justify-content-between">
                <div class="project__title__text my-auto">{{ trans('my-page.information_title_project_f') }}&nbsp;<span>({{ $projectFounder->count() }} {{ trans('my-page.information_count') }})</span></div>
                <div class="d-flex">
                    <div class="pr-4 d-flex m-auto">
                        <div class="overall_flow">{{ trans('my-page.overall_flow') }}</div>
                        <div>
                            <img src="{{ asset('assets/img/icon_my_page.svg') }}" alt="">
                        </div>
                    </div>
                    <a href="{{ route('user.project.create') }}" class="btn btn-color">{{ trans('my-page.information_btn_create_project') }}</a>
                </div>
            </div>
            <div class="project__table">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-color">
                            <th width="8%">ID</th>
                            <th width="24.5%">{{ trans('my-page.information_table.name') }}</th>
                            <th width="13%">{{ trans('my-page.information_table.profession') }}</th>
                            <th width="10%">{{ trans('my-page.information_table.people_number') }}</th>
                            <th width="8.5%">{{ trans('my-page.information_table.participate') }}</th>
                            <th width="17.5%">{{ trans('my-page.information_table.status') }}</th>
                            <th width="9%">{{ trans('my-page.information_table.result') }}</th>
                            <th style="font-size: 13px" width="9.5%">{{ trans('my-page.information_table.operation') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($projectFounder as $project)
                        <tr>
                            <td>{{ \App\Helpers\ProjectHelper::formatId($project->id) }}</td>
                            <td>{{ $project->title }}</td>
                            <td class="td-industry">{{ $project->industryMypage }}</td>
                            <td>{{ $project->recruitment_quantity_min }}人 〜 {{ $project->recruitment_quantity_max }}人</td>
                            <td>{{ $project->countMember }}人</td>
                            <td class="status-project {{ $project->statusColor }}"><span style="position: absolute; font-size: 28px; margin-top: -2px" class="icon-dot">&#8226;</span><span style="padding-left: 13px">{{ $project->statusStr }}</span></td>
                            <td>
                                {{ \App\Helpers\ProjectHelper::getDissolutionAndLegalization($project) }}
                            </td>
                            <td class="operation-color"><a href="{{ \App\Helpers\UrlHelper::getProjectUrl($project) }}">{{ trans('my-page.information_table.view_detail') }}</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center"><img src="{{ asset("assets/img/empty.svg") }}" alt="cover" class="empty-img"></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="project ">
                <div class="project__title">
                    <div class="project__title__text my-auto">
                        {{ trans('my-page.information_title_project_m') }}&nbsp;<span>({{ $projectMember->count() }} {{ trans('my-page.information_count') }})</span>
                    </div>
                </div>
            <div class="project__table">
                <table class="table table-bordered">
                    <thead>
                    <tr class="table-color">
                        <th width="8%">ID</th>
                        <th width="24.5%">{{ trans('my-page.information_table.name') }}</th>
                        <th width="13%">{{ trans('my-page.information_table.profession') }}</th>
                        <th width="10%">{{ trans('my-page.information_table.people_number') }}</th>
                        <th width="8.5%">{{ trans('my-page.information_table.participate') }}</th>
                        <th width="17.5%">{{ trans('my-page.information_table.status') }}</th>
                        <th width="9%">{{ trans('my-page.information_table.result') }}</th>
                        <th style="font-size: 13px" width="9.5%">{{ trans('my-page.information_table.operation') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($projectMember as $project)
                        <tr>
                            <td>{{ \App\Helpers\ProjectHelper::formatId($project->id) }}</td>
                            <td>{{ $project->title }}</td>
                            <td class="td-industry">{{ \App\Helpers\ProjectHelper::substrWords($project->industryMypage, 7) }}</td>
                            <td>{{ $project->recruitment_quantity_min }}人 〜 {{ $project->recruitment_quantity_max }}人</td>
                            <td>{{ $project->countMember }}人</td>
                            <td class="status-project {{ @$project->projectUsers->first()->statusColor }}">
                                <span style="position: absolute; font-size: 28px; margin-top: -2px" class="icon-dot">&#8226;</span>
                                <span style="padding-left: 13px">{{ @$project->projectUsers->first()->statusStr }}</span>
                            </td>
                            <td>{{ \App\Helpers\ProjectHelper::getDissolutionAndLegalization($project) }}</td>
                            <td class="operation-color">
                                <a href="{{ \App\Helpers\UrlHelper::getProjectUrl($project) }}">{{ trans('my-page.information_table.view_detail') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center"><img src="{{ asset("assets/img/empty.svg") }}" alt="cover" class="empty-img"></td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
        <div class="project-mobile project-bottom">
            <div class="project-mobile__title my-auto" id="collapseFound" data-target="#project-founder-collapse" aria-expanded="false" data-toggle="collapse">
                <span >{{ trans('my-page.information_title_project_f') }}
                <span class="count">({{ $projectFounder->count() }} {{ trans('my-page.information_count') }})</span></span>
                <a href="#project-founder-collapse" aria-expanded="false" data-toggle="collapse" class="collapsible">
                    <img src="{{ asset('assets/icon/open.svg') }}" class="imgFounder" alt="">
                </a>
            </div>
            <div class="collapse" id="project-founder-collapse">
                <div class="project-mobile__list">
                    <div class="d-flex">
                        <a href="{{ route('user.project.create') }}" class="btn btn-color">{{ trans('my-page.information_btn_create_project') }}</a>
                        <div class="pr-4 d-flex m-auto">
                            <div class="overall_flow">{{ trans('my-page.overall_flow') }}</div>
                            <div>
                                <img src="{{ asset('assets/img/icon_my_page.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="project-list">
                        @forelse ($projectFounder as $project)
                            <div class="project-list__item">
                                <div class="project-list__item-title d-flex justify-content-between">
                                    <div class="project__item-id">
                                        ID:<span>{{ \App\Helpers\ProjectHelper::formatId($project->id) }}</span>
                                    </div>
                                    <div class="project__item-detail">
                                        <a class="link-url" href="{{ \App\Helpers\UrlHelper::getProjectUrl($project) }}">{{ trans('my-page.information_table.view_detail') }}</a>
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ $project->title }}
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ trans('my-page.information_table.profession') }}:<span>{{ $project->industryMypage }}</span>
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ trans('my-page.information_table.people_number') }}:
                                        <span>{{ $project->recruitment_quantity_min }}人 〜 {{ $project->recruitment_quantity_max }}人</span>
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ trans('my-page.information_table.participate') }}:<span>{{ $project->countMember }}人</span>
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ trans('my-page.information_table.status') }}:<span class="status-project {{ $project->statusColor }}"><span style="position: absolute; font-size: 30px; margin-top: -3px" class="icon-dot">&#8226;</span><span style="padding-left: 15px">{{ $project->statusStr }}</span></span>
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ trans('my-page.information_table.result') }}:<span>{{ \App\Helpers\ProjectHelper::getDissolutionAndLegalization($project) }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center">
                                <img src="{{ asset("assets/img/empty.svg") }}" alt="cover" class="empty-img">
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="project-mobile">
            <div class="project-mobile__title my-auto" id="collapseMember" data-target="#boxnoidung" aria-expanded="false" data-toggle="collapse">
                <span>{{ trans('my-page.information_title_project_m') }}
                <span class="count">({{ $projectMember->count() }} {{ trans('my-page.information_count') }})</span></span>
                <a href="#boxnoidung" aria-expanded="false" data-toggle="collapse" class="collapsible">
                    <img src="{{ asset('assets/icon/open.svg') }}" class="imgMember" alt="">
                </a>
            </div>
            <div class="collapse" id="boxnoidung">
                <div class="project-mobile__list">
                    <div class="project-list">
                        @forelse ($projectMember as $project)
                            <div class="project-list__item">
                                <div class="project-list__item-title d-flex justify-content-between">
                                    <div class="project__item-id">
                                        ID:<span>{{ \App\Helpers\ProjectHelper::formatId($project->id) }}</span>
                                    </div>
                                    <div class="project__item-detail">
                                        <a class="link-url" href="{{ \App\Helpers\UrlHelper::getProjectUrl($project) }}">{{ trans('my-page.information_table.view_detail') }}</a>
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ $project->title }}
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ trans('my-page.information_table.profession') }}:<span>{{ $project->industryMypage }}</span>
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ trans('my-page.information_table.people_number') }}:
                                        <span>{{ $project->recruitment_quantity_min }}人 〜 {{ $project->recruitment_quantity_max }}人</span>
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ trans('my-page.information_table.participate') }}:<span>{{ $project->countMember }}</span>
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ trans('my-page.information_table.status') }}:<span class="status-project {{ $project->projectUsers->first()->statusColor }}"><span style="position: absolute; font-size: 30px; margin-top: -3px" class="icon-dot">&#8226;</span><span style="padding-left: 15px">{{ $project->projectUsers->first()->statusStr }}</span></span>
                                    </div>
                                </div>
                                <div class="project-list__item-title">
                                    <div class="project__item-id">
                                        {{ trans('my-page.information_table.result') }}:<span>{{ \App\Helpers\ProjectHelper::getDissolutionAndLegalization($project) }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center">
                                <img src="{{ asset("assets/img/empty.svg") }}" alt="cover" class="empty-img">
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="d-none" id="overall_flow">
        <div id="test" class="background-image"></div>
        <div class="show-image-my-page d-flex" id="show-image-my-page">
            <img class="img-info" src="{{ asset('assets/img/my_page.png') }}" alt="">
            <button class="close-modal-my-page"><img src="{{ asset('assets/img/close_my_page.svg') }}" alt=""></button>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('#collapseFound').on({
            'click': function() {
                var src = ($('.imgFounder').attr('src') === '{{ asset('assets/icon/close.svg') }}')
                    ? '{{ asset('assets/icon/open.svg') }}'
                    : '{{ asset('assets/icon/close.svg') }}';
                $('.imgFounder').attr('src', src);
            }
        });
        $('#collapseMember').on({
            'click': function() {
                var src = ($('.imgMember').attr('src') === '{{ asset('assets/icon/close.svg') }}')
                    ? '{{ asset('assets/icon/open.svg') }}'
                    : '{{ asset('assets/icon/close.svg') }}';
                $('.imgMember').attr('src', src);
            }
        });

        window.addEventListener('click', function(e){
            if (document.getElementById('test').contains(e.target)){
                $('#overall_flow').removeClass('d-block').addClass('d-none')
                document.getElementById('landing-page').style.overflow = 'auto'
            }
        });

        $('.close-modal-my-page').click(function() {
            $('#overall_flow').removeClass('d-block').addClass('d-none')
            $('#landing-page').attr('style', 'overflow: auto')
        })

        $('.overall_flow').click(function () {
            $('#overall_flow').removeClass('d-none').addClass('d-block')
            $('#landing-page').css('overflow', 'hidden')
        })
    </script>
@endpush

