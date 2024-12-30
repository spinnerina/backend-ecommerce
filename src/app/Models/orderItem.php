<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Products;

class OrderItem extends Model
{
    /**
     * @OA\Schema(
     *  schema="OrderItem",
     *  title="OrderItem",
     *  required={"id", "order_id", "product_id", "quantity", "price"},
     *  @OA\Property(property="id", type="integer", example="1"),
     *  @OA\Property(property="order_id", type="integer", example="1"),
     *  @OA\Property(property="product_id", type="integer", example="1"),
     *  @OA\Property(property="quantity", type="integer", example="1"),
     *  @OA\Property(property="price", type="integer", example="100"),
     * )
     */
    use HasFactory;

    //Table Name
    protected $table = 'orderItem';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    //Disable timestamps
    public $timestamps = false;

    //Relation with order (many to one)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    //Relation with product (many to one)
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
