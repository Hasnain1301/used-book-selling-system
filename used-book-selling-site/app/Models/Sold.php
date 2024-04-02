<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Listing;

class Sold extends Model
{
    use HasFactory;

    protected $table = 'sold';

    protected $fillable = [
        'orderID',
        'buyer_id',
        'seller_id',
        'listing_id',
        'listing_title',
        'listing_author',
        'listing_description',
        'isbn',
        'listing_condition',
        'listing_price',
        'listing_image',
        'orderID'
    ];

    public function buyer() {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller() {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function listing() {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'orderID');
    }
}
