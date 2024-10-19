<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type'
    ];
}
