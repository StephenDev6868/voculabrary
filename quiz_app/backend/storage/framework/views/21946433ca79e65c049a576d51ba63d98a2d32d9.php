<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VE 3000 App | <?php echo $__env->yieldContent('title'); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/plugins/fontawesome-free/css/all.min.css')); ?>">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')); ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/plugins/jqvmap/jqvmap.min.css')); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/dist/css/adminlte.min.css')); ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/plugins/daterangepicker/daterangepicker.css')); ?>">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/plugins/summernote/summernote-bs4.min.css')); ?>">
    <!-- dropify -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/plugins/dropify/css/dropify.min.css')); ?>">
    <!-- toastr -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/plugins/toastr/toastr.min.css')); ?>">
    <!-- loading modal -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/plugins/loadingModal/css/jquery.loadingModal.css')); ?>" />
    <!-- boostrap datepicker -->
    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')); ?>" />

    <!-- DataTables -->
    <link href="<?php echo e(asset('modules/plugins/datatables/dataTables.bootstrap4.css')); ?> " rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('modules/plugins/datatables/buttons.bootstrap4.css')); ?> " rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('modules/plugins/datatables/responsive.bootstrap4.css')); ?> " rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="<?php echo e(asset('modules/backend/css/style.css')); ?>">
    <?php echo $__env->yieldContent('style'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?php echo e(asset('images/Logo_VE3000.png')); ?>" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>






        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <img src="<?php echo e(!empty(auth::user()->avatar) ? getUrlFile(auth::user()->avatar) : asset('modules/backend/dist/img/user2-160x160.jpg')); ?>" class="img-circle avatar-user elevation-2" alt="User Image">
                    <span class="hidden-xs"> <?php echo e(auth::user()->fullname ?  auth::user()->fullname : auth::user()->name); ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="<?php echo e(route('user.edit', auth::user()->id)); ?>" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="<?php echo e(!empty(auth::user()->avatar) ? getUrlFile(auth::user()->avatar) : asset('modules/backend/dist/img/user1-128x128.jpg')); ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    <?php echo e(auth::user()->fullname ?  auth::user()->fullname : auth::user()->name); ?>

                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Cập nhật thông tin</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item dropdown-footer" href="<?php echo e(route('logout')); ?>"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <?php echo e(__('Logout')); ?>

                    </a>

                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
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
        <a href="<?php echo e(route('backend.home')); ?>" class="brand-link">
            <img src="<?php echo e(!empty(auth::user()->avatar) ? getUrlFile(auth::user()->avatar) : asset('modules/backend/dist/img/AdminLTELogo.png')); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light"><?php echo e(auth::user()->fullname ?  auth::user()->fullname : auth::user()->name); ?></span>
        </a>

        <!-- Sidebar -->
    <?php echo $__env->make('backend::layouts.components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                            <li class="breadcrumb-item"><a href="<?php echo e(route('backend.home')); ?>">Trang chủ</a></li>
                            <li class="breadcrumb-item active"><?php echo $__env->yieldContent('title'); ?></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main content -->
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; <?php echo e(date('Y')); ?> <a href="<?php echo e(route('backend.home')); ?>">VE 300 App</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo e(asset('modules/backend/plugins/jquery/jquery.min.js')); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo e(asset('modules/backend/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo e(asset('modules/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- ChartJS -->
<script src="<?php echo e(asset('modules/backend/plugins/chart.js/Chart.min.js')); ?>"></script>
<!-- Sparkline -->
<script src="<?php echo e(asset('modules/backend/plugins/sparklines/sparkline.js')); ?>"></script>
<!-- JQVMap -->
<script src="<?php echo e(asset('modules/backend/plugins/jqvmap/jquery.vmap.min.js')); ?>"></script>
<script src="<?php echo e(asset('modules/backend/plugins/jqvmap/maps/jquery.vmap.usa.js')); ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo e(asset('modules/backend/plugins/jquery-knob/jquery.knob.min.js')); ?>"></script>
<!-- daterangepicker -->
<script src="<?php echo e(asset('modules/backend/plugins/moment/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('modules/backend/plugins/daterangepicker/daterangepicker.js')); ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo e(asset('modules/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')); ?>"></script>
<!-- Summernote -->
<script src="<?php echo e(asset('modules/backend/plugins/summernote/summernote-bs4.min.js')); ?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo e(asset('modules/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('modules/backend/dist/js/adminlte.js')); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo e(asset('modules/backend/dist/js/demo.js')); ?>"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo e(asset('modules/backend/plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>"></script>
<!-- dropify -->
<script src="<?php echo e(asset('modules/backend/plugins/dropify/js/dropify.min.js')); ?>"></script>
<!--toastr js-->
<script src="<?php echo e(asset('modules/plugins/toastr/toastr.min.js')); ?>"></script>
<!-- loadingModal js -->
<script src="<?php echo e(asset('modules/plugins/loadingModal/js/jquery.loadingModal.js')); ?>"></script>

<script src="<?php echo e(asset('modules/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('modules/plugins/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
<!--boostrap datepicker-->
<script src="<?php echo e(asset('modules/backend/plugins//bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>"></script>

<script src="<?php echo e(asset('modules/backend/js/main.js')); ?>"></script>
<script type="text/javascript">
    let APP_URL = <?php echo json_encode(url('/admin')); ?>


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.flashMessages = [];

    <?php if($message = session('success')): ?>
    toastr.success("<?php echo e($message); ?>");

    <?php elseif($message = session('warning')): ?>
    toastr.warning("<?php echo e($message); ?>");

    <?php elseif($message = session('error')): ?>
    toastr.error("<?php echo e($message); ?>");

    <?php elseif($message = session('info')): ?>
    toastr.info("<?php echo e($message); ?>");
    <?php endif; ?>

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
<?php echo $__env->yieldContent('script'); ?>
</body>
</html>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/layouts/master.blade.php ENDPATH**/ ?>