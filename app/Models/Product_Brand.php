<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Brand extends Model
{
    use HasFactory;
    protected $fillable=[
        'brand_name',
         'brand_image',
         'slug',
         'status',
     ];
     public function user(){
        return $this->belongsTo(Admin::class,'user_id','id');
    }
}
