<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DischargePort extends Model
{
    use HasFactory;

    protected $table = "discharge_port";
    protected $fillable = [
        'name', 'position'
    ];
}
