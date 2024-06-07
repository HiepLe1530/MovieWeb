@extends('admin.main')
@section('content')
    <div class="container">
        <h4 class="title pt-4">Chỉnh sửa thể loại phim</h4>
        <form action="{{ route('admin.genre.update') }}" method="POST" class="mt-3 mb-3" >
            @if (session('error'))
                <div id="alert" class="alert alert-danger text-center">
                    {{session('error')}}
                </div>
            @endif
            
            <div class="mb-3">
                <label for="">Thể loại phim</label>
                <input type="text" class="form-control" name="g_Name" placeholder="Thể loại phim.." value="{{old('g_Name') ?? $genresById->g_Name}}">
                @error('g_Name')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Chỉnh sửa thể loại phim</button>
            <a href="{{ route('admin.genre.genre') }}" class="btn btn-warning">Quay lại</a>
            @csrf
            @method('PUT')
        </form>
    </div>
    
    
@endsection

