<?php

namespace IndieHD\Velkart\Controllers;

use Illuminate\Http\Request;
use IndieHD\Velkart\Contracts\CartRepositoryContract;
use IndieHD\Velkart\Resources\CartResource;

class CartController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->repo = resolve(CartRepositoryContract::class);
    }

    /**
     * Sets the RepositoryInterface to resolve
     *
     * @return string
     */
    public function repository()
    {
        return CartRepositoryContract::class;
    }

    /**
     * Sets the ModelResource to resolve
     *
     * @return string
     */
    public function resource()
    {
        return CartResource::class;
    }

    /**
     * Sets the StoreRequest to resolve for validation during a store request
     *
     * @return string
     */
    public function storeRequest()
    {
        // return StoreRequest::class;
    }

    /**
     * Sets the UpdateRequest to resolve for validation during a update request
     *
     * @return string
     */
    public function updateRequest()
    {
        // return UpdateRequest::class;
    }

    public function destroyRequest()
    {
        // TODO: Implement destroyRequest() method.
    }

    public function showByIdentifier($identifier)
    {
        return $this->repo->findByIdentifier($identifier);
    }
}
