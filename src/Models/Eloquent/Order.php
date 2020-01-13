<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
#use IndieHD\Velkart\Models\Eloquent\Product;

class Order extends Model
{
    protected $guarded = ['id'];

    /*
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    */
}
