<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    //Table name
    protected $table = 'order';

    //Relation with user (Many to One)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Relation with orderItem (One to Many)
    public function orderItem()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
