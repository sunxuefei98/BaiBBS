<?php

namespace App\Models;

use App\Models\Topic;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;



class User extends Authenticatable implements MustVerifyEmailContract
{

    use Notifiable, MustVerifyEmailTrait;

    /**
     * 访问器-头像链接字段
     * @param string $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        if (empty($value)) {
            return 'https://cdn.learnku.com/uploads/images/201710/30/1/TrJS40Ey5k.png';
        }
        return $value;
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
