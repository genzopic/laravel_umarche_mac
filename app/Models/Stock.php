<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//
use App\Models\Product;

class Stock extends Model
{
    use HasFactory;

    // テーブル名を変更
    protected $table = 't_stocks';

}
