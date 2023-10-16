<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingCompany extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "shipping_company";
    protected $fillable = [
        'name', 'address', 'phone_number'
    ];
}
