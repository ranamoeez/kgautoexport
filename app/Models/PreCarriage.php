<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreCarriage extends Model
{
    use HasFactory;

    protected $table = "pre_carriage";
    protected $fillable = [
        'name', 'position', 'selected'
    ];
}
