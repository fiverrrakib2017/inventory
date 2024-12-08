<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Category extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(Admin::class,'user_id','id');
    }
}
