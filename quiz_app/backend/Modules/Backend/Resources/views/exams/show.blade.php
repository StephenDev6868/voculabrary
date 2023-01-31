@extends('backend::layouts.master')
@section('title', 'Chi tiết')
@section('content')
    <div class="row">
        <div class="col-12">
            @include('backend::exams.nav_link')
            <div class="tab-content tab-content-customize " style="background: none; border: none">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Chi tiết </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p><b>Tiêu đề:</b> {{ !empty($exam->title) ? $exam->title : null }}</p>
                                        <p><b>Mô tả:</b> {{ !empty($exam->description) ? $exam->description : null }}</p>
                                        <p><b>Danh mục:</b> {{ !empty($exam->category) ?$exam->category->name : null }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <h3 class="card-title text-bold">Danh sách câu hỏi và câu trả lời</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    @if ($exam->questions)
                                        @foreach($exam->questions as $question)
                                            <div class="col-md-6">
                                                <b>{{ $question->priority }}</b>: Chọn đáp án đúng với nghĩa của từ:
                                                    <label class="col-form-label">{{ $question->title }}</label>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="radio_{{ $question->id }}"
                                                        value="{{ $question->a }}" {{ $question->answer == $question->a ? 'checked' : null }}>
                                                        <label class="form-check-label">{{ $question->a }}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="radio_{{ $question->id }}"
                                                               value="{{ $question->b }}" {{ $question->answer == $question->b ? 'checked' : null }}>
                                                        <label class="form-check-label">{{ $question->b }}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="radio_{{ $question->id }}"
                                                               value="{{ $question->c }}" {{ $question->answer == $question->c ? 'checked' : null }}>
                                                        <label class="form-check-label">{{ $question->c }}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="radio_{{ $question->id }}"
                                                               value="{{ $question->d }}" {{ $question->answer == $question->d ? 'checked' : null }}>
                                                        <label class="form-check-label">{{ $question->d }}</label>
                                                    </div>
                                                </div>
                                                <b>Ví dụ:</b>
                                                <p>{{ $question->example }}</p>
                                                <p style="color: #0f88e9">{{ $question->translate_example }}</p>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
