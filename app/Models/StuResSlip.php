<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StuResSlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resource_id',
        'slip_id',
        'paid',
        'expiry_date',
    ];
}
