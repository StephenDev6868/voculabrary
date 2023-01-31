<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\PermissionRegistrar;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions');
    }

    public static function findOrCreate($name, $parentId = 0)
    {
        $permission = Permission::query()->where(['name' => $name])->first();

        if (empty($permission)) {
            return Permission::query()->create(['name' => $name, 'slug' => strSlugName($name), 'parent_id' => $parentId]);
        }

        return $permission;
    }
}
