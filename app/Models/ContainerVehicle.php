<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Container;
use App\Models\AssignVehicle;

class ContainerVehicle extends Model
{
    use HasFactory;

    protected $table = "container_vehicles";
    protected $fillable = [
        'container_id', 'user_id', 'vehicle_id'
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