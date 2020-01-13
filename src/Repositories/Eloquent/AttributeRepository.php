<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Contracts\AttributeRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\Attribute;

class AttributeRepository extends BaseRepository implements AttributeRepositoryContract
{
    /**
     * @var Attribute
     */
    protected $attribute;

    public function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function model(): Model
    {
        return $this->attribute;
    }

    public function modelClass(): string
    {
        return Attribute::class;
    }
}
