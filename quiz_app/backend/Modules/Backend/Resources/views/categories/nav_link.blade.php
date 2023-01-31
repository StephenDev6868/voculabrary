<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="{{ route('category.index') }}" class="nav-link nav-link-tab {{ Route::is('category.index') ? 'active' : null }}" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="{{ route('category.create') }}" class="nav-link nav-link-tab {{ Route::is('category.create') ? 'active' : null }}"><i class="fa fa-plus"></i> Tạo mới danh mục</a>
    </div>
</nav>
