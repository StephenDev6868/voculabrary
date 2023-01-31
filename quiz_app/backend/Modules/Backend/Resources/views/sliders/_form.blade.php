<div class="tab-pane fade show active">
    <div class="card-body">
        <form action="{{ isset($slider) ? route('slider.update', $slider->id) : route('slider.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if (isset($slider))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="src">Hình ảnh <span class="color-red">*</span></label>
                            <input type="file" class="dropify" id="src" name="src" accept="image/*"
                                   {{ isset($slider) ? '' : 'required' }}
                                   data-default-file="{{ isset($slider->src) ? getUrlFile($slider->src) : null }}">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="desc">Mô tả</label>
                            <textarea name="description" class="form-control" cols="4" placeholder="Nhập mô tả..."></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="link">Link đến trang</label>
                            <input name="link" class="form-control" placeholder="Nhập link..."/>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="type">Vị trí hiển thị</label>
                            <select id="type" name="type" class="form-control">
                                <option value="1" {{ isset($slider) && $slider->type == 1 ? 'selected' : null }}>Hiển thị slide ở trang chủ</option>
                                <option value="2" {{ isset($slider) && $slider->type == 2 ? 'selected' : null }}>Hiển thị slide ở danh mục</option>
                                <option value="3" {{ isset($slider) && $slider->type == 3 ? 'selected' : null }}>Hiển thị slide ở bài viết</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <br>
                            <input type="checkbox" name="status" value="1" {{ isset($slider) && $slider->status == 1 ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                    <button type="reset" class="btn btn-default go-back"><i class="fa fa-reply"></i> Trở lại</button>
                </div>
            </div>
        </form>
    </div>
</div>
