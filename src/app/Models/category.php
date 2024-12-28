<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    //Table Name
    protected $table = 'category';

    //Disable timestamps
    public $timestamps = false;

    //Relation with products (one to many)
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
