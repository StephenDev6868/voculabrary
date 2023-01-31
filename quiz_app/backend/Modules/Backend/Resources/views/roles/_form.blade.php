<div class="tab-pane fade show active">
    <div class="card-body">
        <form action="{{ isset($role) ? route('role.update', $role->id) : route('role.store') }}"
              method="post"
              enctype="multipart/form-data">
            @csrf
            @if(isset($role))
                @method('PUT')
            @endif
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Tên quyền hạn <span
                                            class="color-red">*</span></label>
                                    <input type="text" id="name" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Nhập tên quyền hạn"
                                           value="{{ old('name', isset($role) ? $role->name : '') }}"
                                           required="">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mb-1">
                                <label>Chức năng:</label>
                            </div>

                            @if ($permissions && count($permissions) > 0)
                                @foreach($permissions as $key => $permission)
                                    <div class="col-md-3 col-sm-6 data-item mb-3">
                                        <div class="parent-item">
                                            <input type="checkbox" value="{{ $permission->id }}" name="check_all"
                                                   id="parent-{{ $permission->id }}" class="check-all">
                                            <label for="parent-{{ $permission->id }}"
                                                   class="font-weight-bold">{{ $permission->name }}</label>
                                        </div>
                                        @if (count($permission->childPers) > 0)
                                            @foreach($permission->childPers as $childPermission)
                                                <div class="col-auto ml-2">
                                                    <input type="checkbox" class="sub-check"
                                                           value="{{ $childPermission->id }}" name="permission[]"
                                                           id="child-item-{{ $childPermission->id }}" {{ isset($role) && in_array($childPermission->id, $arrPermisson) ? 'checked' : '' }}>
                                                    <label for="child-item-{{ $childPermission->id }}"
                                                           class="font-weight-normal">{{ ucfirst($childPermission->name) }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @if (($key+1) % 4 == 0)
                                        <div class="clearfix"></div>
                                    @endif
                                @endforeach
                            @endif

                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit"
                                class="btn btn-primary waves-effect text-uppercase btn-sm">{{ isset($role) ? 'Cập nhật' : 'Thêm mới' }}</button>
                        <a href="{{ route('role.index') }}" title="hủy" class="btn btn-default btn-sm">Hủy</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@section('script')
    <script type="text/javascript">
        $(document).on('change', 'input[name=check_all]', function () {
            if ($(this).is(':checked', true)) {
                $(this).closest('.data-item').find(".sub-check").prop('checked', true);
            } else {
                $(this).closest('.data-item').find(".sub-check").prop('checked', false);
            }
        });
    </script>
@endsection
