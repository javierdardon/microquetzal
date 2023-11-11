<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'products',
        'total',
        'quantity',
        'invoice',
        'guide',
        'service',
        'payment_date',
        'payment',
        'shipping_date',
        'phone',
        'second_phone',
        'email',
        'nit',
        'department',
        'municipality',
        'address',
        'reference',
        'paymentMethod',
        'paymentType',
        'card',
        'dues',
        'duesQuantity',
        'shipping',
        'total_shipping',
    ];

    protected $casts = [
        'products' => 'array',
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
        'payment_date' => 'datetime:d-m-Y',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
