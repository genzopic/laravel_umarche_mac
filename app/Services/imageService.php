<?php

namespace App\Services;

// 画像関連
use Illuminate\Support\Facades\Storage;     // 画像保存
use InterventionImage;                      // 画像リサイズ

class ImageService
{
    /**
     * 画像アップロード
     * @param mixed $imageFile  画像ファイル
     * @param mixed $folderName public配下のフォルダ名（publicは不要）
     * 
     * @return string   保存したファイル名
     */
    public static function upload($imageFile, $folderName){

        // ファイル名を作成
        $fileName = uniqid(rand().'_');                     // ユニークなファイル名を作成
        $extension = $imageFile->extension();               // 拡張子を退避
        $fileNameToStore = $fileName . '.' . $extension;
        // リサイズ
        $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
        Storage::put('public/' . $folderName . '/' . $fileNameToStore,$resizedImage);

        return $fileNameToStore;
    }

}