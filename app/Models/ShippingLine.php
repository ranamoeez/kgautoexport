<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingLine extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "shipping_line";
    protected $fillable = [
        'name', 'scac_code', 'position'
    ];
}
