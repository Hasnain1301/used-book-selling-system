<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $table = 'listings';

    protected $primaryKey = 'listingID';

    public $timestamps = false;

    protected $fillable = [
        'listingTitle',
        'listingAuthor',
        'listingPrice',
        'listingImage',
        'listingDescription',
        'listingCategory',
        'listingCondition',
        'listingStatus',
        'ISBN',
        'userID',
        'department',
        'year'
    ];
}
