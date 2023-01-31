<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="{{ route('slider.index') }}" class="nav-link nav-link-tab {{ Route::is('slider.index') ? 'active' : null }}" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="{{ route('slider.create') }}" class="nav-link nav-link-tab {{ Route::is('slider.create') ? 'active' : null }}"><i class="fa fa-plus"></i> Tạo mới slider</a>
    </div>
</nav>
