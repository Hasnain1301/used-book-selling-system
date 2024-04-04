<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'address', 
        'flat_number',
        'city', 
        'zip', 
        'is_primary'
    ];
}
