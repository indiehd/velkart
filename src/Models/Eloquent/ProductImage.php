<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
