<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use IndieHD\Velkart\Contracts\Repositories\Eloquent\CountryRepositoryContract;

class CountryTest extends RepositoryTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(CountryRepositoryContract::class));
    }

    /** @test */
    public function itCanUpdate()
    {
        $model = $this->create();

        $update = [
            'name' => 'Foo Country',
        ];

        $updated = $this->getRepository()->update($model->id, $update);

        $this->assertTrue($updated);
        $this->assertDatabaseHas($this->getRepository()->model()->getTable(), $update);
    }
}
