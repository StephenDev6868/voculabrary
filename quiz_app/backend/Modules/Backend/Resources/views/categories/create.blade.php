@extends('backend::layouts.master')
@section('title', 'Thêm danh mục')
@section('content')
    <div class="row">
        <div class="col-12">
            @include('backend::categories.nav_link')
            <div class="tab-content tab-content-customize">
                @include('backend::categories._form')
            </div>
        </div>
    </div>
@endsection
