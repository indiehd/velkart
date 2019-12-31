<?php

namespace IndieHD\Velkart\ProductImage\Repositories;

use IndieHD\Velkart\Base\Repositories\BaseRepository;
use IndieHD\Velkart\ProductImage\Contracts\ProductImageRepositoryContract;
use IndieHD\Velkart\ProductImage\ProductImage;

class ProductImageRepository extends BaseRepository implements ProductImageRepositoryContract
{
    /**
     * @var ProductImage
     */
    protected $productImage;

    /**
     * ProductImageRepository constructor.
     * @param ProductImage $productImage
     */
    public function __construct(ProductImage $productImage)
    {
        $this->productImage = $productImage;
    }

    public function model(): object
    {
        return $this->productImage;
    }

    public function modelClass(): string
    {
        return ProductImage::class;
    }
}
