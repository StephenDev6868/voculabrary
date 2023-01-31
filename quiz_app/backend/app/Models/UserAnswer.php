<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $table = 'user_answers';

    protected $fillable = [
        'exam_id',
        'user_id',
        'question_id',
        'answer',
        'answer_field',
        'correct',
        'num_answer',
        'last_question'
    ];
}
