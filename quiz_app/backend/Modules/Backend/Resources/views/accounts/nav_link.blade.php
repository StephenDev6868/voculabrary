<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="{{ route('account.index') }}" class="nav-link nav-link-tab {{ Route::is('account.index') ? 'active' : null }}" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="{{ route('account.create') }}" class="nav-link nav-link-tab {{ Route::is('account.create') ? 'active' : null }}"><i class="fa fa-plus"></i> Tạo mới tài khoản quản trị</a>
    </div>
</nav>
