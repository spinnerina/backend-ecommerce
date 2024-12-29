<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\OrderItem;

class Products extends Model
{
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
