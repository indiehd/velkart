<?php

namespace IndieHD\Velkart\Product\Contracts;

use IndieHD\Velkart\Base\Contracts\BaseRepositoryContract;

interface ProductRepositoryContract extends BaseRepositoryContract
{
    public function saveImages(int $productId, array $thumbnails): void;
}
