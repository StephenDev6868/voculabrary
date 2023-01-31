<div class="tab-pane fade show active">
    <div class="row">
            <a href="<?php echo e(asset('files/example.xlsx')); ?>" target="_blank" class="ml-4" style="color: black"> <i class="fa fa-file-excel mt-2" style="color: darkgreen"></i> File mẫu</a>
    </div>
    <div class="card-body">
        <form action="<?php echo e(isset($exam) ? route('exam.update', $exam->id) : route('exam.store')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(isset($exam)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="file">File câu hỏi <span class="color-red">*</span></label>
                            <input type="file" class="dropify" id="src" name="file" accept=".xlsx, .xls, .csv"
                                   data-default-file="<?php echo e(isset($exam->file) ? getUrlFile($exam->file) : null); ?>">
                            <?php if(isset($exam->file)): ?>
                                <a href="<?php echo e(getUrlFile($exam->file)); ?>" target="_blank"> <i class="fa fa-file-excel mt-2"></i> Xem File câu hỏi</a>
                                <br>
                                <a href="<?php echo e(route('exam.show', $exam->id)); ?>"> Xem chi tiết câu hỏi</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="title">Tiêu đề <span class="color-red">*</span></label>
                            <textarea name="title" class="form-control" cols="4" placeholder="Nhập tiêu đề..."><?php echo e(isset($exam) ? $exam->title : null); ?></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="desc">Mô tả</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Nhập mô tả  ngắn..."><?php echo e(isset($exam) ? $exam->description : null); ?></textarea>
                        </div>
                    </div>






                </div>
                <div class="col-md-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category-id">Danh mục</label>
                            <select id="category-id" name="category_id" class="form-control" required>
                                <option value="" selected="selected">--Danh mục--</option>
                                <optgroup label="Chọn danh mục">
                                    <?php if(count($categories) > 0): ?>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>" <?php echo e(isset($exam) && $exam->category_id == $category->id ? 'selected' : null); ?>><?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category-id">Số thứ tự hiển thị</label>
                            <input type="number" name="priority" class="form-control" value="<?php echo e(isset($exam) ? $exam->priority : 1); ?>" placeholder="1">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category-id">Số lần xem gợi ý</label>
                            <input type="number" name="suggest_number" class="form-control" value="<?php echo e(isset($exam) ? $exam->suggest_number : null); ?>" placeholder="3">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category-id">Thời gian trả lời câu hỏi</label>
                            <input type="number" name="time_question" class="form-control" value="<?php echo e(isset($exam) ? $exam->time_question : null); ?>" placeholder="30s">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <br>
                            <input type="checkbox" name="status" value="1" <?php echo e(isset($exam) && $exam->status == 1 ? 'checked' : 'checked'); ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary submit-form"><i class="fa fa-save"></i> Lưu</button>
                    <button type="reset" class="btn btn-default go-back"><i class="fa fa-reply"></i> Trở lại</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('modules/backend/plugins/ckeditor/ckeditor.js')); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace('ckeditor', {
                filebrowserBrowseUrl: '<?php echo e(route('ckfinder_browser')); ?>',
            });
        });
        $('input[name="price"]').keyup(function (e) {
            $(this).val(formatPrice($(this).val()));
        });

        $('.submit-form').click(function (event) {
            let price = $(this).closest('form').find('input[name="price"]').val();

            if (price) {
                let unformat = $(this).closest('form').find('input[name="price"]').val().replace(/,/g, "");
                $(this).closest('form').find('input[name="price"]').val(unformat);
            }
        })
    </script>
    <?php echo $__env->make('ckfinder::setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/exams/_form.blade.php ENDPATH**/ ?>