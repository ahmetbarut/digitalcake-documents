<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => config('documents.routes.admin.middleware'),
    'prefix' => config('documents.routes.admin.prefix'),
    'namespace' => 'Digitalcake\Documents\Controllers',
    'as' => config('documents.routes.admin.name')
], function () {
    Route::get(config('documents.routes.admin.index'), 'DocumentsController@index')->name('index');
    Route::get(config('documents.routes.admin.create'), 'DocumentsController@create')->name('create');
    Route::post(config('documents.routes.admin.store'), 'DocumentsController@store')->name('store');
    Route::post(config('documents.routes.admin.show'), 'DocumentsController@show')->name('show');
});

Route::group([
    'middleware' => config('documents.routes.web.middleware'),
    'prefix' => config('documents.routes.web.prefix'),
    'namespace' => 'Digitalcake\Documents\Controllers',
    'as' => config('documents.routes.web.name')
], function () {
    // Route::get(config('documents.routes.web.index'), 'DocumentsController@index')->name('index');
    Route::get(config('documents.routes.web.create'), 'DocumentsMailController@create')->name('create');
    Route::post(config('documents.routes.web.store'), 'DocumentsMailController@store')->name('store');
    Route::get(config('documents.routes.web.download'), 'DocumentsMailController@download')->name('download');
});
