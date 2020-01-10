<?php

namespace Tests\Unit\Repositories;

use IndieHD\Velkart\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Tests\Unit\Repositories\RepositoryTestCase;

class ProductTest extends RepositoryTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(ProductRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdateAProduct()
    {
        $product = $this->create();

        $updated = $this->repo->update($product->id, [
            'price' => 799.99
        ]);

        $this->assertTrue($updated, 'Product did NOT update');
        $this->assertDatabaseHas('products', ['price' => 799.99]);
    }

    /** @test */
    public function itHasManyImages()
    {
        $product = $this->create();

        $this->assertNotNull($product->images);
    }

    /** @test */
    public function itHasManyCategories()
    {
        $product = $this->create();

        $this->assertNotNull($product->categories);
    }

    /** @test */
    public function itHasManyAttributes()
    {
        $product = $this->create();

        $this->assertNotNull($product->attributes);
    }
}
