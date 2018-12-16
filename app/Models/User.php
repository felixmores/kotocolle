<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordResetNotification;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'admin_flag'
    ];
    
    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * パスワードリセット通知の送信をオーバーライド
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new PasswordResetNotification($token));
    }
}
