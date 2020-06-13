<?php

namespace App\Modules\Admin\Repositories\Eloquent;

use App\Modules\Admin\Models\Test as RepositoryModel;
use App\Modules\Admin\Repositories\Contracts\ITestRepository as IRepository;
use App\Repositories\Eloquent\BaseRepository;

class TestRepository extends BaseRepository implements IRepository
{

    public function __construct
    (
         RepositoryModel $model
    )
    {
        parent::__construct($model);
    }

}
