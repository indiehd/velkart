<?php

namespace IndieHD\Velkart\Controllers;

use Illuminate\Http\Request;
use IndieHD\Velkart\Contracts\CartItemRepositoryContract;
#use IndieHD\Velkart\Contracts\CartSessionRepositoryContract;
use IndieHD\Velkart\Requests\StoreCart;
use IndieHD\Velkart\Requests\UpdateCart;
use IndieHD\Velkart\Requests\DestroyCart;
use IndieHD\Velkart\Resources\CartItemResource;

class CartItemController extends Controller
{
    /**
     * @var string $resource
     */
    private $resource;

    public function __construct()
    {
        $this->repository = resolve($this->repository());

        $this->resource = $this->resource();
    }

    /**
     * Sets the RepositoryInterface to resolve
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
     * Store a newly created resource.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function store(Request $request)
    {
        resolve($this->storeRequest());

        /*
        return new $this->resource($this->repository->create(
            $request->json('id'),
            $request->json('name'),
            $request->json('price')
        ));
        */

        return new $this->resource($this->repository->create($request->all()));
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
            $this->repository->update($request->all())
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

        $this->repository->remove(json_decode($request->input('data')));

        return response(['success' => true], 200);
    }

    /**
     * Sets the StoreRequest to resolve for validation during a store request.
     *
     * @return string
     */
    public function storeRequest()
    {
        return StoreCart::class;
    }

    /**
     * Sets the UpdateRequest to resolve for validation during a update request.
     *
     * @return string
     */
    public function updateRequest()
    {
        return UpdateCart::class;
    }

    public function destroyRequest()
    {
        return DestroyCart::class;
    }
}
