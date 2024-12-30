<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\OrderItem;

class Products extends Model
{
    /**
    * @OA\Schema(
    *    schema="Product",
    *    type="object",
    *    title="Product",
    *    required={"name", "description", "price", "stock", "category_id", "image"},
    *    properties={
    *       @OA\Property(property="id", type="integer", example="1"),
    *       @OA\Property(property="name", type="string", example="Product 1"),
    *       @OA\Property(property="description", type="string", example="Description of product 1"),
    *       @OA\Property(property="price", type="number", format="float", example="10.5"),
    *       @OA\Property(property="stock", type="integer", example="10"),
    *       @OA\Property(property="category_id", type="integer", example="1"),
    *       @OA\Property(property="image", type="string", format="binary", description="Product image file"),
    *       @OA\Property(property="category", type="object", ref="#/components/schemas/Category"),
    *   }
    * )
    */
    use HasFactory;

    //Table Name
    protected $table = 'products';

    //Disable timestamps
    public $timestamps = false;

    //Fillable fields
    protected $fillable = [
        'name',
        'description', 
        'price', 
        'stock', 
        'category_id', 
        'image'
    ];

    //Relation with category (many to one)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    //Relation with orderItem (one to many)
    public function orderItem()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
