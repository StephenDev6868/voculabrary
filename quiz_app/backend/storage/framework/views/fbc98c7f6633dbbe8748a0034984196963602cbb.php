<div class="tab-pane fade show active">
    <div class="card-body">
        <form action="<?php echo e(isset($role) ? route('role.update', $role->id) : route('role.store')); ?>"
              method="post"
              enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(isset($role)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Tên quyền hạn <span
                                            class="color-red">*</span></label>
                                    <input type="text" id="name" name="name"
                                           class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Nhập tên quyền hạn"
                                           value="<?php echo e(old('name', isset($role) ? $role->name : '')); ?>"
                                           required="">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-12 mb-1">
                                <label>Chức năng:</label>
                            </div>

                            <?php if($permissions && count($permissions) > 0): ?>
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 col-sm-6 data-item mb-3">
                                        <div class="parent-item">
                                            <input type="checkbox" value="<?php echo e($permission->id); ?>" name="check_all"
                                                   id="parent-<?php echo e($permission->id); ?>" class="check-all">
                                            <label for="parent-<?php echo e($permission->id); ?>"
                                                   class="font-weight-bold"><?php echo e($permission->name); ?></label>
                                        </div>
                                        <?php if(count($permission->childPers) > 0): ?>
                                            <?php $__currentLoopData = $permission->childPers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childPermission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-auto ml-2">
                                                    <input type="checkbox" class="sub-check"
                                                           value="<?php echo e($childPermission->id); ?>" name="permission[]"
                                                           id="child-item-<?php echo e($childPermission->id); ?>" <?php echo e(isset($role) && in_array($childPermission->id, $arrPermisson) ? 'checked' : ''); ?>>
                                                    <label for="child-item-<?php echo e($childPermission->id); ?>"
                                                           class="font-weight-normal"><?php echo e(ucfirst($childPermission->name)); ?></label>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php if(($key+1) % 4 == 0): ?>
                                        <div class="clearfix"></div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit"
                                class="btn btn-primary waves-effect text-uppercase btn-sm"><?php echo e(isset($role) ? 'Cập nhật' : 'Thêm mới'); ?></button>
                        <a href="<?php echo e(route('role.index')); ?>" title="hủy" class="btn btn-default btn-sm">Hủy</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $(document).on('change', 'input[name=check_all]', function () {
            if ($(this).is(':checked', true)) {
                $(this).closest('.data-item').find(".sub-check").prop('checked', true);
            } else {
                $(this).closest('.data-item').find(".sub-check").prop('checked', false);
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/roles/_form.blade.php ENDPATH**/ ?>