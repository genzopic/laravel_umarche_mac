<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;        // ログインユーザー

class CartController extends Controller
{
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
        dd('テスト');

    }
}
