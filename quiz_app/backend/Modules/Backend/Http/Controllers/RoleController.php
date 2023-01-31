<?php

namespace Modules\Backend\Http\Controllers;

use App\Common\AllPermission;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\UserPermission;
use App\Models\UserRole;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        canPermission(AllPermission::xemQuyenHan());
        $roles = Role::query()->orderBy('id', 'DESC')->paginate(20);

        return view('backend::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        canPermission(AllPermission::themQuyenHan());
        $permissions = Permission::where('parent_id', 0)->orderBy('id', 'DESC')->get();

        foreach ($permissions as $permission) {
            $permission->childPers = $this->getChildPermission($permission->id);
        }

        return view('backend::roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $permissions = $request->get('permission');

        $name = $request->get('name');

        if ($name) {
            try {
                DB::beginTransaction();
                $role = new Role();
                $role->name = $name;
                $role->slug = strSlugName($name);
                $role->save();

                if ($permissions) {
                    foreach ($permissions as $permissionId) {
                        RolePermission::findOrCreate($role->id, $permissionId);
                    }
                }

                DB::commit();
                return redirect()->route('role.index')->with('success', 'Thêm mới quyền thành công');

            } catch (\Exception $e)
            {
                DB::rollback();
                dd($e);
            }
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('backend::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        canPermission(AllPermission::suaQuyenHan());
        $role = Role::findOrFail($id);
        $arrPermisson = $role->permissions->pluck('id')->toArray();

        $permissions = Permission::where('parent_id', 0)->orderBy('id', 'DESC')->get();

        foreach ($permissions as $permission) {
            $permission->childPers = $this->getChildPermission($permission->id);
        }

        return view('backend::roles.edit', compact('role', 'arrPermisson',
            'permissions'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $permissions = $request->get('permission');
        $name = $request->get('name');
        $role = Role::findOrFail($id);
        if ($role) {
            try {
                DB::beginTransaction();

                $role->name = $name;
                $role->slug = strSlugName($name);
                $role->save();

                if ($permissions) {
                    RolePermission::where('role_id', $id)->delete();
                    foreach ($permissions as $permissionId) {
                        RolePermission::findOrCreate($role->id, $permissionId);
                    }
                }

                DB::commit();
                return redirect()->route('role.index')->with('success', 'Cập nhật quyền thành công');

            } catch (\Exception $e)
            {
                DB::rollback();
                dd($e);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        canPermission(AllPermission::xoaQuyenHan());
        $role = Role::find($id);
        if ($role) {
            $permissions = $role->permissions;
            if ($permissions) {
                UserPermission::whereIn('permission_id', $permissions->pluck('id')->toArray())->delete();
            }
            RolePermission::where('role_id', $id)->delete();
            UserRole::where('role_id', $id)->delete();

            $role->delete();

            return redirect()->route('role.index')->with('success', 'Xoá quyền thành công');
        }

    }

    public function getChildPermission($permissionId)
    {
        return Permission::where('parent_id', $permissionId)->get();
    }
}
