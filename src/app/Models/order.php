<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{
    /**
     * @OA\Schema(
     *  schema="Order",
     *  title="Order",
     *  required={"id", "user_id", "total_amount", "status", "created_at", "updated_at"},
     *  @OA\Property(
     *     property="id",
     *     type="integer",
     *     format="int64",
     *     description="The order ID"
     * ),
     * @OA\Property(
     *    property="user_id",
     *    type="integer",
     *    format="int64",
     *    description="The user ID"
     * ),
     * @OA\Property(
     *   property="total_amount",
     *   type="number",
     *   format="float",
     *   description="The total amount of the order"
     * ),
     * @OA\Property(
     *  property="status",
     *  type="string",
     *  description="The status of the order"
     *  ),
     *  @OA\Property(
     *  property="created_at",
     *  type="string",
     *  format="date-time",
     *  description="The date and time the order was created"
     *  ),
     *  @OA\Property(
     *  property="updated_at",
     *  type="string",
     *  format="date-time",
     *  description="The date and time the order was updated"
     *  )
     * )
     */
    use HasFactory;

    //Table name
    protected $table = 'order';

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
    ];

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
