@extends('admin.main')
@section('content')
    <div class="container pt-4">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $countMovie }}</h3>
                        <p>Bộ Phim</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-clapperboard"></i>
                    </div>
                    <a href="{{ route('admin.movie.movie') }}" class="small-box-footer">Xem Chi Tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $countUser }}</h3>
                        <p>Người Dùng</p>
                    </div>
                    <div class="icon">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <a href="{{ route('admin.user.user') }}" class="small-box-footer">Xem Chi Tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $countRole }}</h3>
                        <p>Quyền</p>
                    </div>
                    <div class="icon">
                        <i class="nav-icon fa-solid fa-shield-halved"></i>
                    </div>
                    <a href="{{ route('admin.role.role') }}" class="small-box-footer">Xem Chi Tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $countGenre }}</h3>
                        <p>Thể Loại Phim</p>
                    </div>
                    <div class="icon">
                        <i class="nav-icon fa fa-th"></i>
                    </div>
                    <a href="{{ route('admin.genre.genre') }}" class="small-box-footer">Xem Chi Tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            </div>
            <div class="card bg-gradient-primary" style="display:none">



                <div class="card-footer bg-transparent">
                <div class="row">
                <div class="col-4 text-center">
                <div id="sparkline-1"></div>
                <div class="text-white">Visitors</div>
                </div>
                
                <div class="col-4 text-center">
                <div id="sparkline-2"></div>
                <div class="text-white">Online</div>
                </div>
                
                <div class="col-4 text-center">
                <div id="sparkline-3"></div>
                <div class="text-white">Sales</div>
                </div>
                
                </div>
                
                </div>
                </div> 
            <div class="card bg-gradient-success ">
                <div class="card-header border-0">
                <h3 class="card-title">
                <i class="far fa-calendar-alt"></i>
                Calendar
                </h3>
                
                
                
                </div>
                
                <div class="card-body pt-0">
                
                <div id="calendar" style="width: 100%"></div>
                </div>
                
                </div>
    </div>
    
@endsection