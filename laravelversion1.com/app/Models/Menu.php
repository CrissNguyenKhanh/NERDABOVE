<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'album',
        'publish',
        'follow',
        'order',
        'user_id',
        'post_catalogue_id',
    ];
}
