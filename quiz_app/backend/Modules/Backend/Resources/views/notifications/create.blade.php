@extends('backend::layouts.master')
@section('title', 'Thêm mới')
@section('content')
    <div class="row">
        <div class="col-12">
            @include('backend::notifications.nav_link')
            <div class="tab-content tab-content-customize">
                @include('backend::notifications._form')
            </div>
        </div>
    </div>
@endsection
