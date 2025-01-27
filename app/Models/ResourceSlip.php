<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceSlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'st_name',
        'st_email',
        'resource_name',
        'slip_url',
        'note',
    ];
}
