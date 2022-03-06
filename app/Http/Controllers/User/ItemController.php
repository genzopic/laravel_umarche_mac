<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    // コンストラクタ
    public function __construct()
    {
        // 認証チェック
        $this->middleware('auth:users');
        
    }
    //
    public function index()
    {
        $products = Product::availableItems()->get();
        return view('user.index',compact('products'));
    }
    //
    public function show($id)
    {
        // 商品情報取得
        $product = Product::findOrFail($id);
        // 現在庫数
        $quantity = Stock::where('product_id',$product->id)->sum('quantity');
        if($quantity > 9) {
            $quantity = 9;
        }

        return view('user.show',
                compact('product','quantity'));
    }
}
