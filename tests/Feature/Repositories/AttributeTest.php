<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use Illuminate\Database\Eloquent\Collection;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\AttributeRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\AttributeValueRepositoryContract;

class AttributeTest extends RepositoryTestCase
{
    protected $attributeValue;

    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(AttributeRepositoryContract::class));
        $this->attributeValue = resolve(AttributeValueRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdate()
    {
        $attribute = $this->create();

        $updated = $this->getRepository()->update($attribute->id, [
            'name' => 'attribute',
        ]);

        $this->assertTrue($updated, 'Attribute did NOT update');
        $this->assertDatabaseHas($this->getRepository()->model()->getTable(), ['name' => 'attribute']);
    }

    /** @test */
    public function itHasManyAttributeValue()
    {
        $attribute = $this->create();

        $values = $this->factory($this->attributeValue)->count(2)->make();

        $attribute->values()->saveMany($values);

        $this->assertInstanceOf(Collection::class, $attribute->values);

        $this->assertInstanceOf(
            $this->attributeValue->modelClass(),
            $attribute->values->first()
        );
    }
}
