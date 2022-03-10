<?php

namespace App\Models;

// Email認証するように変更１/4
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Auth\MustVerifyEmail;
use App\Notifications\User\VerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
//
use App\Models\Product;

// Email認証するように変更２/4
//class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmailContract
{
    // Email認証するように変更3/4
    // use HasApiTokens, HasFactory, Notifiable;
    use HasApiTokens, HasFactory, Notifiable, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    // リレーションの設定
    public function products()
    {
        // N:N
        // 第2引数で中間テーブル名
        // 中間テーブルのカラム取得
        // デフォルトでは関連付けるカラム(user_idと product_id)のみ取得
        return $this->belongsToMany(Product::class,'carts')
                    ->withPivot(['id','quantity']);
    }

    // Email認証するように変更4/4
    // app/Notifications/User/VerifyEmail.php を作成し、user.verification.verify としたほうを呼び出す
    public function sendEmailVerificationNotification(){
        $this->notify(new VerifyEmail());
    }

}
