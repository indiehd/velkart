<?php

namespace IndieHD\Velkart\Controllers;

use Illuminate\Http\Request;

abstract class ApiController extends Controller
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
     * Should return the <RepositoryInterface>::class
     *
     * @return string
     */
    abstract public function repository();

    /**
     * Should return the <Resource>::class
     *
     * @return string
     */
    abstract public function resource();

    /**
     * Should return <StoreRequest>::class
     *
     * @return string
     */
    abstract public function storeRequest();

    /**
     * Should return <DestroyRequest>::class
     *
     * @return string
     */
    abstract public function destroyRequest();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->repository = resolve($this->repository());

        $this->resource = $this->resource();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Request $request)
    {
        return $this->resource::collection(
            isset($models) ? $models : $this->repository->all()
        );
    }
}
