<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subtotal_eur',
        'shipping_cost',
        'shipping_method_name',
        'total_eur',
        'status',
        'payment_method',
        'shipping_address',
        'items',
        'tracking_number',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'items' => 'array',
        'status' => \App\Enums\OrderStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
