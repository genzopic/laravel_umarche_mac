<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public static function getItemInCart($items)
    {
        $products = [];
        foreach($items as $item)
        {
            //-------------------------------
            // オーナー情報の名前とメールを取得
            //-------------------------------
            // １つの商品を取得
            $p = Product::findOrFail($item->product_id);
            // オーナー情報（商品情報から店情報でオーナー情報の名前とメールを取得する) 
            $owner = $p->shop->owner->select('name', 'email')->first()->toArray();
            // 連想配列の値を取得
            $values = array_values($owner); 
            $keys = ['ownerName', 'email'];
            // オーナー情報のキーを変更 
            $ownerInfo = array_combine($keys, $values); 

            //-------------------------------
            // 商品情報の商品IDと名前と金額。購入数を取得
            //-------------------------------
            // 商品情報の配列 
            $product = Product::where('id', $item->product_id)
                        ->select('id', 'name', 'price')->get()->toArray(); 
            // 在庫数の配列
            $quantity = Cart::where('product_id', $item->product_id)
                        ->select('quantity')->get()->toArray(); 
            // 配列の結合 
            $result = array_merge($product[0], $ownerInfo, $quantity[0]); 
            // 配列に追加
            array_push($products, $result); 
        }
        dd($products);
        return $products;
    }

}