<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Container;

class ContStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "cont_status";
    protected $fillable = [
        'name', 'position'
    ];

    public function containers(){
    	return $this->hasMany(Container::class, 'status_id');
    }
}
