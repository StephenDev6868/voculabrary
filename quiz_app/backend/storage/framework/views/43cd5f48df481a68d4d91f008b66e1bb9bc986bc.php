<?php $__env->startSection('title', 'Về chúng tôi'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <?php echo $__env->make('backend::about-us.nav_link', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="tab-content tab-content-customize">
                <div class="tab-pane fade show active">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped" id="about-us-table">
                                    <thead>
                                    <tr class="text-center">
                                        <th>STT</th>
                                        <th>Tiêu đề</th>
                                        <th>Nội dung</th>
                                        <th>Loại bài viết</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
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
                url: APP_URL + '/about-us-update-status/'+id,
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
                    if (error.responseJSON) {
                        toastr['error'](error.responseJSON.message, 'Thông báo hệ thống');
                    } else {
                        toastr['error'](error.message, 'Thông báo hệ thống');
                    }
                });
        });

        //datatable
        let about = function () {
            let initArticleTable = function () {
                if (!jQuery().dataTable) {
                    return;
                }
                let table = $('#about-us-table');

                // begin first table
                let dataTable = table.DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,

                    ajax: APP_URL+'/about-us',

                    columns: [
                        { data: 'id', search: false, orderable:true, className: "text-center"},
                        { data: 'title'},
                        { data: 'content', "width": "35%"},
                        { data: 'type'},
                        { data: 'created_at', className: "text-center"},
                        { data: 'status', className: "text-center"},
                        { data: 'action', orderable: false, searchable: false, className: "text-center"}
                    ],

                    order: [
                        [0, 'DESC']
                    ],

                    language: {
                        processing: 'Đang xử lý...',
                        emptyTable: 'Không có dữ liệu',
                        info: 'Tổng cộng: _TOTAL_ bản ghi',
                        infoEmpty: 'Không có bản ghi nào',
                        lengthMenu: 'Hiển thị _MENU_ kết quả',
                        search: 'Tìm kiếm:',
                        zeroRecords: 'Không tìm thấy kết quả',
                        paginate: {
                            previous: '<',
                            next: '>',
                            last: 'Cuối cùng',
                            first: 'Đầu tiên'
                        }
                    },

                    lengthMenu: [
                        [10, 15, 20, -1],
                        [10, 15, 20, 'All'] // change per page values here
                    ],
                    // set the initial value
                    pageLength: 10,

                    pagingType: 'simple_numbers',

                });

                table.on('click', 'tbody tr .btn-remove-item', function () {
                    if (confirm('Bạn có chắc chắn muốn xóa dữ liệu này')) {
                        let id = $(this).data('id');

                        $.ajax({
                            url: APP_URL+'/about-us/' + id,
                            type: 'DELETE',
                            beforeSend: showLoading()
                        })
                            .done(function(response) {
                                hideLoading()
                                toastr['success'](response.message, 'Thông báo hệ thống');
                                dataTable.ajax.reload();
                            })
                            .fail(function(error) {
                                hideLoading()
                                toastr['error'](error.message, 'Thông báo hệ thống');
                            });
                    }
                });
            };

            return {

                //main function to initiate the module
                init: function () {
                    initArticleTable();
                }

            };

        }();

        jQuery(document).ready(function() {
            about.init();
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/backend/Modules/Backend/Resources/views/about-us/index.blade.php ENDPATH**/ ?>