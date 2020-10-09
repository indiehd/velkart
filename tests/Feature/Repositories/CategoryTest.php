<?php

namespace Tests\Feature\Repositories;

use IndieHD\Velkart\Contracts\Repositories\Eloquent\CategoryRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\ProductRepositoryContract;
use IndieHD\Velkart\Tests\Feature\Repositories\RepositoryTestCase;

class CategoryTest extends RepositoryTestCase
{
    protected $productRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(CategoryRepositoryContract::class));

        $this->productRepository = resolve(ProductRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdate()
    {
        $category = $this->create();

        $updated = $this->getRepository()->update(
            $category->id,
            ['name' => $category->name.' new']
        );

        $this->assertTrue($updated, 'Category did NOT update');
        $this->assertDatabaseHas(
            $this->getRepository()->model()->getTable(),
            ['name' => $category->name.' new']
        );
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
            $this->getRepository()->model()->getTable(),
            [
                'name'      => $child->name,
                'parent_id' => $parent->id,
                'left'      => 2,
                'right'     => 3,
                'depth'     => 1,
            ]
        );
    }
}
