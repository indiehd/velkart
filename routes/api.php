<?php

Route::middleware('api')
    ->prefix('shop')
    ->namespace('IndieHD\Velkart\Controllers')
    ->group(function () {
        Route::get('/cart/{identifier}', 'CartController@showByIdentifier')->name('cart.show');
        Route::get('/cart', 'CartController@list')->name('cart.all');
        Route::post('/cart/store', 'CartController@store')->name('cart.store');
        Route::delete('/cart/remove/{identifier}', 'CartController@destroy')->name('cart.delete');

        Route::get('/item/{id}', 'CartItemController@showById')->name('item.show');
        Route::get('/item/list', 'CartItemController@list')->name('item.list');
        Route::post('/item/store', 'CartItemController@store')->name('item.store');
        Route::post('/item/update', 'CartItemController@update')->name('item.update');
        Route::post('/item/remove', 'CartItemController@destroy')->name('item.delete');
    });
