@extends('backend::layouts.master')
@section('title', 'Quản lý danh mục')
@section('content')
    <div class="row">
        <div class="col-12">
            @include('backend::categories.nav_link')
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
                                        <th>Mô tả</th>
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
@endsection
@section('script')
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
                if (error.responseJSON) {
                    toastr['error'](error.responseJSON.message, 'Thông báo hệ thống');
                } else {
                    toastr['error'](error.message, 'Thông báo hệ thống');
                }
            });
        });

        //datatable
        let category = function () {
            let initCategoryTable = function () {
                if (!jQuery().dataTable) {
                    return;
                }
                let table = $('#category-table');

                // begin first table
                let dataTable = table.DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,

                    ajax: APP_URL+'/list-data-category',

                    columns: [
                        { data: 'id', search: false, orderable:true, className: "text-center"},
                        { data: 'name'},
                        { data: 'description'},
                        { data: 'created_at', className: "text-center"},
                        { data: 'status', className: "text-center"},
                        { data: 'action', orderable: false, searchable: false, className: "text-center"}
                    ],

                    order: [
                        [0, 'DESC']
                    ],

                    language: {
                        processing: 'Đang xử lý...',
                        emptyTable: 'Không có danh mục nào',
                        info: 'Tổng cộng: _TOTAL_ bản ghi',
                        infoEmpty: 'Không có đơn vị nào',
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
                            url: APP_URL+'/category/' + id,
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
                    initCategoryTable();
                }

            };

        }();

        jQuery(document).ready(function() {
            category.init();
        });

    </script>
@endsection