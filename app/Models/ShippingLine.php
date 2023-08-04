<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingLine extends Model
{
    use HasFactory;

    protected $table = "shipping_line";
    protected $fillable = [
        'name', 'scac_code', 'position'
    ];
}
