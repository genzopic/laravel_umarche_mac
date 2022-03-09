<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;        // ログインユーザー
use App\Models\User;
use App\Models\Stock;
use App\Services\CartService;

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
        /////
        // カートの商品を取得
        $items = Cart::where('user_id',Auth::id())->get();
        // 
        $products = CartService::getItemInCart($items);
        /////

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
        }
        // 秘密鍵のセット
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // stripeのcheckoutセッションの作成
        $session = \Stripe\Checkout\Session::create([
            // 支払い方法は、下記のパラメータで指定できるが、指定しないとdashboardで管理
            //'payment_method_types' => ['card'],
            // 販売する商品の定義
            'line_items' => [$lineItems],
            // modeには、payment、subscription、setup の 3 つのモードがあります。
            // 1 回限りの購入には payment モードを使用します。
            'mode' => 'payment',
            // 成功時に戻るページ
            'success_url' => route('user.cart.success'),
            // キャンセル時に戻るページ
            'cancel_url' => route('user.cart.cancel'),
        ]);

        // // 公開鍵のセット
        // $publicKey = env('STRIPE_PUBLIC_KEY');
        // return view('user.checkout',compact('session','publicKey'));
        //
        // --上記の内容は不要になって、直接リダイレクトできるようになったので、下記に修正
        //
        // Stripeの決済画面に直接リダイレクト
        return redirect($session->url,303);

    }
    // 決済成功
    public function success() 
    {
        // カートの商品をクリア
        Cart::where('user_id',Auth::id())->delete();

        // 商品一覧へリダイレクト
        return redirect()->route('user.items.index');
        
    }
    // 決済キャンセル
    public function cancel()
    {
        // 在庫を戻す
        $user = User::findOrFail(Auth::id());
        foreach ($user->products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['add'],           // 1:入庫
                'quantity' => $product->pivot->quantity,
            ]);
        }

        // 商品一覧へリダイレクト
        return redirect()->route('user.cart.index');
    }
}
