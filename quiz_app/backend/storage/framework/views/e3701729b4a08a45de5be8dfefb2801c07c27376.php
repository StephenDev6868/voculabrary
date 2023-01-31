<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="<?php echo e(route('category.index')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('category.index') ? 'active' : null); ?>" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="<?php echo e(route('category.create')); ?>" class="nav-link nav-link-tab <?php echo e(Route::is('category.create') ? 'active' : null); ?>"><i class="fa fa-plus"></i> Tạo mới danh mục</a>
    </div>
</nav>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/categories/nav_link.blade.php ENDPATH**/ ?>