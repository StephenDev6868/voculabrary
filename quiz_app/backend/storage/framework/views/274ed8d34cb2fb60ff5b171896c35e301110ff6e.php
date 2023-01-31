<?php $__env->startSection('page_title', '403 Error'); ?>
<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 403</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Không có quyền truy cập.</h3>

                <p>
                    Bạn không có quyền truy cập trang này, vui lòng
                    ấn <a href="<?php echo e(route('backend.home')); ?>">vào đây</a> để trở lại trang chủ.
                </p>

                <div class="col-12">
                    <button type="button" class="btn btn-primary go-back"><i class="fa fa-arrow-left"></i> Trở lại</button>
                </div>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/backend/resources/views/errors/403.blade.php ENDPATH**/ ?>