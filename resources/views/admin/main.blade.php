<!DOCTYPE html>
<html lang="en">
<head>
  @include('layout.admin.head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  {{-- <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/images/logo.png" alt="hh3D.tv Logo" height="60" width="60">
  </div> --}}

  @include('layout.admin.nav')

  @include('layout.admin.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  
  <!-- /.content-wrapper -->
  @include('layout.admin.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@include('layout.admin.script_bottom')
@yield('script')

</body>
</html>
