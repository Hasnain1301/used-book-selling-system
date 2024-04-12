<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'userId',
        'total_price',
        'status',
        'session_id',
        'return_status',
        'return_reason',
        'seller_message',
    ];

    public function soldItems() {
        return $this->hasMany(Sold::class, 'orderID');
    }

    public function canBeCancelled() {
        return $this->status !== 'Delivered';
    }

    public function requestReturn($reason = null) {
        $this->return_status = 'Requested';
        $this->return_reason = $reason;
        $this->save();
    }
    
}
