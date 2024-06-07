@extends('user.main')

@section('body')
    <div class="d-flex justify-content-between align-items-center ">
        <h3 style="text-decoration: underline; color: chocolate;" class="pt-2 pb-3 text-uppercase ">Tủ phim theo dõi</h3>
        
    </div>
    @if (session('error'))
        <div id="alert" class="alert alert-danger text-center">
            {{session('error')}}
        </div>
    @endif
    @if (!Auth::check())
        <div class="note p-2" style="background: antiquewhite; border-radius: 5px; text-align:center">
            <p class="m-0">
                <strong>Chú ý: </strong>
                Bạn cần <strong><a href="{{ route('login') }}" style="text-decoration: none">Đăng Nhập</a></strong> 
                tài khoản để có thể lưu phim theo dõi vào tài khoản của bạn, nếu không tủ phim này sẽ mất khi bạn xóa lịch sử trình duyệt !!!
            </p>
        </div>
    @endif
    <div class="movie_detail" id="listFollow">
        @if(Auth::check())
            <div class="row p-3">
                @if (!empty($followByUserId))
                    @foreach ($followByUserId as $item)
                        <div class="col-xx-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 mb-2 item_history">
                            <div class="item_movie ">
                                <a href="{{ route('home.movieDetail', ['movieId'=>$item->m_id, 'm_Slug'=>$item->m_Slug]) }}">
                                    <img src="/images/{{ $item->m_Image }}" alt="{{ $item->m_Image }}">
                                    <div class="item_movie_name">
                                        <p class="text-capitalize">{{ $item->m_Title }}</p>
                                    </div>
                                </a>
                                
                            </div>
                            <i class="fa-solid fa-xmark icon_del"
                                onclick="deleteItemFollow('{{ $item->m_Title }}', '{{ route('home.delItemFollow', ['movieId'=> $item->m_id ]) }}')"></i>
                        </div>
                    @endforeach
                @else
                    <div class="col-10 norecord_history">
                        <h4> Bạn chưa theo dõi bộ phim nào. </h4>
                    </div>
                @endif
                
                
            </div>
        @endif
    </div>
@endsection

@section('style')
    <style>
        
        .title-sweetalert{
            font-size: 20px;
            color: aliceblue
        }

        .swal2-popup{
            background: #000000a8
        }
    </style>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            
            if('{{ !Auth::check() }}'){

                if('{{ session("movieId") }}'){
                    var follows = JSON.parse(localStorage.getItem('follows'));
                    var movieId = '{{ session("movieId") }}';
                    var filteredFollow = follows.filter(function(subArray) {
                        // Trả về true nếu giá trị cần xóa không được tìm thấy trong mảng con
                        return subArray.indexOf(movieId) === -1;
                    });
                    // Lưu filteredFollow trở lại localStorage
                    localStorage.setItem('follows', JSON.stringify(filteredFollow));
                }

                var follows = JSON.parse(localStorage.getItem('follows'));

                $.ajax({
                    url: '{{ route("home.listFollowAjax") }}', // Endpoint trong Laravel
                    type: 'POST',
                    data: { follows: follows },
                    success: function(res) {
                        $('#listFollow').append(res.view)
                    }
                });
            }
            
            
        })
        // Xử lý phần xóa follow
        function deleteItemFollow(title, url){
            Swal.fire({
                title: 'Bạn chắc chắn muốn xóa <span style="color: red">'+ title +'</span> ra khỏi tủ phim theo dõi của bạn.',
                icon: 'warning',
                customClass: {
                    title: 'title-sweetalert', // Thêm class CSS cho tiêu đề
                },
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                
            }).then((result) => {
                if (result.isConfirmed) {
                    // Xử lý khi nhấn nút xóa
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}' // Thêm token CSRF
                        },
                        success: function(res) {
                            // Xử lý phản hồi từ server
                            if(res.success){
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: res.success,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500); // 3000 milliseconds = 3 seconds
                            }else{
                                Swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title: res.error,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // Xử lý lỗi
                        }
                    });
                } else if (result.dismiss === SweetAlert.DismissReason.cancel) {
                    // Xử lý khi nhấn nút xem lại từ đầu
                    
                }
            });
                
        }

        
        function deleteFollowFromLocalStorage(title, url){
            Swal.fire({
                title: 'Bạn chắc chắn muốn xóa <span style="color: red">'+ title +'</span> ra khỏi tủ phim theo dõi của bạn.',
                icon: 'warning',
                customClass: {
                    title: 'title-sweetalert', // Thêm class CSS cho tiêu đề
                },
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                
            }).then((result) => {
                if (result.isConfirmed) {
                    var follows = JSON.parse(localStorage.getItem('follows'));

                    var filteredFollow = follows.filter(function(subArray) {
                        // Trả về true nếu giá trị cần xóa không được tìm thấy trong mảng con
                        return subArray.indexOf(url) === -1;
                    });
                    // Lưu filteredFollow trở lại localStorage
                    localStorage.setItem('follows', JSON.stringify(filteredFollow));
                    
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: 'Xóa thành công',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500); // 3000 milliseconds = 3 seconds
                } else if (result.dismiss === SweetAlert.DismissReason.cancel) {
                    
                    
                }
            });
                
        }

        // Tự động đóng thông báo sau 3 giây
        setTimeout(function() {
            var alert = document.getElementById('alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>
@endsection