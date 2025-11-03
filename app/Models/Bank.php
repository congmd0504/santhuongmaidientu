<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //  use SoftDeletes;
    protected $table="banks";

    protected $guarded = [];
     //  protected $appends = ['breadcrumb'];


     public function users(){
        return $this->hasMany(User::class,'bank_id','id');
     }
     public function admin(){
         return $this->belongsTo(Admin::class,'admin_id','id');
     }
}
