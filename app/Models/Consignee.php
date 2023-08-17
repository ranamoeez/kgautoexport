<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Shipper;

class Consignee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "consignee";
    protected $fillable = [
        'company_name', 'address', 'phone_number', 'fax', 'email', 'contact_person', 'position', 'shipper_id'
    ];

    public function shipper(){
    	return $this->belongsTo(Shipper::class, 'shipper_id');
    }
}
