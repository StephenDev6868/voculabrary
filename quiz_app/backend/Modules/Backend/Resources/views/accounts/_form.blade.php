<div class="tab-pane fade show active">
    <div class="card-body">

        <form class="form-row" action="{{ isset($account) ? route('account.update', $account->id) : route('account.store') }}"
              method="post"
              enctype="multipart/form-data">
            @csrf
            @if(isset($account))
                @method('PUT')
            @endif
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="avatar">Ảnh đại diện </label>
                        <input type="file" class="dropify" id="src" name="avatar" accept="image/*"
                               data-default-file="{{ isset($account->avatar) ? getUrlFile($account->avatar) : null }}">
                    </div>
                    <div class="form-group col-md-9">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="ho-ten">Họ tên <span class="color-red">*</span></label>
                                <input type="text" name="fullname" class="form-control" placeholder="Nhập họ tên..."
                                       value="{{ old('fullname', isset($account) ? $account->fullname : '') }}" required="">
                            </div>
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="accountname" class="col-form-label">Tài khoản </label>--}}
{{--                                <input type="text" id="accountname" name="name"--}}
{{--                                       class="form-control @error('name') is-invalid @enderror"--}}
{{--                                       placeholder="Nhập tên tài khoản"--}}
{{--                                       value="{{ old('name', isset($account) ? $account->name : '') }}">--}}
{{--                                @error('name')--}}
{{--                                <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="password">Mật khẩu </label>
                                <input type="password" id="password" name="password" class="form-control"
                                       placeholder="Nhập mật khẩu..." value="" {{ isset($account) ? '' : 'required' }}>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="email">Email <span class="color-red">*</span></label>
                                <input type="email" name="email" id="email" placeholder="Nhập địa chỉ email..."
                                       value="{{ old('email', isset($account) ? $account->email : null) }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="quyen-han">Quyền hạn</label>
                                <select class="form-control select2" name="role_id" required>
                                    <option value="">-- Chọn quyền hạn --</option>
                                    @if (count($roles) > 0)
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ isset($account) && $account->role_id == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="so-dien-thoai">Số điện thoại</label>
                                <input type="number" name="phone" id="so-dien-thoai" placeholder="Nhập SDT.."
                                       value="{{ old('so_dien_thoai', isset($account) ? $account->so_dien_thoai : '') }}"
                                       class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label">Ngày sinh</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control datepicker" value="{{ isset($account) && !empty($account->date_or_birth) ? date('d/m/Y', strtotime($account->date_or_birth)) : null }}"
                                               name="date_or_birth" placeholder="dd/mm/yyyy">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label">Địa chỉ</label>
                                <textarea name="address"  placeholder="Nhập địa chỉ.."
                                          class="form-control">{{ old('address', isset($account) ? $account->address : '') }}</textarea>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="gioi_tinh">Giới tính</label>
                                <br>
                                <label>
                                    <input type="radio" name="gender" class="flat-red" value="1"
                                           {{ isset($account) && $account->gender == 1 ? 'checked' : '' }}
                                           checked> Nam
                                </label>
                                &nbsp;
                                <label>
                                    <input type="radio" name="gender" class="flat-red"
                                           value="2"
                                        {{ isset($account) && $account->gender == 2 ? 'checked' : '' }}
                                    > Nữ
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="trang_thai">Trạng thái</label>
                                <br>
                                <label>
                                    <input type="radio" name="status" class="flat-red" value="1"
                                        {{ isset($account) && $account->status == 1 ? 'checked' : 'checked' }}> Hoạt động
                                </label>
                                &nbsp;
                                <label>
                                    <input type="radio" name="status" class="flat-red" value="2"
                                        {{ isset($account) && $account->status == 2 ? 'checked' : '' }}
                                    > Tạm khóa
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="submit"
                                class="btn btn-primary waves-effect text-uppercase btn-sm">{{ isset($account) ? 'Cập nhật' : 'Tạo mới tài khoản' }}</button>
                        <a href="{{ route('account.index') }}" title="hủy" class="btn btn-default btn-sm">Hủy</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
