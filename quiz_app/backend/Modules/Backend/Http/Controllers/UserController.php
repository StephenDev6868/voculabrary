<?php

namespace Modules\Backend\Http\Controllers;

use App\Common\AllPermission;
use App\Http\Controllers\Controller;
use App\Models\DepositHistory;
use App\Models\HistoryUserRegisterService;
use App\Models\User;
use App\Models\WithdrawHistory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        canPermission(AllPermission::xemKhachHang());
        if ($request->ajax()) {
            $users = User::query()->select('id', 'fullname', 'email', 'phone',
                'avatar', 'created_at', 'status', 'wallet', 'social_type')->where('role_id', 2);

            $data = $this->dataTableFormat($users, $request);

            return response()->json($data);
        }

        return view('backend::users.index');
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
                $formatData[$key]['phone'] = $item->phone;
                $formatData[$key]['avatar'] = '<img src="' .$avatar . '" width="200px" class="product-image-thumb">';
                $formatData[$key]['online'] = $item->getOnlineUser();
                $formatData[$key]['social_type'] = $item->getSocialType();
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
        canPermission(AllPermission::suaKhachHang());
        return view('backend::users.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->fullname = $request->get('fullname');
        $user->uuid = Str::uuid();
        $user->email = $request->get('email');
        $user->phone = $request->get('phone') ? $request->get('phone') : null;
        $user->status = $request->get('status') ? $request->get('status') : null;
        $user->name = $request->get('name') ? $request->get('name') : null;
        $user->address = $request->get('address') ? $request->get('address') : null;
        if (!empty($request->get('password'))) {
            $user->password = Hash::make($request->get('password'));
        }
        $user->role_id = 2;
        $user->gender = $request->get('gender');
        $user->date_or_birth = $request->get('date_or_birth') ? formatYMD($request->get('date_or_birth')) : null;
        if (!empty($request->file('avatar'))) {
            $inputFile = $request->file('avatar');
            $folderUploads = '/public/users';
            $user->avatar =  uploadFile($inputFile, $folderUploads);
        }
        $user->save();

        return redirect()->route('user.index')->with('success', 'Thêm mới người dùng thành công.');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data['user'] = User::find($id);
        $data['depositHistories'] = DepositHistory::with('userSender')->where('user_id', $id)
            ->orderBy('id', 'DESC')->paginate(20);
        $data['withdrawHistories'] = WithdrawHistory::where('user_id', $id)->orderBy('id', 'DESC')->paginate(20);
        $data['regiterServices'] = HistoryUserRegisterService::where('user_id', $id)->orderBy('id', 'DESC')->paginate(20);

        return view('backend::users.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        canPermission(AllPermission::suaKhachHang());
        $user = User::find($id);

        return view('backend::users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->fullname = $request->get('fullname');
        $user->uuid = Str::uuid();
        $user->email = $request->get('email');
        $user->phone = $request->get('phone') ? $request->get('phone') : null;
        $user->name = $request->get('name') ? $request->get('name') : null;
        $user->address = $request->get('address') ? $request->get('address') : null;
        if (!empty($request->get('password'))) {
            $user->password = Hash::make($request->get('password'));
        }
        if (auth::user()->id != $id) {
            $user->role_id = 2;
            $user->status = $request->get('status') ? $request->get('status') : null;
        }

        $user->gender = $request->get('gender');
        $user->date_or_birth = $request->get('date_or_birth') ? formatYMD($request->get('date_or_birth')) : null;
        if (!empty($request->file('avatar'))) {
            $inputFile = $request->file('avatar');
            $folderUploads = '/public/users';
            $user->avatar =  uploadFile($inputFile, $folderUploads, $user->avatar);
        }
        $user->save();

        if (auth::user()->id == $id) {
             return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        }

        return redirect()->route('user.index')->with('success', 'Cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        canPermissionAjax(AllPermission::xoaKhachHang());
        $data = User::find($id);
        if ($data->avatar) {
            Storage::delete($data->avatar);
        }
        $data->delete();

        return response()->json([
            'status' => 200,
            'message' =>  'Đã xoá thành công!'
        ]);
    }

    public function updateStatus($id, Request $request)
    {
        canPermissionAjax(AllPermission::suaKhachHang());
        $user = User::find($id);
        $status = $request->get('status');

        if ($status == 2) {
            $setStatus = 1;
        } else {
            $setStatus = 2;
        }

        if ($user) {
            $user->status = $setStatus;
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công!',
                'status_code' => $user->status
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Không tìm thấy dữ liệu vui lòng kiểm tra lại!',
        ]);
    }
}
