<?php


namespace App\Modules\Base\Facades\Repositories;

use Illuminate\Support\Facades\Facade;

class TestRepositoryFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'TestRepository';
    }
}
