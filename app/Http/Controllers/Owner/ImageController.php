<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use App\Models\Image;                       // Imageモデル
use Illuminate\Support\Facades\Auth;        // ログインユーザー
use App\Http\Requests\UploadImageRequest;   // リクエストバリデーション

class ImageController extends Controller
{
    // コンストラクタ
    public function __construct()
    {
        // 認証チェック
        $this->middleware('auth:owners');
        // 
        $this->middleware(function(Request $request,$next) {

            $id = $request->route()->parameter('image'); // imageのidを取得
            if(!is_null($id)){
                // owner/images/indexにアクセスするとnullになるので
                // それ以外の場合（owner/shops/edit/{shop}）
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
        dd($request);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
