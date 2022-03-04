<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//
use App\Models\Shop;
use App\Models\SecondaryCategory;
use App\Models\Image;
use App\Models\Stock;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'information',
        'price',
        'is_selling',
        'sort_order',
        'secondary_category_id',
        'image1',
        'image2',
        'image3',
        'image4',
    ];

    // リレーションの設定
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function category()
    {
        return $this->belongsTo(SecondaryCategory::class,'secondary_category_id');
    }
    public function imageFirst()
    {
        return $this->belongsTo(Image::class,'image1','id');
    }
    public function imageSecond()
    {
        return $this->belongsTo(Image::class,'image2','id');
    }
    public function imageThird()
    {
        return $this->belongsTo(Image::class,'image3','id');
    }
    public function imageFourth()
    {
        return $this->belongsTo(Image::class,'image4','id');
    }
    public function stock()
    {
        // 1:N
        return $this->hasMany(Stock::class);
    }
    public function users()
    {
        // N:N
        // 第2引数で中間テーブル名
        // 中間テーブルのカラム取得
        // デフォルトでは関連付けるカラム(user_idと product_id)のみ取得
        return $this->belongsToMany(Product::class,'carts')
                    ->withPivot(['id','quantity']);
    }

}

