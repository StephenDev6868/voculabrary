<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="<?php echo e(route('role.index')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('role.index') ? 'active' : null); ?>" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="<?php echo e(route('role.create')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('role.create') ? 'active' : null); ?>"><i class="fa fa-plus"></i> Tạo mới nhóm quyền</a>
    </div>
</nav>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/roles/nav_link.blade.php ENDPATH**/ ?>