<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function() {
    // Country
    Route::get('/country', "CountryController@index");

    Route::get('/statistics', "StatisticsController@index");
    Route::get('/statistics/history', "StatisticsController@history");
});
