<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\ProductRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\Product;
use IndieHD\Velkart\Traits\UploadsFiles;

class ProductRepository extends BaseRepository implements ProductRepositoryContract
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

    /**
     * @return Model
     */
    public function model(): Model
    {
        return $this->product;
    }

    /**
     * @return string
     */
    public function modelClass(): string
    {
        return Product::class;
    }

    /**
     * Deletes a Product
     *
     * @param int $id
     * @return bool
     * @throws \Throwable
     */
    public function delete(int $id): bool
    {
        $this->db->beginTransaction();

        try {
            $model = $this->findById($id);
            $model->images()->delete();
            $model->delete();
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }

        $this->db->commit();
        return true;
    }
}
