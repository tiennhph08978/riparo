<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
      <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
        <span class="d-none d-md-inline">{{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->email }}</span>
          <i class="fas fa-angle-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right email-menu" aria-labelledby="dropdownMenuLink">
        <li class="user-footer">
          <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat float-right">ログアウト</a>
        </li>
      </ul>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
