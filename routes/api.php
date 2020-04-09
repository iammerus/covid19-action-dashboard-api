<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function() {
    // Country
    Route::get('/country', "CountryController@index");



});
