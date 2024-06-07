@extends('user.main')

@section('body')
    @include('layout.user.owl_carousel')
    @include('layout.user.listItemMovie')
@endsection

@section('script')
    <script>
        //Tự động chuyển đổi carousel
        $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            loop: true,
            dots:false,
            nav: true,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            navText: [
            "<i class='fas fa-chevron-left'></i>",
            "<i class='fas fa-chevron-right'></i>"
            ],
            responsive: {
                0: {
                    items: 1 // Hiển thị 1 ảnh khi màn hình nhỏ hơn hoặc bằng sm
                },
                768: {
                    items: 2 // Hiển thị 2 ảnh khi màn hình có kích thước lg (992px) hoặc md (768-991px)
                },
                992: {
                    items: 2 // Hiển thị 2 ảnh khi màn hình có kích thước lg (992px) hoặc md (768-991px)
                }
            }
        });
        });
        
    </script>
@endsection