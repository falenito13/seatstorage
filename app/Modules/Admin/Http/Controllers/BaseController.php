<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Repositories\IBaseRepository;
use App\Traits\ExportTrait;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    use ExportTrait;

    /**
     * @var int
     */
    protected $perPage = 20;

    /**
     * @var $repository IBaseRepository
     */
    public $repository;

    /**
     * @var array
     */
    protected $baseData = [];

    /**
     * @var string
     */
    protected $baseModuleName = 'admin::';

    /**
     * @var string
     */
    protected $baseAdminViewName = 'admin.';

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->baseData['langFolderName'] = 'admin';
        $this->baseData['baseRouteName'] = 'admin';
    }

}
