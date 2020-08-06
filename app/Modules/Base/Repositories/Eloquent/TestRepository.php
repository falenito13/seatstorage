<?php

namespace App\Modules\Base\Repositories\Eloquent;

use App\Modules\Base\Models\Test;
use App\Repositories\Eloquent\BaseRepository;

class TestRepository extends BaseRepository
{

    /**
    * TestRepository constructor.
    *
    * @param Test $model
    */
    public function  __construct(Test $model)
    {
        parent::__construct($model);
    }

}
