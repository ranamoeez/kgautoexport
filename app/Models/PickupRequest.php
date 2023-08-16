<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickupRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pickup_requests";
    protected $fillable = [
        'user_id', 'vehicle_id', 'comments', 'file', 'status'
    ];

    public function vehicle(){
    	return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
