<?php

namespace App\Modules\Admin\Http\Controllers\Admin;

use App\Modules\Admin\Helper\TextHelper;
use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Admin\Http\Requests\Text\SaveTextRequest;
use App\Modules\Admin\Repositories\Contracts\ITextRepository;
use App\Modules\Admin\Utilities\LangFiles;
use App\Utilities\ServiceResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

/**
 * @property ITextRepository textRepository
 */
class TextController extends BaseController
{

    /**
     * @var string
     */
    public $viewFolderName = 'text';

    /**
     * @var ITextRepository
     */
    protected $textRepository;

    /**
     * DashboardController constructor.
     * @param ITextRepository $textRepository
     */
    public function __construct(
        ITextRepository $textRepository
    )
    {
        parent::__construct();
        $this->baseData['moduleKey'] = 'text';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = TextHelper::getLang();
        $this->textRepository = $textRepository;
    }

    /**
     * @param SaveTextRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SaveTextRequest $request)
    {

        try {

            // Save text in db.
            $this->textRepository->postEdit($request, true);

            // Save in file.
            $this->textRepository->exportTranslations($request->get('file'));

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200,  $this->baseData );
    }

    /**
     * @param LangFiles $langFile
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(LangFiles $langFile, Request $request)
    {

        $this->baseData['routes']['index_data'] = route($this->baseData['baseRouteName'] . 'index_data');

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexData(Request $request)
    {

        try {

            $langFiles = [];
            $groups = [];

            foreach(config('language_manager.locales') as $locale) {
                foreach($this->textRepository->where('locale', $locale)->get() as $langText){

                    // Set group.
                    $groups[$langText->group] = $langText->group;

                    // Set value.
                    $langFiles[$langText->group][$langText->key][$locale] = $langText->value;
                }
            }

            $this->baseData['lang_files'] = $langFiles;
            $this->baseData['locales'] = config('language_manager.locales');
            $this->baseData['groups'] = $groups;

            // Set routes.
            $this->baseData['routes']['update'] = route($this->baseData['baseRouteName'] . 'update');
            $this->baseData['routes']['store'] = route($this->baseData['baseRouteName'] . 'store');
            $this->baseData['routes']['delete'] = route($this->baseData['baseRouteName'] . 'delete');

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification('get_index_data', 200,  $this->baseData );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        try {

            // Save text in db.
            $this->textRepository->postEdit($request);

            // Save in file.
            $this->textRepository->exportTranslations($request->get('file'));

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['update_successfully'], 200,  $this->baseData );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {

        try {

            // Delete text.
            $this->textRepository->deleteText($request);

            // Save in file.
            $this->textRepository->exportTranslations($request->get('file'));

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['delete_successfully'], 200,  $this->baseData );
    }

}
