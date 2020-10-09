<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use IndieHD\Velkart\Contracts\Repositories\Eloquent\AddressRepositoryContract;

class AddressTest extends RepositoryTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(AddressRepositoryContract::class));
    }

    protected function create($params = null): object
    {
        if ($params === null) {
            $params = factory($this->getRepository()->modelClass())->states(['withCountry'])->make()->toArray();
        }

        return $this->getRepository()->create($params);
    }

    protected function createMany(int $count = 3): iterable
    {
        return factory($this->getRepository()->modelClass(), $count)->states(['withCountry'])->create();
    }

//    /** @test */
//    public function itCanCreate()
//    {
//        $model = $this->create(null, ['withCountry']);
//
//        $this->assertNotNull($model);
//    }

    /** @test */
    public function itCanUpdate()
    {
        $model = $this->create();

        $update = [
            'address_1' => '1 Foo St.',
        ];

        $updated = $this->getRepository()->update($model->id, $update);

        $this->assertTrue($updated);
        $this->assertDatabaseHas($this->getRepository()->model()->getTable(), $update);
    }

//    /** @test */
//    public function itCanListAllTheModels()
//    {
//        $this->assertCount($this->createMany(3, ['withCountry'])->count(), $this->getRepository()->list());
//    }
//
//    /** @test */
//    public function itCanFindAModelByItsId()
//    {
//        $model = $this->create(null, ['withCountry']);
//
//        $this->assertNotNull($this->getRepository()->findById($model->id));
//    }
//
//    /** @test */
//    public function itCanListByIdInDescendingOrder()
//    {
//        $models = $this->createMany(3, ['withCountry']);
//
//        $ids = $models->sortByDesc('id')->pluck('id');
//
//        $this->assertEquals($ids, $this->getRepository()->list('id', 'desc')->pluck('id'));
//    }
//
//    /** @test */
//    public function itCanListByIdInAscendingOrder()
//    {
//        $models = $this->createMany(3, ['withCountry']);
//
//        $ids = $models->sortBy('id')->pluck('id');
//
//        $this->assertEquals($ids, $this->getRepository()->list('id', 'asc')->pluck('id'));
//    }
}
