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

Route::group(['prefix' => 'admin/base'], function () {
    // Test module.
    Route::name('admin.test.')->prefix('tests')->group(function() {
        $contrl = 'TestController';
        $moduleName = 'test';
        //Index.
        Route::get('', $contrl . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        //Create/Update view.
        Route::get('/create', $contrl . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $contrl . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/edit/{id?}', $contrl . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        //Save
        Route::post('/store', $contrl . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        // Delete
        Route::post('/delete', $contrl . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
    });
});
