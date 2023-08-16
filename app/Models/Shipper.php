<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipper extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "shipper";
    protected $fillable = [
        'company_name', 'address', 'phone_number', 'fax', 'email', 'contact_person', 'position', 'aes_number_xtn'
    ];
}
