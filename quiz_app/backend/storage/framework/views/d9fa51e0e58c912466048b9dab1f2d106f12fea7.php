<?php $__env->startSection('title', 'Quản lý danh mục'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <?php echo $__env->make('backend::categories.nav_link', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="tab-content tab-content-customize">
                <div class="tab-pane fade show active">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped" id="category-table">
                                    <thead>
                                    <tr class="text-center">
                                        <th>STT</th>
                                        <th>Tên danh mục</th>
                                        <th>Danh mục cha</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(count($categories) > 0): ?>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="text-center"><?php echo e($key+1); ?></td>
                                                <td><?php echo e($category->name); ?></td>
                                                <td><?php echo e($category->parent ? $category->parent->name : null); ?></td>
                                                <td class="text-center"><?php echo e(date('d/m/Y H:i:s', strtotime($category->created_at))); ?></td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-switch custom-switch-on-success">
                                                        <input type="checkbox" class="custom-control-input change-status" value="<?php echo e($category->status); ?>"
                                                               data-id="<?php echo e($category->id); ?>"
                                                               <?php echo e($category->status == 1 ? 'checked' : null); ?> id="customSwitch<?php echo e($category->id); ?>">
                                                        <label class="custom-control-label"
                                                               for="customSwitch<?php echo e($category->id); ?>"></label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn-action btn btn-color-blue btn-icon btn-sm"
                                                       href="<?php echo e(route('category.edit', $category->id)); ?>" role="button"
                                                       title="Sửa">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="<?php echo e(route('category.destroy', $category->id)); ?>"
                                                          accept-charset="UTF-8" style="display:inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button
                                                            class="btn btn-action btn-color-red btn-icon btn-ligh btn-sm btn-remove-item"
                                                            role="button" title="Xóa">
                                                            <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Tổng số: <b><?php echo e($categories->total()); ?></b>
                            </div>
                            <div class="col-md-8 float-right col-12">
                                <?php echo $categories->render(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $('body').on('click', '.change-status', function () {
            let $this = $(this);
            let status = $(this).val();
            let id = $(this).data('id');
            $.ajax({
                url: APP_URL + '/category-update-status/'+id,
                type: 'POST',
                data: {status: status},
                beforeSend: showLoading(),
            })
                .done(function (response) {
                    hideLoading();
                    $this.val(response.status_code);
                    toastr['success'](response.message, 'Thông báo hệ thống');
                })
                .fail(function (error) {
                    hideLoading();
                    toastr['error'](error.message, 'Thông báo hệ thống');
                });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/backend/Modules/Backend/Resources/views/categories/table_ex.blade.php ENDPATH**/ ?>