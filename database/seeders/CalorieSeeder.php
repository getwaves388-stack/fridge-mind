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
        // 定番の食材データを配列で用意（重複を防ぐため、存在しない場合のみ作成）
        // 日本の家庭料理で「最もよく使われる食材・調味料」の上位100品目
        $data = [
            // --- 肉類・加工肉（1〜18） ---
            ['key_name' => 'ぶたにく', 'calories' => 250],
            ['key_name' => 'ブタニク', 'calories' => 250],
            ['key_name' => '豚肉', 'calories' => 250],
            ['key_name' => 'pork', 'calories' => 250],

            ['key_name' => 'ぎゅうにく', 'calories' => 300],
            ['key_name' => 'ギュウニク', 'calories' => 300],
            ['key_name' => '牛肉', 'calories' => 300],
            ['key_name' => 'beef', 'calories' => 300],

            ['key_name' => 'とりにく', 'calories' => 200],
            ['key_name' => 'トリニク', 'calories' => 200],
            ['key_name' => '鶏肉', 'calories' => 200],
            ['key_name' => 'とり肉', 'calories' => 200],
            ['key_name' => 'chicken', 'calories' => 200],

            ['key_name' => 'ひきにく', 'calories' => 230],
            ['key_name' => 'ひき肉', 'calories' => 230],
            ['key_name' => 'ミンチ', 'calories' => 230],

            ['key_name' => 'はむ', 'calories' => 40],
            ['key_name' => 'ハム', 'calories' => 40],
            ['key_name' => 'ham', 'calories' => 40],

            ['key_name' => 'べーこん', 'calories' => 80],
            ['key_name' => 'ベーコン', 'calories' => 80],
            ['key_name' => 'bacon', 'calories' => 80],

            ['key_name' => 'ういんなー', 'calories' => 60],
            ['key_name' => 'ウインナー', 'calories' => 60],
            ['key_name' => 'ソーセージ', 'calories' => 60],
            ['key_name' => 'sausage', 'calories' => 60],

            // --- 魚介類（19〜33） ---
            ['key_name' => 'さけ', 'calories' => 130],
            ['key_name' => 'サケ', 'calories' => 130],
            ['key_name' => '鮭', 'calories' => 130],
            ['key_name' => 'salmon', 'calories' => 130],

            ['key_name' => 'さば', 'calories' => 200],
            ['key_name' => 'サバ', 'calories' => 200],
            ['key_name' => '鯖', 'calories' => 200],
            ['key_name' => 'mackerel', 'calories' => 200],

            ['key_name' => 'いわし', 'calories' => 150],
            ['key_name' => 'イワシ', 'calories' => 150],
            ['key_name' => '鰯', 'calories' => 150],

            ['key_name' => 'まぐろ', 'calories' => 120],
            ['key_name' => 'マグロ', 'calories' => 120],
            ['key_name' => '鮪', 'calories' => 120],
            ['key_name' => 'tuna', 'calories' => 120],

            ['key_name' => 'えび', 'calories' => 50],
            ['key_name' => 'エビ', 'calories' => 50],
            ['key_name' => '蝦', 'calories' => 50],
            ['key_name' => 'shrimp', 'calories' => 50],

            ['key_name' => 'いか', 'calories' => 80],
            ['key_name' => 'イカ', 'calories' => 80],
            ['key_name' => 'squid', 'calories' => 80],

            ['key_name' => 'ちくわ', 'calories' => 30],
            ['key_name' => '竹輪', 'calories' => 30],

            // --- 野菜類・根菜（34〜65） ---
            ['key_name' => 'たまねぎ', 'calories' => 40],
            ['key_name' => 'タマネギ', 'calories' => 40],
            ['key_name' => '玉ねぎ', 'calories' => 40],
            ['key_name' => '玉葱', 'calories' => 40],
            ['key_name' => 'onion', 'calories' => 40],

            ['key_name' => 'にんじん', 'calories' => 30],
            ['key_name' => 'ニンジン', 'calories' => 30],
            ['key_name' => '人参', 'calories' => 30],
            ['key_name' => 'carrot', 'calories' => 30],

            ['key_name' => 'じゃがいも', 'calories' => 80],
            ['key_name' => 'ジャガイモ', 'calories' => 80],
            ['key_name' => 'potato', 'calories' => 80],

            ['key_name' => 'きゃべつ', 'calories' => 25],
            ['key_name' => 'キャベツ', 'calories' => 25],
            ['key_name' => 'cabbage', 'calories' => 25],

            ['key_name' => 'はくさい', 'calories' => 15],
            ['key_name' => '白菜', 'calories' => 15],

            ['key_name' => 'ほうれんそう', 'calories' => 20],
            ['key_name' => 'ほうれん草', 'calories' => 20],
            ['key_name' => 'spinach', 'calories' => 20],

            ['key_name' => 'れたす', 'calories' => 12],
            ['key_name' => 'レタス', 'calories' => 12],
            ['key_name' => 'lettuce', 'calories' => 12],

            ['key_name' => 'とまと', 'calories' => 20],
            ['key_name' => 'トマト', 'calories' => 20],
            ['key_name' => 'tomato', 'calories' => 20],

            ['key_name' => 'きゅうり', 'calories' => 15],
            ['key_name' => 'キュウリ', 'calories' => 15],
            ['key_name' => 'cucumber', 'calories' => 15],

            ['key_name' => '大根', 'calories' => 18],
            ['key_name' => 'だいこん', 'calories' => 18],
            ['key_name' => 'daikon', 'calories' => 18],

            ['key_name' => 'なす', 'calories' => 20],
            ['key_name' => 'ナス', 'calories' => 20],
            ['key_name' => '茄子', 'calories' => 20],
            ['key_name' => 'eggplant', 'calories' => 20],

            ['key_name' => 'ぴーまん', 'calories' => 15],
            ['key_name' => 'ピーマン', 'calories' => 15],
            ['key_name' => 'pepper', 'calories' => 15],

            ['key_name' => 'ねぎ', 'calories' => 15],
            ['key_name' => 'ネギ', 'calories' => 15],
            ['key_name' => '葱', 'calories' => 15],

            ['key_name' => 'もやし', 'calories' => 14],
            ['key_name' => 'モヤシ', 'calories' => 14],

            ['key_name' => 'ぶろっこりー', 'calories' => 30],
            ['key_name' => 'ブロッコリー', 'calories' => 30],
            ['key_name' => 'broccoli', 'calories' => 30],

            ['key_name' => 'かぼちゃ', 'calories' => 50],
            ['key_name' => 'カボチャ', 'calories' => 50],
            ['key_name' => 'pumpkin', 'calories' => 50],

            ['key_name' => 'にんにく', 'calories' => 15],
            ['key_name' => 'ニンニク', 'calories' => 15],
            ['key_name' => 'garlic', 'calories' => 15],

            ['key_name' => 'しょうが', 'calories' => 5],
            ['key_name' => 'ショウガ', 'calories' => 5],
            ['key_name' => '生姜', 'calories' => 5],
            ['key_name' => 'ginger', 'calories' => 5],

            // --- きのこ・大豆・卵・乳製品（66〜82） ---
            ['key_name' => 'たまご', 'calories' => 80],
            ['key_name' => 'タマゴ', 'calories' => 80],
            ['key_name' => '卵', 'calories' => 80],
            ['key_name' => 'egg', 'calories' => 80],

            ['key_name' => 'ちーず', 'calories' => 120],
            ['key_name' => 'チーズ', 'calories' => 120],
            ['key_name' => 'cheese', 'calories' => 120],

            ['key_name' => 'とうふ', 'calories' => 70],
            ['key_name' => '豆腐', 'calories' => 70],
            ['key_name' => 'tofu', 'calories' => 70],

            ['key_name' => 'なっとう', 'calories' => 100],
            ['key_name' => '納豆', 'calories' => 100],

            ['key_name' => '油揚げ', 'calories' => 80],
            ['key_name' => 'あぶらあげ', 'calories' => 80],

            ['key_name' => 'しいたけ', 'calories' => 15],

            ['key_name' => 'しめじ', 'calories' => 15],

            ['key_name' => 'えのき', 'calories' => 15],

            ['key_name' => 'ぎゅうにゅう', 'calories' => 130],
            ['key_name' => '牛乳', 'calories' => 130],
            ['key_name' => 'milk', 'calories' => 130],

            ['key_name' => 'よーぐると', 'calories' => 65],
            ['key_name' => 'ヨーグルト', 'calories' => 65],

            // --- 主食・粉類（83〜90） ---
            ['key_name' => 'ごはん', 'calories' => 250],
            ['key_name' => 'ゴハン', 'calories' => 250],
            ['key_name' => 'ご飯', 'calories' => 250],
            ['key_name' => '白米', 'calories' => 250],
            ['key_name' => 'rice', 'calories' => 250],

            ['key_name' => 'ぱん', 'calories' => 150],
            ['key_name' => 'パン', 'calories' => 150],
            ['key_name' => 'bread', 'calories' => 150],

            ['key_name' => 'うどん', 'calories' => 240],

            ['key_name' => 'パスタ', 'calories' => 350],
            ['key_name' => 'スパゲッティ', 'calories' => 350],

            ['key_name' => 'そうめん', 'calories' => 300],

            ['key_name' => '小麦粉', 'calories' => 100],
            ['key_name' => 'こむぎこ', 'calories' => 100],

            ['key_name' => '片栗粉', 'calories' => 50],

            // --- 調味料・油・その他（91〜100） ---
            ['key_name' => 'さらだあぶら', 'calories' => 110],
            ['key_name' => 'サラダ油', 'calories' => 110],
            ['key_name' => 'ごまあぶら', 'calories' => 110],
            ['key_name' => 'ごま油', 'calories' => 110],
            
            ['key_name' => 'ばたー', 'calories' => 70],
            ['key_name' => 'バター', 'calories' => 70],
            ['key_name' => 'butter', 'calories' => 70],

            ['key_name' => 'まよねーず', 'calories' => 80],
            ['key_name' => 'マヨネーズ', 'calories' => 80],
            ['key_name' => 'mayonnaise', 'calories' => 80],

            ['key_name' => 'けちゃっぷ', 'calories' => 20],
            ['key_name' => 'ケチャップ', 'calories' => 20],
            ['key_name' => 'ketchup', 'calories' => 20],

            ['key_name' => 'みそ', 'calories' => 30],
            ['key_name' => '味噌', 'calories' => 30],
            ['key_name' => 'miso', 'calories' => 30],

            ['key_name' => 'カレールー', 'calories' => 100],

            ['key_name' => 'しょうゆ', 'calories' => 15],
            ['key_name' => '醤油', 'calories' => 15],

            ['key_name' => 'めんつゆ', 'calories' => 40],

            ['key_name' => '砂糖', 'calories' => 35],

            ['key_name' => 'さとう', 'calories' => 35],
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
