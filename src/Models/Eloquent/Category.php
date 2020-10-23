<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Baum\NestedSet\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use Node;

    public $timestamps = false;

    protected $guarded = ['id', 'parent_id', 'left', 'right', 'depth'];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
