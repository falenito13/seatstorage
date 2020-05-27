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
    'middleware' => ['auth:admin'],
], function () {

    /**
     * Admin Dashboard page.
     */
    Route::get('dashboard', 'Admin\DashboardController@index')
        ->name('admin.dashboard');

    // Translate texts
    Route::prefix('translations')
        ->name('admin.text.')->group(function () {

            $controller = 'TextController';
            $moduleName = 'text';

            Route::get('/index/{file?}', $controller . '@index')
                ->name('index')
                    ->middleware(['permission:'.config('permission_list.' .$moduleName. '.default.index.key')]);
            Route::get('/create', $controller . '@create')
                ->name('create')
                    ->middleware(['permission:'.config('permission_list.' .$moduleName. '.default.create.key')]);
            Route::post('/store', $controller . '@store')
                ->name('store')
                    ->middleware(['permission:'.config('permission_list.' .$moduleName. '.default.create.key')]);
            Route::post('/update', $controller . '@update')
                ->name('update')
                    ->middleware(['permission:'.config('permission_list.' .$moduleName. '.default.update.key')]);
            Route::post('/delete', $controller . '@delete')
                ->name('delete')
                    ->middleware(['permission:'.config('permission_list.' .$moduleName. '.default.delete.key')]);

        });


});

