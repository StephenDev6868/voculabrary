<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="<?php echo e(route('slider.index')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('slider.index') ? 'active' : null); ?>" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="<?php echo e(route('slider.create')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('slider.create') ? 'active' : null); ?>"><i class="fa fa-plus"></i> Tạo mới slider</a>
    </div>
</nav>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/sliders/nav_link.blade.php ENDPATH**/ ?>