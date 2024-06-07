@extends('admin.main')
@section('content')
    <div class="container">
        <h4 class="title pt-4">Chỉnh sửa quyền</h4>
        <form action="{{ route('admin.role.update') }}" method="POST" class="mt-3 mb-3" >
            @if (session('error'))
                <div id="alert" class="alert alert-danger text-center">
                    {{session('error')}}
                </div>
            @endif
            
            <div class="mb-3">
                <label for="">Tên quyền</label>
                <input type="text" class="form-control" name="r_Name" placeholder="Tên quyền.." value="{{old('r_Name') ?? $roleById->r_Name}}">
                @error('r_Name')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Mô tả</label>
                <input type="text" class="form-control" name="r_Description" placeholder="Mô tả.." value="{{old('r_Description') ?? $roleById->r_Description}}">
                @error('r_Description')
                <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Chỉnh sửa quyền</button>
            <a href="{{ route('admin.role.role') }}" class="btn btn-warning">Quay lại</a>
            @csrf
            @method('PUT')
        </form>
    </div>
    
    
@endsection

