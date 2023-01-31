<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="<?php echo e(route('notification.index')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('notification.index') ? 'active' : null); ?>" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="<?php echo e(route('notification.create')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('notification.create') ? 'active' : null); ?>"><i class="fa fa-plus"></i> Tạo mới thông báo</a>
    </div>
</nav>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/notifications/nav_link.blade.php ENDPATH**/ ?>