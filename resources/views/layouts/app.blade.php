<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Airlangga Administrator</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('vendors/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('vendors/dist/css/adminlte.min.css')}}">
</head>
<body  class="hold-transition sidebar-mini">
<div id="app" class="wrapper">

  <!-- Navbar -->
  @include('layouts.topMenu')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.leftMenu')
  <div class="content-wrapper">
    <div class="content">
        <app></app>
      <div class="container-fluid">
        <section class="content">
            @yield('content')
        </section>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('layouts.rightMenu')
  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  @include('layouts.footer')
  <!-- Main Footer -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{asset('vendors/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('vendors/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('vendors/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
