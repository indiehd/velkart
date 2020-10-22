<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Gloudemans\Shoppingcart\CanBeBought;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use IndieHD\Velkart\Database\Factories\ProductFactory;

class Product extends Model implements Buyable
{
    use CanBeBought;
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

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
