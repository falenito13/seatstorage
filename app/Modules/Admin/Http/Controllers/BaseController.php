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
    protected function generateCreateData()
    {
        $item = null;
        if (!empty($this->baseData['item'])) {
            $item = $this->baseData['item'];
        }

        foreach($this->baseData['locales'] as $locale) {
            foreach($this->baseData['fields'] as $key => $field) {
                $name = $field['name'];

                if (empty($field['has_additional_fields'])) {
                    $this->setFieldValue($field, $locale,$item);
                } else if($field['has_additional_fields']) {
                    foreach($field['inputs'] as $inputKey => $input) {
                        $inputName = $input['name'];
                        if ($input['type'] == config('form.fields.types.select_multiple.name') && $item) {
                            if (empty($field['is_translations'])) {
                                $this->baseData['values'][$name][$inputName]   = $item->{$inputName}->pluck('id')->toArray();
                            } else {
                                $this->baseData['values'][$name][$locale][$inputName]   = $item->{$inputName}->pluck('id')->toArray();
                            }
                        } else if ($item) {
                            if (empty($input['is_translations'])) {
                                $this->baseData['values'][$name][$inputName]   = $item->translations($locale) ? $item->translations($locale)->{$inputName} : '';
                            } else {
                                $this->baseData['values'][$name][$locale][$inputName]   = $item->{$inputName};
                            }
                        } else if (array_key_exists('default_value', $input)) {
                            if (empty($input['is_translations'])) {
                                $this->baseData['values'][$name][$inputName]   = $input['default_value'];
                            } else {
                                $this->baseData['values'][$name][$locale][$inputName]   = $input['default_value'];
                            }
                        } else {
                            if (empty($input['is_translations'])) {
                                $this->baseData['values'][$name][$inputName]   = '';
                            } else {
                                $this->baseData['values'][$name][$locale][$inputName]   = '';
                            }
                        }

                    }
                }
            }
        }

        if ($item) {
            $this->baseData['values']['id'] = $item->id;
        }

//        dd($this->baseData['values']);

    }

    /**
     * @param $field
     * @param $locale
     * @param $item
     */
    protected function setFieldValue($field, $locale, $item)
    {
        $name = $field['name'];
        if ($field['type'] == config('form.fields.types.select_multiple.name') && $item) {
            if (empty($field['is_translations'])) {
                $this->baseData['values'][$name]   = $item->{$name}->pluck('id')->toArray();
            } else {
                $this->baseData['values'][$locale][$name]   = $item->{$name}->pluck('id')->toArray();
            }
        } else if ($item) {
            if (empty($field['is_translations'])) {
                $this->baseData['values'][$name]   = $item->translations($locale) ? $item->translations($locale)->{$name} : '';
            } else {
                $this->baseData['values'][$locale][$name]   = $item->{$name};
            }
        } else if (array_key_exists('default_value', $field)) {
            if (empty($field['is_translations'])) {
                $this->baseData['values'][$name]   = $field['default_value'];
            } else {
                $this->baseData['values'][$locale][$name]   = $field['default_value'];
            }
        } else {
            if (empty($field['is_translations'])) {
                $this->baseData['values'][$name]   = '';
            } else {
                $this->baseData['values'][$locale][$name]   = '';
            }
        }
    }



}
