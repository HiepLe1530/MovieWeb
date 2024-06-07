<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>hh3d.tv</title>
    {{-- Link Bootstrap --}}
    <link href="/user/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Owl Carousel CSS  --}}
    <link rel="stylesheet" href="/user/owl_carousel/dist/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="/user/owl_carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="/user/owl_carousel/dist/assets/owl.theme.green.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css">
    {{-- Link css --}}
    <link rel="stylesheet" href="/user/css/style.css">
  </head>
  <body>
    @include('layout.user.navbar')

    @include('layout.user.nav_genre')
    <div class="wrapper">
      <div class="body" style="background-color: #1b2d3c; ">
        <div class="container" style="background-color: #2b3029; ">
          @yield('body')
        </div>
      </div>
      
  
      @include('layout.user.footer')
    </div>
    
    
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="/user/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="/user/owl_carousel/dist/owl.carousel.min.js"></script>
    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    @yield('style')
    @yield('script')
    
  </body>
</html>

