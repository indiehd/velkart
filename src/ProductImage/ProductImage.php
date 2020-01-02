<?php

namespace IndieHD\Velkart\ProductImage;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Product\Product;

class ProductImage extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
