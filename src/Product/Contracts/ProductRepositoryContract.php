<?php

namespace IndieHD\Velkart\Product\Contracts;

use Illuminate\Database\Eloquent\Collection;
use IndieHD\Velkart\Product\Product;

interface ProductRepositoryContract
{
    public function list(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection;

    public function create(array $data): Product;
}
