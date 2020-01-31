<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\BaseRepositoryContract;
use IndieHD\Velkart\Contracts\CartItemContract;
use IndieHD\Velkart\Contracts\CartItemRepositoryContract;
use IndieHD\Velkart\Contracts\CartRepositoryContract;
use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;
use Ramsey\Uuid\UuidFactoryInterface;

class CartTest extends TestCase
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
     * @param CartRepositoryContract $repo
     */
    protected function setRepository(CartRepositoryContract $repo): void
    {
        $this->repo = $repo;
    }

    /**
     * @return BaseRepositoryContract
     * @throws \Exception
     */
    protected function getRepository(): CartRepositoryContract
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

        $this->setRepository(resolve(CartRepositoryContract::class));

        $this->uuid = resolve(UuidFactoryInterface::class);

        $this->order = resolve(OrderRepositoryContract::class);

        $this->cartItem = resolve(CartItemRepositoryContract::class);
    }

    /** @test */
    public function itCanCreate()
    {
        $identifier = $this->uuid->uuid4();

        $this->getRepository()->create($identifier);

        $cart = $this->getRepository()->findByIdentifier($identifier);

        $this->assertInstanceOf(
            Collection::class,
            $cart
        );

        $this->assertTrue($cart->isEmpty());
    }

    /** @test */
    public function itHasOneOrder()
    {
        $cart = factory($this->getRepository()->modelClass())->create();

        $cart->order()->save(factory($this->order->modelClass())->make());

        $this->assertInstanceOf(
            $this->order->modelClass(),
            $cart->order
        );
    }
}
