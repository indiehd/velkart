<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use Illuminate\Database\Eloquent\Collection;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\AttributeRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\ProductImageRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\ProductRepositoryContract;

class ProductTest extends RepositoryTestCase
{
    protected $productImage;
    protected $attribute;
    protected $order;

    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(ProductRepositoryContract::class));

        $this->productImage = resolve(ProductImageRepositoryContract::class);
        //$this->productCategory = resolve(CategoryRepositoryContract::class);
        $this->attribute = resolve(AttributeRepositoryContract::class);
        $this->order = resolve(OrderRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdate()
    {
        $product = $this->create();

        $updated = $this->getRepository()->update($product->id, [
            'price' => 799.99,
        ]);

        $this->assertTrue($updated, 'Product did NOT update');
        $this->assertDatabaseHas($this->getRepository()->model()->getTable(), ['price' => 799.99]);
    }

    /** @test */
    public function itHasManyImages()
    {
        $product = $this->create();

        $images = $this->productImage->factory()->count(2)->make();

        $product->images()->saveMany($images);

        $this->assertInstanceOf(Collection::class, $product->images);

        $this->assertInstanceOf(
            $this->productImage->modelClass(),
            $product->images->first()
        );
    }

    /** @test */
    /*
    public function itHasManyCategories()
    {
        $product = $this->create();

        $this->assertInstanceOf(Collection::class, $product->categories);

        $this->assertInstanceOf(
            $this->productCategory->modelClass(),
            $product->categories->first()
        );
    }
    */

    /** @test */
    public function itHasManyAttributes()
    {
        $product = $this->create();

        $attributes = $this->attribute->factory()->count(2)->create();

        $product->attributes()->saveMany($attributes);

        $this->assertInstanceOf(Collection::class, $product->attributes);

        $this->assertInstanceOf(
            $this->attribute->modelClass(),
            $product->attributes->first()
        );
    }

    /** @test */
    public function itHasManyOrders()
    {
        $product = $this->create();

        $orders = $this->order->factory()->count(2)->create();

        $orders->each(function ($order) use ($product) {
            $product->orders()->attach($order->id, ['price' => $product->price]);
        });

        $this->assertInstanceOf(Collection::class, $product->orders);

        $this->assertInstanceOf(
            $this->order->modelClass(),
            $product->orders->first()
        );
    }
}
