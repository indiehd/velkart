<?php

namespace IndieHD\Velkart\Product\Repositories;

use IndieHD\Velkart\Base\Repositories\BaseRepository;
use IndieHD\Velkart\Base\Traits\UploadsFiles;
use IndieHD\Velkart\Product\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Product\Product;
use IndieHD\Velkart\ProductImage\Contracts\ProductImageRepositoryContract;
use Illuminate\Database\DatabaseManager;

class ProductRepository extends BaseRepository Implements ProductRepositoryContract
{
    use UploadsFiles;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var DatabaseManager
     */
    protected $db;

    /**
     * ProductRepository constructor.
     * @param Product $product
     * @param DatabaseManager $db
     */
    public function __construct(Product $product, DatabaseManager $db)
    {
        $this->product = $product;
        $this->db = $db;
    }

    public function model(): object
    {
        return $this->product;
    }

    public function modelClass(): string
    {
        return Product::class;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Throwable
     */
    public function delete(int $id): bool
    {
        $this->db->transaction(function () use ($id) {
            $model = $this->model()->find($id);
            $model->images()->delete();
            $model->delete();
        });

        return true;
    }
}
