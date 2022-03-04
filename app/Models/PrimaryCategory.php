<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SecondaryCategory;

class PrimaryCategory extends Model
{
    use HasFactory;

    // リレーションの設定
    public function secondary()
    {
        // 1:N
        return $this->hasMany(SecondaryCategory::class);
    }
    
}
