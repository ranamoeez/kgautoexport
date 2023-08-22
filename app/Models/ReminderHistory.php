<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ReminderTemplate;

class ReminderHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "reminder_history";
    protected $fillable = [
        'vehicle_id', 'buyer_id', 'template_id'
    ];

    public function template(){
    	return $this->belongsTo(ReminderTemplate::class, 'template_id');
    }
}
