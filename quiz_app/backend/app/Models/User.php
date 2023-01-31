<?php

namespace App\Models;

use App\Permission\HasPermissionsTrait;
use App\Traits\Filterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filterable, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'fullname',
        'email',
        'password',
        'uuid',
        'gender',
        'date_or_birth',
        'avatar',
        'phone',
        'address',
        'wallet',
        'social_id',
        'social_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const TYPE_GOOGLE = 1;
    const TYPE_FACEBOOK = 2;
    const TYPE_APPLE = 4;

    public function getStatus()
    {

        return
            '<div class="custom-control custom-switch custom-switch-on-success">'.
            '<input type="checkbox" class="custom-control-input change-status" value="'. $this->status.'"'.
            'data-id="'.$this->id .'"'.
            ($this->status == 1 ? "checked" : null) .' id="customSwitch'. $this->id .'">'.
            '<label class="custom-control-label"
                  for="customSwitch' .$this->id .'"></label>'.
            '</div>';
    }

    public function getAction()
    {
        if ($this->role_id != 1) {
            return '<a class="btn-action btn btn-color-blue btn-icon btn-sm" title="Sửa" href="' .route('account.edit',$this->id).'"><i class="fa fa-edit"></i></a>
                <button type="submit" class="btn btn-action btn-color-red btn-icon btn-ligh btn-sm btn-remove-item" data-id="' . $this->id .'"><i class="fa fa-trash"></i></button>
                ';
        } else {
            return '<a class="btn-action btn btn-color-blue btn-icon btn-sm" title="Sửa" href="' .route('user.edit',$this->id).'"><i class="fa fa-edit"></i></a>
                <button type="submit" class="btn btn-action btn-color-red btn-icon btn-ligh btn-sm btn-remove-item" data-id="' . $this->id .'"><i class="fa fa-trash"></i></button>
                ';
        }

    }

    public function getOnlineUser()
    {
        if ($this->online == 1) {
            return '<small class="badge badge-success">Online</small>';
        } else {
            return '<small class="badge badge-warning">Offline</small>';
        }
    }

    public function getSocialType()
    {
        switch ($this->social_type) {
            case 1:
                return '<small class="badge badge-danger">Google</small>';

            case 2:
                return '<small class="badge badge-primary">Facebook</small>';

            case 3:
                return '<small class="badge badge-info">Khách</small>';

            case 4:
                return '<small class="badge badge-dark">Apple</small>';

            default:
                return '<small class="badge badge-secondary">Tài khoản mới</small>';

        }
    }

    public static function getUserInfo($user)
    {
        $avatar = null;
        $type = null;

        switch ($user->social_type) {
            case 1:
                $type = 'Google';
                break;

            case 2:
                $type = 'Facebook';
                break;

            case 3:
                $type = 'Khách';
                break;


        }

        if (!empty($user->avatar)) {
            if (strpos($user->avatar, 'https://') !== false) {
                $avatar = $user->avatar;
            } else {
                $avatar = getUrlFile($user->avatar);
            }
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'fullname' => $user->fullname,
            'email' => $user->email,
            'gender' => $user->gender,
            'date_or_birth' => $user->date_or_birth,
            'avatar' => $avatar,
            'phone' => $user->phone,
            'address' => $user->address,
            'social_type' => $type
        ];
    }

    public function otpUser()
    {
        return $this->hasMany(OtpUser::class, 'user_id', 'id');
    }

    public function articles()
    {
        return $this->belongsToMany(Exam::class, 'user_articles');
    }

    public function depositHistory()
    {
        return $this->hasMany(DepositHistory::class, 'user_id', 'id');
    }

    public function withDrawHistory()
    {
        return $this->hasMany(WithdrawHistory::class, 'user_id', 'id');
    }

    public function historyRegisterService()
    {
        return $this->hasMany(HistoryUserRegisterService::class, 'user_id', 'id');
    }

    public static function createTokenUser($user)
    {
        $tokenResult = $user->createToken(USER_TOKEN)->plainTextToken;

        return $tokenResult;
    }

    public function userAnswer()
    {
        return $this->hasMany(UserAnswer::class)->whereNotNull('last_question');
    }

    public function getUserRole()
    {

    }

}
