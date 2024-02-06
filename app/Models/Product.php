<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $primaryKey='product_id';
    public $incrementing = false;


    //membuat generate id product
    public static function generateCustomeId() {
        $latestProduct=self::select('product_id')
        ->whereNotNull('product_id')
        ->orderBy('product_id','desc')
        ->first();

        //membuat generate number id product
        $lastNumber = $latestProduct? (int)substr($latestProduct->product_id,-5):0;
        $newNumber = $lastNumber + 1;

        //membuat format id
        $formatNumber = str_pad($newNumber,5,'0',STR_PAD_LEFT);

        //generate id product
        $id_product = 'PRD-' . date('Y').'-' . $formatNumber;

        return $id_product;
    }

    //membuat relasi dengan table order item
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
