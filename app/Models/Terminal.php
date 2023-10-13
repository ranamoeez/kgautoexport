<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Vehicle;

class Terminal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "terminal";
    protected $fillable = [
        'name', 'position', 'selected'
    ];

    public function vehicles(){
    	return $this->hasMany(Vehicle::class, 'terminal_id');
    }
}
