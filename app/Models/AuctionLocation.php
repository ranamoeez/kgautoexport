<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionLocation extends Model
{
    use HasFactory;

    protected $table = "auction_location";
    protected $fillable = [
        'name', 'position', 'selected'
    ];
}
