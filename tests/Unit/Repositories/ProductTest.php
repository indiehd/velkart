<?php

namespace Tests\Unit\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function itCanCreateAProduct()
    {
        $product = $this->create();

        $this->assertNotNull($product, 'Product IS null');
    }

    /** @test */
    public function itCanListAllTheProducts()
    {
        $n = 3;

        $this->createMany($n);

        $this->assertCount($n, $this->repo->list());
    }

    /** @test */
    public function itCanFindAProductByItsId()
    {
        $product = $this->create();

        $this->assertNotNull($this->repo->findById($product->id));
    }

    /** @test */
    public function itThrowsModelNotFoundExceptionWithInvalidProductId()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repo->findById(999);
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
    public function itCanDeleteAProduct()
    {
        $product = $this->create();
        $deleted = $this->repo->delete($product->id);

        $this->assertTrue($deleted, 'Product did NOT delete');
        $this->assertDatabaseMissing('products', ['name' => $product->name]);
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
