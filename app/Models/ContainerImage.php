<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "container_images";
    protected $fillable = [
        'container_id', 'filename', 'filepath', 'type', 'filesize', 'owner_id', 'title', 'ctime'
    ];
}
