<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\AttributeValueRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\AttributeValue;

class AttributeValueRepository extends BaseRepository implements AttributeValueRepositoryContract
{
    /**
     * @var AttributeValue
     */
    protected $attributeValue;

    /**
     * AttributeValueRepository constructor.
     *
     * @param AttributeValue $attributeValue
     */
    public function __construct(AttributeValue $attributeValue)
    {
        $this->attributeValue = $attributeValue;
    }

    /**
     * @return Model
     */
    public function model(): Model
    {
        return $this->attributeValue;
    }

    /**
     * @return string
     */
    public function modelClass(): string
    {
        return AttributeValue::class;
    }
}
