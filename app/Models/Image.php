<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;

class Image extends Model
{
    use HasFactory;
    // 更新項目の設定
    protected $fillable = [
        'owner_id',
        'filename',
    ];
    // リレーションの設定
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }


}
