<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_class_id',
        'video_link',
        'video_name',
        'expiry_date',
        'index',
    ];
    
}
