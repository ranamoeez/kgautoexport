<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerImage extends Model
{
    use HasFactory;

    protected $table = "container_images";
    protected $fillable = [
        'container_id ', 'filename', 'filepath', 'type', 'filesize', 'owner_id', 'title', 'ctime'
    ];
}
