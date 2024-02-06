<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $primaryKey='order_id';
    public $incrementing = false;

    //membuat generate id order
    public static function generateCustomeId(){
        $latestOrder = self::select('order_id')
        ->whereNotNull('order_id')
        ->orderBy('order_id', 'desc')
        ->first();

        //membuat generate id order
        $lastNumber = $latestOrder? (int)substr($latestOrder->order_id,-5):0;
        $newNumber = $lastNumber + 1;

        //membuat format id order
        $formattedOrder = str_pad($newNumber,5,'0',STR_PAD_LEFT);

        //generate number id order
        $id_order = 'ORD-'.date('Y').'-'.$formattedOrder;
        return $id_order;
    }

    //relasi untuk menampilkan data penjualan dan pendapatan dari transaksi
    public function orderItems(){
        return $this->hasMany(OrderItem::class,'order_id','order_id');
    }

    //relasi dengan table user
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    //relasi dengan table orderpayment
    public function payments(){
        return $this->hasMany(OrderPayment::class,'order_id','order_id');
    }
}
