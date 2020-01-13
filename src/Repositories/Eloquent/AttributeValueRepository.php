<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Contracts\AttributeValueRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\AttributeValue;

class AttributeValueRepository extends BaseRepository implements AttributeValueRepositoryContract
{
    /**
     * @var AttributeValue
     */
    protected $attributeValue;

    public function __construct(AttributeValue $attributeValue)
    {
        $this->attributeValue = $attributeValue;
    }

    public function model(): Model
    {
        return $this->attributeValue;
    }

    public function modelClass(): string
    {
        return AttributeValue::class;
    }
}
