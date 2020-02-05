<?php

namespace IndieHD\Velkart\Controllers;

use Illuminate\Http\Request;
use IndieHD\Velkart\Contracts\Repositories\Session\CartItemRepositoryContract;
use IndieHD\Velkart\Requests\CartItem\DestroyCartItem;
use IndieHD\Velkart\Requests\CartItem\StoreCartItem;
use IndieHD\Velkart\Requests\CartItem\UpdateCartItem;
use IndieHD\Velkart\Resources\CartItemResource;

class CartItemController extends ApiController
{
    /**
     * @var string $repository
     */
    private $repository;

    /**
     * @var string $resource
     */
    private $resource;

    /**
     * CartItemController constructor.
     */
    public function __construct()
    {
        $this->repository = resolve($this->repository());

        $this->resource = $this->resource();
    }

    /**
     * Sets the RepositoryInterface to resolve.
     *
     * @return string
     */
    public function repository()
    {
        return CartItemRepositoryContract::class;
    }

    /**
     * Sets the ModelResource to resolve.
     *
     * @return string
     */
    public function resource()
    {
        return CartItemResource::class;
    }

    /**
     * Sets the StoreRequest to resolve for validation during a store request.
     *
     * @return string
     */
    public function storeRequest()
    {
        return StoreCartItem::class;
    }

    /**
     * Sets the UpdateRequest to resolve for validation during an update request.
     *
     * @return string
     */
    public function updateRequest()
    {
        return UpdateCartItem::class;
    }

    /**
     * Sets the DestroyRequest to resolve for validation during a destroy request.
     *
     * @return string
     */
    public function destroyRequest()
    {
        return DestroyCartItem::class;
    }

    /**
     * @param $id
     * @return JsonResource
     */
    public function showById($id)
    {
        return new $this->resource(
            $this->repository->findById($id)
        );
    }

    /**
     * Store a newly created resource.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function store(Request $request)
    {
        resolve($this->storeRequest());

        return new $this->resource($this->repository->create(
            $request->json('id'),
            $request->json('name'),
            $request->json('price')
        ));
    }

    /**
     * Update the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResource
     */
    public function update(Request $request)
    {
        resolve($this->updateRequest());

        return new $this->resource(
            $this->repository->update(
                $request->json('rowId'),
                $request->json('qty'),
            )
        );
    }

    /**
     * Remove the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        resolve($this->destroyRequest());

        $this->repository->destroy($request->json('rowId'));

        return response(['success' => true], 200);
    }
}
