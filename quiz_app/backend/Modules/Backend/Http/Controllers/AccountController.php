<?php

namespace Modules\Backend\Http\Controllers;

use App\Common\AllPermission;
use App\Http\Controllers\Controller;
use App\Models\DepositHistory;
use App\Models\HistoryUserRegisterService;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserRole;
use App\Models\WithdrawHistory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        canPermission(AllPermission::xemDanhSachTaiKhoan());
        if ($request->ajax()) {
            $accounts = User::query()
                ->select('id', 'fullname', 'email', 'phone',
                'avatar', 'created_at', 'status', 'wallet', 'social_type')
                ->whereHas('roles', function ($query) {
                    return $query->where('name', '!=', SUPER_ADMIN);
                })
                ->where('role_id', '!=',1);

            $data = $this->dataTableFormat($accounts, $request);

            return response()->json($data);
        }

        return view('backend::accounts.index');
    }

    public function customFormat($data)
    {
        $formatData = [];
        if (count($data) > 0) {
            foreach ($data as $key => $item) {
                $avatar = null;
                if (!empty($item->avatar)) {
                    if (strpos($item->avatar, 'https://') !== false) {
                        $avatar = $item->avatar;
                    } else {
                        $avatar = getUrlFile($item->avatar);
                    }
                }

                $formatData[$key]['id'] = $key + 1;
                $formatData[$key]['fullname'] = $item->fullname;
                $formatData[$key]['email'] = $item->email;
                $formatData[$key]['phone'] = $item->phone;
                $formatData[$key]['avatar'] = !empty($avatar) ? '<img src="' .$avatar . '" width="200px" class="product-image-thumb">': '';
                $formatData[$key]['role'] = $item->roles[0]->name;
                $formatData[$key]['status'] = $item->getStatus();
                $formatData[$key]['created_at'] = date('d/m/Y H:i:s', strtotime($item->created_at));
                $formatData[$key]['action'] = $item->getAction();
            }
        }
        return $formatData;
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        canPermission(AllPermission::themTaiKhoan());
        $data['roles'] = Role::query()->get();
        return view('backend::accounts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $roleId = $request->role_id;
        $account = new User();
        $account->fullname = $request->get('fullname');
        $account->uuid = Str::uuid();
        $account->email = $request->get('email');
        $account->phone = $request->get('phone') ? $request->get('phone') : null;
        $account->status = $request->get('status') ? $request->get('status') : null;
        $account->name = $request->get('name') ? $request->get('name') : null;
        $account->address = $request->get('address') ? $request->get('address') : null;
        if (!empty($request->get('password'))) {
            $account->password = Hash::make($request->get('password'));
        }
        $account->role_id = $roleId;
        $account->gender = $request->get('gender');
        $account->date_or_birth = $request->get('date_or_birth') ? formatYMD($request->get('date_or_birth')) : null;
        if (!empty($request->file('avatar'))) {
            $inputFile = $request->file('avatar');
            $folderUploads = '/public/accounts';
            $account->avatar =  uploadFile($inputFile, $folderUploads);
        }
        $account->save();

        $role = Role::where('id', $roleId)->first();
        if ($role) {
            $permissions = $role->permissions;
            $account->roles()->attach($role);
            $this->givePermission($permissions, $account);
        }


        return redirect()->route('account.index')->with('success', 'Thêm mới người dùng thành công.');

    }

    public function givePermission($permissions, $account)
    {
        if ($permissions) {
            foreach ($permissions as $permission)
            {
                $account->permissions()->attach($permission);
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
        $data['account'] = User::find($id);
        $data['depositHistories'] = DepositHistory::with('accountSender')->where('account_id', $id)
            ->orderBy('id', 'DESC')->paginate(20);
        $data['withdrawHistories'] = WithdrawHistory::where('account_id', $id)->orderBy('id', 'DESC')->paginate(20);
        $data['regiterServices'] = HistoryUserRegisterService::where('account_id', $id)->orderBy('id', 'DESC')->paginate(20);

        return view('backend::accounts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        canPermission(AllPermission::suaTaiKhoan());
        $account = User::find($id);

        $roles = Role::query()->get();

        return view('backend::accounts.edit', compact('account', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $roleId = $request->role_id;
        $account = User::find($id);
        $account->fullname = $request->get('fullname');
        $account->uuid = Str::uuid();
        $account->email = $request->get('email');
        $account->phone = $request->get('phone') ? $request->get('phone') : null;
        $account->name = $request->get('name') ? $request->get('name') : null;
        $account->address = $request->get('address') ? $request->get('address') : null;
        if (!empty($request->get('password'))) {
            $account->password = Hash::make($request->get('password'));
        }
        $account->role_id = $roleId;
        $account->status = $request->get('status') ? $request->get('status') : null;

        $account->gender = $request->get('gender');
        $account->date_or_birth = $request->get('date_or_birth') ? formatYMD($request->get('date_or_birth')) : null;
        if (!empty($request->file('avatar'))) {
            $inputFile = $request->file('avatar');
            $folderUploads = '/public/accounts';
            $account->avatar =  uploadFile($inputFile, $folderUploads, $account->avatar);
        }
        $account->save();

        $role = Role::where('id', $roleId)->first();
        if ($role) {
            $permissions = $role->permissions;
            $account->roles()->attach($role);
            $this->givePermission($permissions, $account);
        }

        return redirect()->route('account.index')->with('success', 'Cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        canPermissionAjax(AllPermission::xoaTaiKhoan());
        $data = User::find($id);
        if ($data->avatar) {
            Storage::delete($data->avatar);
        }
        UserRole::where('user_id', $data->id)->delete();
        UserPermission::where('user_id', $data->id)->delete();
        $data->delete();

        return response()->json([
            'status' => 200,
            'message' =>  'Đã xoá thành công!'
        ]);
    }

    public function updateStatus($id, Request $request)
    {
        canPermissionAjax(AllPermission::suaTaiKhoan());
        $account = User::find($id);
        $status = $request->get('status');

        if ($status == 2) {
            $setStatus = 1;
        } else {
            $setStatus = 2;
        }

        if ($account) {
            $account->status = $setStatus;
            $account->save();

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công!',
                'status_code' => $account->status
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Không tìm thấy dữ liệu vui lòng kiểm tra lại!',
        ]);
    }
}
