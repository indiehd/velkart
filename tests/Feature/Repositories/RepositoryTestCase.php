<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use IndieHD\Velkart\Contracts\BaseRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;
use IndieHD\Velkart\Database\Seeds\CountriesSeeder;

abstract class RepositoryTestCase extends TestCase
{
    private $repo;

    protected function setRepository(BaseRepositoryContract $repo): void
    {
        $this->repo = $repo;
    }

    /**
     * @return BaseRepositoryContract
     * @throws \Exception
     */
    protected function getRepository(): BaseRepositoryContract
    {
        if ($this->repo === null) {
            throw new \Exception('The repository has not been set! See setRepository()');
        }
        return $this->repo;
    }

    protected function create($params = null): object
    {
        if ($params === null) {
            $params = factory($this->getRepository()->modelClass())->make()->toArray();
        }

        return $this->getRepository()->create($params);
    }

    protected function createMany(int $count = 3): iterable
    {
        return factory($this->getRepository()->modelClass(), $count)->create();
    }

    /**
     * This method should be implemented by all repository tests as a @test
     */
    abstract public function itCanUpdate();

    /** @test */
    public function itCanCreate()
    {
        $model = $this->create();

        $this->assertNotNull($model, 'Model IS null');
    }

    /** @test */
    public function itCanListAllTheModels()
    {
        $this->assertCount($this->createMany()->count(), $this->getRepository()->list());
    }

    /** @test */
    public function itCanFindAModelByItsId()
    {
        $model = $this->create();

        $this->assertNotNull($this->getRepository()->findById($model->id));
    }

    /** @test */
    public function itThrowsModelNotFoundExceptionWithInvalidModelId()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->getRepository()->findById(999);
    }

    /** @test */
    public function itCanListByIdInAscendingOrder()
    {
        $models = $this->createMany();

        $ids = $models->sortBy('id')->pluck('id');

        $this->assertEquals($ids, $this->getRepository()->list('id', 'asc')->pluck('id'));
    }

    /** @test */
    public function itCanListByIdInDescendingOrder()
    {
        $models = $this->createMany();

        $ids = $models->sortByDesc('id')->pluck('id');

        $this->assertEquals($ids, $this->getRepository()->list('id', 'desc')->pluck('id'));
    }

    /** @test */
    public function itFailsWhenSortOrderInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->getRepository()->list('id', 'foo');
    }

    /** @test */
    public function itCanCallListWithoutArgumentsAndOrderMatchesDefault()
    {
        $models = $this->createMany();

        $ids = $models->sortByDesc('id')->pluck('id');

        $this->assertEquals($ids, $this->getRepository()->list()->pluck('id'));
    }

    /** @test */
    public function itCanDelete()
    {
        $model = $this->create();
        $deleted = $this->getRepository()->delete($model->id);

        $this->assertTrue($deleted, 'Model did NOT delete');

        $this->assertDatabaseMissing(
            $this->getRepository()->model()->getTable(),
            ['name' => $model->name]
        );
    }

    /** @test */
    public function itFailsToDeleteModelWhenModelIdIsInvalid()
    {
        $this->assertFalse($this->getRepository()->delete(5), 'Model DID delete');
    }
}
