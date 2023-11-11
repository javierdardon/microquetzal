<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationHero extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'message1',
        'message2',
        'message3',
        'message4',
        'image',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
