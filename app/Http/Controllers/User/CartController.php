<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;        // ログインユーザー
use App\Models\User;

class CartController extends Controller
{
    //
    public function index()
    {
        // ログインしているユーザーから、中間テーブルの(carts)カートの内容を取得する
        $user = User::findOrFail(Auth::id());
        $products = $user->products;
        $totalPrice = 0;
        // 合計金額
        foreach ($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }
        // dd($products,$totalPrice);
        return view('user.cart',
            compact('products','totalPrice'));
    }
    //
    public function add(Request $request)
    {
        // dd($request->product_id);
        $itemInCart = Cart::where('product_id',$request->product_id)
                ->where('user_id',Auth::id())
                ->first();
        if($itemInCart){
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        // カートへ移動
        return redirect()->route('user.cart.index');

    }
}
