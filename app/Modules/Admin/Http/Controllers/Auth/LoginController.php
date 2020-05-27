<?php

namespace App\Modules\Admin\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class LoginController extends \App\Http\Controllers\Auth\LoginController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->redirectTo = route('admin.dashboard');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin::auth.login');
    }

    /**
     * @return mixed
     */
    protected function guard()
    {
        return \Auth::guard('admin');
    }

}
