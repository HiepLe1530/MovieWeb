<div>
    
    <div class="mt-2">
        <form method="GET" class="d-flex" role="search">
            <div style="margin-right: 10px">
                <label for="">Tên bộ phim</label>
                <input wire:model.live.debounce.500ms="movieName" class="form-control" type="search" name="" placeholder="Tên phim" aria-label="Search"  value="" >
                
            </div>
            <div style="margin-right: 10px">
                <label for="">Tên đạo diễn</label>
                <input wire:model.live.debounce.500ms="directorName" class="form-control" type="search" name="title" placeholder="Tên đạo diễn" aria-label="Search"  value="" >
                
            </div>
            <div>
                <label for="">Năm công chiếu</label>
                <select wire:model.live.debounce.500ms="releaseYear" class="form-control" name="" id="">
                    <option value="0">Chọn năm công chiếu</option>
                    @for ($i = $currentYear; $i >= 1900; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                
            </div>
            
        </form>
        
    </div>
    <table class="table-secondary mt-3 mb-3 w-100">
        <thead style="border: 1px solid black">
            <tr>
                <th class="col-1.5">Ảnh phim</th>
                <th class="col-2">Poster</th>
                <th class="col-2">Tên phim</th>
                <th class="col-2">Đạo diễn</th>
                <th class="col-1.5">Năm công chiếu</th>
                <th class="col-2">Mô tả</th>
                <th class="col-0.5">Hành động</th>
                <th class="col-0.5"></th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @if (!empty($movies))
                @foreach ($movies as $movie)
                    <tr style="border: 1px solid black">
                        <td><img src="/images/{{ $movie->m_Image }}" alt=""  class="movie_image"></td>
                        <td><img src="/images/poster/{{ $movie->m_Poster }}" alt=""  style="width:100%; height:100%; object-fit:cover"></td>
                        <td>{{ $movie->m_Title }}</td>
                        <td>{{ $movie->m_Director }}</td>
                        <td>{{ $movie->m_ReleaseYear }}</td>
                        <td class="">{{ Str::words($movie->m_Description, 10) }}</td>
                        <td>
                            <a href="{{ route('admin.movie.edit',['id'=>$movie->m_id]) }}" class="mr-2"><i class="fa-solid fa-pen-to-square" style="color: green"></i></a>
                            <a onclick="deleteMovie('{{$movie->m_Title}}', '{{ route('admin.movie.delete', ['id'=>$movie->m_id]) }}')"><i  class="fa-solid fa-trash" style="color: red"></i></a>
                        </td>
                        <td>
                            <a href="{{ route('admin.movie.detail',['id'=>$movie->m_id]) }}" class="btn btn-outline-success  ">Chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" style="color: black">{{ $norecord }}</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{-- @if (!empty($movies))
        <div class="d-flex justify-content-end mt-3">
            {{ $movies->links() }}
        </div>
    @endif --}}
    {{-- <div class="d-flex justify-content-end mt-3">
        {{ $movies->links() }}
    </div> --}}
</div>