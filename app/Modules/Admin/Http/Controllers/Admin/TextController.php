<?php

namespace App\Modules\Admin\Http\Controllers\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Admin\Utilities\LangFiles;
use App\Utilities\ServiceResponse;
use Illuminate\Http\Request;

class TextController extends BaseController
{

    /**
     * @var string
     */
    public $viewFolderName = 'text';

    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->baseData['moduleKey'] = 'text';
        $this->baseData['baseLangName'] = $this->baseData['langFolderName'] . '.' . $this->baseData['moduleKey'] . '.';
    }

    /**
     * @param LangFiles $langFile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(LangFiles $langFile)
    {
        $langFile->setLanguage('ka');
        $data['langFiles'] = $langFile->getlangFiles();
        $data['locales'] = app()->getLocale();

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.create', $data);
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
     * @param LangFiles $langfile
     * @param Request $request
     * @param string $file
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(LangFiles $langfile, Request $request, $file = '')
    {

        $data['currentFile'] = $file;
        $data['langFiles'] = $langfile->getlangFiles();

        foreach(config('app.locales') as $locale) {
            $langfile->setLanguage($locale);
            $langfile->setFile($file);
            $data['fileArrays'][$locale] = $langfile->getFileContent();
        }

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.index', $data);
    }

    /**
     * @param LangFiles $langFile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LangFiles $langFile, Request $request)
    {

        foreach(config('app.locales') as $locale) {
            $langFile->setLanguage($locale);
            $langFile->setFile($request->file);

            $oldLangFiles = $langFile->getFileContent();
            $oldLangFiles[$request->key] = $request->values[$locale];

            $fields = $langFile->testFields($oldLangFiles);

            if (empty($fields)) {
                $langFile->setFileContent($oldLangFiles);
            }

        }

        return response()->json(['status'   => 'success']);
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
