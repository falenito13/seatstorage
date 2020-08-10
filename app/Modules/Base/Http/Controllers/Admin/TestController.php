<?php

namespace App\Modules\Base\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Base\Http\Requests\Admin\Test\CreateRequest;
use App\Modules\Base\Helper\TestHelper as HelperClass;
use TestRepository as ModuleRepository;
use App\Utilities\ServiceResponse;
use Illuminate\Http\Request;
use \App\Modules\Admin\Http\Controllers\BaseController as BaseController;

class TestController extends BaseController
{

    protected $baseModuleName = 'base::';

    /**
     * @var string
     */
    public $moduleTitle = 'test';

    /**
     * @var string
     */
    public $viewFolderName = 'test';

    /**
     * FormController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'test';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = HelperClass::getLang();
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->baseData['allData'] = ModuleRepository::paginate($this->perPage);

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName.'.index', $this->baseData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $this->baseData['routes']['create_form_data'] = HelperClass::getRoutes()['create_data'];

        } catch (\Exception $ex) {
            return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.create', ServiceResponse::error($ex->getMessage()));
        }

        return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.create', ServiceResponse::success($this->baseData));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createData(Request $request)
    {
        try {
            $this->baseData['routes'] = HelperClass::getRoutes();

            if ($request->get('id')) {
                $item = ModuleRepository::findOrFail($request->get('id'));
                $this->baseData['item'] = $item;
            }

            $this->baseData['fields'] = [
                [
                    'label'                     => $this->baseData['trans_text']['name'],
                    'is_required'               => true,
                    'name'                      => 'multi_image2',
                    'type'                      => config('form.fields.types.multi_image.name'),
                    'placeholder'               => $this->baseData['trans_text']['name'],
                    'route'                     => route('admin.file.upload'),
                    'has_additional_fields'     => true,
                    'inputs'                    => [
                        [
                            'label'                     => $this->baseData['trans_text']['name'],
                            'is_required'               => true,
                            'name'                      => 'name',
                            'type'                      => config('form.fields.types.text.name'),
                            'placeholder'               => $this->baseData['trans_text']['name'],
                            'is_translations'           => false
                        ],
                        [
                            'label'                     => $this->baseData['trans_text']['name'],
                            'is_required'               => true,
                            'name'                      => 'name1231',
                            'type'                      => config('form.fields.types.textarea.name'),
                            'placeholder'               => $this->baseData['trans_text']['name'],
                            'is_translations'           => false
                        ]
                    ]
                ],
                [
                    'label'                     => $this->baseData['trans_text']['name'],
                    'is_required'               => true,
                    'name'                      => 'multi_image1',
                    'type'                      => config('form.fields.types.multi_image.name'),
                    'placeholder'               => $this->baseData['trans_text']['name'],
                    'route'                     => route('admin.file.upload'),
                    'has_additional_fields'     => false
                ],
                [
                    'is_translations'   => true,
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => false,
                    'name'              => 'name',
                    'type'              => config('form.fields.types.text.name'),
                    'class'             => [
                        'form_group'        => '',      // Input form group class name.
                        'label'             => '',      // Input group label class name.
                        'input_div'         => ''       // Input div class name.
                    ]
                ],
                [
                    'is_translations'   => true,
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => false,
                    'name'              => 'textarea',
                    'type'              => config('form.fields.types.textarea.name')
                ],
                [
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => true,
                    'name'              => 'date',
                    'type'              => config('form.fields.types.date.name'),
                    'placeholder'       => $this->baseData['trans_text']['name'],
                ],
                [
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => true,
                    'name'              => 'datetime',
                    'type'              => config('form.fields.types.datetime.name'),
                    'placeholder'       => $this->baseData['trans_text']['name'],
                ],
                [
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => true,
                    'name'              => 'checkbox',
                    'type'              => config('form.fields.types.checkbox.name'),
                    'placeholder'       => $this->baseData['trans_text']['name'],
                    'default_value'     => true
                ],
                [
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => true,
                    'name'              => 'wysiwyg',
                    'type'              => config('form.fields.types.wysiwyg.name'),
                    'placeholder'       => $this->baseData['trans_text']['name'],
                    'default_value'     => 'true'
                ],
                [
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => true,
                    'name'              => 'radio',
                    'type'              => config('form.fields.types.radio.name'),
                    'placeholder'       => $this->baseData['trans_text']['name'],
                    'options'           => [
                        [
                            'label'     => 1,
                            'value'     => 1,
                        ],
                        [
                            'label'     => 2,
                            'value'     => 2,
                        ]
                    ]
                ],
                [
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => true,
                    'name'              => 'select',
                    'type'              => config('form.fields.types.select.name'),
                    'placeholder'       => $this->baseData['trans_text']['name'],
                    'options'           => [
                        [
                            'label'     => 1,
                            'value'     => 1,
                        ],
                        [
                            'label'     => 2,
                            'value'     => 2,
                        ]
                    ]
                ],
                [
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => true,
                    'name'              => 'select_multiple',
                    'type'              => config('form.fields.types.select_multiple.name'),
                    'placeholder'       => $this->baseData['trans_text']['name'],
                    'options'           => [
                        [
                            'label'     => 1,
                            'value'     => 1,
                        ],
                        [
                            'label'     => 2,
                            'value'     => 2,
                        ]
                    ]
                ],
                [
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => true,
                    'name'              => 'input_number',
                    'type'              => config('form.fields.types.input_number.name'),
                    'placeholder'       => $this->baseData['trans_text']['name'],
                    'params'        => [
                        'min'           => 1,
                        'max'           => 10,
                        'step'          => 1,
                        'precision'     => 0
                    ]
                ],
                [
                    'label'             => $this->baseData['trans_text']['name'],
                    'is_required'       => true,
                    'name'              => 'multi_image',
                    'type'              => config('form.fields.types.multi_image.name'),
                    'placeholder'       => $this->baseData['trans_text']['name'],
                    'route'             => route('admin.file.upload')
                ],
            ];

            $this->generateCreateData();

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification(__('Filter role successfully'), 200,  $this->baseData );
    }

    /**
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request)
    {
        try {
            dd($request->all());
            if ($request->get('id')) {
                ModuleRepository::findOrFail($request->get('id'))->update($request->except(['id']));
            } else {
                ModuleRepository::create($request->except('_token'));
            }

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200,  $this->baseData );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = '')
    {
        try {
            $this->baseData['routes']['create_form_data'] = HelperClass::getRoutes()['create_data'];

            $this->baseData['id'] = $id;
        } catch (\Exception $ex) {
            return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::error($ex->getMessage()));
        }

        return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::success($this->baseData));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            ModuleRepository::findOrFail($request->get('id'))->delete();
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['delete_successfully'], 200,  $this->baseData );
    }

}
