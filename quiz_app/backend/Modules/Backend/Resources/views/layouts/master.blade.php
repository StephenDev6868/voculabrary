<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VE 3000 App | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('modules/backend/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- dropify -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/dropify/css/dropify.min.css') }}">
    <!-- toastr -->
    <link rel="stylesheet" href="{{ asset('modules/plugins/toastr/toastr.min.css') }}">
    <!-- loading modal -->
    <link rel="stylesheet" href="{{ asset('modules/plugins/loadingModal/css/jquery.loadingModal.css') }}" />
    <!-- boostrap datepicker -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" />

    <!-- DataTables -->
    <link href="{{ asset('modules/plugins/datatables/dataTables.bootstrap4.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('modules/plugins/datatables/buttons.bootstrap4.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('modules/plugins/datatables/responsive.bootstrap4.css') }} " rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('modules/backend/css/style.css') }}">
    @yield('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('images/Logo_VE3000.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
{{--            <li class="nav-item d-none d-sm-inline-block">--}}
{{--                <a href="{{ route('backend.home') }}" class="nav-link">Trang chủ</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item d-none d-sm-inline-block">--}}
{{--                <a href="#" class="nav-link">@yield('title')</a>--}}
{{--            </li>--}}
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <img src="{{ !empty(auth::user()->avatar) ? getUrlFile(auth::user()->avatar) : asset('modules/backend/dist/img/user2-160x160.jpg') }}" class="img-circle avatar-user elevation-2" alt="User Image">
                    <span class="hidden-xs"> {{auth::user()->fullname ?  auth::user()->fullname : auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="{{ route('user.edit', auth::user()->id) }}" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ !empty(auth::user()->avatar) ? getUrlFile(auth::user()->avatar) : asset('modules/backend/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    {{auth::user()->fullname ?  auth::user()->fullname : auth::user()->name }}
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Cập nhật thông tin</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item dropdown-footer" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('backend.home') }}" class="brand-link">
            <img src="{{ !empty(auth::user()->avatar) ? getUrlFile(auth::user()->avatar) : asset('modules/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ auth::user()->fullname ?  auth::user()->fullname : auth::user()->name }}</span>
        </a>

        <!-- Sidebar -->
    @include('backend::layouts.components.sidebar')
    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-1">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.home') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main content -->
                @yield('content')
            </div>
        </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} <a href="{{ route('backend.home') }}">VE 300 App</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('modules/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('modules/backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('modules/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('modules/backend/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('modules/backend/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('modules/backend/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('modules/backend/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('modules/backend/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('modules/backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('modules/backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('modules/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('modules/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('modules/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('modules/backend/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('modules/backend/dist/js/demo.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('modules/backend/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- dropify -->
<script src="{{ asset('modules/backend/plugins/dropify/js/dropify.min.js') }}"></script>
<!--toastr js-->
<script src="{{ asset('modules/plugins/toastr/toastr.min.js') }}"></script>
<!-- loadingModal js -->
<script src="{{ asset('modules/plugins/loadingModal/js/jquery.loadingModal.js') }}"></script>

<script src="{{ asset('modules/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('modules/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!--boostrap datepicker-->
<script src="{{ asset('modules/backend/plugins//bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('modules/backend/js/main.js') }}"></script>
<script type="text/javascript">
    let APP_URL = {!! json_encode(url('/admin')) !!}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.flashMessages = [];

    @if ($message = session('success'))
    toastr.success("{{ $message }}");

    @elseif ($message = session('warning'))
    toastr.warning("{{ $message }}");

    @elseif ($message = session('error'))
    toastr.error("{{ $message }}");

    @elseif ($message = session('info'))
    toastr.info("{{ $message }}");
    @endif

        toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>
@yield('script')
</body>
</html>
