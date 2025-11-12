<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DepositWallet;
use App\Models\DepositWalletLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReleaseDepositWalletCommand extends Command
{
    protected $signature = 'wallet:release-monthly';
    protected $description = 'Giải ngân ví đặt cọc (mỗi tháng một lần vào mùng 1)';

    public function handle()
    {
        Log::info("=== Bắt đầu giải ngân ví đặt cọc (" . now() . ") ===");

        $wallets = DepositWallet::where('status', 'active')
            ->where('remaining_amount', '>', 0)
            ->whereDate('start_date', '<=', now()->startOfMonth()) // ✅ Thêm điều kiện này
            ->get();


        if ($wallets->isEmpty()) {
            Log::info("Không có ví nào cần giải ngân.");
            return 0;
        }

        DB::beginTransaction();

        try {
            foreach ($wallets as $wallet) {
                $releaseAmount = $wallet->monthly_release;

                if ($wallet->remaining_amount < $releaseAmount) {
                    $releaseAmount = $wallet->remaining_amount;
                }

                // Cập nhật ví
                $wallet->remaining_amount -= $releaseAmount;

                if ($wallet->remaining_amount <= 0) {
                    $wallet->remaining_amount = 0;
                    $wallet->status = 'completed';
                }

                $wallet->save();

                DepositWalletLog::create([
                    'wallet_id'   => $wallet->id,
                    'user_id'     => $wallet->user_id,
                    'amount'      => $releaseAmount,
                    'type'        => config("wallet.typeWallet")[2]['name'] ?? 'Ví Đặt Cọc',
                    'released_at' => now(),
                    'status'      => 'success',
                ]);

                $user = User::find($wallet->user_id);
                if ($user) {
                    $user->points()->create([
                        'type' => config("point.typePoint")[28]['type'] ?? 28,
                        'point' => $releaseAmount,
                        'active' => 1,
                        'userorigin_id' => $user->id,
                    ]);
                }

                Log::info("✅ Giải ngân {$releaseAmount}đ & cộng điểm cho user #{$wallet->user_id}, ví #{$wallet->id}");
            }

            DB::commit();
            Log::info("=== Giải ngân hoàn tất (" . now() . ") ===");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("❌ Lỗi khi giải ngân ví đặt cọc: " . $e->getMessage());
        }

        return 0;
    }
}
