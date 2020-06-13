<?php


Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth:admin'],
], function () {


    // Tag module.
    Route::name('admin.test.')->prefix('test')->group(function() {

        $contrl = 'TestController';
        $moduleName = 'tag';

        //Index.
        Route::get('', $contrl . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);

        //Create/Update view.
        Route::get('/create', $contrl . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $contrl . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/edit/{id?}', $contrl . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;

        //Save
        Route::post('/store', $contrl . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);

        // Delete
        Route::delete('/delete', $contrl . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;

    });

});
