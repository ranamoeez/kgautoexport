<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = "posts";
    protected $fillable = [
        'user_id', 'vehicle_id', 'amount'
    ];

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle(){
    	return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
