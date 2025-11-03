<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodeSale extends Model
{
    //
    protected $table = "code_sales";
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
