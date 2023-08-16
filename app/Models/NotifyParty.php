<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotifyParty extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "notify_party";
    protected $fillable = [
        'name', 'position', 'selected'
    ];
}
