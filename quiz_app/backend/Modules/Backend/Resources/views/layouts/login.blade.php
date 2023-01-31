<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VE 3000 App | Log in </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('modules/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('modules/backend/dist/css/adminlte.min.css') }}">
    <style>
        /*.login-page {*/
        /*    background-color: #b1d5f4;;*/
        /*    background-repeat: no-repeat;*/
        /*    background-attachment: fixed;*/
        /*    background-size: 100% 100%;*/
        /*}*/

        .body input:focus {
            outline: 0;
        }

        .body input {
            border-color: white;
            background-color: white;
            border-width: 0px;
        }

        h4, h5 {
            color: #0065B3;
        }

    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="logo">
        <a href="javascript:void(0);" class="text-center" style="margin-bottom: 11px">
            <div class="text-center">
                <img src="{{ asset('images/Logo_VE3000.png') }}" style="vertical-align: middle" alt="" height="90">
            </div>
            <h5 style="font-family: Arial;  margin: 20px 0px 20px 0px;" >Đăng nhập để sử dụng hệ thống</h5>
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="card card-outline">
        <div class="card-body">
            <form action="{{ route('backend.login') }}" method="post">
                @csrf
                <div class="input-group mb-3" :class="[errors.has('email') ? 'has-error' : '']">
                    <input id="email"
                           class="form-control form-control-solid placeholder-no-fix @error('email') is-invalid @enderror"
                           type="text" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}"
                        {{ !old('email') ? 'autofocus' : null }}/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3" :class="[errors.has('password') ? 'has-error' : '']">
                    <input type="password" name="password"
                           class="form-control placeholder-no-fix @error('password') is-invalid @enderror"
                           placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-sm">Đăng nhập</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('modules/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('modules/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('modules/backend/dist/js/adminlte.js') }}"></script>
</body>
</html>
