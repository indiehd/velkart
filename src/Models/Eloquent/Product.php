<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\CanBeBought;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model implements Buyable
{
    use CanBeBought;

    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('order', 'desc')
            ->orderBy('id', 'asc');
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }
}
