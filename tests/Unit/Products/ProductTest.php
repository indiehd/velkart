<?php

namespace Tests\Unit\Products;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use IndieHD\Velkart\Product\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;

class ProductTest extends TestCase
{
    protected $repo;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(ProductRepositoryContract::class);
    }

    private function createProduct($params = null): object
    {
        if ($params === null) {
            $params = factory($this->repo->modelClass())->make()->toArray();
        }

        return $this->repo->create($params);
    }

    private function createProducts(int $count = 3): iterable
    {
        return factory($this->repo->modelClass(), $count)->create();
    }

    /** @test */
    public function itCanCreateAProduct()
    {
        $product = $this->createProduct();

        $this->assertNotNull($product, 'Product IS null');
    }

    /** @test */
    public function itCanListAllTheProducts()
    {
        $this->createProducts();

        $this->assertCount(3, $this->repo->list());
    }

    /** @test */
    public function itCanFindAProductByItsId()
    {
        $product = $this->createProduct();

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
        $product = $this->createProduct();

        $updated = $this->repo->update($product->id, [
            'price' => 799.99
        ]);

        $this->assertTrue($updated, 'Product did NOT update');
        $this->assertDatabaseHas('products', ['price' => 799.99]);
    }

    /** @test */
    public function itCanDeleteAProduct()
    {
        $product = $this->createProduct();
        $deleted = $this->repo->delete($product->id);

        $this->assertTrue($deleted, 'Product did NOT delete');
        $this->assertDatabaseMissing('products', ['name' => $product->name]);
    }

    /** @test */
    public function itHasManyImages()
    {
        $product = $this->createProduct();

        $this->assertNotNull($product->images);
    }

    /** @test */
    public function itHasManyCategories()
    {
        $product = $this->createProduct();

        $this->assertNotNull($product->categories);
    }

    /** @test */
    public function itHasManyAttributes()
    {
        $product = $this->createProduct();

        $this->assertNotNull($product->attributes);
    }
}
