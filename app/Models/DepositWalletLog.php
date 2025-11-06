<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositWalletLog extends Model
{
    //
    protected $table="deposit_wallet_logs";
    protected $guarded = [];
    public function wallet()
    {
        return $this->belongsTo(DepositWallet::class, 'wallet_id');
    }
}
