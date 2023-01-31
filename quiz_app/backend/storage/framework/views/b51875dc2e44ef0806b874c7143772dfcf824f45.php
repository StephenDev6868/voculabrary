<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="<?php echo e(route('account.index')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('account.index') ? 'active' : null); ?>" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="<?php echo e(route('account.create')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('account.create') ? 'active' : null); ?>"><i class="fa fa-plus"></i> Tạo mới tài khoản quản trị</a>
    </div>
</nav>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/accounts/nav_link.blade.php ENDPATH**/ ?>