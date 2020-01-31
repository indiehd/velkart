<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;
use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\BaseRepositoryContract;
use IndieHD\Velkart\Contracts\CartItemContract;
use IndieHD\Velkart\Contracts\CartItemRepositoryContract;
use IndieHD\Velkart\Contracts\CartRepositoryContract;
use IndieHD\Velkart\Contracts\CartSessionRepositoryContract;
use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;
use Ramsey\Uuid\UuidFactoryInterface;

class CartSessionTest extends TestCase
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

    /**
     * @param CartSessionRepositoryContract $repo
     */
    protected function setRepository(CartSessionRepositoryContract $repo): void
    {
        $this->repo = $repo;
    }

    /**
     * @return BaseRepositoryContract
     * @throws \Exception
     */
    protected function getRepository(): CartSessionRepositoryContract
    {
        if ($this->repo === null) {
            throw new \Exception('The repository has not been set! See setRepository()');
        }
        return $this->repo;
    }

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(CartSessionRepositoryContract::class));

        $this->uuid = resolve(UuidFactoryInterface::class);

        $this->order = resolve(OrderRepositoryContract::class);

        $this->cartItem = resolve(CartItemRepositoryContract::class);
    }

    /** @test */
    public function itCanCreate()
    {
        $item = $this->cartItem->make(1, 'Foo', 1.00);

        $this->assertInstanceOf(
            CartItem::class,
            $this->getRepository()->create($item)
        );
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itCanListAllModels()
    {
        $item = $this->cartItem->make(1, 'Foo', 1.00);

        $this->getRepository()->create($item);

        $this->assertInstanceOf(
            CartItem::class,
            $this->getRepository()->all()->first()
        );
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itCanListOneModel()
    {
        $item = $this->cartItem->make(1, 'Foo', 1.00);

        $this->getRepository()->create($item);

        $this->assertInstanceOf(
            CartItem::class,
            $this->getRepository()->find($item->rowId)
        );
    }
}
