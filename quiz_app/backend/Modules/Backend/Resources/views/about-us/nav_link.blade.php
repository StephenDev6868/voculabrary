<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="{{ route('about-us.index') }}" class="nav-link nav-link-tab {{ Route::is('about-us.index') ? 'active' : null }}" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="{{ route('about-us.create') }}" class="nav-link nav-link-tab {{ Route::is('about-us.create') ? 'active' : null }}"><i class="fa fa-plus"></i> Tạo mới</a>
    </div>
</nav>
