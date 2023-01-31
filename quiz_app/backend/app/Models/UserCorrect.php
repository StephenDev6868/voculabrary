<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCorrect extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exam_id',
        'category_id',
        'correct',
        'incorrect',
        'num_answer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
