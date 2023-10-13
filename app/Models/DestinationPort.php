<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DischargePort;

class DestinationPort extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "destination_port";
    protected $fillable = [
        'name', 'position', 'unloading_fee', 'discharge_port'
    ];

    public function discharge(){
    	return $this->belongsTo(DischargePort::class, 'discharge_port');
    }
}
