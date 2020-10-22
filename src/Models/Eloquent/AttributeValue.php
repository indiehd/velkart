<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IndieHD\Velkart\Database\Factories\AttributeValueFactory;

class AttributeValue extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return AttributeValueFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
