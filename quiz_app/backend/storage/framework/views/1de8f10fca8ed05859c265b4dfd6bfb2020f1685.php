<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="<?php echo e(route('user.index')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('user.index') ? 'active' : null); ?>" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="<?php echo e(route('user.create')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('user.create') ? 'active' : null); ?>"><i class="fa fa-plus"></i> Tạo mới người dùng</a>
    </div>
</nav>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/users/nav_link.blade.php ENDPATH**/ ?>