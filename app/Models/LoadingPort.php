<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoadingPort extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "loading_port";
    protected $fillable = [
        'name', 'position', 'selected'
    ];
}
