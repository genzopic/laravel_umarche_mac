<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // プライマリーカテゴリー
        DB::table('primary_categories')->insert([ 
            [
                'name' => '家電',
                'sort_order' => 1,
            ],
            [
                'name' => 'TV・オーディオ・カメラ',
                'sort_order' => 2,
            ],
            [
                'name' => 'タブレットPC・スマートフォン',
                'sort_order' => 3,
            ],
        ]);
        // セカンダリーカテゴリー
        DB::table('secondary_categories')->insert([ 
            [
                'name' => '生活家電',
                'sort_order' => 1,
                'primary_category_id' => 1,
            ],
            [
                'name' => '住宅設備家電',
                'sort_order' => 2,
                'primary_category_id' => 1,
            ],
            [
                'name' => 'キッチン家電',
                'sort_order' => 3,
                'primary_category_id' => 1,
            ],
            //
            [
                'name' => 'オーディオ',
                'sort_order' => 1,
                'primary_category_id' => 2,
            ],
            [
                'name' => 'テレビ',
                'sort_order' => 2,
                'primary_category_id' => 2,
            ],
            [
                'name' => '光ディスクレコーダー・プレーヤー',
                'sort_order' => 3,
                'primary_category_id' => 2,
            ],
            //
            [
                'name' => 'スマートフォン本体',
                'sort_order' => 1,
                'primary_category_id' => 3,
            ],
            [
                'name' => '携帯電話本体',
                'sort_order' => 2,
                'primary_category_id' => 3,
            ],
            [
                'name' => 'スマートフォン・携帯電話アクセサリー',
                'sort_order' => 3,
                'primary_category_id' => 3,
            ],
            [
                'name' => 'スマートフォン・タブレット用ケーブル・変換アダプター',
                'sort_order' => 4,
                'primary_category_id' => 3,
            ],
        ]);
    }
}
