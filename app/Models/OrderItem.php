<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded=[];

    //membuat relasi dengan table order
    public function order(){
        return $this->belongsTo(Order::class);
    }

    //membuat relasi dengan table product
    public function product(){
        return $this->belongsTo(Product::class,'product_id','product_id');
    }
}
