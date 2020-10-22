<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Gloudemans\Shoppingcart\CanBeBought;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    /*
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
    */

    /**
     * @return BelongsToMany
     */
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }

    /**
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('price');
    }
}
