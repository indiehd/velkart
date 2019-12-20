<?php

namespace IndieHD\Velkart;

use Illuminate\Support\ServiceProvider;

class VelkartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '../routes/api.php');
    }

    public function register()
    {
        //
    }
}
