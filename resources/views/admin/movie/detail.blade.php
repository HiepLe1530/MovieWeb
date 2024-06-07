@extends('admin.main')

@section('content')
<div class="container ">
    
    <div class="pt-4 d-flex justify-content-between ">
        <h4 class="title">Chi tiết bộ phim</h4>
    </div>
    @if(session('error'))
        <div id="alert" class="alert alert-info text-center mt-2">
            {{session('error')}}
        </div>
    @endif
    <div class="row mt-3 align-items-center">
        <div class="col-md-2 "> <!-- Ảnh nằm một cột -->
            <img src="/images/{{ $detail->m_Image }}" class="card-img-top" alt="...">
        </div>
        <div class="col-md-10"> <!-- Các thẻ div khác nằm một cột -->
            
            <div class="cart-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <span class="font-weight-bold col-2">Tên phim</span>
                            <span class="col-10">{{ $detail->m_Title }}</span>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <span class="font-weight-bold col-2">Đạo diễn</span>
                            <span class="col-10">{{$detail->m_Director }}</span>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <span class="font-weight-bold col-2">Năm công chiếu</span>
                            <span class="col-10">{{ $detail->m_ReleaseYear }}</span>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <span class="font-weight-bold col-2">Thể loại</span>
                            @if (!empty($genreNameByMovieId))
                                <div class="col-10">
                                    <div class="row">
                                        @foreach ($genreNameByMovieId as $item)
                                            <div class="col-2"> 
                                                <h5><span class="badge bg-genre-movie">{{ $item->g_Name }}</span></h5>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <span class="col-10">Thể loại phim đang được cập nhật</span>
                            @endif
                            
                        </div>
                    </li>
                    
                </ul>
            </div>
            
        </div>
    </div>
    <h5 class="mt-2 title">Mô tả</h5>
    <span>{{ $detail->m_Description }}</span>
    @if(session('success'))
        <div id="alert" class="alert alert-info text-center mt-2">
            {{session('success')}}
        </div>
    @endif
    <table class=" table-light mt-3 w-100">
        <thead style="border: 1px solid black">
            <tr>
                <th class="col-2">Tập phim</th>
                <th class="col-8">Video phim</th>
                <th class="col-2">Hành động</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @if (!empty($episodeByMovieId))
                @foreach ($episodeByMovieId as $episode)
                    <tr>
                        <td>{{ $episode->e_Episode }}</td>
                        <td>
                            <video  controls poster="/images/poster/{{ $detail->m_Poster }}" muted width="150px" height="100px">
                                <source src="/videos/{{ $episode->e_MovieVideo }}">
                            </video>
                        </td>
                        <td>
                            <a href="{{ route('admin.movie.editEpisode', ['id'=>$detail->m_id, 'episodeId'=>$episode->id]) }}" class="mr-2"><i class="fa-solid fa-pen-to-square" style="color: green"></i></a>
                            <a onclick="deleteEpisode('{{$episode->e_Episode}}', '{{ route('admin.movie.deleteEpisode', ['id'=>$detail->m_id, 'episodeId'=>$episode->id]) }}')"><i  class="fa-solid fa-trash" style="color: red"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Vui lòng cập nhật tập phim</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class=" mt-2 mb-2">
        <a href="{{ route('admin.movie.addEpisode', ['id'=>$detail->m_id]) }}" class="btn btn-info "><i class="fa-solid fa-plus"></i> Thêm tập phim</a>
        <a href="{{ route('admin.movie.movie') }}" class="btn btn-warning">Quay lại</a>
    </div>
</div>
@endsection

