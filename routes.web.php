<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [config('documents.routes.admin.middleware')],
    'prefix' => config('documents.routes.admin.prefix'),
    'namespace' => 'Digitalcake\Documents\Controllers',
    'as' => config('documents.routes.admin.name')
], function () {
    Route::get(config('documents.routes.admin.index'), 'DocumentController@index')->name('index');
    Route::get(config('documents.routes.admin.create'), 'DocumentController@create')->name('create');
    Route::get(config('documents.routes.admin.destroy'), 'DocumentController@destroy')->name('destroy');
    Route::get(config('documents.routes.admin.show'), 'DocumentController@show')->name('show');
    Route::get(config('documents.routes.admin.edit'), 'DocumentController@edit')->name('edit');

    Route::post(config('documents.routes.admin.store'), 'DocumentController@store')->name('store');
    Route::post(config('documents.routes.admin.update'), 'DocumentController@update')->name('update');
});

Route::group([
    'middleware' => config('documents.routes.web.middleware'),
    'prefix' => config('documents.routes.web.prefix'),
    'namespace' => 'Digitalcake\Documents\Controllers',
    'as' => config('documents.routes.web.name')
], function () {
    Route::get(config('documents.routes.web.index'), 'DocumentMailController@index')->name('index');
    Route::get(config('documents.routes.web.create'), 'DocumentMailController@create')->name('create');
    Route::post(config('documents.routes.web.store'), 'DocumentMailController@store')->name('store');
    Route::get(config('documents.routes.web.download'), 'DocumentMailController@download')->name('download');
});
