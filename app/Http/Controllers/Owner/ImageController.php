<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use App\Models\Image;                       // Imageモデル
use App\Models\Product;                     // Productモデル
use Illuminate\Support\Facades\Auth;        // ログインユーザー
use App\Http\Requests\UploadImageRequest;   // リクエストバリデーション
use App\Services\ImageService;              // 画像保存
use Illuminate\Support\Facades\Storage;     // 画像

class ImageController extends Controller
{
    // コンストラクタ
    public function __construct()
    {
        // 認証チェック
        $this->middleware('auth:owners');
        // ログインオーナーのものかをチェック
        $this->middleware(function(Request $request,$next) {

            $id = $request->route()->parameter('image'); // imageのidを取得
            if(!is_null($id)){
                // owner/images/indexにアクセスするとnullになるので
                // それ以外の場合（owner/images/edit/{image}）
                $imagesOwnerId = Image::findOrFail($id)->owner->id;
                if($imagesOwnerId !== Auth::id()) {
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
        $owner_id = Auth::id();
        $images = Image::where('owner_id',$owner_id)
            ->orderBy('updated_at','desc')
            ->paginate(20);

        return view('owner.images.index',compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        //
        // dd($request->file('files'));
        $imageFiles = $request->file('files');
        if (!is_null($imageFiles)) {
            foreach ($imageFiles as $imageFile) {
                $fileNameToStore = ImageService::upload($imageFile,'products');
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore
                ]);
            }
        }
        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像登録を実施しました。',
                'status' => 'info']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $image = Image::findOrFail($id);
        return view('owner.images.edit',compact('image'));
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
        //
        // バリデーション
        $request->validate([
            'title' => 'string|max:50',
        ]);
        
        // 更新処理
        $image = Image::findorFail($id);
        $image->title = $request->title;
        $image->save();

        // 一覧画面に戻る
        return redirect()
        ->route('owner.images.index')
        ->with(['message' =>'画像情報を更新しました',
                'status' => 'info',
                ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 画像ファイルパスを取得
        $image = Image::findOrFail($id);
        $filePath = 'public/products/' . $image->filename;

        // 商品で画像を使用しているかチェックし、使用していたら、nullをセット
        $imageInProducts = Product::where('image1',$image->id)
                        ->orWhere('image2',$image->id)
                        ->orWhere('image3',$image->id)
                        ->orWhere('image4',$image->id)
                        ->get();        
        if($imageInProducts) {
            $imageInProducts->each(function($product) use($image) {
                if($product->image1 === $image->id){
                    $product->image1 = null;
                    $product->save();
                }
                if($product->image2 === $image->id){
                    $product->image2 = null;
                    $product->save();
                }
                if($product->image3 === $image->id){
                    $product->image3 = null;
                    $product->save();
                }
                if($product->image4 === $image->id){
                    $product->image4 = null;
                    $product->save();
                }
            });
        }
        
        // 削除
        Image::findOrFail($id)->delete();

        // ファイル削除
        if(Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        // 一覧画面に戻る
        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像を削除しました',
                'status' => 'alert',
                ]);
    }
}
