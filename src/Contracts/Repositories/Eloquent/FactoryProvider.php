<?php

namespace IndieHD\Velkart\Contracts\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Factories\Factory;

interface FactoryProvider
{
    /**
     * Get a factory instance.
     */
    public function factory(): Factory;
}
