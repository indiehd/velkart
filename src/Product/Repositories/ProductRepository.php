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
     * @var ProductImageRepositoryContract
     */
    protected $productImage;

    /**
     * @var DatabaseManager
     */
    protected $db;

    /**
     * ProductRepository constructor.
     * @param Product $product
     * @param ProductImageRepositoryContract $productImage
     * @param DatabaseManager $db
     */
    public function __construct(Product $product, ProductImageRepositoryContract $productImage, DatabaseManager $db)
    {
        $this->product = $product;
        $this->productImage = $productImage;
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

    public function delete(int $id): bool
    {
        $model = $this->model()->find($id);
        $model->images()->delete();
        return $model->delete();
    }

    /**
     * @param int $productId
     * @param array $thumbnails
     * @return bool
     * @throws \Throwable
     */
    public function saveImages(int $productId, array $thumbnails): bool
    {
        $this->db->transaction(function () use ($productId, $thumbnails) {
            foreach ($thumbnails as $file) {
                $filename = $this->storeFile($file);

                $productImage = $this->productImage->create([
                    'product_id' => $productId,
                    'src' => $filename
                ]);

                $product = $this->model()->find($productId);

                $product->images()->save($productImage);
            }
        });

        return true;
    }
}
