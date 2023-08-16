<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuctionLocation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "auction_location";
    protected $fillable = [
        'name', 'position', 'selected'
    ];
}
