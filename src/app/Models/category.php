<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Category extends Model
{
    /**
     * @OA\Schema(
     *   schema="Category",
     *   type="object",
     *   title="Category",
     *   required={"name"},
     *   properties={
     *      @OA\Property(property="id", type="integer", example="1"),
     *      @OA\Property(property="name", type="string", example="Category 1"),
     *  }
     * )
     */
    use HasFactory;

    //Table Name
    protected $table = 'category';

    protected $fillable = [
        'name',
        'description'
    ];

    //Disable timestamps
    public $timestamps = false;

    //Relation with products (one to many)
    public function products()
    {
        return $this->hasMany(Products::class, 'category_id');
    }
}
