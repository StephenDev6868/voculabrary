<div class="tab-pane fade show active">
    <div class="card-body">

        <form class="form-row" action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}"
              method="post"
              enctype="multipart/form-data">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="avatar">Ảnh đại diện </label>
                        <input type="file" class="dropify" id="src" name="avatar" accept="image/*"
                               data-default-file="{{ isset($user->avatar) ? getUrlFile($user->avatar) : null }}">
                    </div>
                    <div class="form-group col-md-9">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="ho-ten">Họ tên <span class="color-red">*</span></label>
                                <input type="text" name="fullname" class="form-control" placeholder="Nhập họ tên..."
                                       value="{{ old('fullname', isset($user) ? $user->fullname : '') }}" required="">
                            </div>
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="username" class="col-form-label">Tài khoản </label>--}}
{{--                                <input type="text" id="username" name="name"--}}
{{--                                       class="form-control @error('name') is-invalid @enderror"--}}
{{--                                       placeholder="Nhập tên tài khoản"--}}
{{--                                       value="{{ old('name', isset($user) ? $user->name : '') }}">--}}
{{--                                @error('name')--}}
{{--                                <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                            @if (isset($user) && auth::user()->id == $user->id)
                                <div class="form-group col-md-4">
                                    <label class="col-form-label" for="password">Mật khẩu </label>
                                    <input type="password" id="password" name="password" class="form-control"
                                           placeholder="Nhập mật khẩu..." value="" {{ isset($user) ? '' : 'required' }}>
                                </div>
                            @endif

                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="email">Email <span class="color-red">*</span></label>
                                <input type="text" name="email" id="email" placeholder="Nhập địa chỉ email..."
                                       value="{{ old('email', isset($user) ? $user->email : null) }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="so-dien-thoai">Số điện thoại</label>
                                <input type="number" name="phone" id="so-dien-thoai" placeholder="Nhập SDT.."
                                       value="{{ old('so_dien_thoai', isset($user) ? $user->so_dien_thoai : '') }}"
                                       class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label">Ngày sinh</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control datepicker" value="{{ isset($user) && !empty($user->date_or_birth) ? date('d/m/Y', strtotime($user->date_or_birth)) : null }}"
                                               name="date_or_birth" placeholder="dd/mm/yyyy">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label">Địa chỉ</label>
                                <textarea name="address"  placeholder="Nhập địa chỉ.."
                                          class="form-control">{{ old('address', isset($user) ? $user->address : '') }}</textarea>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label" for="gioi_tinh">Giới tính</label>
                                <br>
                                <label>
                                    <input type="radio" name="gender" class="flat-red" value="1"
                                           {{ isset($user) && $user->gender == 1 ? 'checked' : '' }}
                                           checked> Nam
                                </label>
                                &nbsp;
                                <label>
                                    <input type="radio" name="gender" class="flat-red"
                                           value="2"
                                        {{ isset($user) && $user->gender == 2 ? 'checked' : '' }}
                                    > Nữ
                                </label>
                            </div>
                            @if (empty($user) || isset($user) && auth::user()->id != $user->id)
                                <div class="col-md-4">
                                    <label class="col-form-label" for="trang_thai">Trạng thái</label>
                                    <br>
                                    <label>
                                        <input type="radio" name="status" class="flat-red" value="1"
                                            {{ isset($user) && $user->status == 1 ? 'checked' : 'checked' }}> Hoạt động
                                    </label>
                                    &nbsp;
                                    <label>
                                        <input type="radio" name="status" class="flat-red" value="2"
                                            {{ isset($user) && $user->status == 2 ? 'checked' : '' }}
                                        > Tạm khóa
                                    </label>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="submit"
                                class="btn btn-primary waves-effect text-uppercase btn-sm">{{ isset($user) ? 'Cập nhật' : 'Tạo mới tài khoản' }}</button>
                        <a href="{{ route('user.index') }}" title="hủy" class="btn btn-default btn-sm">Hủy</a>
                    </div>
                </div>
            </div>
        </form>






        {{--        <form action="{{ isset($slider) ? route('slider.update', $slider->id) : route('slider.store') }}" method="post" enctype="multipart/form-data">--}}
{{--            @csrf--}}
{{--            @if (isset($slider))--}}
{{--                @method('PUT')--}}
{{--            @endif--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-6">--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="src">Hình ảnh <span class="color-red">*</span></label>--}}
{{--                            <input type="file" class="dropify" id="src" name="src" accept="image/*"--}}
{{--                                   {{ isset($slider) ? '' : 'required' }}--}}
{{--                                   data-default-file="{{ isset($slider->src) ? getUrlFile($slider->src) : null }}">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="desc">Mô tả</label>--}}
{{--                            <textarea name="description" class="form-control" cols="4" placeholder="Nhập mô tả..."></textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="link">Link đến trang</label>--}}
{{--                            <input name="link" class="form-control" placeholder="Nhập link..."/>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="type">Vị trí hiển thị</label>--}}
{{--                            <select id="type" name="type" class="form-control">--}}
{{--                                <option value="1" {{ isset($slider) && $slider->type == 1 ? 'selected' : null }}>Hiển thị slide ở trang chủ</option>--}}
{{--                                <option value="2" {{ isset($slider) && $slider->type == 2 ? 'selected' : null }}>Hiển thị slide ở danh mục</option>--}}
{{--                                <option value="3" {{ isset($slider) && $slider->type == 3 ? 'selected' : null }}>Hiển thị slide ở bài viết</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="">Trạng thái</label>--}}
{{--                            <br>--}}
{{--                            <input type="checkbox" name="status" value="1" {{ isset($slider) && $slider->status == 1 ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-12">--}}
{{--                    <button class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>--}}
{{--                    <button type="reset" class="btn btn-default go-back"><i class="fa fa-reply"></i> Trở lại</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
    </div>
</div>
