<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DestinationPort extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "destination_port";
    protected $fillable = [
        'name', 'position', 'unloading_fee'
    ];
}
