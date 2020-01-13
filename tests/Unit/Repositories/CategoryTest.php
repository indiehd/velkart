<?php

namespace Tests\Unit\Repositories;

use Illuminate\Database\Eloquent\Collection;
use IndieHD\Velkart\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Contracts\CategoryRepositoryContract;
use IndieHD\Velkart\Tests\Unit\Repositories\RepositoryTestCase;

class CategoryTest extends RepositoryTestCase
{
    protected $productRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(CategoryRepositoryContract::class);

        $this->productRepository = resolve(ProductRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdateACategory()
    {
        $category = $this->create();

        $updated = $this->repo->update($category->id, [
            'name' => $category->name . ' new',
        ]);

        $this->assertTrue($updated, 'Category did NOT update');
        $this->assertDatabaseHas('categories', ['name' => $category->name . ' new']);
    }

    /** @test */
    public function itHasManyProducts()
    {
        $category = $this->create();
        $products = factory($this->productRepository->modelClass(), 3)->make();

        $category->products()->saveMany($products);

        $category->refresh();

        $this->assertCount(3, $category->products);
    }

    /** @test */
    public function itHasAChild()
    {
        $parent = $this->create();
        $child = $this->create();

        $child->makeChildOf($parent);

        $this->assertCount(1, $parent->children);
        $this->assertDatabaseHas(
            'categories',
            [
                'name' => $child->name,
                'parent_id' => $parent->id,
                'left' => 2,
                'right' => 3,
                'depth' => 1,
            ]
        );
    }
}
