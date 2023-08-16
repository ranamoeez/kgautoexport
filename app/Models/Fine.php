<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fine extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "fines";
    protected $fillable = [
        'vehicle_id', 'type', 'cause', 'amount'
    ];
}
