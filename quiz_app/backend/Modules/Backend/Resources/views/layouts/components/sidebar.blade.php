<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
{{--            <li class="nav-item {{ Route::is('backend.home') ? 'active' : null }}">--}}
{{--                <a href="{{ route('backend.home') }}" class="nav-link {{ Route::is('backend.home') ? 'active' : null }}">--}}
{{--                    <i class="nav-icon fas fa-tachometer-alt"></i>--}}
{{--                    <p>--}}
{{--                        Dashboard--}}
{{--                    </p>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="#" class="nav-link">--}}
{{--                    <i class="nav-icon fas fa-images"></i>--}}
{{--                    <p>--}}
{{--                        Sản phẩm--}}
{{--                        <i class="fas fa-angle-left right"></i>--}}
{{--                    </p>--}}
{{--                </a>--}}
{{--                <ul class="nav nav-treeview">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="pages/tables/simple.html" class="nav-link">--}}
{{--                            <i class="far fa-circle nav-icon"></i>--}}
{{--                            <p>Simple Tables</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="pages/tables/data.html" class="nav-link">--}}
{{--                            <i class="far fa-circle nav-icon"></i>--}}
{{--                            <p>DataTables</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="pages/tables/jsgrid.html" class="nav-link">--}}
{{--                            <i class="far fa-circle nav-icon"></i>--}}
{{--                            <p>jsGrid</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
            @can(\App\Common\AllPermission::xemDanhMuc())
            <li class="nav-item  {{ Route::is('category.*') ? 'active' : null }}">
                <a href="{{ route('category.index') }}" class="nav-link {{ Route::is('category.*') ? 'active' : null }}">
                    <i class="nav-icon fas fa-list-alt"></i>
                    <p>
                        Quản lý danh mục
                    </p>
                </a>
            </li>
            @endcan
            @can(\App\Common\AllPermission::xemBanner())
            <li class="nav-item  {{ Route::is('slider.*') ? 'active' : null }}">
                <a href="{{ route('slider.index') }}" class="nav-link {{ Route::is('slider.*') ? 'active' : null }}">
                    <i class="nav-icon fas fa-sliders-h"></i>
                    <p>
                        Quản lý banner
                    </p>
                </a>
            </li>
            @endcan
            @can(\App\Common\AllPermission::xemCauHoi())
            <li class="nav-item  {{ Route::is('exam.*') ? 'active' : null }}">
                <a href="{{ route('exam.index') }}" class="nav-link {{ Route::is('exam.*') ? 'active' : null }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Quản lý câu hỏi
                    </p>
                </a>
            </li>
            @endcan
            @can(\App\Common\AllPermission::xemKhachHang())
            <li class="nav-item  {{ Route::is('user.*') ? 'active' : null }}">
                <a href="{{ route('user.index') }}" class="nav-link {{ Route::is('user.*') ? 'active' : null }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Quản lý khách hàng
                    </p>
                </a>
            </li>
            @endcan
            @can(\App\Common\AllPermission::xemDanhSachGopY())
            <li class="nav-item  {{ Route::is('feedback.*') ? 'active' : null }}">
                <a href="{{ route('feedback.index') }}" class="nav-link {{ Route::is('feedback.*') ? 'active' : null }}">
                    <i class="nav-icon fa fa-envelope"></i>
                    <p>
                        Góp ý của người dùng
                    </p>
                </a>
            </li>
            @endcan
            @can(\App\Common\AllPermission::xemDanhSachThongBao())
            <li class="nav-item  {{ Route::is('notification.*') ? 'active' : null }}">
                <a href="{{ route('notification.index') }}" class="nav-link {{ Route::is('notification.*') ? 'active' : null }}">
                    <i class="nav-icon fa fa-bell"></i>
                    <p>
                        Quản lý thông báo
                    </p>
                </a>
            </li>
            @endcan
            @can(\App\Common\AllPermission::xemCauHinhThongTin())
            <li class="nav-item  {{ Route::is('about-us.*') ? 'active' : null }}">
                <a href="{{ route('about-us.index') }}" class="nav-link {{ Route::is('about-us.*') ? 'active' : null }}">
                    <i class="nav-icon fa fa-cog"></i>
                    <p>
                        Cấu hình thông tin
                    </p>
                </a>
            </li>
            @endcan
            <li class="nav-item {{ Route::is('role.*') || Route::is('account.*') ? 'menu-open' : null }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-cogs"></i>
                    <p>
                        Cấu hình hệ thống
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can(\App\Common\AllPermission::xemQuyenHan())
                    <li class="nav-item {{ Route::is('role.*') ? 'active' : null }}">
                        <a href="{{ route('role.index') }}" class="nav-link {{ Route::is('role.*') ? 'active' : null }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Quyền hạn</p>
                        </a>
                    </li>
                    @endcan
                    @can(\App\Common\AllPermission::xemDanhSachTaiKhoan())
                    <li class="nav-item {{ Route::is('account.*') ? 'active' : null }}">
                        <a href="{{ route('account.index') }}" class="nav-link {{ Route::is('account.*') ? 'active' : null }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Quản lý tài khoản</p>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
