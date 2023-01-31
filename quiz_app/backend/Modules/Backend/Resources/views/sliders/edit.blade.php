@extends('backend::layouts.master')
@section('title', 'Sửa')
@section('content')
    <div class="row">
        <div class="col-12">
            @include('backend::sliders.nav_link')
            <div class="tab-content tab-content-customize">
                @include('backend::sliders._form')
            </div>
        </div>
    </div>
@endsection
