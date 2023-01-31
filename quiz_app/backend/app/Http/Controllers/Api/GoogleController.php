<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use DB;

class GoogleController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->client = new Client();
    }


    public function login(Request $request)
    {
        $accessToken = $request->get('id_token');

        if (empty($accessToken)) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'id_token không được để trống'
            ]);
        }

        try {
            DB::beginTransaction();
            $checkToken = $this->client->get("https://oauth2.googleapis.com/tokeninfo?id_token=$accessToken");
            $responseGoogle = json_decode($checkToken->getBody()->getContents(), true);

            $user = User::where('email', $responseGoogle['email'])->where('social_type', User::TYPE_GOOGLE)->first();

            if(empty($user)) {
                $data = [
                    'name' => $responseGoogle['name'],
                    'fullname' => $responseGoogle['name'],
                    'uuid' => Str::uuid(),
                    'email' =>$responseGoogle['email'],
                    'avatar' => $responseGoogle['picture'],
                    'social_id'=> $responseGoogle['sub'],
                    'social_type'=> User::TYPE_GOOGLE,
                ];

                $user = new User();
                $user->fill($data);
                $user->save();


            }

            $token = User::createTokenUser($user);
            $userInfo = User::getUserInfo($user);

            DB::commit();

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Đăng nhập thành công.',
                'token' => $token,
                'token_type' => TOKEN_TYPE,
                'data' => $userInfo,
            ]);



        } catch (\Exception $e)
        {
            DB::rollback();
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            DB::beginTransaction();

            $socialUser = Socialite::driver('google')->user();

            $user = User::where('social_id', $socialUser->id)->where('social_type', User::TYPE_GOOGLE)->first();

            if(empty($user)) {
                $data = [
                    'name' => $socialUser->name,
                    'fullname' => $socialUser->name,
                    'uuid' => Str::uuid(),
                    'email' => $socialUser->email,
                    'avatar' => $socialUser->avatar,
                    'social_id'=> $socialUser->id,
                    'social_type'=> User::TYPE_GOOGLE,
                ];

                $user = new User();
                $user->fill($data);
                $user->save();


            }

            $token = User::createTokenUser($user);
            $userInfo = User::getUserInfo($user);

            DB::commit();

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Đăng nhập thành công.',
                'token' => $token,
                'token_type' => TOKEN_TYPE,
                'data' => $userInfo,
            ]);

        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
        }
    }

}
