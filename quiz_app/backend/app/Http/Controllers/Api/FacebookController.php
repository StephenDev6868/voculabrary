<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use DB;

class FacebookController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->client = new Client();
    }

    public function login(Request $request)
    {
        $userId = $request->get('user_id');
        $accessToken = $request->get('access_token');

        if (empty($accessToken)) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'access_token không được để trống'
            ]);
        }

        if (empty($userId)) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'user_id không được để trống'
            ]);
        }

        try {
            DB::beginTransaction();
            $checkToken = $this->client->get("https://graph.facebook.com/".$userId."?fields=id,name,email,picture&access_token=$accessToken");
            $responseData = json_decode($checkToken->getBody()->getContents(), true);
            $user = User::where('social_id', $responseData['id'])->where('social_type', User::TYPE_FACEBOOK)->first();

            if (empty($user)) {

                $avatar = $responseData['picture']['data'];
                $data = [
                    'name' => $responseData['name'],
                    'fullname' => $responseData['name'],
                    'uuid' => Str::uuid(),
                    'email' => !empty($responseData['email']) ? $responseData['email'] : null,
                    'social_id' => $responseData['id'],
                    'social_type' => User::TYPE_FACEBOOK,
                ];

                $user = new User();
                $user->fill($data);
                $user->save();

                if (!empty($avatar) && !empty($avatar['url'])) {
                    $url = $avatar['url'];
                    $image = file_get_contents($url);
                    $filename = time().'_'.strSlugName($responseData['name'], '_').'.jpg';
                    $filedir = 'public/users/' . $filename;
                    Storage::put($filedir, $image);

                    $user->avatar = $filedir;
                    $user->save();
                }
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

    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            DB::beginTransaction();

            $socialUser = Socialite::driver('facebook')->user();

            $user = User::where('social_id', $socialUser->id)->where('social_type', User::TYPE_FACEBOOK)->first();

            if (empty($user)) {
                $data = [
                    'name' => $socialUser->name,
                    'fullname' => $socialUser->name,
                    'uuid' => Str::uuid(),
                    'email' => $socialUser->email,
                    'avatar' => $socialUser->avatar,
                    'social_id' => $socialUser->id,
                    'social_type' => User::TYPE_FACEBOOK,
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
