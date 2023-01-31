@extends('backend::layouts.master')
@section('title', 'Chi tiết')
@section('content')
    <div class="row">
        <div class="col-12">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a href="{{ route('feedback.index') }}"
                       class="nav-link nav-link-tab {{ Route::is('feedback.index') ? 'active' : null }}"
                       id="nav-home-tab"> <i class="fa fa-list-alt"></i> Danh sách </a>
                </div>
            </nav>

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
                                        <p><b>Người gửi:</b> {{ $feedback->user->fullname }}</p>
                                        <p><b>Nội dung:</b> {{ $feedback->content }}</p>
                                        <p><b>File góp ý:</b>
                                            @if (!empty($feedback->feedbackFile))
                                                @foreach($feedback->feedbackFile as $file)
                                                    <a href="{{ getUrlFile($file->src) }}">{{ $file->file_name }}</a>
                                                    <br/>
                                                @endforeach
                                            @endif
                                        </p>
                                        <p><b>Ngày gửi:</b> {{ date('d/m/Y H:i:s', strtotime($feedback->created_at))  }}
                                        </p>
                                    </div>
                                </div>
                                @if (count($feedback->replyFeedback) > 0)
                                    <hr>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <h3 class="card-title text-bold">Trả lời góp ý</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($feedback->replyFeedback as $reply)
                                            <div class="col-md-12">
                                                <p><b>Ngày
                                                        gửi:</b> {{ date('d/m/y H:i:s', strtotime($reply->created_at)) }}
                                                </p>
                                                <p><b>Tiêu đề: </b>{{ $reply->title }}</p>
                                                <p><b>Nội dung: </b>{{ $reply->content }}</p>
                                                <p>-----------------------------------------------</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <hr>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <h3 class="card-title text-bold"><i class="fa fa-reply"></i> Trả lời góp ý
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('feedback.send_email', $feedback->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="desc">Tiêu đề</label>
                                                <input name="title" class="form-control"
                                                       value="{{ env('APP_NAME') }} Cảm ơn góp ý của bạn">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="desc">Nội dung <span class="color-red">*</span></label>
                                                <textarea name="content" class="form-control" rows="5"
                                                          placeholder="Cảm ơn bạn đã gửi góp ý ....."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary submit-form"><i class="fa fa-save"></i> Gửi
                                            </button>
                                            <button type="reset" class="btn btn-default go-back"><i
                                                    class="fa fa-reply"></i> Trở lại
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
