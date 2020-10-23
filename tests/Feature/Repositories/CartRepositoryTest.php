<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CartRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartItemRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;
use Ramsey\Uuid\UuidFactoryInterface;

class CartRepositoryTest extends TestCase
{
    /**
     * @var CartRepositoryContract
     */
    private $repo;

    /**
     * @var OrderRepositoryContract
     */
    protected $order;

    /**
     * @var UuidFactoryInterface
     */
    protected $uuid;

    /**
     * @var CartItemRepositoryContract
     */
    protected $cartItem;

    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(CartRepositoryContract::class));

        $this->uuid = resolve(UuidFactoryInterface::class);

        $this->order = resolve(OrderRepositoryContract::class);

        $this->cartItem = resolve(CartItemRepositoryContract::class);
    }

    protected function setRepository(CartRepositoryContract $repo): void
    {
        $this->repo = $repo;
    }

    /**
     * @throws \Exception
     *
     * @return CartRepositoryContract
     */
    protected function getRepository(): CartRepositoryContract
    {
        if ($this->repo === null) {
            throw new \Exception('The repository has not been set! See setRepository()');
        }

        return $this->repo;
    }

    protected function create(): object
    {
        return $this->getRepository()->factory()->create();
    }

    protected function createMany(int $count = 3): iterable
    {
        return $this->getRepository()->factory()->count($count)->create();
    }

    /** @test */
    public function itCanCreate()
    {
        $identifier = 'foo';

        $this->getRepository()->create($identifier);

        $cart = $this->getRepository()->findByIdentifier($identifier);

        $this->assertInstanceOf(
            $this->getRepository()->modelClass(),
            $cart
        );
    }

    /** @test */
    public function itCanListAllTheModels()
    {
        $this->assertCount($this->createMany()->count(), $this->getRepository()->all());
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

        $this->assertEquals($ids, $this->getRepository()->all('id', 'asc')->pluck('id'));
    }

    /** @test */
    public function itCanListByIdInDescendingOrder()
    {
        $models = $this->createMany();

        $ids = $models->sortByDesc('id')->pluck('id');

        $this->assertEquals($ids, $this->getRepository()->all('id', 'desc')->pluck('id'));
    }

    /** @test */
    public function itFailsWhenSortOrderInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->getRepository()->all('id', 'foo');
    }

    /** @test */
    public function itCanCallListWithoutArgumentsAndOrderMatchesDefault()
    {
        $models = $this->createMany();

        $ids = $models->sortByDesc('id')->pluck('id');

        $this->assertEquals($ids, $this->getRepository()->all()->pluck('id'));
    }

    /** @test */
    public function itCanDelete()
    {
        $model = $this->create();

        $this->assertDatabaseHas(
            $this->getRepository()->model()->getTable(),
            ['identifier' => $model->identifier]
        );

        $this->getRepository()->delete($model->identifier);

        //$this->expectException(ModelNotFoundException::class);

        $this->assertDatabaseMissing(
            $this->getRepository()->model()->getTable(),
            ['identifier' => $model->identifier]
        );
    }
}
