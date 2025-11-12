<?php

namespace App\Traits;

use App\Models\DepositWallet;
use App\Models\DepositWalletLog;
use App\Models\Hoahong;
use App\Models\Point;
use App\Models\User;
use FontLib\TrueType\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToArray;

/**
 *
 */
trait WalletTrait
{

    private $data = [];

   public function addWalletDeposit($user, $product, $quantity)
    {
        if (!$user || !$product) {
            return 0;
        }

        // Cộng quà cho user
        $user->update([
            'gift' => $user->gift + 1,
        ]);

        // Chỉ áp dụng cho sản phẩm khởi nghiệp
        if ($product->sp_khoi_nghiep == 1) {
            $settingMonth = getConfigWallet(); // Số tháng được cấu hình
            $typeWallet = config('wallet.typeWallet');
            $totalAmount = $product->price * $quantity;

            DB::transaction(function () use ($user, $product, $settingMonth, $typeWallet, $totalAmount) {
                $now = now();
                $firstDayNextMonth = $now->copy()->addMonth()->startOfMonth();

                // Tính số ngày từ hôm nay đến mùng 1 tháng sau
                $daysToNextMonth = $now->diffInDays($firstDayNextMonth);

                // Nếu còn >=15 ngày đến mùng 1 tháng sau => bắt đầu từ tháng sau
                // Nếu ít hơn 15 ngày => bắt đầu từ tháng kế tiếp nữa
                if ($daysToNextMonth >= 15) {
                    $startDate = $firstDayNextMonth;
                } else {
                    $startDate = $firstDayNextMonth->copy()->addMonth();
                }

                $endDate = $startDate->copy()->addMonths($settingMonth);

                // Tạo ví nạp
                $wallet = DepositWallet::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'total_amount' => $totalAmount,
                    'type' => $typeWallet[1]['type'],
                    'remaining_amount' => $totalAmount,
                    'monthly_release' => $totalAmount / $settingMonth,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active',
                ]);

                // Ghi log lịch sử ví
                DepositWalletLog::create([
                    'wallet_id' => $wallet->id,
                    'user_id' => $user->id,
                    'type' => $typeWallet[1]['name'],
                    'amount' => $wallet->total_amount,
                    'released_at' => now(),
                    'status' => 'success',
                ]);
            });
        }

        return true;
    }




}
