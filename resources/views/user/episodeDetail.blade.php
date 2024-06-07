@extends('user.main')
@section('body')
    <div class="row">
        <div class="{{ empty($movieMaxFollow) ? '' : 'col-xl-8 col-lg-12' }} "> 
            <div class="movie_detail wrapper_video">
                <video id="video_{{ $episodeOneByMovieId->id }}" controls poster="/images/poster/{{ $movieDetail->m_Poster }}" muted>
                    <source src="/videos/{{ $episodeOneByMovieId->e_MovieVideo }}">
                </video>
            </div>

            <div>
                <h3 style="margin: 10 0px;" class="text-warning">{{ $movieDetail->m_Title }}</h3>
            </div>

            <div  class="mb-2">
                <p style="color: aliceblue" class=" text-uppercase"><i class="fa-solid fa-magnifying-glass me-2"></i>Tìm tập nhanh</p>
                <input
                type="text" 
                style="background: #333232; color:aliceblue; padding-left:10px;" 
                placeholder="Nhập số tập"
                oninput="episodeSearch(this, '{{ route('home.episodeSearch') }}', '{{ $movieDetail->m_id }}')"
                class="mb-2">
                <div id="layoutEpisodeSearch"></div>
            </div>

            <div class="movie_detail row p-2" style="max-height: 180px; overflow: auto">
                @if (!empty($episodeByMovieId))
                    @foreach ($episodeByMovieId as $item)
                        <div class=" col-md-2 col-sm-3 wrapper_btn-episode">
                            <a href="{{ route('home.episodeDetail', ['movieId'=>$movieDetail->m_id, 'm_Slug'=>$movieDetail->m_Slug, 'e_Episode'=>$item->e_Episode]) }}" 
                                class=" btn btn-episode {{ request()->is('hh3d/'.$movieDetail->m_id.'-'.$movieDetail->m_Slug.'/episode-'.$item->e_Episode) ? 'btn-episode-active disabled' : '' }}">
                                {{ $item->e_Episode }}
                            </a>
                        </div>
                    @endforeach
                    
                @else
                    <div class="d-flex justify-content-center align-items-center "><p class=" text-light ">Tập phim sắp được công chiếu.</p></div>
                @endif
                
            </div>
            
            <div class="movie_detail p-5">
                <div class="comment">
                    <div class="my_comment mb-4">
                        @if (Auth::check())
                            <div class="d-flex">
                                <img src="/images/{{ Auth::user()->u_Avatar }}" alt="" class=" rounded-circle" width="60px" height="60px" style="margin: 10px 0">
                                <div class="form-group flex-grow-1 ms-3">
                                    <form action="" method="">
                                        <textarea class="comment_content_textarea form-control " name="comment_content" placeholder="Tham gia bình luận" id="comment_content"  rows="2"></textarea>
                                        <button id="btn_send_comment" style="">Gửi</button>
                                        <small id="comment_error" style="color: red"></small>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="d-flex justify-content-center ">
                                <a href="{{ route('login') }}" class="btn btn-primary " style="color:aliceblue"><i class="fa-solid fa-right-to-bracket me-2"></i>Đăng nhập để bình luận</a>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <h4 id="count_comment" class="count_comment text-uppercase">{{ $comment->getCountCommentByMovieId($movieDetail->m_id) }} bình luận</h4>
                    </div>

                    <div id="list_comment" style="max-height: 400px; overflow: auto">
                        @if (!empty($comment->getCommentParrent($movieDetail->m_id)))
                            @foreach ($comment->getCommentParrent($movieDetail->m_id) as $commentParrent)
                                
                                @include('user.itemComment')
                                
                            @endforeach
                        @endif
                    </div>

                    
                </div>
            </div>
        </div>
        @if (!empty($movieMaxFollow))
            <div class="related_movie col-xl-4 col-lg-12 ">
                @include('layout.user.list_follow_max', ['movieMaxFollow' => $movieMaxFollow, 'rating' => $rating])
            </div>
        @endif
    </div>
    
    
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Xử lý gửi comment
            var _csrf = '{{ csrf_token() }}';
            var _commentUrl = '{{ route("home.addComment", $movieDetail->m_id) }}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#btn_send_comment').click(function(e){
                e.preventDefault();
                comment_content = $('#comment_content').val();

                $.ajax({
                    url: _commentUrl,
                    type: 'POST',
                    data: {
                        comment_content: comment_content,
                    },
                    success: function(res){
                        if(res.error){
                            $('#comment_error').html(res.error)
                        }else{
                            $('#count_comment').html(res.countComment);
                            $('#comment_content').val('');
                            $('#list_comment').prepend(res.view);
                        }
                    }
                })
            })

            $(document).on('click', '.btn_reply', function(e){
                e.preventDefault();
                //Bắt id của nút phản hồi
                id = $(this).data('id');

                //Lấy userName và gán cho textarea
                userName = $('.userName_' + id).text().trim();
                id_comment_content_reply = '#comment_content_'+id;
                $(id_comment_content_reply).val('@'+userName+' ');

                form_reply_class = '.form_reply_'+id;
                $(form_reply_class).slideToggle()
                btn_send_comment_reply = '#btn_send_comment_reply_'+id
                //Xử lý sự kiện click cho nút gửi
                $(btn_send_comment_reply).unbind('click').click(function(ev){
                    ev.preventDefault();
                    
                    comment_content = $(id_comment_content_reply).val();
                    commentParrentId = $('.commentParrentId_'+id).val();

                    $.ajax({
                    url: _commentUrl,
                    type: 'POST',
                    data: {
                        comment_content: comment_content,
                        c_Reply: commentParrentId

                    },
                    success: function(res){
                        if(res.error){
                            $('.comment_error_'+id).html(res.error)
                        }else{
                            $('#count_comment').html(res.countComment);
                            $(id_comment_content_reply).val('')
                            $('#list_comment_child_' + commentParrentId).append(res.view);
                            $('.form_reply_' + id).slideUp();
                        }
                    }
                    })
                })
            })


            //Xử lý video
            // Lấy thẻ video
            var video = document.querySelector('#video_{{ $episodeOneByMovieId->id }}');
        
            // Lắng nghe sự kiện tắt video
            window.addEventListener('beforeunload', function(event) {
                var watchedTime = Math.round(video.currentTime);
                localStorage.setItem('watchedTime_{{ $episodeOneByMovieId->id }}', watchedTime);
                
            });

            window.onload = function() {
                
                    var watchedTime = localStorage.getItem('watchedTime_{{ $episodeOneByMovieId->id }}');
                    var duration = video.duration

                    // Nếu có thời gian đã xem được lưu trước đó, đặt thời gian phát bắt đầu từ thời điểm đó
                    if (watchedTime && watchedTime != 0 && watchedTime < (duration)) {
                        var hours = Math.floor(watchedTime / 3600);
                        var minutes = Math.floor((watchedTime % 3600) / 60);
                        var seconds = Math.floor(watchedTime %  60);
                        var time = pad(hours, 2) + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
                        console.log(watchedTime + ' ' +hours+' '+minutes+' '+seconds)
                        Swal.fire({
                            title: 'Lần trước bạn đã xem video đến <span style="color: red">'+ time +'</span>',
                            icon: 'info',
                            html: '<h4 style="color: aliceblue">Bạn có muốn xem tiếp không?</h4>',
                            customClass: {
                                title: 'title-sweetalert', // Thêm class CSS cho tiêu đề
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Xem tiếp',
                            cancelButtonText: 'Xem lại từ đầu',
                            
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Xử lý khi nhấn nút xem tiếp
                                video.currentTime = watchedTime;
                                video.autoplay = true;
                            } else if (result.dismiss === SweetAlert.DismissReason.cancel) {
                                // Xử lý khi nhấn nút xem lại từ đầu
                                localStorage.removeItem('watchedTime_{{ $episodeOneByMovieId->id }}'); // Xóa thời gian đã lưu
                            }
                        });
                    }
                
            }

            function pad(number, length) {
                var str = '' + number;
                while (str.length < length) {
                    str = '0' + str;
                }
                return str;
            }
            
        });

        if(!localStorage.getItem('histories')){
            localStorage.setItem('histories', JSON.stringify([]));
        }
        if('{{ !Auth::check() }}'){
            function addLeadingZero(number) {
                return (number < 10 ? '0' : '') + number;
            }
            var histories = JSON.parse(localStorage.getItem('histories'));
            var movieId = '{{ $movieDetail->m_id }}';
            var movieImage = '{{ $movieDetail->m_Image }}';
            var movieName = '{{ $movieDetail->m_Title }}';
            var episode = '{{ $episodeOneByMovieId->e_Episode }}';

            // Tạo một đối tượng Date mới, biểu diễn thời điểm hiện tại
            var currentDate = new Date();

            // Lấy thông tin ngày, tháng, năm
            var day = currentDate.getDate(); // Ngày trong tháng (1-31)
            var month = currentDate.getMonth() + 1; // Tháng (0-11), cộng thêm 1 để hiển thị từ 1-12
            var year = currentDate.getFullYear(); // Năm

            // Lấy thông tin giờ, phút, giây
            var hour = currentDate.getHours(); // Giờ (0-23)
            var minute = currentDate.getMinutes(); // Phút (0-59)
            var second = currentDate.getSeconds(); // Giây (0-59)

            // Định dạng lại chuỗi ngày giờ
            var timestamp = year + '-' + addLeadingZero(month) + '-' + addLeadingZero(day) + ' ' + addLeadingZero(hour) + ':' + addLeadingZero(minute) + ':' + addLeadingZero(second);

            var history_watch = [movieId, window.location.href, episode, timestamp, movieImage, movieName];

            var isExist = false;

            if(histories.length>0){
                // Duyệt qua mỗi phần tử trong mảng histories
                histories.forEach(function(item) {
                    // Nếu giá trị đầu tiên của item trùng với history[0]
                    if (item[0] === history_watch[0]) {
                        // Cập nhật các giá trị của item từ history
                        item[1] = history_watch[1];
                        item[2] = history_watch[2];
                        item[3] = history_watch[3];
                        // Đặt cờ để biết rằng giá trị đã được cập nhật
                        isExist = true;
                    }
                });

                // Nếu giá trị chưa được thêm vào history
                if (!isExist) {
                    // Thêm giá trị vào mảng history
                    histories.push(history_watch);
                }
                 // Lưu lại danh sách histories vào localStorage
                 localStorage.setItem('histories', JSON.stringify(histories));
                
                
            }else{
                histories.push(history_watch);
                // Lưu lại danh sách movies vào localStorage
                localStorage.setItem('histories', JSON.stringify(histories));
            }
                    
                    
                    
                
        }

        function episodeSearch(that, url, movieId){
            var episode = $(that).val();
            $.ajax({
                url: url,
                type: 'POST',
                data:{
                    episode: episode,
                    movieId: movieId
                },
                success: function(res){
                    
                    $('#layoutEpisodeSearch').html(res.view);
                }
            })
        }

        function editComment(id){
            var comment = $('.comment_content_'+id).text().trim();
            $('#comment_content_edit_'+id).val(comment+' ');

            $('.edit_input_'+id).css('display', 'block');
            $('.comment_content_'+id).css('display', 'none')
            
            $('#comment_content_edit_'+id).focus();
        }

        function cancelEditComment(id){
            $('.comment_content_'+id).css('display', 'block');
            $('.edit_input_'+id).css('display', 'none');
            $('.comment_error_edit_'+id).text('');
            return false;
        }

        function saveEditComment(id, url){
            var comment_content_edit = $('#comment_content_edit_'+id).val();
            if(comment_content_edit == ""){
                $('.comment_error_edit_'+id).text('Vui lòng không để trống');
            }
            else{
                $('.comment_error_edit_'+id).text('');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data:{
                        commentId: id,
                        desEdit: comment_content_edit
                    },
                    success: function(res){
                        
                        if(res.success == 'done'){
                            $('.comment_content_'+id).text(comment_content_edit);
                            $('.edit_input_'+id).css('display', 'none');
                            $('.comment_content_'+id).css('display', 'block')
                        }
                    }
                })
            }
            return false;
        }

        function deleteComment(id){
            Swal.fire({
                title: 'Bạn chắc chắn muốn xóa bình luận này.',
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
                        url: '{{ route("home.deleteComment") }}',
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',// Thêm token CSRF
                            commentId: id
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
    </script>
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