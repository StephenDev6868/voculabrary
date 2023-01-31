<div class="tab-pane fade show active">
    <div class="card-body">

        <form class="form-row" action="<?php echo e(isset($user) ? route('user.update', $user->id) : route('user.store')); ?>"
              method="post"
              enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(isset($user)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="avatar">Ảnh đại diện </label>
                        <input type="file" class="dropify" id="src" name="avatar" accept="image/*"
                               data-default-file="<?php echo e(isset($user->avatar) ? getUrlFile($user->avatar) : null); ?>">
                    </div>
                    <div class="form-group col-md-9">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="ho-ten">Họ tên <span class="color-red">*</span></label>
                                <input type="text" name="fullname" class="form-control" placeholder="Nhập họ tên..."
                                       value="<?php echo e(old('fullname', isset($user) ? $user->fullname : '')); ?>" required="">
                            </div>










                            <?php if(isset($user) && auth::user()->id == $user->id): ?>
                                <div class="form-group col-md-4">
                                    <label class="col-form-label" for="password">Mật khẩu </label>
                                    <input type="password" id="password" name="password" class="form-control"
                                           placeholder="Nhập mật khẩu..." value="" <?php echo e(isset($user) ? '' : 'required'); ?>>
                                </div>
                            <?php endif; ?>

                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="email">Email <span class="color-red">*</span></label>
                                <input type="text" name="email" id="email" placeholder="Nhập địa chỉ email..."
                                       value="<?php echo e(old('email', isset($user) ? $user->email : null)); ?>"
                                       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                                <?php $__errorArgs = ['email'];
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
                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="so-dien-thoai">Số điện thoại</label>
                                <input type="number" name="phone" id="so-dien-thoai" placeholder="Nhập SDT.."
                                       value="<?php echo e(old('so_dien_thoai', isset($user) ? $user->so_dien_thoai : '')); ?>"
                                       class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label">Ngày sinh</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control datepicker" value="<?php echo e(isset($user) && !empty($user->date_or_birth) ? date('d/m/Y', strtotime($user->date_or_birth)) : null); ?>"
                                               name="date_or_birth" placeholder="dd/mm/yyyy">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label">Địa chỉ</label>
                                <textarea name="address"  placeholder="Nhập địa chỉ.."
                                          class="form-control"><?php echo e(old('address', isset($user) ? $user->address : '')); ?></textarea>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="gioi_tinh">Giới tính</label>
                                <br>
                                <label>
                                    <input type="radio" name="gender" class="flat-red" value="1"
                                           <?php echo e(isset($user) && $user->gender == 1 ? 'checked' : ''); ?>

                                           checked> Nam
                                </label>
                                &nbsp;
                                <label>
                                    <input type="radio" name="gender" class="flat-red"
                                           value="2"
                                        <?php echo e(isset($user) && $user->gender == 2 ? 'checked' : ''); ?>

                                    > Nữ
                                </label>
                            </div>
                            <?php if(empty($user) || isset($user) && auth::user()->id != $user->id): ?>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="trang_thai">Trạng thái</label>
                                    <br>
                                    <label>
                                        <input type="radio" name="status" class="flat-red" value="1"
                                            <?php echo e(isset($user) && $user->status == 1 ? 'checked' : 'checked'); ?>> Hoạt động
                                    </label>
                                    &nbsp;
                                    <label>
                                        <input type="radio" name="status" class="flat-red" value="2"
                                            <?php echo e(isset($user) && $user->status == 2 ? 'checked' : ''); ?>

                                        > Tạm khóa
                                    </label>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="submit"
                                class="btn btn-primary waves-effect text-uppercase btn-sm"><?php echo e(isset($user) ? 'Cập nhật' : 'Tạo mới tài khoản'); ?></button>
                        <a href="<?php echo e(route('user.index')); ?>" title="hủy" class="btn btn-default btn-sm">Hủy</a>
                    </div>
                </div>
            </div>
        </form>






        





















































    </div>
</div>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/users/_form.blade.php ENDPATH**/ ?>