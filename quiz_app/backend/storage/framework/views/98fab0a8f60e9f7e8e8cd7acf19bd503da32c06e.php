<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: <?php echo config('frontend.name'); ?>

    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/backend/Modules/Frontend/Resources/views/index.blade.php ENDPATH**/ ?>