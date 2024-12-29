<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;

class OrderItem extends Model
{
    use HasFactory;

    //Table Name
    protected $table = 'orderItem';

    //Relation with order (many to one)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    //Relation with product (many to one)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
