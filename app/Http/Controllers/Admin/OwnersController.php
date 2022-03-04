<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use App\Models\Owner;                   // Eloquent エロクアント
use App\Models\Shop;
use Illuminate\Support\Facades\DB;      // DB
use Carbon\Carbon;                      // 日付拡張ライブラリ
use Illuminate\Support\Facades\Hash;    // 
// ログ＆例外
use Throwable;
use Illuminate\Support\Facades\Log;

class OwnersController extends Controller
{
    // adminで認証しているかチェック
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // カーボンテスト
        // $date_now = Carbon::now();
        // $date_parse = Carbon::parse(now());
        // echo $date_now->year;
        // echo $date_parse;

        // エロクアント
        // $e_all = Owner::all();
        // クエリビルダー
        // $q_get = DB::table('owners')->select('name','created_at')->get();
        // $q_first = DB::table('owners')->select('name','created_at')->first();

        // コレクション
        // $c_test = collect([
        //     'name' => 'てすと'
        // ]);

        // var_dump($q_first);
        //
        // dd($e_all,$q_get,$q_first,$c_test);

        // 一覧画面
        // $owners = Owner::select('id','name','email','created_at')->get();
        // ページネーション対応
        $owners = Owner::select('id','name','email','created_at')->paginate(3);

        return view('admin.owners.index',compact('owners'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 作成画面
        return view('admin.owners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:owners',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // 保存処理
        try {
            DB::transaction(function() use($request) {
                $owner = Owner::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                Shop::create([
                    'owner_id' =>  $owner->id,
                    'name' => '店名を入力してください',
                    'information' => '',
                    'filename' => '',
                    'is_selling' => true,
                ]);
            },2);
        } catch(Throwable $e) {
            Log::error($e);     // ログ出力
            throw $e;           // 画面に表示
        }

        // 一覧画面に戻る
        return redirect()
        ->route('admin.owners.index')
        ->with(['message' => 'オーナー登録を実施しました',
                'status' => 'info',
                ]);

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
        // 編集画面
        $owner = Owner::findorFail($id);
        // dd($owner);

        return view('admin.owners.edit',compact('owner'));

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
        // 更新処理
        $owner = Owner::findorFail($id);
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->save();

        // 一覧画面に戻る
        return redirect()
        ->route('admin.owners.index')
        ->with(['message' =>'オーナー情報を更新しました',
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
        // 削除
        Owner::findOrFail($id)->delete(); //ソフトデリート

        // 一覧画面に戻る
        return redirect()
        ->route('admin.owners.index')
        ->with(['message' => 'オーナー情報を削除しました',
                'status' => 'alert',
                ]);
    }

    //---------------------------------------------------------
    // 期限切れオーナー一覧
    public function expiredOwnerIndex(){
        // 削除日があるものだけ取得
        $expiredOwners = Owner::onlyTrashed()->get();
        // 一覧に戻る
        return view('admin.expired-owners',compact('expiredOwners'));
    }
    // 期限切れオーナー削除
    public function expiredOwnerDestroy($id){
        // 強制削除
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        // 一覧に戻る
        return redirect()->route('admin.expired-owners.index');
    }
    // 期限切れオーナー復元
    public function expiredOwnerRestore($id){
        // 復元
        Owner::onlyTrashed()->findOrFail($id)->restore();
        // 一覧に戻る
        return redirect()->route('admin.expired-owners.index');
    }

}
