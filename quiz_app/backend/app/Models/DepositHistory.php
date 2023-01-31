<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositHistory extends Model
{
    use HasFactory;

    protected $table = 'deposit_histories';

    public function userSender()
    {
        return $this->belongsTo(User::class, 'user_sender_id', 'id')
            ->select('id', 'fullname', 'phone');
    }
}
