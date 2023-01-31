<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a href="{{ route('exam.index') }}" class="nav-link nav-link-tab {{ Route::is('exam.index') ? 'active' : null }}" id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
        <a href="{{ route('exam.create') }}" class="nav-link nav-link-tab {{ Route::is('exam.create') ? 'active' : null }}"><i class="fa fa-plus"></i> Tạo mới</a>
    </div>
</nav>
