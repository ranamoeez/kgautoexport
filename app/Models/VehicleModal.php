<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\VehicleBrand;

class VehicleModal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "vehicle_modals";
    protected $fillable = [
        'name', 'vehicle_brand_id'
    ];

    public function vehicles_brand(){
    	return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
    }
}
