<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    protected $fillable = [
        'user_id', 'url', 'time', 'answers', 'popups'
    ];
    protected $casts = [
        'popups' => 'array',
        'answers' => 'array'
    ];
}
