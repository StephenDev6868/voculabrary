<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user_roles';

    public static function findOrCreate($userId, $roleId)
    {
        $userRole = UserRole::query()->where([
            'user_id' => $userId,
            'role_id' => $roleId
        ])->first();

        if (empty($userRole)) {
            return UserRole::query()->create([
                'user_id' => $userId,
                'role_id' => $roleId
            ]);
        }

        return $userRole;
    }
}
