<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use Illuminate\Support\Facades\Auth;        // ログインユーザー
use App\Models\Shop;                        // shopモデル
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;          // QueryBuilder クエリビルダー
//
use Illuminate\Support\Facades\Storage;     // 画像アップロード＝Storage::putFileで保存

class ShopController extends Controller
{
    // コンストラクタ
    public function __construct()
    {
        // 認証チェック
        $this->middleware('auth:owners');
        // 
        $this->middleware(function(Request $request,$next) {
            // dd($request->route()->parameter('shop'));   // 文字列
            // dd(Auth::id()); // 数字

            $id = $request->route()->parameter('shop'); // shopのidを取得
            if(!is_null($id)){
                // owner/shops/indexにアクセスするとnullになるので
                // それ以外の場合（owner/shops/edit/{shop}）
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                $ownerId = Auth::id();
                if($shopsOwnerId !== $ownerId) {
                    // ログインしたオーナーと違う場合は、404
                    abort(404);     // 404画面表示
                }
            }

            return $next($request);
        });

    }
    // 一覧
    public function index()
    {
        $owner_id = Auth::id();
        $shops = Shop::where('owner_id',$owner_id)->get();

        return view('owner.shops.index',compact('shops'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        return view('owner.shops.edit',compact('shop'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // inputのnameでimageとしたので、
        $imageFile = $request->image;
        // 選択されていて、かつ妥当なものかの判定
        if(!is_null($imageFile) && $imageFile->isValid()){
            Storage::putFile('public/shops',$imageFile);
        }
        // 戻る
        return redirect()->route('owner.shops.index');
    }
 

}
