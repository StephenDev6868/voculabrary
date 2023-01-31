@extends('backend::layouts.master')
@section('title', 'Về chúng tôi')
@section('content')
    <div class="row">
        <div class="col-12">
            @include('backend::feedback.nav_link')
            <div class="tab-content tab-content-customize">
                <div class="tab-pane fade show active">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped" id="feedback-table">
                                    <thead>
                                    <tr class="text-center">
                                        <th>STT</th>
                                        <th>Người gửi</th>
                                        <th>Nội dung</th>
                                        <th>File góp ý</th>
                                        <th>Ngày gửi</th>
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
        //datatable
        let feedback = function () {
            let initArticleTable = function () {
                if (!jQuery().dataTable) {
                    return;
                }
                let table = $('#feedback-table');

                // begin first table
                let dataTable = table.DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,

                    ajax: APP_URL+'/feedback',
                    columns: [
                        { data: 'id', search: false, orderable:true, className: "text-center"},
                        { data: 'user_id'},
                        { data: 'content'},
                        { data: 'file_feedback'},
                        { data: 'created_at', className: "text-center"},
                        { data: 'reply', className: "text-center"},
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
                            url: APP_URL+'/feedback/destroy/' + id,
                            type: 'POST',
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
            feedback.init();
        });

    </script>
@endsection
