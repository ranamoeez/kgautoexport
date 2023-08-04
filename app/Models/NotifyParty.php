<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyParty extends Model
{
    use HasFactory;

    protected $table = "notify_party";
    protected $fillable = [
        'name', 'position', 'selected'
    ];
}
