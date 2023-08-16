<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "vehicle_images";
    protected $fillable = [
        'vehicle_id', 'ctime', 'filesize', 'owner_id', 'title', 'filename', 'filepath', 'type'
    ];
}
