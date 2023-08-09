<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsHistory extends Model
{
    use HasFactory;

    protected $table = "transactions_history";
    protected $fillable = [
        'user_id', 'amount', 'vehicle_id', 'status'
    ];

    public function vehicle(){
    	return $this->belongsTo(Auction::class, 'vehicle_id');
    }
}
