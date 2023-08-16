<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "cont_status";
    protected $fillable = [
        'name', 'position'
    ];
}
