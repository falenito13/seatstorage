<?php


namespace App\Modules\Admin\Repositories\Contracts;

use App\Repositories\IBaseRepository;
use Illuminate\Http\Request;

interface ITextRepository extends IBaseRepository
{

    /**
     * @param bool $replace
     * @param null $base
     * @param bool $import_group
     * @return mixed
     */
    public function importTranslations($replace = false, $base = null, $import_group = false);

    /**
     * @param $key
     * @param $value
     * @param $locale
     * @param $group
     * @param bool $replace
     * @return mixed
     */
    public function importTranslation($key, $value, $locale, $group, $replace = false);

    /**
     * @param Request $request
     * @param bool $createEvent
     * @return mixed
     */
    public function postEdit(Request $request, $createEvent = false);

    /**
     * @param null $group
     * @param bool $json
     * @return mixed
     */
    public function exportTranslations($group = null, $json = false);

    /**
     * @param $namespace
     * @param $group
     * @param $key
     * @return mixed
     */
    public function missingKey($namespace, $group, $key);

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteText(Request $request);

}
