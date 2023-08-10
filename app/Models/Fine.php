<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    protected $table = "fines";
    protected $fillable = [
        'vehicle_id', 'type', 'cause', 'amount'
    ];
}
