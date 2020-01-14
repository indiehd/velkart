<?php

namespace Tests\Unit\Repositories;

use IndieHD\Velkart\Contracts\AttributeRepositoryContract;
use IndieHD\Velkart\Contracts\AttributeValueRepositoryContract;
use IndieHD\Velkart\Tests\Unit\Repositories\RepositoryTestCase;

class AttributeValueTest extends RepositoryTestCase
{
    protected $attribute;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(AttributeValueRepositoryContract::class);
        $this->attribute = resolve(AttributeRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdateAnAttributeValue()
    {
        $attributeValue = $this->create();

        $updated = $this->getRepository()->update($attributeValue->id, [
            'value' => 'new value'
        ]);

        $this->assertTrue($updated, 'Attribute did NOT update');
        $this->assertDatabaseHas($this->getRepository()->model()->getTable(), ['value' => 'new value']);
    }

    /** @test */
    public function itBelongsToAnAttribute()
    {
        $attributeValue = $this->create();

        $this->assertInstanceOf($this->attribute->modelClass(), $attributeValue->attribute);
    }
}
