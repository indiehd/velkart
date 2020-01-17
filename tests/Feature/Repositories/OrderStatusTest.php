<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use IndieHD\Velkart\Contracts\OrderStatusRepositoryContract;

class OrderStatusTest extends RepositoryTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(OrderStatusRepositoryContract::class));
    }

    /** @test */
    public function itCanUpdate()
    {
        $this->assertTrue(true);
    }
}
