<?php

namespace Tests\Unit\Repositories;

use IndieHD\Velkart\Contracts\AttributeValueRepositoryContract;
use IndieHD\Velkart\Tests\Unit\Repositories\RepositoryTestCase;

class AttributeValueTest extends RepositoryTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(AttributeValueRepositoryContract::class);
    }
}
