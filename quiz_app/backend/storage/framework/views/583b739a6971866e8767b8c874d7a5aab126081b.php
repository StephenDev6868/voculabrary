<?php $__env->startSection('title', 'Chi tiết'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <?php echo $__env->make('backend::exams.nav_link', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                        <p><b>Tiêu đề:</b> <?php echo e(!empty($exam->title) ? $exam->title : null); ?></p>
                                        <p><b>Mô tả:</b> <?php echo e(!empty($exam->description) ? $exam->description : null); ?></p>
                                        <p><b>Danh mục:</b> <?php echo e(!empty($exam->category) ?$exam->category->name : null); ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <h3 class="card-title text-bold">Danh sách câu hỏi và câu trả lời</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php if($exam->questions): ?>
                                        <?php $__currentLoopData = $exam->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-6">
                                                <b><?php echo e($question->priority); ?></b>: Chọn đáp án đúng với nghĩa của từ:
                                                    <label class="col-form-label"><?php echo e($question->title); ?></label>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="radio_<?php echo e($question->id); ?>"
                                                        value="<?php echo e($question->a); ?>" <?php echo e($question->answer == $question->a ? 'checked' : null); ?>>
                                                        <label class="form-check-label"><?php echo e($question->a); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="radio_<?php echo e($question->id); ?>"
                                                               value="<?php echo e($question->b); ?>" <?php echo e($question->answer == $question->b ? 'checked' : null); ?>>
                                                        <label class="form-check-label"><?php echo e($question->b); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="radio_<?php echo e($question->id); ?>"
                                                               value="<?php echo e($question->c); ?>" <?php echo e($question->answer == $question->c ? 'checked' : null); ?>>
                                                        <label class="form-check-label"><?php echo e($question->c); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="radio_<?php echo e($question->id); ?>"
                                                               value="<?php echo e($question->d); ?>" <?php echo e($question->answer == $question->d ? 'checked' : null); ?>>
                                                        <label class="form-check-label"><?php echo e($question->d); ?></label>
                                                    </div>
                                                </div>
                                                <b>Ví dụ:</b>
                                                <p><?php echo e($question->example); ?></p>
                                                <p style="color: #0f88e9"><?php echo e($question->translate_example); ?></p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/backend/Modules/Backend/Resources/views/exams/show.blade.php ENDPATH**/ ?>