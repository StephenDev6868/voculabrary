@extends('backend::layouts.master')
@section('title', 'Sửa')
@section('content')
    <div class="row">
        <div class="col-12">
            @include('backend::about-us.nav_link')
            <div class="tab-content tab-content-customize">
                @include('backend::about-us._form')
            </div>
        </div>
    </div>
@endsection
