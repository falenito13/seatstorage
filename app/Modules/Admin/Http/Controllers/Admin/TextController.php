<?php

namespace App\Modules\Admin\Http\Controllers\Admin;

use App\Modules\Admin\Helper\TextHelper;
use App\Modules\Admin\Http\Controllers\BaseController;
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
     * @param LangFiles $langFile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(LangFiles $langFile)
    {
        $langFile->setLanguage('en');
        $this->baseData['langFiles'] = $langFile->getlangFiles();
        $this->baseData['locales'] = app()->getLocale();

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.create', $this->baseData);
    }

    /**
     * @param LangFiles $langFile
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LangFiles $langFile, Request $request)
    {

        try {

            foreach(config('app.locales') as $locale) {

                $langFile->setLanguage($locale);
                $langFile->setFile($request->file);

                $oldLangFiles = $langFile->getFileContent();

                $key = str_replace(' ','_', $request->key);

                if (array_key_exists($key, $oldLangFiles)) {
                    throw new \Exception('მსგავსი key უკვე არსებობს');
                }

                $oldLangFiles[$key] = $request->{$locale};

                $fields = $langFile->testFields($oldLangFiles);

                if (empty($fields)) {
                    $langFile->setFileContent($oldLangFiles);
                }

            }

        } catch (\Exception $ex) {
            return redirect()->back()->with('notifications', ServiceResponse::notification($ex->getMessage(), 'danger'))->withInput();
        }

        return redirect()->back()->with('notifications', ServiceResponse::notification('წარმატებით დაემატა', 'success'));
    }

    /**
     * @param LangFiles $langFile
     * @param Request $request
     * @param string $file
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(LangFiles $langFile, Request $request)
    {

        $this->baseData['routes']['index_data'] = route($this->baseData['baseRouteName'] . 'index_data');

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }

    /**
     * @param Request $request
     * @param LangFiles $langFile
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexData(Request $request, LangFiles $langFile)
    {

        try {

            $langFiles = $langFile->getlangFiles();

            foreach(config('language_manager.locales') as $locale) {

                foreach($langFiles as $file) {

                    $fileContents = Lang::get($file['original_name'],[],$locale, false);

                    if (!$fileContents) {
                        continue;
                    }

                    foreach($fileContents as $key => $value) {
                        $this->baseData['lang_files'][$file['original_name']][$key][$locale] = $value;
                    }

                }

            }

//            dd($this->baseData['lang_files']['auth']);

            $this->baseData['locales'] = config('language_manager.locales');

            // Set routes.
            $this->baseData['routes']['update'] = route($this->baseData['baseRouteName'] . 'update');
            $this->baseData['routes']['store'] = route($this->baseData['baseRouteName'] . 'store');
            $this->baseData['routes']['delete'] = route($this->baseData['baseRouteName'] . 'delete');

//            dd($this->baseData);

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

        return ServiceResponse::jsonNotification('get_index_data', 200,  $this->baseData );
    }

    /**
     * @param LangFiles $langFile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(LangFiles $langFile, Request $request)
    {

        foreach(config('app.locales') as $locale) {

            $langFile->setLanguage($locale);
            $langFile->setFile($request->file);

            $oldLangFiles = $langFile->getFileContent();
            unset($oldLangFiles[$request->key]);

            $fields = $langFile->testFields($oldLangFiles);

            if (empty($fields)) {
                $langFile->setFileContent($oldLangFiles);
            }

        }

        return response()->json(['status'  => 'success']);
    }

}
