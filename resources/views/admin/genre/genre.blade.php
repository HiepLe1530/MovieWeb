@extends('admin.main')
@section('content')
    
    <div class="container ">
        @if(session('success'))
            <div id="alert" class="alert alert-info text-center">
                {{session('success')}}
            </div>
        @endif
        @if(session('error'))
            <div id="alert" class="alert alert-danger text-center">
                {{session('error')}}
            </div>
        @endif
        
        <div class="pt-4 d-flex justify-content-between ">
            <h4 class="title">Quản lý thể loại phim</h4>
            <a href="{{ route('admin.genre.add') }}" class="btn btn-info btnThem"><i class="fa-solid fa-plus"></i> Thêm thể loại phim</a>
        </div>
        <table class="table-secondary mt-3 w-100">
            <thead style="border: 1px solid black">
                <tr>
                    <th class="col-2">#</th>
                    <th class="col-8">Tên thể loại phim</th>
                    <th class="col-2">Hành động</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @if (!empty($genres))
                    @foreach ($genres as $item)
                        <tr>
                            <td>{{ $index++ }}</td>
                            <td>{{ $item->g_Name }}</td>
                            <td>
                                <a href="{{ route('admin.genre.edit', ['id'=>$item->id]) }}" class="mr-2"><i class="fa-solid fa-pen-to-square" style="color: green"></i></a>
                                <a onclick="Delete('Bạn chắc chắn muốn xóa thể loại {{$item->g_Name}} ?', '{{ route('admin.genre.delete', ['id'=>$item->id]) }}')"><i  class="fa-solid fa-trash" style="color: red"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">{{ $norecord }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
        
        
    
@endsection

{{-- @section('script')
    <script type="text/javascript">
        // Tự động đóng thông báo sau 3 giây
        setTimeout(function() {
            var alert = document.getElementById('alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>
@endsection --}}