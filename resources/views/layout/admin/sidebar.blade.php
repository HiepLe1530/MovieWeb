<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home.hh3d') }}" class="brand-link">
      <img src="/images/logo.png" alt="hh3D.tv Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">hh3D.tv</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/images/{{ Auth::user()->u_Avatar }}" class="img-circle elevation-2" alt="avater">
        </div>
        <div class="info">
          <a href="{{ route('admin.profile.profile') }}" class="d-block">{{ Auth::user()->u_UserName }}</a>
        </div>
      </div>

    


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item {{ (request()->is('admin/movie/*') || request()->is('admin/movie')) ? 'menu-open' : '' }}">
            <a href="{{ route('admin.movie.movie') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-clapperboard"></i>
              <p>
                Quản lý bộ phim
              </p>
            </a>
          </li>
          <li class="nav-item {{ (request()->is('admin/user/*') || request()->is('admin/user')) ? 'menu-open' : '' }}">
            <a href="{{ route('admin.user.user') }}" class="nav-link" >
              <i class="nav-icon fa-solid fa-user"></i>
              <p>
                Quản lý người dùng
              </p>
            </a>
          </li>
          <li class="nav-item {{ (request()->is('admin/role/*') || request()->is('admin/role')) ? 'menu-open' : '' }}">
            <a href="{{ route('admin.role.role') }}" class="nav-link">
              <i class="nav-icon fa-solid fa-shield-halved"></i>
              <p>
                Quản lý quyền
              </p>
            </a>
          </li>
          <li class="nav-item {{ (request()->is('admin/genre/*') || request()->is('admin/genre'))  ? 'menu-open' : '' }}">
            <a href="{{ route('admin.genre.genre') }}" class="nav-link">
              <i class="nav-icon fa fa-th"></i>
              <p>
                Quản lý thể loại phim
              </p>
            </a>
          </li>
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" style="padding: 8px 16px" class="nav-link">
              @csrf
              <button class="nav-link" type="submit">
                <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                <p>
                  Đăng xuất
                </p>
              </button>
            </form>
            
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>