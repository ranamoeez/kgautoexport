<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyTransfer extends Model
{
    use HasFactory;

    protected $table = "money_transfer";
    protected $fillable = [
        'vehicle_id', 'user_id', 'amount', 'exchange_company', 'transfer_no', 'comment', 'latest'
    ];

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle(){
    	return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
