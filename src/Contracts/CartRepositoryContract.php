<?php

namespace IndieHD\Velkart\Contracts;

interface CartRepositoryContract extends BaseRepositoryContract
{
    public function findByIdentifier(string $identifier): string;
}
