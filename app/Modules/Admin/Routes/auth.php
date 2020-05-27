<?php

Route::group(['prefix' => 'admin', 'middleware' => ['guest:admin'], 'namespace' => 'Auth'], function () {

    /**
     * Admin show login form.
     */
    Route::get('', 'LoginController@showLoginForm')
        ->name('admin.login_form');

    /**
     * Login method.
     */
    Route::post('login', 'LoginController@login')
        ->name('admin.login');

});

Route::group(['prefix' => 'admin', 'middleware' => ['guest:admin'], 'namespace' => 'Auth'], function () {

    /**
     * Logout method.
     */
    Route::get('logout', 'LoginController@logout')
        ->name('admin.logout');

});
