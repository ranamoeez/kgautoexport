<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auction;

class AuctionLocation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "auction_location";
    protected $fillable = [
        'name', 'position', 'auction_id'
    ];

    public function auction(){
    	return $this->belongsTo(Auction::class, 'auction_id');
    }
}
