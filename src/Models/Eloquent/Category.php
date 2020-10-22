<?php

namespace IndieHD\Velkart\Models\Eloquent;

use Baum\NestedSet\Node;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use IndieHD\Velkart\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;
    use Node;

    public $timestamps = false;

    protected $guarded = ['id', 'parent_id', 'left', 'right', 'depth'];

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
