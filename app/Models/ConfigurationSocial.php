<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationSocial extends Model
{
    use HasFactory;

    protected $fillable = [
        'facebook',
        'whatsapp',
        'gmail',
        'twitter',
        'instagram',
        'tikTok',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
