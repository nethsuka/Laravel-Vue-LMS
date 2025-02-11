<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name',
        'zoom_link',
        'tele_group',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'stclasses');
    }
}
