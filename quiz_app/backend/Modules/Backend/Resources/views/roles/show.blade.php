@extends('backend::layouts.master')
@section('title', 'Chi tiết')
@section('content')
    <div class="row">
        <div class="col-12">
            @include('backend::users.nav_link')
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
                                        <p><b>Họ tên:</b> {{ !empty($user->fullname) ? $user->fullname : null }}</p>
                                        <p><b>Số điện thoại:</b> {{ !empty($user->phone) ? $user->phone : null }}</p>
                                        <p><b>Email:</b> {{ !empty($user->email) ? $user->email : null }}</p>
                                        <p><b>Địa chỉ:</b> {{ !empty($user->address) ?  $user->address : null }}</p>
                                    </div>

                                    <div class="col-sm-6">
                                        <p><b>Giới tính: </b>{{ $user->gender == 1 ? 'Nam' : 'Nữ' }}</p>
                                        <p><b>Ngày sinh:</b> {{ !empty($user->date_or_birth) ? date('d/m/Y', strtotime($user->date_or_birth)) : null  }}</p>
                                        <p><b>Ngày đăng ký:</b> {{ !empty($user->created_at) ? date('d/m/Y H:i:s', strtotime($user->created_at)) : null  }}</p>
                                        <p><b>Tổng tiền: {{ formatPrice($user->wallet) }} đ</b></p>
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
                                        @if (count($depositHistories) > 0)
                                            @foreach($depositHistories as $key => $item)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ formatPrice($item->money) }} đ</td>
                                                    <td>
                                                        @if (!empty($item->user_sender_id))
                                                            Được nạp tiền từ số thuê bao <b>{{ $item->userSender->phone }}</b>
                                                        @else
                                                            Nạp trực tiếp
                                                        @endif
                                                    </td>
                                                    <td>{{ !empty($item->created_at) ? date('d/m/Y H:i:s', strtotime($item->created_at)) : null  }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center"> Không có dữ liệu</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-12">
                                        {!! $depositHistories->links() !!}
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
                                        @if (count($withdrawHistories) > 0)
                                            @foreach($withdrawHistories as $key => $item)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ formatPrice($item->money) }} đ</td>
                                                    <td>
                                                        @if (!empty($item->phone))
                                                            Chuyển tiền tới số thuê bao <b>{{ $item->phone }}</b>
                                                        @endif
                                                    </td>
                                                    <td>{{ !empty($item->created_at) ? date('d/m/Y H:i:s', strtotime($item->created_at)) : null  }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center"> Không có dữ liệu</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-12">
                                        {!! $withdrawHistories->links() !!}
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
                                        @if (count($regiterServices) > 0)
                                            @foreach($regiterServices as $key => $item)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $item->article->title  }}</td>
                                                    <td>{{ formatPrice($item->price) }} đ</td>
                                                    <td>{{ !empty($item->created_at) ? date('d/m/Y H:i:s', strtotime($item->created_at)) : null  }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center"> Không có dữ liệu</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-12">
                                        {!! $regiterServices->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
