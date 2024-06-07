@extends('admin.main')
@section('content')
    <div class="container">
        <h4 class="title pt-4">Thêm bộ phim</h4>
        <form action="" method="POST" class="mt-3 mb-3" enctype="multipart/form-data">
            @if (session('error'))
                <div id="alert" class="alert alert-danger text-center">
                    {{session('error')}}
                </div>
            @endif
            <div class="mb-3">
                <label for="">Ảnh bộ phim</label>
                <input type="file" class="form-control-file" name="m_Image">
                @error('m_Image')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Poster</label>
                <input type="file" class="form-control-file" name="m_Poster">
                @error('m_Poster')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Tên bộ phim</label>
                <input type="text" class="form-control" name="m_Title" placeholder="Tên bộ phim.." value="{{old('m_Title')}}">
                @error('m_Title')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Đạo diễn</label>
                <input type="text" class="form-control" name="m_Director" placeholder="Đạo diễn.." value="{{old('m_Director')}}">
                @error('m_Director')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Năm công chiếu</label>
                <input type="text" class="form-control" name="m_ReleaseYear" placeholder="Năm công chiếu.." value="{{old('m_ReleaseYear')}}">
                @error('m_ReleaseYear')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Mô tả</label>
                <textarea name="m_Description" class="form-control" id="" rows="5">{{ old('m_Description') }}</textarea>
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
                                    @if(is_array(old('genres')) && in_array($genre->id, old('genres'))) checked @endif
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
            
            <button type="submit" class="btn btn-primary" {{ empty($genres)?'disabled':'' }}>Thêm bộ phim</button>
            <a href="{{ route('admin.movie.movie') }}" class="btn btn-warning">Quay lại</a>
            @csrf
        </form>
    </div>
    
    
@endsection

{{-- @section('content')
    <div class="container">
        <h4 class="title pt-4">Thêm bộ phim</h4>
        <form action="" method="POST" class="mt-3 mb-3" enctype="multipart/form-data">
            @if (session('error'))
                <div id="alert" class="alert alert-danger text-center">
                    {{session('error')}}
                </div>
            @endif
            <div class="mb-3">
                <label for="">Ảnh bộ phim</label>
                <input type="file" class="form-control-file" name="m_Image">
                @error('m_Image')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Tên bộ phim</label>
                <input type="text" class="form-control" name="m_Title" placeholder="Tên bộ phim.." value="{{old('m_Title')}}">
                @error('m_Title')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
        </form>
    </div>
@endsection --}}