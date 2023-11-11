<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'images',
        'price',
        'brand_id',
        'category_id',
        'description',
        'warranty',
        'details',
        'quantity',
        'visacuotas',
        'featured',
        'condition',
        'shipping',
        'sale',
        'percentage',
        'sale_price',
        'normal_price',
        'sale_normal_price',
        'show_price',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'visacuotas' => 'boolean',
        'featured' => 'boolean',
        'shipping' => 'boolean',
        'sale' => 'boolean',
        'details' => 'array',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
