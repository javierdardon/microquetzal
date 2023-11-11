<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationFinalFrame extends Model
{
    use HasFactory;

    protected $fillable = [
        'message1',
        'message2',
        'image',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
