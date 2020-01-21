<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    protected $guarded = ['id'];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @return HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
