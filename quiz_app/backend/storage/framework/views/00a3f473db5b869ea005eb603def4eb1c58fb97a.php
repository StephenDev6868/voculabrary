<?php $__env->startSection('title', 'Quản lý nhóm quyền'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <?php echo $__env->make('backend::roles.nav_link', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="tab-content tab-content-customize">
                <div class="tab-pane fade show active">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="text-center">
                                        <th>STT</th>
                                        <th>Tên</th>
                                        <th>Ngày tạo</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(count($roles) > 0): ?>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="text-center"><?php echo e($key+1); ?></td>
                                                <td><?php echo e($role->name); ?></td>
                                                <td class="text-center"><?php echo e(date('d/m/Y H:i:s', strtotime($role->created_at))); ?></td>
                                                <td class="text-center">
                                                        <a class="btn-action btn btn-color-blue btn-icon btn-sm"
                                                           href="<?php echo e(route('role.edit', $role->id)); ?>" role="button"
                                                           title="Sửa">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    <?php if($role->name != SUPER_ADMIN): ?>
                                                        <form method="POST" action="<?php echo e(route('role.destroy', $role->id)); ?>"
                                                              accept-charset="UTF-8" style="display:inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button
                                                                class="btn btn-action btn-color-red btn-icon btn-ligh btn-sm btn-remove-item"
                                                                role="button" title="Xóa">
                                                                <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
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
                                Tổng số: <b><?php echo e($roles->total()); ?></b>
                            </div>
                            <div class="col-md-8 float-right col-12">
                                <?php echo $roles->render(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/backend/Modules/Backend/Resources/views/roles/index.blade.php ENDPATH**/ ?>