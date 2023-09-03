<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperatorLevel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "operator_levels";
    protected $fillable = [
        'name', 'access'
    ];
}
