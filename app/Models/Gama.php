<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gama extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'percentage',
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
}
