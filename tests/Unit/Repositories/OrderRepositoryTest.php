<?php

namespace IndieHD\Velkart\Tests\Unit\Repositories;

use IndieHD\Velkart\Contracts\OrderRepositoryContract;

class OrderRepositoryTest extends RepositoryTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(OrderRepositoryContract::class);
    }
}
