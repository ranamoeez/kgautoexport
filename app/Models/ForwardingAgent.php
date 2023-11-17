<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForwardingAgent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "forwarding_agent";
    protected $fillable = [
        'company_name', 'address', 'phone_number', 'fax', 'email', 'contact_person', 'position', 'aes_number_xtn'
    ];
}
