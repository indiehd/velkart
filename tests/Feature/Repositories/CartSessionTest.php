<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use IndieHD\Velkart\Contracts\BaseRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartItemRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartSessionRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;

class CartSessionTest extends TestCase
{
    /**
     * @var CartSessionRepositoryContract
     */
    private $repo;

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
     * @throws \Exception
     *
     * @return BaseRepositoryContract
     */
    protected function getRepository(): CartSessionRepositoryContract
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

        $this->setRepository(resolve(CartSessionRepositoryContract::class));

        $this->cartItem = resolve(CartItemRepositoryContract::class);
    }

    /** @test */
    public function itCanDestroy()
    {
        $this->cartItem->create(1, 'Foo', 1.00);

        $this->getRepository()->destroy();

        $this->assertTrue($this->cartItem->all()->isEmpty());
    }
}
