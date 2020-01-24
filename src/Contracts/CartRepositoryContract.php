<?php

namespace IndieHD\Velkart\Contracts;

use Illuminate\Support\Collection;

interface CartRepositoryContract
{
    public function findByIdentifier(string $identifier): Collection;
}
