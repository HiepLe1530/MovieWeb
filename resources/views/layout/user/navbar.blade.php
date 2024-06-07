<div style="background-color: #1b2d3c;" class="header_top">
    <div class="container">
        <nav class="navbar flex-sm-column flex-lg-row flex-lg-nowrap">
          <a class="navbar-brand" href="{{ route('home.hh3d') }}">
              <img src="/images/logo_user.png" alt="Bootstrap" width="202" height="34">
          </a>
              
              
          <form class="d-flex me-auto ms-auto mt-sm-2 mb-sm-2 mt-lg-0 mb-lg-0  search_form" role="search" method="GET" action="{{ route('home.search') }}">
              <label for="input_search" class="icon_search">
                  <i class="fa-solid fa-magnifying-glass " ></i>
              </label>
              
              <input class="form-control input_search" type="search" name="title" placeholder="Tìm kiếm..." aria-label="Search" id="input_search" value="">
              
              {{-- <button class="btn btn-outline-success" type="submit" style="">Tìm</button> --}}
          </form>
          <ul class="navbar-nav flex-row justify-content-center ">
            <li class="nav-item ms-sm-2 me-sm-2">
              <a class="nav-link" aria-current="page" href="{{ route('home.history') }}"><i class="fa-solid fa-clock-rotate-left icon"></i></a>
            </li>
            <li class="nav-item ms-sm-2 me-sm-2">
              <a class="nav-link" href="{{ route('home.listFollow') }}"><i class="fa-regular fa-heart icon"></i></a>
            </li>
            @if (!Auth::check())
              <li class="nav-item ms-sm-2 me-sm-2">
                <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket icon"></i></a>
              </li>
            @else
              <li class="nav-item dropdown ms-sm-2 me-sm-2 me-lg-0">
                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                  <img src="/images/{{ Auth::user()->u_Avatar }}" alt="Bootstrap" class="icon_avatar">
                </a>
                <ul class="dropdown-menu">
                  <li class="d-flex flex-column justify-content-center align-items-center ">
                    <img src="/images/{{ Auth::user()->u_Avatar }}" alt="" style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 5px;">
                    <p class="text-white ">{{ Auth::user()->u_UserName }}</p>
                  </li>
                  <li><a class="dropdown-item" href="{{ route('home.profile.profile') }}"><i class="fa-regular fa-user me-2"></i>Thông tin</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form action="{{ route('logout_user') }}" method="POST" class="dropdown-item">
                      @csrf
                      <button class="user_btn-logout w-100 d-flex justify-content-start align-items-center " type="submit" style="border:none; background-color: transparent; color:white">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>Đăng xuất
                      </button>
                    </form>
                    {{-- <a class="dropdown-item" href="#"><i class="fa-solid fa-right-from-bracket me-2"></i>Đăng xuất</a> --}}
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="{{ route('admin.homeAdmin') }}"><i class="fa-solid fa-user-tie me-2"></i>Trang quản trị</a></li>
                </ul>
              </li>
            @endif
            
            
            
          </ul>
        </nav>
    </div>
  </div>