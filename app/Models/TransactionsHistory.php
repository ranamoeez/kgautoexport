<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionsHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "transactions_history";
    protected $fillable = [
        'user_id', 'amount', 'vehicle_id', 'type'
    ];

    public function vehicle(){
    	return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
