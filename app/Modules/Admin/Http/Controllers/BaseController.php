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
     * @var string
     */
    protected $successCreateText = 'წარმატებით დაემატა';

    /**
     * @var string
     */
    protected $successUpdateText = 'წარმატებით განახლდა';

    /**
     * @var string
     */
    protected $successDeleteText = 'წარმატებით წაიშალა';

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
        $this->baseData['locales'] = config('language_manager.locales');
        $this->baseData['default_locale'] = config('language_manager.default_locale');
        $this->baseData['editor_config'] = config('editor.config');
        $this->baseData['editor_config']['upload_editor'] = route('admin.file.upload_editor');
        $this->baseData['file_upload_url'] = route('admin.file.upload');
        $this->baseData['form'] = config('form');
    }

    /**
     * Generate create data.
     */
    public function generateCreateData()
    {
        $item = null;
        if (!empty($this->baseData['item'])) {
            $item = $this->baseData['item'];
        }

        foreach($this->baseData['fields'] as $key => $field) {
            if ($field['type'] == config('form.fields.types.select_multiple.name') && $item) {
                $this->baseData['values'][$field['name']]   = $item->{$field['name']}->pluck('id')->toArray();
            } else if (array_key_exists('default_value', $field)) {
                $this->baseData['values'][$field['name']]   = $field['default_value'];
            } else {
                $this->baseData['values'][$field['name']]   = '';
            }
        }

        if ($item) {
            $this->baseData['values']['id'] = $item->id;
        }

    }



}
