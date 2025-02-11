<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassTute extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_class_id',
        'tute_path',
        'tute_name',
    ];
}
