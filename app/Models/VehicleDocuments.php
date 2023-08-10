<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDocuments extends Model
{
    use HasFactory;

    protected $table = "vehicle_documents";
    protected $fillable = [
        'vehicle_id', 'filename', 'filepath'
    ];
}
