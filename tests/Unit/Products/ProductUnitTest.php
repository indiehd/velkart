<?php

namespace Tests\Unit\Products;

use Illuminate\Http\UploadedFile;
use IndieHD\Velkart\Product\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;

class ProductUnitTest extends TestCase
{
    protected $repo;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(ProductRepositoryContract::class);
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $product = 'Samsung Galaxy S10';

        $params = [
            'sku' => $this->faker->unique()->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => UploadedFile::fake()->image('product.png', 600, 600),
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
        ];

        $created = factory($this->repo->modelClass())->create($params);

        $this->assertInstanceOf($this->repo->modelClass(), $created);
        $this->assertEquals($params['sku'], $created->sku);
        $this->assertEquals($params['name'], $created->name);
        $this->assertEquals($params['slug'], $created->slug);
        $this->assertEquals($params['description'], $created->description);
        $this->assertEquals($params['cover'], $created->cover);
        $this->assertEquals($params['quantity'], $created->quantity);
        $this->assertEquals($params['price'], $created->price);
        $this->assertEquals($params['status'], $created->status);
    }

    /** @test */
    public function it_can_list_all_the_products()
    {
        $products = factory($this->repo->modelClass(), 3)->create();
        $attributes = $products->first()->getFillable();

        $list = $this->repo->list();

        $this->assertCount(3, $list);

        $list->each(function ($product, $key) use ($attributes) {
            foreach ($product->getFillable() as $key => $value) {
                $this->assertArrayHasKey($key, $attributes);
            }
        });
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $created = factory($this->repo->modelClass())->create();

        $updated = $this->repo->update($created->id, [
            'price' => 799.99
        ]);

        $this->assertTrue($updated);
        $product = $this->repo->model()->find($created->id);
        $this->assertEquals(799.99, $product->price);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = factory($this->repo->modelClass())->create();
        $deleted = $this->repo->delete($product->id);
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('products', ['name' => $product->name]);
    }

    /** @test */
    public function it_can_save_the_thumbnails_properly()
    {
        $thumbnails = [
            UploadedFile::fake()->image('cover.jpg', 600, 600),
            UploadedFile::fake()->image('cover.jpg', 600, 600),
            UploadedFile::fake()->image('cover.jpg', 600, 600)
        ];

        $product = factory($this->repo->modelClass())->create();

        $this->assertTrue($this->repo->saveImages($product->id, $thumbnails));
        $this->assertCount(3, $product->images);
    }
}
