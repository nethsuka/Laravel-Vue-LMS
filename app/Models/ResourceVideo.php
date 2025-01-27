<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'name',
        'link',
        'index',
    ];
}
