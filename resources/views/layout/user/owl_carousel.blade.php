<!-- Carousel -->
<div class="owl-carousel owl-theme pt-2">
    @foreach ($moviePoster as $item)
        <div class="item">
            <a href="{{ route('home.movieDetail', ['movieId'=>$item->m_id, 'm_Slug'=>$item->m_Slug]) }}">
                <img src="/images/poster/{{ $item->m_Poster }}" alt="{{ $item->m_Poster }}">
                <div class="movie_name-slide d-flex flex-column justify-content-center ">
                    <div>
                        <h3 class="text-capitalize movie_name">{{ $item->m_Title }}</h3>
                    </div>
                    
                </div>
            </a>
        </div>
    @endforeach
    <!-- Add more items as needed -->

</div>