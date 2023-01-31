<?php $__env->startSection('title', 'Chi tiết'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <?php echo $__env->make('backend::users.nav_link', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="tab-content tab-content-customize " style="background: none; border: none">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Chi tiết người dùng</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p><b>Họ tên:</b> <?php echo e(!empty($user->fullname) ? $user->fullname : null); ?></p>
                                        <p><b>Số điện thoại:</b> <?php echo e(!empty($user->phone) ? $user->phone : null); ?></p>
                                        <p><b>Email:</b> <?php echo e(!empty($user->email) ? $user->email : null); ?></p>
                                        <p><b>Địa chỉ:</b> <?php echo e(!empty($user->address) ?  $user->address : null); ?></p>
                                    </div>

                                    <div class="col-sm-6">
                                        <p><b>Giới tính: </b><?php echo e($user->gender == 1 ? 'Nam' : 'Nữ'); ?></p>
                                        <p><b>Ngày sinh:</b> <?php echo e(!empty($user->date_or_birth) ? date('d/m/Y', strtotime($user->date_or_birth)) : null); ?></p>
                                        <p><b>Ngày đăng ký:</b> <?php echo e(!empty($user->created_at) ? date('d/m/Y H:i:s', strtotime($user->created_at)) : null); ?></p>
                                        <p><b>Tổng tiền: <?php echo e(formatPrice($user->wallet)); ?> đ</b></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Lịch sử nạp tiền</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th width="4%">#</th>
                                            <th width="22%">Số tiền nạp vào tài khoản</th>
                                            <th width="12%">Hình thức nạp</th>
                                            <th width="10%">Ngày nạp</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($depositHistories) > 0): ?>
                                            <?php $__currentLoopData = $depositHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><?php echo e(formatPrice($item->money)); ?> đ</td>
                                                    <td>
                                                        <?php if(!empty($item->user_sender_id)): ?>
                                                            Được nạp tiền từ số thuê bao <b><?php echo e($item->userSender->phone); ?></b>
                                                        <?php else: ?>
                                                            Nạp trực tiếp
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e(!empty($item->created_at) ? date('d/m/Y H:i:s', strtotime($item->created_at)) : null); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center"> Không có dữ liệu</td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <div class="col-12">
                                        <?php echo $depositHistories->links(); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Lịch sử chuyển tiền </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th width="4%">#</th>
                                            <th width="22%">Số tiền chuyển</th>
                                            <th width="12%">Chuyển tới</th>
                                            <th width="10%">Ngày chuyển</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($withdrawHistories) > 0): ?>
                                            <?php $__currentLoopData = $withdrawHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><?php echo e(formatPrice($item->money)); ?> đ</td>
                                                    <td>
                                                        <?php if(!empty($item->phone)): ?>
                                                            Chuyển tiền tới số thuê bao <b><?php echo e($item->phone); ?></b>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e(!empty($item->created_at) ? date('d/m/Y H:i:s', strtotime($item->created_at)) : null); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center"> Không có dữ liệu</td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <div class="col-12">
                                        <?php echo $withdrawHistories->links(); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Lịch sử đăng ký dịch vụ, gói cước, data. </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th width="4%">#</th>
                                            <th width="22%">Tên dịch vụ</th>
                                            <th width="12%">Giá</th>
                                            <th width="10%">Ngày đăng ký</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($regiterServices) > 0): ?>
                                            <?php $__currentLoopData = $regiterServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td><?php echo e($item->article->title); ?></td>
                                                    <td><?php echo e(formatPrice($item->price)); ?> đ</td>
                                                    <td><?php echo e(!empty($item->created_at) ? date('d/m/Y H:i:s', strtotime($item->created_at)) : null); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center"> Không có dữ liệu</td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <div class="col-12">
                                        <?php echo $regiterServices->links(); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/backend/Modules/Backend/Resources/views/roles/show.blade.php ENDPATH**/ ?>