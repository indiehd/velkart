<?php

namespace IndieHD\Velkart\Product;

use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Attribute\Attribute;
use IndieHD\Velkart\Category\Category;
use IndieHD\Velkart\ProductImage\ProductImage;

class Product extends Model implements Buyable
{
    /**
     * @inheritDoc
     */
    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getBuyableDescription($options = null)
    {
        return $this->description ?: $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getBuyablePrice($options = null)
    {
        return $this->price;
    }

    /**
     * @inheritDoc
     */
    public function getBuyableWeight($options = null)
    {
        // TODO: Implement getBuyableWeight() method.
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
}
