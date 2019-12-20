<?php

Route::middleware('auth:api')->prefix('shop')->group(function () {
    Route::get('/cart');
});
