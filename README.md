## udemy Laravel講座


## ダウンロード方法

git clone

git clone https://github.com/genzopic/laravel_umarche_mac.git

git clone ブランチを指定してダウンロードする場合

git clone -b ブランチ名 https://github.com/genzopic/laravel_umarche_mac.git

もしくはzipファイルでダウンロードしてください

## インストール方法

cd laravel_umarche_mac

composer install

npm install

num run dev

.env.example をコピーして、.envファイルを作成

データベースを作成し、.envファイルの中のDB関連をご利用の環境に合わせて変更してください

データベーステーブルとダミーデータの作成
php artisan migrate:fresh --seed

php artisan key:generate

php artisan serve

## インストール後の実施事項

画像のダミーデータは、public/imagesフォルダ内に
sample1.jpg〜sample6.jpgとして保存しています。

php artisan storage:link でstorageフォルダにリンク後、

storage/app/public/productsフォルダ内に保存すると表示されます。
（productsフォルダがない場合は作成してください。）

ショップの画像も表示する場合は、
storage/app/public/shopsフォルダを作成し画像を保存してください。
