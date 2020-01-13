<?php

namespace Tests\Unit\Repositories;

use IndieHD\Velkart\Contracts\AttributeRepositoryContract;
use IndieHD\Velkart\Tests\Unit\Repositories\RepositoryTestCase;

class AttributeTest extends RepositoryTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(AttributeRepositoryContract::class);
    }
}
