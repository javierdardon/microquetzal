<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Build extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'images',
        'cpu_id',
        'cpu_name',
        'cpu_link',
        'cooler_id',
        'cooler_name',
        'cooler_link',
        'ram_id',
        'ram_name',
        'ram_link',
        'cooler_stock',
        'ram_units',
        'gpu_id',
        'gpu_name',
        'gpu_link',
        'psu_id',
        'psu_name',
        'psu_link',
        'mobo_id',
        'mobo_name',
        'mobo_link',
        'case_id',
        'case_name',
        'case_link',
        'rom_id',
        'rom_name',
        'rom_link',
        'rom_multiple_id',
        'rom_multiple',
        'price',
        'description',
        'gama_id',
        'warranty',
        'details',
        'quantity',
        'visacuotas',
        'shipping',
        'featured',
        'sale',
        'percentage',
        'sale_price',
        'show_price',
        'normal_price',
        'sale_normal_price',
    ];

    protected $casts = [
        'visacuotas' => 'boolean',
        'shipping' => 'boolean',
        'featured' => 'boolean',
        'sale' => 'boolean',
        'details' => 'array',
        'cooler_stock' => 'boolean',
        'rom_multiple_id' => 'array',
        'rom_multiple' => 'array',
     ];

    public function cpu(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cooler(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function ram(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function gpu(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function psu(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function mobo(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function case(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function rom(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function multipleRom(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['id']);
    }
    
    public function gama(): BelongsTo
    {
        return $this->belongsTo(Gama::class);
    }

    protected $hidden = ['created_at', 'updated_at'];
}
