<?php

namespace IndieHD\Velkart\Contracts;

interface CartItemRepositoryContract
{
    public function make($id, $name, $price): CartItemContract;
}
