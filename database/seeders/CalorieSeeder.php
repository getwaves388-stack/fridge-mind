<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Calorie;

class CalorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 💡 定番の食材データを配列で用意（重複を防ぐため、存在しない場合のみ作成する設定にしています）
        $data = [
            ['key_name' => 'ぶたにく', 'calories' => 250],
            ['key_name' => '豚肉', 'calories' => 250],
            ['key_name' => 'pork', 'calories' => 250],

            ['key_name' => 'ぎゅうにく', 'calories' => 300],
            ['key_name' => '牛肉', 'calories' => 300],
            ['key_name' => 'beef', 'calories' => 300],

            ['key_name' => 'とりにく', 'calories' => 200],
            ['key_name' => '鶏肉', 'calories' => 200],
            ['key_name' => 'とり肉', 'calories' => 200],
            ['key_name' => 'chicken', 'calories' => 200],

            ['key_name' => 'たまねぎ', 'calories' => 40],
            ['key_name' => '玉ねぎ', 'calories' => 40],
            ['key_name' => '玉葱', 'calories' => 40],
            ['key_name' => 'onion', 'calories' => 40],

            ['key_name' => 'にんじん', 'calories' => 30],
            ['key_name' => '人参', 'calories' => 30],
            ['key_name' => 'carrot', 'calories' => 30],

            ['key_name' => 'じゃがいも', 'calories' => 80],
            ['key_name' => 'potato', 'calories' => 80],

            ['key_name' => 'たまご', 'calories' => 80],
            ['key_name' => '卵', 'calories' => 80],
            ['key_name' => 'egg', 'calories' => 80],

            ['key_name' => 'ちーず', 'calories' => 120],
            ['key_name' => 'cheese', 'calories' => 120],

            ['key_name' => 'ごはん', 'calories' => 250],
            ['key_name' => 'ご飯', 'calories' => 250],
            ['key_name' => 'rice', 'calories' => 250],

            ['key_name' => 'ぱん', 'calories' => 150],
            ['key_name' => 'bread', 'calories' => 150],
        ];

        foreach ($data as $item) {
            // 重複エラーを防ぎながら安全にデータを1行ずつ挿入
            Calorie::firstOrCreate(
                ['key_name' => $item['key_name']],
                ['calories' => $item['calories']]
            );
        }
    }
}
