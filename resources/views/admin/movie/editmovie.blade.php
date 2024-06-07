@extends('admin.main')
@section('content')
<div class="container">
    <h4 class="title pt-4">Chỉnh sửa bộ phim</h4>
    <form action="{{ route('admin.movie.update') }}" method="POST" class="mt-3 mb-3" enctype="multipart/form-data">
        @if (session('error'))
            <div id="alert" class="alert alert-danger text-center">
                {{session('error')}}
            </div>
        @endif
        <div class="mb-3">
            <label for="">Ảnh bộ phim</label>
            <img class="ml-4" src="/images/{{ $movieById->m_Image }}" alt="" width="60px">
            <input type="file" class="form-control-file" name="m_Image">
            @error('m_Image')
            <span style="color: red">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="">Poster</label>
            <img class="ml-5" src="/images/poster/{{ $movieById->m_Poster }}" alt="" height="60px">
            <input type="file" class="form-control-file" name="m_Poster">
            @error('m_Poster')
            <span style="color: red">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="">Tên bộ phim</label>
            <input type="text" class="form-control" name="m_Title" placeholder="Tên bộ phim.." value="{{old('m_Title') ?? $movieById->m_Title}}">
            @error('m_Title')
            <span style="color: red">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="">Đạo diễn</label>
            <input type="text" class="form-control" name="m_Director" placeholder="Đạo diễn.." value="{{old('m_Director') ?? $movieById->m_Director}}">
            @error('m_Director')
            <span style="color: red">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="">Năm công chiếu</label>
            <input type="text" class="form-control" name="m_ReleaseYear" placeholder="Năm công chiếu.." value="{{old('m_ReleaseYear') ?? $movieById->m_ReleaseYear}}">
            @error('m_ReleaseYear')
            <span style="color: red">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="">Mô tả</label>
            <textarea name="m_Description" class="form-control" id="" rows="5">{{ old('m_Description') ?? $movieById->m_Description}}</textarea>
            @error('m_Description')
            <span style="color: red">{{$message}}</span>
            @enderror
        </div>
        @if (!empty($genres))
                <div class="mb-3">
                    <label for="">Thể loại phim</label>
                    <div class="row">
                        @foreach ($genres as $genre)
                            <div class="col-md-3"> 
                                <div class="form-check form-check-inline"> <!-- Sử dụng lớp form-check-inline để checkbox hiển thị trên cùng một hàng -->
                                    <input class="form-check-input" type="checkbox" value="{{ $genre->id }}" id="{{ $genre->id }}" name="genres[]"
                                    @if(!empty(old('genres')))
                                        @if((is_array(old('genres')) && in_array($genre->id, old('genres'))))
                                            checked 
                                        @endif
                                    @else
                                        @if( in_array($genre->id, $genreIdByMovieIdInt))
                                            checked 
                                        @endif
                                    @endif
                                    
                                    >
                                    <label class="form-check-label" for="{{ $genre->id }}">
                                        {{ $genre->g_Name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('genres')
                        <span style="color: red">{{$message}}</span>
                    @enderror
                </div>
            @else
                <span style="color: red" class="form-control-file mb-3">Vui lòng thêm thể loại phim trước khi thêm bộ phim</span>
            @endif
        <button type="submit" class="btn btn-primary" {{ empty($genres)?'disabled':'' }}>Chỉnh sửa bộ phim</button>
        <a href="{{ route('admin.movie.movie') }}" class="btn btn-warning">Quay lại</a>
        
        @csrf
        @method('PUT')
    </form>
</div>
@endsection