<?php $__env->startSection('title', 'Chi tiết'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a href="<?php echo e(route('feedback.index')); ?>"
                       class="nav-link nav-link-tab <?php echo e(Route::is('feedback.index') ? 'active' : null); ?>"
                       id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
                </div>
            </nav>

            <div class="tab-content tab-content-customize " style="background: none; border: none">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Chi tiết </h3>
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
                                        <p><b>Người gửi:</b> <?php echo e($feedback->user->fullname); ?></p>
                                        <p><b>Nội dung:</b> <?php echo e($feedback->content); ?></p>
                                        <p><b>File góp ý:</b>
                                            <?php if(!empty($feedback->feedbackFile)): ?>
                                                <?php $__currentLoopData = $feedback->feedbackFile; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="<?php echo e(getUrlFile($file->src)); ?>"><?php echo e($file->file_name); ?></a>
                                                    <br/>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </p>
                                        <p><b>Ngày gửi:</b> <?php echo e(date('d/m/Y H:i:s', strtotime($feedback->created_at))); ?>

                                        </p>
                                    </div>
                                </div>
                                <?php if(count($feedback->replyFeedback) > 0): ?>
                                    <hr>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <h3 class="card-title text-bold">Trả lời góp ý</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php $__currentLoopData = $feedback->replyFeedback; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-12">
                                                <p><b>Ngày
                                                        gửi:</b> <?php echo e(date('d/m/y H:i:s', strtotime($reply->created_at))); ?>

                                                </p>
                                                <p><b>Tiêu đề: </b><?php echo e($reply->title); ?></p>
                                                <p><b>Nội dung: </b><?php echo e($reply->content); ?></p>
                                                <p>-----------------------------------------------</p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                                <hr>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <h3 class="card-title text-bold"><i class="fa fa-reply"></i> Trả lời góp ý
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <form action="<?php echo e(route('feedback.send_email', $feedback->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="desc">Tiêu đề</label>
                                                <input name="title" class="form-control"
                                                       value="<?php echo e(env('APP_NAME')); ?> Cảm ơn góp ý của bạn">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="desc">Nội dung <span class="color-red">*</span></label>
                                                <textarea name="content" class="form-control" rows="5"
                                                          placeholder="Cảm ơn bạn đã gửi góp ý ....."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary submit-form"><i class="fa fa-save"></i> Gửi
                                            </button>
                                            <button type="reset" class="btn btn-default go-back"><i
                                                    class="fa fa-reply"></i> Trở lại
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/backend/Modules/Backend/Resources/views/feedback/show.blade.php ENDPATH**/ ?>