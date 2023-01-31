<div class="tab-pane fade show active">
    <div class="card-body">
        <form action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if (isset($category))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Tên danh mục <span class="color-red">*</span></label>
                            <input type="text" name="name" class="form-control" id="name"
                                   placeholder="Nhập tên danh mục" value="{{ isset($category) ? $category->name : null }}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="desc">Mô tả</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Nhập mô tả  ngắn...">{{ isset($category) ? $category->description : null }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <br>
                            <input type="checkbox" name="status" value="1" {{ isset($category) && $category->status == 1 ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
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
