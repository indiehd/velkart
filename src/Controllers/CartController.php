<?php

namespace IndieHD\Velkart\Controllers;

use Illuminate\Http\Request;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CartRepositoryContract;
use IndieHD\Velkart\Requests\Cart\DestroyCart;
use IndieHD\Velkart\Requests\Cart\StoreCart;
use IndieHD\Velkart\Resources\CartResource;

class CartController extends ApiController
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
     * CartController constructor.
     */
    public function __construct()
    {
        parent::__construct();

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
     * Sets the StoreRequest to resolve for validation during a store request.
     *
     * @return string
     */
    public function storeRequest()
    {
        return StoreCart::class;
    }

    public function destroyRequest()
    {
        return DestroyCart::class;
    }

    /**
     * @param $identifier
     * @return mixed
     */
    public function showByIdentifier($identifier)
    {
        return new $this->resource(
            $this->repository->findByIdentifier($identifier)
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
            $request->json('identifier')
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $identifier)
    {
        resolve($this->destroyRequest());

        $this->repository->delete($identifier);

        return response(['success' => true], 200);
    }
}
