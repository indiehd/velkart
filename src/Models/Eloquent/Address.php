<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Database\Factories\AddressFactory;

class Address extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return AddressFactory::new();
    }

    protected $guarded = ['id'];
}
