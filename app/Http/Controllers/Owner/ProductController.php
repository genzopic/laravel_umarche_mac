<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use Illuminate\Support\Facades\Auth;        // ログインユーザー
use Illuminate\Support\Facades\DB;          // DB
use App\Models\Product;
use App\Models\PrimaryCategory;
use App\Models\Owner;
use App\Models\Image;
use App\Models\Shop;
use App\Models\Stock;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    // コンストラクタ
    public function __construct()
    {
        // 認証チェック
        $this->middleware('auth:owners');
        // ログインオーナーのものかをチェック
        $this->middleware(function(Request $request,$next) {

            $id = $request->route()->parameter('product'); // productのidを取得
            if(!is_null($id)){
                // owner/products/indexにアクセスするとnullになるので
                // それ以外の場合（owner/products/edit/{product}）
                $productsOwnerId = Product::findOrFail($id)->shop->owner->id;
                if($productsOwnerId !== Auth::id()) {
                    // ログインしたオーナーと違う場合は、404
                    abort(404);     // 404画面表示
                }
            }

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 商品一覧を取得（n+1問題あり）
        // $products = Owner::findOrFail(Auth::id())->shop->product;
        // 商品一覧を取得（n+1問題対応あり）
        $ownerInfo = Owner::with('shop.product.imageFirst')
            ->where('id',Auth::id())
            ->get();
        // dd($ownerInfo);
        // foreach($ownerInfo as $owner){
        //     // dd($owner->shop->product);
        //     foreach($owner->shop->product as $product){
        //         dd($product->imageFirst->filename);
        //     }
        // }

        return view('owner.products.index',compact('ownerInfo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $shops = Shop::where('owner_id',Auth::id())
                ->select('id','name')
                ->get();

        $images = Image::where('owner_id',Auth::id())
                ->select('id','title','filename')
                ->orderBy('updated_at','desc')
                ->get();
        
        $categories = PrimaryCategory::with('secondary')
                ->get();
        
        return view('owner.products.create',
            compact('shops','images','categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // dd($request);
        // バリデーション
        // $request->validate([
        //     'name' => 'required|string|max:50',
        //     'information' => 'required|string|max:1000',
        //     'price' => 'required|integer',
        //     'sort_order' => 'nullable|integer',
        //     'quantity' => 'required|integer',
        //     'shop_id' => 'required|exists:shops,id',
        //     'category' => 'required|exists:secondary_categories,id',
        //     'image1' => 'nullable|exists:images,id',
        //     'image2' => 'nullable|exists:images,id',
        //     'image3' => 'nullable|exists:images,id',
        //     'image4' => 'nullable|exists:images,id',
        //     'is_selling' => 'required',
        // ]);

        // 保存処理
        try {
            DB::transaction(function() use($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'sort_order' => $request->sort_order,
                    'shop_id' => $request->shop_id,
                    'secondary_category_id' => $request->category,
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                    'is_selling' => $request->is_selling,
                ]);
                Stock::create([
                    'product_id' => $product->id,
                    'type' => 1,                        // 1:入庫
                    'quantity' => $request->quantity,
                ]);
            },2);
        } catch(Throwable $e) {
            Log::error($e);     // ログ出力
            throw $e;           // 画面に表示
        }

        // 一覧画面に戻る
        return redirect()
        ->route('owner.products.index')
        ->with(['message' => '商品登録を実施しました',
                'status' => 'info',
                ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 商品
        $product = Product::findOrFail($id);
        // 現在庫数
        $quantity = Stock::where('product_id',$product->id)->sum('quantity');
        // 店舗（自分の）
        $shops = Shop::where('owner_id',Auth::id())
                ->select('id','name')
                ->get();
        // 画像（自分の）
        $images = Image::where('owner_id',Auth::id())
                ->select('id','title','filename')
                ->orderBy('updated_at','desc')
                ->get();
        // カテゴリ
        $categories = PrimaryCategory::with('secondary')
                ->get();

        return view('owner.products.edit',
                compact('product','quantity','shops','images','categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        // 追加のバリデーション
        $request->validate([
            'current_quantity' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id',$product->id)
            ->sum('quantity');
        
        // 現在在庫数が変わっていないか確認
        if($request->current_quantity !== $quantity){
            // 変わっていたら戻す
            $id = $request->route()->parameter('product');
            return redirect()->route('owner.products.edit',['product'=>$id])
                ->with(['message' => '在庫数が変更されています。再度確認してください' ,
                        'status' => 'alert']);
        } else {
            // 変わってなかったら保存処理
            try {
                DB::transaction(function() use($request,$product) {
                    $product->name = $request->name;
                    $product->information = $request->information;
                    $product->price = $request->price;
                    $product->sort_order = $request->sort_order;
                    $product->shop_id = $request->shop_id;
                    $product->secondary_category_id = $request->category;
                    $product->image1 = $request->image1;
                    $product->image2 = $request->image2;
                    $product->image3 = $request->image3;
                    $product->image4 = $request->image4;
                    $product->is_selling = $request->is_selling;
                    $product->save();

                    if($request->type === "1"){
                        $newQuantity = $request->quantity;
                    }
                    if($request->type === "2"){
                        $newQuantity = $request->quantity * -1;
                    }
                    Stock::create([
                        'product_id' => $product->id,
                        'type' => $request->type,           // 1:入庫
                        'quantity' => $newQuantity,
                    ]);
                },2);
            } catch(Throwable $e) {
                Log::error($e);     // ログ出力
                throw $e;           // 画面に表示
            }
            // 一覧画面に戻る
            return redirect()
            ->route('owner.products.index')
            ->with(['message' => '商品情報を登録を実施しました',
                    'status' => 'info',
                    ]);
            
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
