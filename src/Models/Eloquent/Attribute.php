<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use IndieHD\Velkart\Database\Factories\AttributeFactory;

class Attribute extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return AttributeFactory::new();
    }

    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
