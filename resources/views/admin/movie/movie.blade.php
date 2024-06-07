@extends('admin.main')
@section('content')
    <div class="container ">
        @if(session('success'))
            <div id="alert" class="alert alert-info text-center">
                {{session('success')}}
            </div>
        @endif
        @if(session('error'))
            <div id="alert" class="alert alert-danger text-center">
                {{session('error')}}
            </div>
        @endif
        
        <div class="pt-4 d-flex justify-content-between ">
            <h4 class="title">Quản lý bộ phim</h4>
            <a href="{{ route('admin.movie.add') }}" class="btn btn-info btnThem"><i class="fa-solid fa-plus"></i> Thêm mới bộ phim</a>
        </div>
        @livewire('search-movie-admin')
    </div>
        
        
    
@endsection

{{-- @section('script')
    <script type="text/javascript">
        // Tự động đóng thông báo sau 3 giây
        setTimeout(function() {
            var alert = document.getElementById('alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>
@endsection --}}