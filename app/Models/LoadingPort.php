<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadingPort extends Model
{
    use HasFactory;

    protected $table = "loading_port";
    protected $fillable = [
        'name', 'position', 'selected'
    ];
}
