@extends('admin.main')
@section('content')
    <div class="container">
        <h4 class="title pt-4">Chỉnh sửa tập phim</h4>
        <form action="{{ route('admin.movie.updateEpisode', ['id'=>$movieId]) }}" method="POST" class="mt-3 mb-3" enctype="multipart/form-data">
            @if (session('error'))
                <div id="alert" class="alert alert-danger text-center">
                    {{session('error')}}
                </div>
            @endif
            <div class="mb-3">
                <label for="">ID bộ phim</label>
                <input type="text" class="form-control" name="e_m_id" readonly value="{{$movieId}}">
            </div>
            <div class="mb-3">
                <label for="">Tập phim</label>
                <input type="text" class="form-control" name="e_Episode" placeholder="Tập phim.." value="{{old('e_Episode') ?? $episode->e_Episode}}">
                @error('e_Episode')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="">Video tập phim</label>
                <span class="form-control-file">{{ $episode->e_MovieVideo }}</span>
                <input type="file" class="form-control-file" name="e_MovieVideo">
                @error('e_MovieVideo')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            
            <input type="submit" class="btn btn-primary" value="Chỉnh sửa tập phim"></input>
            <a href="{{ route('admin.movie.detail',['id'=>$movieId]) }}" class="btn btn-warning">Quay lại</a>
            @csrf
            @method('PUT')
        </form>
    </div>
    
@endsection