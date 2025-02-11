<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'st_id',
        'st_name',
        'st_email',
        'name',
        'video_link',
        'expiry_date'
    ];
}
