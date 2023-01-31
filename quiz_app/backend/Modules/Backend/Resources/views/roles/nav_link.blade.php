<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="{{ route('role.index') }}" class="nav-link nav-link-tab {{ Route::is('role.index') ? 'active' : null }}" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="{{ route('role.create') }}" class="nav-link nav-link-tab {{ Route::is('role.create') ? 'active' : null }}"><i class="fa fa-plus"></i> Tạo mới nhóm quyền</a>
    </div>
</nav>
