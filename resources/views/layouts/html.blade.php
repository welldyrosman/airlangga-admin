<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Airlangga Administrator</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('vendors/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/plugins/summernote/summernote-bs4.min.css')}}">
  <link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
  <!-- Theme style -->
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('vendors/dist/css/adminlte.min.css')}}">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{asset('vendors/plugins/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('vendors/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendors/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<!-- Bootstrap 4 -->
<!-- JavaScript Bundle with Popper -->

<!-- AdminLTE App -->
<script src="{{asset('vendors/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('vendors/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="{{ mix('js/app.js') }}"></script>

</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div id="app" class="wrapper">

  <!-- Navbar -->
  @include('layouts.topMenu')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.leftMenu')
  <div class="content-wrapper">
    <div class="content">
      <div class="container-fluid">
        <section class="content">
            @yield('content')
            <br>
            <br>
            <br>
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




</body>
</html>
