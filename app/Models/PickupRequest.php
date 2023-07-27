<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    use HasFactory;

    protected $table = "pickup_requests";
    protected $fillable = [
        'user_id', 'vehicle_id', 'comments', 'file'
    ];
}
