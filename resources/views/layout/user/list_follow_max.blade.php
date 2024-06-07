<h5 style="margin: 15px 0; color:chocolate; text-decoration:underline" class="text-uppercase ">Top phim theo dõi nhiều</h5>
<div class="row">
    @foreach ($movieMaxFollow as $item)
        <div class="col-xl-12 col-md-6 mb-2 " style="">
            <a href="{{ route('home.movieDetail', ['movieId'=>$item->m_id, 'm_Slug'=>$item->m_Slug]) }}" style="text-decoration: none">
                <div class="d-flex" style="background: #162312; border-radius:10px">
                    <img src="/images/{{ $item->m_Image }}" alt="{{ $item->m_Image }}" style="width:100px; height:110px; object-fit:cover; border-radius:10px 0 0 10px">
                    <div class="d-flex flex-column justify-content-center  ms-3">
                        <p style="color: #e6dede; margin:5px 0" class=" text-capitalize fw-bold ">{{ $item->m_Title }}</p>
                        <p style="color: #e6dede; margin:5px 0">Tập mới nhất: <span class=" badge text-bg-warning ">{{ $item->episodeNew }}</span></p>
                        <div>
                            @if (!empty($rating->getRatingAvg($item->m_id)))
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        if($i <= $rating->getRatingAvg($item->m_id)){
                                            $color = 'color:orange;';
                                        }else{
                                            $color = 'color:#ccc;';
                                        }
                                    @endphp
                                    <i class="fa-solid fa-star" style="font-size:15px; {{ $color }}"></i>
                                @endfor
                                <span style="color: aliceblue; font-size:15px;"> / {{ $rating->getRatingCount($item->m_id) }} lượt</span>
                            @else
                                <span style="color: aliceblue">Chưa có đánh giá</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
    
    
</div>