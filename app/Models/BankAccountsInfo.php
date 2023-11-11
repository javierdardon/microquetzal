<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccountsInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank_name',
        'account_name',
        'account_number',
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
}
