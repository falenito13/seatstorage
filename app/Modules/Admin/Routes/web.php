<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function () {

    // Error log show.
    Route::get('log', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')
        ->name('admin.log.show');

});


Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth:admin'],
], function () {

    /**
     * Admin Dashboard page.
     */
    Route::get('dashboard', 'DashboardController@index')
        ->name('admin.dashboard');

    // Translate texts
    Route::prefix('translations')
        ->name('admin.text.')->group(function () {

            $controller = 'TextController';
            $moduleName = 'text';

            Route::get('/index', $controller . '@index')
                ->name('index');
            Route::post('/index-data', $controller . '@indexData')
                ->name('index_data')
                    ->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
            Route::get('/create', $controller . '@create')
                ->name('create')
                    ->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
            Route::post('/store', $controller . '@store')
                ->name('store')
                    ->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
            Route::post('/update', $controller . '@update')
                ->name('update')
                    ->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);
            Route::post('/delete', $controller . '@delete')
                ->name('delete')
                    ->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);

        });


});

