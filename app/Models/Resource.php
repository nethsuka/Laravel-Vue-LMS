<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category',
    ];

    public function videos()
    {
        return $this->hasMany(ResourceVideo::class);
    }
}
