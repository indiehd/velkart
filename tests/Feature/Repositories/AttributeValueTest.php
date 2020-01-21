<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use IndieHD\Velkart\Contracts\AttributeRepositoryContract;
use IndieHD\Velkart\Contracts\AttributeValueRepositoryContract;

class AttributeValueTest extends RepositoryTestCase
{
    protected $attribute;

    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(AttributeValueRepositoryContract::class));
        $this->attribute = resolve(AttributeRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdate()
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
