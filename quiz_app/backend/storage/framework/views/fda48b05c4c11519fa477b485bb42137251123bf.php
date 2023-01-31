<div class="tab-pane fade show active">
    <div class="card-body">
        <form action="<?php echo e(isset($aboutUs) ? route('about-us.update', $aboutUs->id) : route('about-us.store')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(isset($aboutUs)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="title">Tiêu đề <span class="color-red">*</span></label>
                            <textarea name="title" class="form-control" cols="4" placeholder="Nhập tiêu đề..." required><?php echo e(isset($aboutUs) ? $aboutUs->title : null); ?></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="content">Nội dung</label>
                            <textarea name="content" class="form-control" id="ckeditor" cols="4" placeholder="Nhập nội dung..." required><?php echo isset($aboutUs) ? $aboutUs->content : null; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="parent">Loại bài viết</label>
                            <select id="tye" name="type" class="form-control">
                                <option value="1" <?php echo e(isset($aboutUs) && $aboutUs->type == 1 ? 'selected' : null); ?>>Về chúng tôi</option>
                                <option value="2" <?php echo e(isset($aboutUs) && $aboutUs->type == 2 ? 'selected' : null); ?>>Điều khoản và chính sách</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <br>
                            <input type="checkbox" name="status" value="1" <?php echo e(isset($aboutUs) && $aboutUs->status == 1 ? 'checked' : 'checked'); ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
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
<?php /**PATH /var/www/backend/Modules/Backend/Resources/views/feedback/_form.blade.php ENDPATH**/ ?>