<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="{{ route('notification.index') }}" class="nav-link nav-link-tab {{ Route::is('notification.index') ? 'active' : null }}" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="{{ route('notification.create') }}" class="nav-link nav-link-tab {{ Route::is('notification.create') ? 'active' : null }}"><i class="fa fa-plus"></i> Tạo mới thông báo</a>
    </div>
</nav>
