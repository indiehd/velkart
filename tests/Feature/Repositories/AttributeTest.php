<?php

namespace Tests\Unit\Repositories;

use Illuminate\Database\Eloquent\Collection;
use IndieHD\Velkart\Contracts\AttributeRepositoryContract;
use IndieHD\Velkart\Contracts\AttributeValueRepositoryContract;
use IndieHD\Velkart\Tests\Unit\Repositories\RepositoryTestCase;

class AttributeTest extends RepositoryTestCase
{
    protected $attributeValue;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(AttributeRepositoryContract::class);
        $this->attributeValue = resolve(AttributeValueRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdateAnAttribute()
    {
        $attribute = $this->create();

        $updated = $this->getRepository()->update($attribute->id, [
            'name' => 'attribute'
        ]);

        $this->assertTrue($updated, 'Attribute did NOT update');
        $this->assertDatabaseHas($this->getRepository()->model()->getTable(), ['name' => 'attribute']);
    }

    /** @test */
    public function itHasManyAttributeValue()
    {
        $attribute = $this->create();

        $values = factory($this->attributeValue->modelClass(), 2)->make();

        $attribute->values()->saveMany($values);

        $this->assertInstanceOf(Collection::class, $attribute->values);

        $this->assertInstanceOf(
            $this->attributeValue->modelClass(),
            $attribute->values->first()
        );
    }
}
