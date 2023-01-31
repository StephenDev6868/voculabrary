<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="{{ route('user.index') }}" class="nav-link nav-link-tab {{ Route::is('user.index') ? 'active' : null }}" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="{{ route('user.create') }}" class="nav-link nav-link-tab {{ Route::is('user.create') ? 'active' : null }}"><i class="fa fa-plus"></i> Tạo mới người dùng</a>
    </div>
</nav>
