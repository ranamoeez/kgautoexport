<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Container;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerVehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "container_vehicles";
    protected $fillable = [
        'container_id', 'user_id', 'vehicle_id', 'added_by'
    ];

    public function container(){
    	return $this->belongsTo(Container::class, 'container_id');
    }

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle(){
    	return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
