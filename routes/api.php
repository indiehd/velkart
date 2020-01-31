<?php

Route::middleware('api')
    ->prefix('shop')
    ->namespace('IndieHD\Velkart\Controllers')
    ->group(function () {
        Route::get('/cart', 'CartController@index')->name('cart.index');
        Route::get('/cart/{identifier}', 'CartController@showByIdentifier')->name('cart.show');
        Route::post('/cart/list', 'CartItemController@list')->name('cart.list');
        Route::post('/cart/store', 'CartItemController@store')->name('cart.store');
        Route::post('/cart/update', 'CartItemController@update')->name('cart.update');
        Route::post('/cart/remove', 'CartItemController@destroy')->name('cart.delete');
    });
