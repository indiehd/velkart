<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];
}
