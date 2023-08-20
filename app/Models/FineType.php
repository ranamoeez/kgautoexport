<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FineType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "fine_types";
    protected $fillable = [
        'name', 'position', 'selected'
    ];
}
