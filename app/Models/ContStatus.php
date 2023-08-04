<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContStatus extends Model
{
    use HasFactory;

    protected $table = "cont_status";
    protected $fillable = [
        'name', 'position'
    ];
}
