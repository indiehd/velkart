<?php

namespace Tests\Unit\Products;

use Illuminate\Http\UploadedFile;
use IndieHD\Velkart\Product\Product;
use IndieHD\Velkart\Tests\TestCase;

class ProductUnitTest extends TestCase
{
    /** @test */
    public function it_can_create_a_product()
    {
        $product = 'apple';

        $cover = UploadedFile::fake()->image('file.png', 600, 600);

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => $cover,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
        ];

        $product = factory(Product::class)->make($params);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($params['sku'], $product->sku);
        $this->assertEquals($params['name'], $product->name);
        $this->assertEquals($params['slug'], $product->slug);
        $this->assertEquals($params['description'], $product->description);
        $this->assertEquals($params['cover'], $product->cover);
        $this->assertEquals($params['quantity'], $product->quantity);
        $this->assertEquals($params['price'], $product->price);
        $this->assertEquals($params['status'], $product->status);
    }
}