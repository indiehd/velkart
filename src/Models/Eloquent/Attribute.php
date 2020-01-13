<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
