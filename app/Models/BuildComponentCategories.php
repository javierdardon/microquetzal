<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildComponentCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpu',
        'cooler',
        'ram',
        'gpu',
        'psu',
        'mobo',
        'case',
        'rom',
    ];

    protected $hidden = ['created_at', 'updated_at'];

}
