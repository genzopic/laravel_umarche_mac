<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//
use App\Models\Owner;
use App\Models\Product;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'information',
        'filename',
        'is_selling',
    ];

    // リレーションの設定
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
    public function product()
    {
        // 1:N
        return $this->hasMany(Product::class);
    }

}
