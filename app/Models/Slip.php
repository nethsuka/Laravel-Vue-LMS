<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slip extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'slip_url',
        'paid_classes',
        'st_email',
    ];
}
