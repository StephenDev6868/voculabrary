<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DepositHistory;
use App\Models\Exam;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\UserSuggestion;
use App\Models\WithdrawHistory;
use Illuminate\Http\Request;
use Auth, DB;
use Hash;
use Spatie\Permission\Models\Role;
use Validator;

class UserController extends Controller
{

    public function index()
    {

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Hồ sơ cá nhân',
            'data' => User::getUserInfo(auth::user())
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,'. auth::user()->id,
        ], [
            'fullname.required' => 'Vui lòng nhập họ tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại vui lòng nhập email khác'
        ]);

        $data = $request->all();
        if (!empty($request->get('date_or_birth'))) {
            $data['date_or_birth'] = formatYMD($request->get('date_or_birth'));
        }
        $user = auth::user();
        $user->fullname = $data['fullname'];
        $user->phone = $data['phone'];
        $user->email = $data['email'];
        $user->date_or_birth = $data['date_or_birth'];
        $user->address = !empty($request->address) ? $request->address : null;

        if (!empty($request->file('avatar'))) {
            $inputFile = $request->file('avatar');
            $folderUploads = '/public/users';
            $user->avatar =  uploadFile($inputFile, $folderUploads, $user->avatar);
        }
        $user->save();

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Cập nhập hồ sơ thành công.',
            'data' => User::getUserInfo($user)
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|mimes:jpeg,jpg,png'
        ], [
            'avatar.required' => 'Ảnh đại diện không được để trống',
            'avatar.mimes' => 'Ảnh đại diện phải là định dạng jpeg, jpg, png'
        ]);

        $user = auth::user();

        if (!empty($request->file('avatar'))) {
            $inputFile = $request->file('avatar');
            $folderUploads = '/public/users';
            $user->avatar =  uploadFile($inputFile, $folderUploads, $user->avatar);
            $user->save();

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Cập nhập thành công.',
                'avatar' => getUrlFile($user->avatar)
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        $currentPassword = auth::user()->password;

        $validate = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'new_password_confirm' => 'required|same:new_password'
        ], [
            'old_password.required' => 'Trường mật khẩu cũ không được để trống.',
            'new_password.required' => 'Trường mật khẩu mới không được để trống.',
            'new_password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'new_password_confirm.required' => 'Nhập lại mật khẩu không được để trống.',
            'new_password_confirm.same' => 'Nhập lại mật khẩu không trùng với mật khẩu mới.',
        ]);
        if ($validate->fails()) {

            return response()->json([
                'status' => ERROR_VALIDATE,
                'message' => 'Đối mật khẩu không thành công',
                'errors' => $validate->errors()
            ], ERROR_VALIDATE);
        }
        if (Hash::check($request->old_password, $currentPassword)) {

            $user = auth::user();
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Đổi mật khẩu thành công'
            ]);
        } else {
            return response()->json([
                'status' => -1,
                'message' => 'Mật khẩu cũ nhập không chính xác vui lòng kiểm tra lại'
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $user = auth::user();
        $user->online = 2;
        $user->save();

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Đăng xuất thành công!',
        ]);
    }

    public function deposit(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone' => 'required',
            'money' => 'required|integer',
        ], [
            'phone.required' => 'Số điện thoại không được để trống.',
            'money.required' => 'Số tiền không được để trống.',
            'money.integer' => 'Số tiền phải là số lớn hơn 0.',
        ]);

        if ($validate->fails()) {

            return response()->json([
                'status' => ERROR_VALIDATE,
                'errors' => $validate->errors()
            ], ERROR_VALIDATE);
        }

        $phone = trim($request->get('phone'), ' ');
        $money = $request->get('money');
        $type = $request->get('type') ? $request->get('type') : 1;

        try {
            $user = auth::user();
            $myWallet = $user->wallet;

            DB::beginTransaction();

            // chuyen tien
            if ($type == 2) {
                if ($money > $myWallet) {

                    return response()->json([
                        'status' => SUCCESS,
                        'message' => 'Số tiền trong ví không đủ để thực hiện chuyển tiền.'
                    ]);
                }

                $checkUserReceive = User::where('phone', $phone)->where('id', '!=', $user->id)
                    ->select('id', 'phone', 'wallet')->first();

                if ($checkUserReceive) {
                    /** thuc hien nap tien cho so dt nay **/
                    $myWalletReceive = $checkUserReceive->wallet;
                    $depositUserReceive = new DepositHistory();
                    $depositUserReceive->user_id = $checkUserReceive->id;
                    $depositUserReceive->total_wallet = $myWalletReceive;
                    $depositUserReceive->money = $money;
                    $depositUserReceive->user_sender_id = $user->id;
                    $depositUserReceive->phone = $phone;
                    $depositUserReceive->type = 1;
                    $depositUserReceive->save();

                    $checkUserReceive->wallet = $myWalletReceive + $money;
                    $checkUserReceive->save();

                }

                $withdrawHistory = new WithdrawHistory();
                $withdrawHistory->user_id = $user->id;
                $withdrawHistory->total_wallet = $myWallet;
                $withdrawHistory->money = $money;
                $withdrawHistory->receive_user_id = !empty($checkUserReceive) ? $checkUserReceive->id : null;
                $withdrawHistory->phone = $phone;
                $withdrawHistory->type = $type;
                $withdrawHistory->save();

                $user->wallet = $myWallet - $money;

            } else {
                $depositHistory = new DepositHistory();
                $depositHistory->user_id = $user->id;
                $depositHistory->total_wallet = $myWallet;
                $depositHistory->money = $money;
                $depositHistory->phone = $phone;
                $depositHistory->type = $type;
                $depositHistory->save();

                $user->wallet = $myWallet + $money;
            }
            $user->save();

            DB::commit();

            $message = 'Chúc mừng bạn đã nạp thành công '. formatPrice($money).'đ vào tài khoản';

            if ($type == 2) {
                $message = 'Chúc mừng bạn đã chuyển thành công '. formatPrice($money).'đ đến thuê bao '. $phone;
            }

            return response()->json([
                'status' => SUCCESS,
                'message' => $message,
            ]);


        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'error',
                'data' => $e
            ]);

        }
    }

    public function suggestion(Request $request)
    {
        $id = $request->get('exam_id');
        $type = !empty($request->get('type')) ? $request->get('type') : null;

        $request->validate([
            'exam_id' => 'required|int',
        ], [
            'exam_id.required' => 'exam_id không được để trống',
            'exam_id.int' => 'exam_id phải là số nguyên'
        ]);

        $exam = Exam::where('id', $id)->where('status', 1)->select('id', 'suggest_number')->first();

        if (empty($exam)) {

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Bộ câu hỏi này không tồn tại',
            ]);
        }

        $dateNow = Date('Y-m-d');
        $user = auth::user();

        $countUserSuggestion = UserSuggestion::where('exam_id', $id)
            ->where('user_id', $user->id)->whereNull('reset_suggest')->count();

        if (!empty($type)) {
            if ($countUserSuggestion == $exam->suggest_number) {

                return response()->json([
                    'status' => SUCCESS,
                    'message' => 'Bạn đã dùng hết lượt gợi ý của ngày hôm nay'
                ]);
            }

            $userSuggestion = new UserSuggestion();
            $userSuggestion->user_id = $user->id;
            $userSuggestion->exam_id = $id;
            $userSuggestion->date = $dateNow;
            $userSuggestion->save();
        }

        $countUserSuggestion = UserSuggestion::where('exam_id', $id)
            ->where('user_id', $user->id)->whereNull('reset_suggest')->count();
        $suggestNumber = $exam->suggest_number - $countUserSuggestion;

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => [
                'exam_id' => (int)$id,
                'suggest_number' => $suggestNumber
            ]
        ]);

    }

    public function resetSuggestion(Request $request)
    {
        $id = $request->get('exam_id');

        $request->validate([
            'exam_id' => 'required|int',
        ], [
            'exam_id.required' => 'exam_id không được để trống',
            'exam_id.int' => 'exam_id phải là số nguyên'
        ]);

        $exam = Exam::where('id', $id)->where('status', 1)->select('id', 'suggest_number')->first();

        if (empty($exam)) {

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Bộ câu hỏi này không tồn tại',
            ]);
        }

        UserSuggestion::where('exam_id', $id)
            ->where('user_id', auth::user()->id)->whereNull('reset_suggest')
            ->update([
                'reset_suggest' => 1
            ]);

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
        ]);
    }
}
