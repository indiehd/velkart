<?php

namespace IndieHD\Velkart\Product\Repositories;

use Illuminate\Database\Eloquent\Collection;
use IndieHD\Velkart\Product\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Product\Product;

class ProductRepository Implements ProductRepositoryContract
{
    /**
     * @var Product
     */
    protected $model;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * List all the products
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function list(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        return $this->model->orderBy($order, $sort)->get($columns);
    }

    /**
     * Create a new product
     *
     * @param array $attributes
     * @return Product
     */
    public function create(array $attributes): Product
    {
        return $this->model->create($attributes);
    }
}
