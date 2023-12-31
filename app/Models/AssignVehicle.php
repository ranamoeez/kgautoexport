<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Container;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignVehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "assign_vehicle";
    protected $fillable = [
        'user_id', 'vehicle_id', 'assigned_to', 'payment_status', 'assigned_by', 'pickup'
    ];

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle(){
    	return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function container(){
    	return $this->belongsTo(Container::class, 'assigned_to');
    }
}
