<?php

namespace IndieHD\Velkart\Tests\Unit\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function itCanCreateAModel()
    {
        $model = $this->create();

        $this->assertNotNull($model, 'Model IS null');
    }

    /** @test */
    public function itCanListAllTheModels()
    {
        $this->assertCount($this->createMany()->count(), $this->repo->list());
    }

    /** @test */
    public function itCanFindAModelByItsId()
    {
        $model = $this->create();

        $this->assertNotNull($this->repo->findById($model->id));
    }

    /** @test */
    public function itThrowsModelNotFoundExceptionWithInvalidModelId()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repo->findById(999);
    }

    /** @test */
    public function itCanListByIdInAscendingOrder()
    {
        $models = $this->createMany();

        $ids = $models->sortBy('id')->pluck('id');

        $this->assertEquals($ids, $this->repo->list('id', 'asc')->pluck('id'));
    }

    /** @test */
    public function itCanListByIdInDescendingOrder()
    {
        $models = $this->createMany();

        $ids = $models->sortByDesc('id')->pluck('id');

        $this->assertEquals($ids, $this->repo->list('id', 'desc')->pluck('id'));
    }

    /** @test */
    public function itFailsWhenSortOrderInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->repo->list('id', 'foo');
    }

    /** @test */
    public function itCanCallListWithoutArgumentsAndOrderMatchesDefault()
    {
        $models = $this->createMany();

        $ids = $models->sortByDesc('id')->pluck('id');

        $this->assertEquals($ids, $this->repo->list()->pluck('id'));
    }

    /** @test */
    public function itCanDeleteAModel()
    {
        $model = $this->create();
        $deleted = $this->repo->delete($model->id);

        $this->assertTrue($deleted, 'Model did NOT delete');

        $this->assertDatabaseMissing(
            $this->repo->model()->getTable(),
            ['name' => $model->name]
        );
    }
}
