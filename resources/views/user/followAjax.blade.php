<div class="row p-3">
    @if (!empty($follows))
        @foreach ($follows as $item)
            <div class="col-xx-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 mb-2 item_history">
                <div class="item_movie ">
                    <a href="{{ $item[1] }}">
                        <img src="/images/{{ $item[2] }}" alt="{{ $item[2] }}">
                        <div class="item_movie_name">
                            <p class="text-capitalize">{{ $item[3] }}</p>
                        </div>
                    </a>
                    
                </div>
                <i class="fa-solid fa-xmark icon_del"
                    onclick="deleteFollowFromLocalStorage('{{ $item[3] }}', '{{ $item[1] }}')"></i>
            </div>
        @endforeach
    @else
        <div class="col-10 norecord_history">
            <h4> Bạn chưa theo dõi bộ phim nào. </h4>
        </div>
    @endif
    
    
</div>