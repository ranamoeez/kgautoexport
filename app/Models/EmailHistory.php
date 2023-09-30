<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "emails_history";
    protected $fillable = [
        'vehicle_id', 'container_id', 'sent_to', 'user_id'
    ];
}
