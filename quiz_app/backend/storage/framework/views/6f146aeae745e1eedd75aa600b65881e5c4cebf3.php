<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="<?php echo e(route('about-us.index')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('about-us.index') ? 'active' : null); ?>" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="<?php echo e(route('about-us.create')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('about-us.create') ? 'active' : null); ?>"><i class="fa fa-plus"></i> Tạo mới</a>
    </div>
</nav>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/about-us/nav_link.blade.php ENDPATH**/ ?>