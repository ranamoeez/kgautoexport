<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReminderTemplate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "reminder_templates";
    protected $fillable = [
        'name', 'content'
    ];
}
