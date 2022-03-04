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
     * @return string $fileNameToStore 保存したファイル名
     */
    public static function upload($imageFile, $folderName){
        
        // ファイル名を作成
        if(is_array($imageFile)){
            $file = $imageFile['image'];
        } else {
            $file = $imageFile;
        }
        $fileName = uniqid(rand().'_');                     // ユニークなファイル名を作成
        $extension = $file->extension();               // 拡張子を退避
        $fileNameToStore = $fileName . '.' . $extension;
        // リサイズ
        $resizedImage = InterventionImage::make($file)->resize(1920, 1080)->encode();
        Storage::put('public/' . $folderName . '/' . $fileNameToStore,$resizedImage);

        return $fileNameToStore;
    }

}