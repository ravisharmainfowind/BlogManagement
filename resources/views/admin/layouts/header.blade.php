<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('admin/dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>N</b>DL</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ __('message.APP_NAME') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @if(auth('web')->user()->profile_picture)
               <img src="{{ asset('public/Admin/users_profile/'.auth('web')->user()->profile_picture) }}" class="user-image" alt="User Image">
               @else
               <img src="{{ asset('public/Admin/no-image.png') }}" class="user-image" alt="User Image">
              @endif
              <span class="hidden-xs">{{ auth('web')->user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
               @if(auth('web')->user()->profile_picture)
               <img src="{{ asset('public/Admin/users_profile/'.auth('web')->user()->profile_picture) }}" class="img-circle" alt="User Image">
               @else
               <img src="{{ asset('public/Admin/no-image.png') }}" class="img-circle" alt="User Image">
              @endif

                <p>
                 {{ auth('web')->user()->name }}
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('admin/profile') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('admin/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
</header>

