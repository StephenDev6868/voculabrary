<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryUserRegisterService extends Model
{
    use HasFactory;

    public function article()
    {
        return $this->belongsTo(Exam::class, 'article_id', 'id');
    }
}
