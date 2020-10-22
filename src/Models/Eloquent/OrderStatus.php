<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Database\Factories\OrderStatusFactory;

class OrderStatus extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return OrderStatusFactory::new();
    }

    protected $guarded = ['id'];
}
