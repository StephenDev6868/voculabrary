<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->





































            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Common\AllPermission::xemDanhMuc())): ?>
            <li class="nav-item  <?php echo e(Route::is('category.*') ? 'active' : null); ?>">
                <a href="<?php echo e(route('category.index')); ?>" class="nav-link <?php echo e(Route::is('category.*') ? 'active' : null); ?>">
                    <i class="nav-icon fas fa-list-alt"></i>
                    <p>
                        Quản lý danh mục
                    </p>
                </a>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Common\AllPermission::xemBanner())): ?>
            <li class="nav-item  <?php echo e(Route::is('slider.*') ? 'active' : null); ?>">
                <a href="<?php echo e(route('slider.index')); ?>" class="nav-link <?php echo e(Route::is('slider.*') ? 'active' : null); ?>">
                    <i class="nav-icon fas fa-sliders-h"></i>
                    <p>
                        Quản lý banner
                    </p>
                </a>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Common\AllPermission::xemCauHoi())): ?>
            <li class="nav-item  <?php echo e(Route::is('exam.*') ? 'active' : null); ?>">
                <a href="<?php echo e(route('exam.index')); ?>" class="nav-link <?php echo e(Route::is('exam.*') ? 'active' : null); ?>">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Quản lý câu hỏi
                    </p>
                </a>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Common\AllPermission::xemKhachHang())): ?>
            <li class="nav-item  <?php echo e(Route::is('user.*') ? 'active' : null); ?>">
                <a href="<?php echo e(route('user.index')); ?>" class="nav-link <?php echo e(Route::is('user.*') ? 'active' : null); ?>">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Quản lý khách hàng
                    </p>
                </a>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Common\AllPermission::xemDanhSachGopY())): ?>
            <li class="nav-item  <?php echo e(Route::is('feedback.*') ? 'active' : null); ?>">
                <a href="<?php echo e(route('feedback.index')); ?>" class="nav-link <?php echo e(Route::is('feedback.*') ? 'active' : null); ?>">
                    <i class="nav-icon fa fa-envelope"></i>
                    <p>
                        Góp ý của người dùng
                    </p>
                </a>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Common\AllPermission::xemDanhSachThongBao())): ?>
            <li class="nav-item  <?php echo e(Route::is('notification.*') ? 'active' : null); ?>">
                <a href="<?php echo e(route('notification.index')); ?>" class="nav-link <?php echo e(Route::is('notification.*') ? 'active' : null); ?>">
                    <i class="nav-icon fa fa-bell"></i>
                    <p>
                        Quản lý thông báo
                    </p>
                </a>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Common\AllPermission::xemCauHinhThongTin())): ?>
            <li class="nav-item  <?php echo e(Route::is('about-us.*') ? 'active' : null); ?>">
                <a href="<?php echo e(route('about-us.index')); ?>" class="nav-link <?php echo e(Route::is('about-us.*') ? 'active' : null); ?>">
                    <i class="nav-icon fa fa-cog"></i>
                    <p>
                        Cấu hình thông tin
                    </p>
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item <?php echo e(Route::is('role.*') || Route::is('account.*') ? 'menu-open' : null); ?>">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-cogs"></i>
                    <p>
                        Cấu hình hệ thống
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Common\AllPermission::xemQuyenHan())): ?>
                    <li class="nav-item <?php echo e(Route::is('role.*') ? 'active' : null); ?>">
                        <a href="<?php echo e(route('role.index')); ?>" class="nav-link <?php echo e(Route::is('role.*') ? 'active' : null); ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Quyền hạn</p>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Common\AllPermission::xemDanhSachTaiKhoan())): ?>
                    <li class="nav-item <?php echo e(Route::is('account.*') ? 'active' : null); ?>">
                        <a href="<?php echo e(route('account.index')); ?>" class="nav-link <?php echo e(Route::is('account.*') ? 'active' : null); ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Quản lý tài khoản</p>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/layouts/components/sidebar.blade.php ENDPATH**/ ?>