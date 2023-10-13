<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class NotesHistory extends Model
{
    use HasFactory;

    protected $table = "notes_history";
    protected $fillable = [
        'vehicle_id', 'buyer_id', 'notes'
    ];

    public function user(){
    	return $this->belongsTo(User::class, 'buyer_id');
    }
}
