<?php

namespace IndieHD\Velkart\Tests\Unit\Repositories;

use IndieHD\Velkart\Tests\TestCase;

abstract class RepositoryTestCase extends TestCase
{
    protected $repo;

    protected function create($params = null): object
    {
        if ($params === null) {
            $params = factory($this->repo->modelClass())->make()->toArray();
        }

        return $this->repo->create($params);
    }

    protected function createMany(int $count = 3): iterable
    {
        return factory($this->repo->modelClass(), $count)->create();
    }

    /** @test */
    public function itCanListByIdInAscendingOrder()
    {
        $products = $this->createMany();

        $ids = $products->sortBy('id')->pluck('id');

        $this->assertEquals($ids, $this->repo->list('id', 'asc')->pluck('id'));
    }

    /** @test */
    public function itCanListByIdInDescendingOrder()
    {
        $products = $this->createMany();

        $ids = $products->sortByDesc('id')->pluck('id');

        $this->assertEquals($ids, $this->repo->list('id', 'desc')->pluck('id'));
    }

    /** @test */
    public function itFailsWhenSortOrderInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->repo->list('id', 'foo');
    }
}
