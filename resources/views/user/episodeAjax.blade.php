<div class="movie_detail row p-2" style="max-height: 180px; overflow: auto; background: unset;">
    @if (!empty($episodeSearch))
        @foreach ($episodeSearch as $item)
            <div class=" col-md-1 col-sm-3 wrapper_btn-episode"><a href="{{ route('home.episodeDetail', ['movieId'=>$item->m_id, 'm_Slug'=>$item->m_Slug, 'e_Episode'=>$item->e_Episode]) }}" class="btn_history btn btn-episode">{{ $item->e_Episode }}</a></div>
        @endforeach
        
    @else
        <div class="d-flex justify-content-start  align-items-center "><p class=" text-light ">Không có kết quả!</p></div>
    @endif
    
</div>