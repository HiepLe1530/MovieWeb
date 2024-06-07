@extends('user.main')
@section('body')
    <div class="row">
        <div class="{{ empty($movieMaxFollow) ? '' : 'col-xl-8 col-lg-12' }} "> 
            <div class="d-flex p-3 align-items-center movie_detail">
                
                <div class=""> <!-- Ảnh nằm một cột -->
                    <img src="/images/{{ $movieDetail->m_Image }}" class=" img_detail_movie" alt="...">
                </div>
                <div class="flex-grow-1 ms-3 "> <!-- Các thẻ div khác nằm một cột -->
                    
                    <div class="">
                        <ul class="wrapper_detail-movie">
                            <li class="">
                                <div class="row">
                                    <span class="fw-bold col-md-3  name_intro">Tên phim</span>
                                    <span class="col-md-9  text-warning text-capitalize fw-bold">{{ $movieDetail->m_Title }}</span>
                                </div>
                            </li>
                            <li class="">
                                <div class="row">
                                    <span class="fw-bold col-md-3  name_intro">Đạo diễn</span>
                                    <span class="col-md-9  name_intro">{{$movieDetail->m_Director }}</span>
                                </div>
                            </li>
                            <li class="">
                                <div class="row">
                                    <span class="fw-bold col-md-3  name_intro">Năm công chiếu</span>
                                    <span class="col-md-9  text-info">{{ $movieDetail->m_ReleaseYear }}</span>
                                </div>
                            </li>
                            <li class="">
                                <div class="row">
                                    <span class="fw-bold col-md-3  name_intro">Thể loại</span>
                                    @if (!empty($genreByMovieId))
                                        <div class="col-md-9 ">
                                            <div class="d-flex flex-wrap ">
                                                @foreach ($genreByMovieId as $item)
                                                    <div class="me-2 mb-2"> 
                                                        <a href="{{ route('home.movieByGenre', ['g_Slug'=>$item->g_Slug, 'genreId'=>$item->id]) }}"><span class="badge bg-secondary p-2">{{ $item->g_Name }}</span></a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <span class="col-md-9 ">Thể loại phim đang được cập nhật</span>
                                    @endif
                                    
                                </div>
                            </li>
                            @if (!empty($episodeNewByMovieId))
                                <li class="">
                                    <div class="row">
                                        <span class="fw-bold col-md-3  name_intro">Tập mới nhất</span>
                                        <div class="col-md-9 ">
                                            <span class="badge text-bg-info">Tập {{ $episodeNewByMovieId->e_Episode }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li class="">
                                <div class="row">
                                    <span class="fw-bold col-md-3  name_intro">Đánh giá chung</span>
                                    <div class="col-md-9 ">
                                        @if (!empty($rating->getRatingAvg($movieDetail->m_id)))
                                            @for ($i = 1; $i <= 5; $i++)
                                                @php
                                                    if($i <= $rating->getRatingAvg($movieDetail->m_id)){
                                                        $color = 'color:orange;';
                                                    }else{
                                                        $color = 'color:#ccc;';
                                                    }
                                                @endphp
                                                <i class="fa-solid fa-star" style="{{ $color }}"></i>
                                            @endfor
                                            <span style="color: aliceblue"> / {{ $rating->getRatingCount($movieDetail->m_id) }} lượt</span>
                                        @else
                                            <span style="color: aliceblue">Chưa có đánh giá</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <li class="">
                                <div class="row">
                                    <span class="fw-bold col-md-3  name_intro">Đánh giá của bạn</span>
                                    <div class="col-md-9 ">
                                        @if (!empty($rating->getRatingByMovieIdAndIpAddress($movieDetail->m_id, request()->ip())))
                                            @for ($i = 1; $i <= 5; $i++)
                                                @php
                                                    if($i <= $rating->getRatingByMovieIdAndIpAddress($movieDetail->m_id, request()->ip())->r_Rating){
                                                        $color = 'color:orange;';
                                                    }else{
                                                        $color = 'color:#ccc;';
                                                    }
                                                @endphp
                                                <i class="fa-solid fa-star" style="{{ $color }}"></i>
                                            @endfor
                                        @else
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div class="d-inline rating"
                                                data-rating="{{ $i }}"
                                                data-movie_id="{{ $movieDetail->m_id }}"
                                                style="cursor: pointer;">
                                                    <i class="fa-solid fa-star" 
                                                    id="{{ $movieDetail->m_id }}-{{ $i }}"
                                                    style="color: #ccc;"></i>
                                                </div>
                                            @endfor
                                            <span style="color: red">(Bạn chưa đánh giá)</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            <div class="movie_detail ">
                <div class="d-flex justify-content-between p-3">
                    @if (!empty($episodeNewByMovieId))
                        <a href="{{ route('home.episodeDetail', ['movieId'=>$movieDetail->m_id, 'm_Slug'=>$movieDetail->m_Slug, 'e_Episode'=>$episodeNewByMovieId->e_Episode]) }}" class="btn_history btn btn_watchMovie-folow">
                            <i class="fa-regular fa-circle-play me-2"></i>Xem Phim
                        </a>
                        
                    @endif
                    @if (Auth::check())
                        @if (!empty($follow))
                            @include('layout.user.btn_unfollow', ['movieId'=>$movieDetail->m_id])
                        @else
                            @include('layout.user.btn_follow', ['movieId'=>$movieDetail->m_id])
                        @endif
                    @else
                        <div id="followOrunfollow_localStorage"></div>
                    @endif
                    {{-- <div id="followOrunfollow">
                        <a onclick="follow('{{ route('home.follow', ['movieId'=>$movieDetail->m_id]) }}')" class="btn btn_watchMovie-folow"><i class="fa-solid fa-bookmark me-2"></i>Theo Dõi</a>
                    </div> --}}
                    
                </div>
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
                        <div class=" col-md-2 col-sm-3 wrapper_btn-episode"><a href="{{ route('home.episodeDetail', ['movieId'=>$movieDetail->m_id, 'm_Slug'=>$movieDetail->m_Slug, 'e_Episode'=>$item->e_Episode]) }}" class="btn_history btn btn-episode">{{ $item->e_Episode }}</a></div>
                    @endforeach
                    
                @else
                    <div class="d-flex justify-content-center align-items-center "><p class=" text-light ">Tập phim sắp được công chiếu.</p></div>
                @endif
                
            </div>
            <div class="movie_detail ">
                <div class="p-3"><h5 class="mt-2 text-decoration-underline text-uppercase " style="color:chocolate">Mô tả phim</h5></div>
                <p class="ps-3 pe-3 pb-3" style="color: #ffffffb3">{{ $movieDetail->m_Description }}</p>
            </div>
        
            <div class="movie_detail p-5">
                <div class="comment ">
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

            $(document).on('mouseenter', '.rating', function(){
                var rating = $(this).data('rating');
                var movieId = $(this).data('movie_id');
                for(var i=1; i<=rating; i++){
                    $('#'+movieId+'-'+i).css('color','orange');
                }
            })

            $(document).on('mouseleave', '.rating', function(){
                var movieId = $(this).data('movie_id');
                for(var i=1; i<=5; i++){
                    $('#'+movieId+'-'+i).css('color','#ccc');
                }
            })
            $(document).on('click', '.rating', function(){
                var rating = $(this).data('rating');
                var movieId = $(this).data('movie_id');
                var _url = "{{ route('home.addRating') }}";
                $.ajax({
                    url: _url,
                    type: 'POST',
                    data: {
                        rating: rating,
                        movieId: movieId
                    },
                    success: function(res){
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
                        }
                        // if(res.exist){
                        //     Swal.fire({
                        //         position: "center",
                        //         icon: "success",
                        //         title: res.exist,
                        //         showConfirmButton: false,
                        //         timer: 1500
                        //     });
                        // }
                    }
                })
            })

        });

        if('{{ Auth::check() }}'){
            function follow(url){
                $.ajax({
                    url: url,
                    type: 'POST',
                    success: function(res){
                        
                        $('#followOrunfollow').html(res.btn_unfollow)
                    }
                })
            }

            function unFollow(url){
                $.ajax({
                    url: url,
                    type: 'POST',
                    success: function(res){
                        
                        $('#followOrunfollow').html(res.btn_follow)
                    }
                })
            }
        }else{
            if(!localStorage.getItem('follows')){
                localStorage.setItem('follows', JSON.stringify([]));
            }

            var follows = JSON.parse(localStorage.getItem('follows'));
            var movieId = '{{ $movieDetail->m_id }}';
            var movieImage = '{{ $movieDetail->m_Image }}';
            var movieName = '{{ $movieDetail->m_Title }}';
            var follow = [movieId, window.location.href, movieImage, movieName];

            var isExist = false;

            if(follows.length>0){
                for(var i=0; i<follows.length; i++){
                    if(JSON.stringify(follows[i]) === JSON.stringify(follow)){
                        isExist = true;
                        break;
                    }
                }
                if(isExist){
                    $('#followOrunfollow_localStorage').html(`<div id="followOrunfollow_localStorage">
                                                                <a onclick="unFollowLocalStorage()" class="btn btn_watchMovie-unfolow">
                                                                    <i class="fa-solid fa-bookmark me-2"></i>
                                                                    Hủy Theo Dõi
                                                                </a>
                                                            </div>`);
                }else{
                    $('#followOrunfollow_localStorage').html(`<div id="followOrunfollow_localStorage">
                                                                <a onclick="followLocalStorage()" class="btn btn_watchMovie-folow">
                                                                    <i class="fa-solid fa-bookmark me-2"></i>
                                                                    Theo Dõi
                                                                </a>
                                                            </div>`);
                }
            }else{
                $('#followOrunfollow_localStorage').html(`<div id="followOrunfollow_localStorage">
                                                            <a onclick="followLocalStorage()" class="btn btn_watchMovie-folow">
                                                                <i class="fa-solid fa-bookmark me-2"></i>
                                                                Theo Dõi
                                                            </a>
                                                        </div>`);
            }


            function followLocalStorage(){
                
                var follows = JSON.parse(localStorage.getItem('follows'));
                var movieId = '{{ $movieDetail->m_id }}';
                var movieImage = '{{ $movieDetail->m_Image }}';
                var movieName = '{{ $movieDetail->m_Title }}';
                var follow = [movieId, window.location.href, movieImage, movieName];

                var isExist = false;

                if(follows.length>0){
                    for(var i=0; i<follows.length; i++){
                        if(JSON.stringify(follows[i]) === JSON.stringify(follow)){
                            isExist = true;
                            break;
                        }
                    }
                    if(!isExist){
                        // Add historys
                        follows.push(follow);
                        // Lưu lại danh sách movies vào localStorage
                        localStorage.setItem('follows', JSON.stringify(follows));
                    }
                    
                }else{
                    // var movieImage = '{{ $movieDetail->m_Image }}';
                    // var movieName = '{{ $movieDetail->m_Title }}';
                    // var history = [window.location.href, movieImage, movieName];
                    // Add historys
                    follows.push(follow);
                    // Lưu lại danh sách movies vào localStorage
                    localStorage.setItem('follows', JSON.stringify(follows));
                }
                $('#followOrunfollow_localStorage').html(`<div id="followOrunfollow_localStorage">
                                                            <a onclick="unFollowLocalStorage()" class="btn btn_watchMovie-unfolow">
                                                                <i class="fa-solid fa-bookmark me-2"></i>
                                                                Hủy Theo Dõi
                                                            </a>
                                                        </div>`);
            }

            function unFollowLocalStorage(){
                var follows = JSON.parse(localStorage.getItem('follows'));
                var url = window.location.href;

                var filteredFollow = follows.filter(function(subArray) {
                    // Trả về true nếu giá trị cần xóa không được tìm thấy trong mảng con
                    return subArray.indexOf(url) === -1;
                });
                // Lưu filteredFollow trở lại localStorage
                localStorage.setItem('follows', JSON.stringify(filteredFollow));
                $('#followOrunfollow_localStorage').html(`<div id="followOrunfollow_localStorage">
                                                            <a onclick="followLocalStorage()" class="btn btn_watchMovie-folow">
                                                                <i class="fa-solid fa-bookmark me-2"></i>
                                                                Theo Dõi
                                                            </a>
                                                        </div>`);
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