<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\HealthRecord;
use Carbon\Carbon;

#[Signature('app:record-health-command')]
#[Description('Command description')]
class RecordHealthCommand extends Command
{
    // ターミナルでのコマンドの入力形式を定義 (引数としてユーザーID、体重、最高血圧、最低血圧を受け取る)
    protected $signature = 'health:record {user_id : 対象ユーザーのID} {weight : 体重(kg)} {systolic : 最高血圧(mmHg)} {diastolic : 最低血圧(mmHg)}';

    // コマンドの説明（php artisan list を叩いた時に表示される説明文）
    protected $description = 'ユーザーの毎日の健康データ(体重・血圧)をCUI(ターミナル)から直接記録します';

    public function handle()
    {
        // 1. コマンド引数からデータを取得
        $userId = $this->argument('user_id');
        $weight = $this->argument('weight');
        $systolic = $this->argument('systolic');
        $diastolic = $this->argument('diastolic');

        // 2. ユーザーが存在するかバックエンドの安全チェック
        $user = User::find($userId);
        if (!$user) {
            $this->error("error: ユーザーID {$userId} はシステム内に存在しません。");
            return Command::FAILURE;
        }

        // 3. 本日の日付を取得
        $today = Carbon::today()->toDateString();

        // 4. 【プロのクエリ】updateOrCreate を使い、すでに今日データがあれば上書き、無ければ新規作成
        HealthRecord::updateOrCreate(
            [
                'user_id' => $userId,
                'recorded_at' => $today,
            ],
            [
                'weight' => $weight,
                'systolic_bp' => $systolic,
                'diastolic_bp' => $diastolic,
            ]
        );

        // 5. ターミナルへ成功メッセージを出力
        $this->info("--------------------------------------------------");
        $this->info("ユーザー [{$user->name}] の本日の健康データを記録しました！");
        $this->info("記録日: {$today}");
        $this->info("体重  : {$weight} kg");
        $this->info("血圧  : {$systolic} / {$diastolic} mmHg");
        $this->info("--------------------------------------------------");

        return Command::SUCCESS;
    }
}
