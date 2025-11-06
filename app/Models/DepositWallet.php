<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositWallet extends Model
{
    //
    protected $table="deposit_wallets";
    protected $guarded = [];
    public function logs()
    {
        return $this->hasMany(DepositWalletLog::class, 'wallet_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
