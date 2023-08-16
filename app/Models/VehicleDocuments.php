<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleDocuments extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "vehicle_documents";
    protected $fillable = [
        'vehicle_id', 'filename', 'filepath'
    ];
}
