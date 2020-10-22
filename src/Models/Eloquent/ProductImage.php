<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use IndieHD\Velkart\Database\Factories\ProductImageFactory;

class ProductImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return ProductImageFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
