<div class="row">
    <div class="{{ empty($movieMaxFollow) ? '' : 'col-xl-8 col-lg-12' }} ">
        <!-- Item movie -->
        <h5 style="text-decoration: underline; color: chocolate; margin:15px 0" class="text-uppercase ">{{ $title_content }}</h5>
        <div class="row">
            @if (!empty($movieAndEpisodeNew->items()))
                @foreach ($movieAndEpisodeNew as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                        <div class="item_movie">
                            <a href="{{ route('home.movieDetail', ['movieId'=>$item->m_id, 'm_Slug'=>$item->m_Slug]) }}">
                                <img src="/images/{{ $item->m_Image }}" alt="">
                                <div class="item_movie_name d-flex flex-column justify-content-center ">
                                    <div>
                                        <p class="text-capitalize">{{ Str::limit($item->m_Title, 15) }}</p>
                                    </div>
                                    
                                </div>
                                <span class="badge text-bg-warning episodeNew">Tập {{ $item->episodeNew }}</span>
                            </a>
                            
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center align-items-center mt-4">
                    {{ $movieAndEpisodeNew->links() }}
                </div>
            @else
                <div class="col-10 norecord_listItem"><h4> {{ $norecord }}</h4></div>
            @endif
            
        </div>
    </div>
    @if (!empty($movieMaxFollow))
        <div class="related_movie col-xl-4 col-lg-12 ">
            @include('layout.user.list_follow_max', ['movieMaxFollow' => $movieMaxFollow, 'rating' => $rating])
        </div>
    @endif
</div>