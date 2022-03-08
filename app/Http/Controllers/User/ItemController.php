<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use App\Models\Product;
use App\Models\Stock;
use App\Models\PrimaryCategory;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    // コンストラクタ
    public function __construct()
    {
        // 認証チェック
        $this->middleware('auth:users');

        // 販売中の商品かをチェック
        $this->middleware(function(Request $request,$next) {
            $id = $request->route()->parameter('item'); // productのidを取得
            if(!is_null($id)){
                // show/indexにアクセスするとnullになるので
                // それ以外の場合（show/{item}）
                $itemId = Product::availableItems()->where('products.id',$id)->exists();
                if(!$itemId) {
                    // 有効な商品がなkれば、404
                    abort(404);     // 404画面表示
                }
            }
            return $next($request);
        });
        
    }
    //
    public function index(Request $request)
    {
        // dd($request);
        $products = Product::availableItems()
                    ->selectCategory($request->category ?? '0')
                    ->searchKeyword($request->keyword)
                    ->sortOrder($request->sort)
                    ->paginate($request->pagination ?? '20');
        $categories = PrimaryCategory::with('secondary')
                    ->get();
    
        return view('user.index',compact('products','categories'));
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
