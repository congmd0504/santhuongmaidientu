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

    public function addWalletDeposit($user, $product,$quantity)
    {
        if (!$user || !$product) {
            return 0;
        }
        $user->update([
            'gift' => $user->gift + 1,
        ]);

        if ($product->sp_khoi_nghiep == 1) {
            $settingMonth = getConfigWallet();
            $typeWallet = config('wallet.typeWallet');
            $totalAmount = $product->price*$quantity;

            DB::transaction(function () use ($user, $product, $settingMonth, $typeWallet, $totalAmount) {
                $startDate = now()->startOfMonth()->addMonth();
                $endDate = $startDate->copy()->addMonths($settingMonth);

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

                DepositWalletLog::create([
                    'wallet_id' => $wallet->id,
                    'user_id' => $user->id,
                    'type' => $typeWallet[1]['name'],
                    'amount' => $wallet->total_amount,
                    'released_at' => now(),
                    'status' => 'success',
                ]);
            });

            // $user->points()->create([
            //     'type' => $typePoint[30]['type'] ?? 30, 
            //     'point' => $totalAmount,
            //     'active' => 1,
            //     'userorigin_id' => $user->id,
            // ]);
        }

        return true;
    }



}
