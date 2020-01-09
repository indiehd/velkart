<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Traits\UploadsFiles;
use Illuminate\Database\DatabaseManager;
use IndieHD\Velkart\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\Product;

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

    public function model(): Model
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
            $model = $this->findById($id);
            $model->images()->delete();
            $model->delete();
        });

        return true;
    }
}
