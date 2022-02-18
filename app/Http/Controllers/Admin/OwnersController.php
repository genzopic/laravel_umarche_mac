<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//
use App\Models\Owner;                   // Eloquent エロクアント
use Illuminate\Support\Facades\DB;      // QueryBuilder クエリビルダー
//
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


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

        $owners = Owner::select('name','email','created_at')->get();

        return view('admin.owners.index',
        compact('owners'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        // 保存
        Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 一覧画面に戻る
        return redirect()
        ->route('admin.owners.index')
        ->with('message','オーナー登録を実施しました');

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