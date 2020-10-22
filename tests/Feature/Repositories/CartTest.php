<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use IndieHD\Velkart\Contracts\BaseRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CartRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartItemRepositoryContract;
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
     * @throws \Exception
     *
     * @return BaseRepositoryContract
     */
    protected function getRepository(): CartRepositoryContract
    {
        if ($this->repo === null) {
            throw new \Exception('The repository has not been set! See setRepository()');
        }

        return $this->repo;
    }

    /**
     * {@inheritdoc}
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
        $identifier = 'foo';

        $this->getRepository()->create($identifier);

        $cart = $this->getRepository()->findByIdentifier($identifier);

        $this->assertInstanceOf(
            $this->getRepository()->modelClass(),
            $cart
        );

        $this->assertEquals($identifier, $cart->identifier);
    }
}
