<?php

Route::middleware('api')
    ->prefix('shop')
    ->namespace('IndieHD\Velkart\Controllers')
    ->group(function () {
        Route::get('/cart', 'CartController@index')->name('cart.index');
        Route::get('/cart/{identifier}', 'CartController@showByIdentifier')->name('cart.show');
    });
