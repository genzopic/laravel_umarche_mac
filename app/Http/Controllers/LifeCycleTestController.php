<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{
    // サービスプロバイダの例
    public function showServiceProviderTest()
    {
        // 暗号化のサービスプロバイダを呼び出して使う
        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');

        // サービスプロバイダの生成
        // php artisan make:provider SampleServiceProvider
        // App¥Providers配下に生成される
        // 作成されたファイルのregisterにサービスコンテナーに登録処理を記載し、app\config\app.phpのProvidersに追記する
        $sample = app()->make('serviceProviderTest');

        dd($sample,$password,$encrypt->decrypt($password));



    }
    // サービスコンテナの例
    public function showServiceContainerTest()
    {

        // サービスコンテナに登録する
        app()->bind('lifeCycleTest',function(){
            return 'ライフサイクルテスト';
        });
        // サービスコンテナを取り出す
        $test = app()->make('lifeCycleTest');


        // サービスコンテナなしのパターン
        // $message = new Message();
        // $sample = new Sample($message);
        // $sample->run();
        
        // サービスコンテナありのパターン(newでインスタンス化が不要。依存関係も解決してくれる)
        app()->bind('sample',Sample::class);
        $sample = app()->make('sample');
        $sample->run();

        dd($test,app());

    }
}

// Sampleクラスを使うには、Messageクラスをインスタンス化しておく必要がある。
// 依存関係
class Sample
{
    public $message;
    // クラスに引数を渡すと自動でインスタンス化してくれる
    public function __construct(Message $message)
    {
        $this->message = $message;
    }
    public function run()
    {
        $this->message->send();
    }
}

class Message
{
    public function send(){
        echo('メッセージ表示');
    }
}