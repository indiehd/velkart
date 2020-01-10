<?php

namespace Tests\Unit\Repositories;

use Illuminate\Database\Eloquent\Collection;
use IndieHD\Velkart\Contracts\ProductImageRepositoryContract;
use IndieHD\Velkart\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Tests\Unit\Repositories\RepositoryTestCase;

class ProductTest extends RepositoryTestCase
{
    protected $productImage;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(ProductRepositoryContract::class);

        $this->productImage = resolve(ProductImageRepositoryContract::class);
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

        $images = factory($this->productImage->modelClass(), 2)->make();

        $product->images()->saveMany($images);

        $this->assertInstanceOf(Collection::class, $product->images);

        $this->assertInstanceOf(
            $this->productImage->modelClass(),
            $product->images->first()
        );
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
