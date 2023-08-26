<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransFineType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "trans_fine_type";
    protected $fillable = [
        'name', 'position', 'selected'
    ];
}
