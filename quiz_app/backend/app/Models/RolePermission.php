<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = 'role_permissions';

    protected $fillable = [
        'role_id',
        'permission_id'
    ];

    public static function findOrCreate($roleId, $permissionId)
    {
        $rolePermisson = RolePermission::query()->where([
            'role_id' => $roleId,
            'permission_id' => $permissionId
        ])->first();

        if (empty($rolePermisson)) {
            return RolePermission::query()->create([
                'role_id' => $roleId,
                'permission_id' => $permissionId
            ]);
        }

        return $rolePermisson;
    }
}
