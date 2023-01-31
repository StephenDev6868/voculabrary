<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OtpUser;
use App\Models\User;
use Hash;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Http\Request;
use Auth, DB, Mail;
use Faker\Generator;
use Illuminate\Container\Container;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register(Request $request)
    {

        $this->validate($request,
            [
                'phone' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:6',
            ],
            [
                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'email.required' => 'Vui lòng nhập email.',
                'email.unique' => 'Email đã tồn tại vui lòng nhập email khác.',
                'password.min' => 'Mật khẩu tối thiểu 6 kí tự.',
                'password.same' => 'Nhập lại mật khẩu không đúng với mật khẩu.',
            ]);

        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['uuid'] = Str::uuid();
            $user = new User();
            $user->fill($data);

            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            $user->save();

            auth::login($user);

            $token = $this->createToken($user);
            $userInfo = User::getUserInfo($user);

            DB::commit();

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Đăng ký thành công.',
                'data' => $userInfo,
                'token' => $token,
                'token_type' => TOKEN_TYPE
            ]);

        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
        }
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Vui lòng nhập tên đăng nhập',
            'password.required' => 'Vui lòng nhập mật khẩu.'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => ERROR_VALIDATE,
                'message' => 'Đăng nhập không thành công',
                'errors' => $validate->errors()
            ]);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'Sai email hoặc mật khẩu.'
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if ($user->status == 2) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'Tài khoản đã bị khoá vui lòng liên hệ admin để được trợ giúp.'
            ]);
        }

        // check pass
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'Thông tin đăng nhập không chính xác.'
            ]);
        }

        $token = $this->createToken($user);
        $userInfo = User::getUserInfo($user);

        $user->online = 1;
        $user->save();

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Đăng nhập thành công.',
            'token' => $token,
            'token_type' => TOKEN_TYPE,
            'data' => $userInfo,
        ]);

    }

    public function loginGuest()
    {
        $faker = Container::getInstance()->make(Generator::class);
        $data = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => Hash::make('1'),
            'social_type' => 3
        ];
        $data['uuid'] = Str::uuid();
        $user = new User();
        $user->fill($data);
        $user->save();

        $user->online = 1;
        $user->fullname = 'Guest'.$user->id;
        $user->name = 'Guest'.$user->id;
        $user->save();

        $token = $this->createToken($user);
        $userInfo = User::getUserInfo($user);

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Đăng nhập thành công.',
            'token' => $token,
            'token_type' => TOKEN_TYPE,
            'data' => $userInfo,
        ]);

    }

    public function createToken($user)
    {
        $tokenResult = $user->createToken(USER_TOKEN)->plainTextToken;

        return $tokenResult;
    }

    public function forgetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng.'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => ERROR_VALIDATE,
                'message' => 'Email sai định dạng',
                'errors' => $validate->errors()
            ]);
        }

        $email = $request->get('email');
        $checkEmail = User::where('email', $email)->first();

        if (empty($checkEmail)) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'Email chưa được đăng ký trong hệ thống.'
            ]);
        }

        if ($checkEmail->status == 2) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'Tài khoản đã bị khoá vui lòng liên hệ admin để được trợ giúp.'
            ]);
        }

        $otp = rand(10000,99999);
        $otpUser = new OtpUser();
        $otpUser->user_id = $checkEmail->id;
        $otpUser->otp = $otp;
        $otpUser->save();

        // send otp to email using email api
        $subject = 'Mã xác thực reset mật khẩu';
        $content = $otp;
        $toEmail = $checkEmail->email;// mail nhận
        $toName = $checkEmail->fullname ? $checkEmail->fullname : 'No name';

        Mail::Send('emails.send_otp', ['content' => $content], function ($message) use ($toEmail, $toName, $subject) {
            $message->to($toEmail, $toName)->subject($subject);
        });

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Đã gửi otp đến email của bạn vui lòng kiểm tra.',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'code' => 'required',
            'email' => 'required|email',
        ], [
            'code.required' => 'Vui lòng nhập otp',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng.'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => ERROR_VALIDATE,
                'message' => 'error',
                'errors' => $validate->errors()
            ]);
        }

        $email = $request->get('email');
        $otp = (int)$request->get('code');
        $checkEmail = User::where('email', $email)->first();

        if (empty($checkEmail)) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'Email chưa được đăng ký trong hệ thống.'
            ]);
        }

        $userOtp = OtpUser::where('otp', $otp)->where('user_id', $checkEmail->id)
            ->whereNull('verify_otp_at')->first();

        if (empty($userOtp)) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'OTP không đúng vui lòng kiểm tra lại.'
            ]);
        }

        $userOtp->verify_otp_at = date('Y-m-d H:i:s');
        $userOtp->save();

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Đã xác thực thành công otp',
        ]);

    }

    public function updatePassword(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required|email',
                'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:6',
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không đúng định dạng.',
                'password.min' => 'Mật khẩu tối thiểu 6 kí tự.',
                'password.same' => 'Nhập lại mật khẩu không đúng với mật khẩu.',
            ]);

        $email = $request->get('email');
        $password = $request->get('password');

        $checkEmail = User::where('email', $email)->first();

        if (empty($checkEmail)) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'Email chưa được đăng ký trong hệ thống.'
            ]);
        }

        if ($checkEmail->status == 2) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'Tài khoản đã bị khoá vui lòng liên hệ admin để được trợ giúp.'
            ]);
        }

        $checkEmail->password = Hash::make($password);
        $checkEmail->save();

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Đã cập nhật mật khẩu thành công vui lòng đăng nhập lại để tiếp tục ứng dụng.',
        ]);
    }

    public function loginApple(Request $request)
    {
        $fullname = $request->get('fullname');
        $email = $request->get('email');

        $this->validate($request,
            [
                'fullname' => 'required',
                'email' => 'required'
            ],
            [
                'fullname.required' => 'Vui lòng nhập fullname.',
                'email.required' => 'Vui lòng nhập email.'
            ]);

        try {
            DB::beginTransaction();

            $user = User::where('email', $email)->where('fullname', $fullname)
                ->where('social_type', User::TYPE_APPLE)->first();

            if(empty($user)) {
                $data = [
                    'fullname' => $fullname,
                    'uuid' => Str::uuid(),
                    'email' =>$email,
                    'social_type'=> User::TYPE_APPLE,
                ];

                $user = new User();
                $user->fill($data);
                $user->save();
            }

            $token = $this->createToken($user);
            $userInfo = User::getUserInfo($user);

            DB::commit();

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Đăng ký thành công.',
                'data' => $userInfo,
                'token' => $token,
                'token_type' => TOKEN_TYPE
            ]);

        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
        }
    }
}
