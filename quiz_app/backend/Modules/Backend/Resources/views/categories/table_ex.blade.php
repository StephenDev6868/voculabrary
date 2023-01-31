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
                                        <th>Danh mục cha</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($categories) > 0)
                                        @foreach($categories as $key => $category)
                                            <tr>
                                                <td class="text-center">{{ $key+1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->parent ? $category->parent->name : null }}</td>
                                                <td class="text-center">{{ date('d/m/Y H:i:s', strtotime($category->created_at)) }}</td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-switch custom-switch-on-success">
                                                        <input type="checkbox" class="custom-control-input change-status" value="{{ $category->status }}"
                                                               data-id="{{ $category->id }}"
                                                               {{ $category->status == 1 ? 'checked' : null }} id="customSwitch{{ $category->id }}">
                                                        <label class="custom-control-label"
                                                               for="customSwitch{{ $category->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn-action btn btn-color-blue btn-icon btn-sm"
                                                       href="{{ route('category.edit', $category->id) }}" role="button"
                                                       title="Sửa">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('category.destroy', $category->id) }}"
                                                          accept-charset="UTF-8" style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="btn btn-action btn-color-red btn-icon btn-ligh btn-sm btn-remove-item"
                                                            role="button" title="Xóa">
                                                            <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Tổng số: <b>{{ $categories->total() }}</b>
                            </div>
                            <div class="col-md-8 float-right col-12">
                                {!! $categories->render() !!}
                            </div>
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
                    toastr['error'](error.message, 'Thông báo hệ thống');
                });
        });
    </script>
@endsection
