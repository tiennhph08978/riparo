@php
    $currentScreen = Request::route()->getName();
    $currentUrl = Request::url();
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
    <!-- Brand Logo -->
    <a href="{{ route('admin.manager-user.index') }}" class="brand-link"
       style="justify-content: center; display: flex;">
        <span class="brand-text font-weight-light">{{ trans('admin.admin') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('admin.manager-user.index') }}" class="nav-link {{ in_array($currentScreen, ['admin.manager-user.index', 'admin.manager-user.detail', 'admin.manager-user.update']) ? 'active' : '' }}">
                        <i class="fa-solid fa-people-group"></i>
                        <p>ユーザー管理</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.projects.index') }}" class="nav-link {{ in_array($currentScreen, ['admin.projects.index', 'admin.projects.detail', 'admin.projects.user.dedications']) ? 'active' : '' }}">
                        <i class="fa-solid fa-list"></i>
                        <p>プロジェクト管理</p>
                    </a>
                </li>
                <li class="nav-item {{ in_array($currentScreen, ['admin.edit-email.index', 'admin.receive-email.index']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <p>設定<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.edit-email.index') }}" class="nav-link {{ in_array($currentScreen, ['admin.edit-email.index']) ? 'active' : '' }}">
                                <i class="fas fa-envelope"></i>
                                <p>ユーザーのメール管理</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.receive-email.index') }}" class="nav-link {{ in_array($currentScreen, ['admin.receive-email.index']) ? 'active' : '' }}">
                                <i class="fas fa-paper-plane"></i>
                                <p>{{ trans('admin.title.receive') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
