<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleBrand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "vehicle_brands";
    protected $fillable = [
        'name'
    ];
}
