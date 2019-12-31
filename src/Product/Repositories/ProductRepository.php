<?php

namespace IndieHD\Velkart\Product\Repositories;

use IndieHD\Velkart\Base\Contracts\BaseContract;
use IndieHD\Velkart\Base\Repositories\BaseRepository;
use IndieHD\Velkart\Base\Traits\UploadsFiles;
use IndieHD\Velkart\Product\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Product\Product;
use IndieHD\Velkart\ProductImage\Contracts\ProductImageRepositoryContract;

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
     * ProductRepository constructor.
     * @param Product $product
     * @param ProductImageRepositoryContract $productImage
     */
    public function __construct(Product $product, ProductImageRepositoryContract $productImage)
    {
        $this->product = $product;
        $this->productImage = $productImage;
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

    public function saveImages(int $productId, array $thumbnails): void
    {
        foreach ($thumbnails as $file) {
            $filename = $this->storeFile($file);
            $productImage = $this->productImage->create([
                'product_id' => $productId,
                'src' => $filename
            ]);
            $this->product->images()->save($this->productImage->model());
        }
    }
}
