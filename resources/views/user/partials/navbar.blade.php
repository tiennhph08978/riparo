<div class="navi d-flex justify-content-between">
    <a href="{{ route('user.my_page.index') }}" class="item color-primary">
        <img src="{{ asset("assets/img/main-logo.svg") }}" class="main-logo">
    </a>

    <div class="button">
        <div><a href="{{ route('user.index') }}" class="item color-primary"><img src="{{ asset("assets/img/icon_home.svg") }}" alt="">{{ trans('partial.home') }}</a></div>
        <div><a href="{{ route('user.project.create') }}" class="item color-primary"><img src="{{ asset("assets/img/icon_edit_home.svg") }}" alt="">{{ trans('partial.project_post') }}</a></div>
        <div><a href="{{ route('user.project.list') }}" class="item color-primary"><img src="{{ asset("assets/img/icon_file.svg") }}" alt="">{{ trans('partial.find_a_project') }}</a></div>
        @if($user)
            <div class="align-items-center user-header-button">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if ($user->avatar)
                            <img src="{{ \App\Helpers\FileHelper::getFullUrl($user->avatar) }}" alt="" id="file-preview" width="100%">
                        @else
                            <img src="{{ asset('assets/img/default.png') }}" alt="" id="file-preview" width="100%">
                        @endif
                        <span>{{ $user->full_name }}</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="{{ route('user.my_page.index') }}" class="item color-primary drop-item">
                            <img src="{{ asset('assets/icon/icon-avatar.svg') }}" alt="" width="100%">
                            <span>{{ trans('my-page.title') }}</span>
                        </a>
                        <a href="{{ route('user.my_page.edit_password') }}" class="item color-primary drop-item">
                            <img src="{{ asset('assets/icon/padlock.png') }}" alt="" width="24">
                            <span>{{ trans('edit-personal.header.action_text') }}</span>
                        </a>
                        <a href="{{ route('user.auth.logout') }}" class="item color-primary drop-item">
                            <img src="{{ asset('assets/icon/icon-logout.svg') }}" alt="" width="100%">
                            <span>{{ trans('auth.logout') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div><a href="{{ route('user.auth.register') }}" class="item color-primary"><img src="{{ asset("assets/img/icon_add_user.svg") }}" alt="">{{ trans('partial.register') }}</a></div>
            <div>
                <a href="{{ route('user.auth.login') }}" class="item login color-white">{{ trans('auth.login') }}</a>
            </div>
        @endif
    </div>
    <div class="toggle_icon">
        @if($user)
            <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal">
                <img src="{{ asset('assets/img/togger.svg') }}" alt="">
            </button>
            <div class="modal  fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="info">
                            @if ($user->avatar)
                                <img src="{{ \App\Helpers\FileHelper::getFullUrl($user->avatar) }}" alt="" id="file-preview" width="10%">
                            @else
                                <img src="{{ asset('assets/img/default.png') }}" alt="" id="file-preview" width="100%">
                            @endif
                            <span class="item">{{ $user->full_name }}</span>
                        </div>
                        <div><a href="{{ route('user.index') }}" class="item {{ (request()->routeIs('user.index')) ? 'active' : ''}}"><img src="{{ asset("assets/img/icon_home.svg") }}" alt="">{{ trans('partial.home') }}</a></div>
                        <div><a href="{{ route('user.project.create') }}" class="item {{ (request()->routeIs('user.project.create')) ? 'active' : ''}}"><img src="{{ asset("assets/img/icon_edit_home.svg") }}" alt="">{{ trans('partial.project_post') }}</a></div>
                        <div><a href="{{ route('user.project.list') }}" class="item {{ (request()->routeIs('user.project.list')) ? 'active' : ''}}"><img src="{{ asset("assets/img/icon_file.svg") }}" alt="">{{ trans('partial.find_a_project') }}</a></div>
                        <div>
                            <a href="{{ route('user.auth.logout') }}" class="item">
                                <img src="{{ asset('assets/img/logout-mobi.svg') }}" alt="">
                                <span>{{ trans('auth.logout') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="box-login">
                <div style="margin: auto"><a href="{{ route('user.index') }}" class="item">{{ trans('partial.home') }}</a></div>
                <a href="{{ route('user.auth.login') }}" class="item login">{{ trans('auth.login') }}</a>
            </div>
        @endif
    </div>

</div>
