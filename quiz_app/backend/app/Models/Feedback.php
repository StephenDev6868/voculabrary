<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory, Filterable;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function feedbackFile()
    {
        return $this->hasMany(FeedbackFile::class);
    }

//    public function getAction()
//    {
//        return '<a class="btn-action btn btn-color-blue btn-icon btn-sm" title="chi tiết" href="' .route('feedback.show',$this->id).'"><i class="fa fa-eye"></i></a>';
//    }

    public function getAction()
    {
        return '<a class="btn-action btn btn-color-blue btn-icon btn-sm" title="Phản hồi" href="' .route('feedback.show',$this->id).'"><i class="fa fa-reply"></i></a>
                <button type="submit" class="btn btn-action btn-color-red btn-icon btn-ligh btn-sm btn-remove-item" data-id="' . $this->id .'"><i class="fa fa-trash"></i></button>';
    }

    public function getFile()
    {
        $data = null;
        if ($this->feedbackFile) {

            foreach ($this->feedbackFile as $fileFeedback) {

                $f = '<a href="'.getUrlFile($fileFeedback->src).'">'.$fileFeedback->file_name.'</a><br/>';

                $data = $data.$f;
            }
        }

        return $data;
    }

    public function getReply()
    {
        if ($this->reply == 1) {
            return '<small class="badge badge-success">Đã gửi phản hồi</small>';
        } else {
            return '<small class="badge badge-warning">chờ phản hồi</small>';
        }
    }

    public function replyFeedback()
    {
        return $this->hasMany(ReplyFeedback::class);
    }
}
