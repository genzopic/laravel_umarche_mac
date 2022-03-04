<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;        // ログインユーザー
use App\Models\User;
use App\Models\Stock;

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
    // 追加
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
    // 削除
    public function delete($id)
    {
        Cart::where('product_id',$id)
            ->where('user_id',Auth::id())
            ->delete();

            // カートへ移動
        return redirect()->route('user.cart.index');
    }
    // 決済
    public function checkout()
    {
        $user = User::findOrFail(Auth::id());
        $products = $user->products;

        $lineItems = [];
        // カートの中身を取得して、lineItemsにセット
        foreach ($products as $product) {
            // 在庫チェック
            $quantity = '';
            $quantity = Stock::Where('product_id',$product->id)->sum('quantity');
            if($product->pivot->quantity > $quantity) {
                // 在庫がない場合は、買えないので、カートに戻す
                return redirect()->route('user.cart.index');
            } else {
                $lineItem = [
                    'name' => $product->name,
                    'description' => $product->information,
                    'amount' => $product->price,
                    'currency' => 'jpy',
                    'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems,$lineItem);
           }
           // 在庫確保
           foreach($products as $product) {
                Stock::create([
                    'product_id' => $product->id,
                    'type' => \Constant::PRODUCT_LIST['reduce'],           // 2:出庫
                    'quantity' => $product->pivot->quantity * -1,
                ]);
           }
           dd('test');

        }
        // dd($lineItems);
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            // ['card', 'konbini'] このパラメータがないとdashboardで管理？
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('user.items.index'),
            'cancel_url' => route('user.cart.index'),
        ]);

        $publicKey = env('STRIPE_PUBLIC_KEY');

        return view('user.checkout',compact('session','publicKey'));

    }
}
