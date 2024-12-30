<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Order;

class User extends Authenticatable implements MustVerifyEmail
{
    /**
     * @OA\Schema(
     *  schema="User",
     *  title="User",
     *  required={"name", "email", "password"},
     *  @OA\Property(property="name", type="string", example="John Doe"),
     *  @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *  @OA\Property(property="password", type="string", format="password", example="password"),
     *  @OA\Property(property="email_verified_at", type="string", format="date-time", example="2021-01-01 00:00:00"),
     *  @OA\Property(property="created_at", type="string", format="date-time", example="2021-01-01 00:00:00"),
     *  @OA\Property(property="updated_at", type="string", format="date-time", example="2021-01-01 00:00:00"),
     * )
     */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Table name
    protected $table = 'users';

    //Relation with order (One to Many)
    public function order()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
