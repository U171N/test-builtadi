<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $primaryKey ='order_id';
    protected $guarded=[];

    //membuat relasi dengan table order
    public function order() {
        return $this->belongsTo(Order::class);
    }
}
