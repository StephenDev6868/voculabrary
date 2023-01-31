@extends('backend::layouts.master')
@section('title', 'Quản lý nhóm quyền')
@section('content')
    <div class="row">
        <div class="col-12">
            @include('backend::roles.nav_link')
            <div class="tab-content tab-content-customize">
                <div class="tab-pane fade show active">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="text-center">
                                        <th>STT</th>
                                        <th>Tên</th>
                                        <th>Ngày tạo</th>
                                        <th>Tác vụ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($roles) > 0)
                                        @foreach($roles as $key => $role)
                                            <tr>
                                                <td class="text-center">{{ $key+1 }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td class="text-center">{{ date('d/m/Y H:i:s', strtotime($role->created_at)) }}</td>
                                                <td class="text-center">
                                                        <a class="btn-action btn btn-color-blue btn-icon btn-sm"
                                                           href="{{ route('role.edit', $role->id) }}" role="button"
                                                           title="Sửa">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @if ($role->name != SUPER_ADMIN)
                                                        <form method="POST" action="{{ route('role.destroy', $role->id) }}"
                                                              accept-charset="UTF-8" style="display:inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                class="btn btn-action btn-color-red btn-icon btn-ligh btn-sm btn-remove-item"
                                                                role="button" title="Xóa">
                                                                <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    @endif
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
                                Tổng số: <b>{{ $roles->total() }}</b>
                            </div>
                            <div class="col-md-8 float-right col-12">
                                {!! $roles->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
