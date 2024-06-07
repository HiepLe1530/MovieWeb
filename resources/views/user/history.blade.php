@extends('user.main')

@section('body')
    <div class="d-flex justify-content-between align-items-center ">
        <h3 style="text-decoration: underline; color: chocolate;" class="pt-2 pb-3 text-uppercase ">Lịch sử xem</h3>
        
        @if (Auth::check())
            <p style="color: chocolate;" class="delAllHistory {{ (empty($history)) ? 'delHistoryEmpty' : '' }}" 
                onclick="deleteAllHistory('{{ route('home.delAllHistory') }}')">
                Xóa tất cả lịch sử
            </p>
        @else
            <p id="delHistoryFromLocalStorage" style="color: chocolate;" class="delAllHistory" 
                onclick="deleteHistoryFromLocalStorage()">
                Xóa tất cả lịch sử
            </p>
        @endif
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
                tài khoản để có thể lưu lịch sử xem phim vào tài khoản của bạn, nếu không lịch sử này sẽ mất khi bạn xóa lịch sử trình duyệt !!!
            </p>
        </div>
    @endif
    <div class="movie_detail" id="history">
        @if(Auth::check())
            <div class="row p-3">
                @if (!empty($history))
                    @foreach ($history as $item)
                        <div class="col-6 pt-2 pb-2 item_history">
                            <a href="{{ route('home.episodeDetail', ['movieId'=>$item->m_id, 'm_Slug'=>$item->m_Slug, 'e_Episode'=>$item->wh_e_Episode]) }}" style="text-decoration: none">
                                <div class="d-flex" style="background: #1b2d3c;">
                                    <img src="/images/{{ $item->m_Image }}" alt="gia-thien" style="width:100px; height:110px; object-fit:cover">
                                    <div class="d-flex flex-column justify-content-center  ms-3">
                                        <p style="color: #e6dede; margin:5px 0" class=" text-capitalize fw-bold ">{{ $item->m_Title }}</p>
                                        <p style="color: #e6dede; margin:5px 0">Bạn đã xem Tập {{ $item->wh_e_Episode }}</p>
                                        <span style="color: rgba(178, 187, 40, 0.755)">{{ $item->wh_Timestamp }}</span>
                                    </div>
                                    
                                </div>
                            </a>
                            <i class="fa-solid fa-xmark icon_del" data-id="{{ $item->m_id }}" 
                                onclick="deleteItemHistory('{{ $item->m_Title }}', '{{ route('home.delItemHistory', ['movieId'=> $item->m_id ]) }}')"></i>
                        </div>
                    @endforeach
                @else
                    <div class="col-10 norecord_history">
                        <h4> Bạn chưa xem bộ phim nào. </h4>
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
                    var histories = JSON.parse(localStorage.getItem('histories'));
                    var movieId = '{{ session("movieId") }}';
                    var filteredHistory = histories.filter(function(subArray) {
                        // Trả về true nếu giá trị cần xóa không được tìm thấy trong mảng con
                        return subArray.indexOf(movieId) === -1;
                    });
                    // Lưu filteredFollow trở lại localStorage
                    localStorage.setItem('histories', JSON.stringify(filteredHistory));
                }
                
                var histories = JSON.parse(localStorage.getItem('histories'));
                if(histories == null){
                    document.getElementById("delHistoryFromLocalStorage").style.pointerEvents = "none";
                    document.getElementById("delHistoryFromLocalStorage").style.opacity = "0.5";

                }
                
                $.ajax({
                    url: '{{ route("home.historyAjax") }}', // Endpoint trong Laravel
                    type: 'POST',
                    data: { histories: histories },
                    success: function(res) {
                        $('#history').append(res.view)
                    }
                });
            }


            
            
        })
        // Xử lý phần xóa history
        function deleteItemHistory(title, url){
            Swal.fire({
                title: 'Bạn chắc chắn muốn xóa <span style="color: red">'+ title +'</span> ra khỏi lịch sử xem của bạn.',
                icon: 'warning',
                customClass: {
                    title: 'title-sweetalert', // Thêm class CSS cho tiêu đề
                },
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                
            }).then((result) => {
                if (result.isConfirmed) {
                    // Xử lý khi nhấn nút xem tiếp
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

        function deleteAllHistory(url){
            Swal.fire({
                title: 'Bạn chắc chắn muốn xóa tất cả lịch sử xem phim của bạn.',
                icon: 'warning',
                customClass: {
                    title: 'title-sweetalert', // Thêm class CSS cho tiêu đề
                },
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                
            }).then((result) => {
                if (result.isConfirmed) {
                    // Xử lý khi nhấn nút xem tiếp
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
        
        function deleteHistoryFromLocalStorage(){
            Swal.fire({
                title: 'Bạn chắc chắn muốn xóa tất cả lịch sử xem phim của bạn.',
                icon: 'warning',
                customClass: {
                    title: 'title-sweetalert', // Thêm class CSS cho tiêu đề
                },
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem('histories');
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