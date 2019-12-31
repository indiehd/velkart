<?php

namespace IndieHD\Velkart\Product\Contracts;

use IndieHD\Velkart\Base\Contracts\BaseContract;

interface ProductRepositoryContract extends BaseContract
{
    public function saveImages(int $productId, array $thumbnails): void;
}
