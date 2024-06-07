<div class="row p-3">
    @if (!empty($histories))
        @foreach ($histories as $item)
            <div class="col-6 pt-2 pb-2">
                <a href="{{ $item[1] }}" style="text-decoration: none">
                    <div class="d-flex" style="background: #1b2d3c;">
                        <img src="/images/{{ $item[4] }}" alt="{{ $item[4] }}" style="width:100px; height:110px; object-fit:cover">
                        <div class="d-flex flex-column justify-content-center  ms-3">
                            <p style="color: #e6dede; margin:5px 0" class=" text-capitalize fw-bold ">{{ $item[5] }}</p>
                            <p style="color: #e6dede; margin:5px 0">Bạn đã xem Tập {{ $item[2] }}</p>
                            <span style="color: rgba(178, 187, 40, 0.755)">{{ $item[3] }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    @else
        <div class="col-10 norecord_history">
            <h4> Bạn chưa xem bộ phim nào. </h4>
        </div>
    @endif
    
    
</div>