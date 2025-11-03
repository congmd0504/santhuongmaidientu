<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pointtt extends Model
{
    //
    protected $table = "pointtts";
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
