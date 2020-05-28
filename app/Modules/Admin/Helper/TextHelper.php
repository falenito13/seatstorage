<?php


namespace App\Modules\Admin\Helper;


class TextHelper
{

    /**
     * @param string $baseLangName
     * @param string $baseModuleName
     * @return array
     */
    public static function getLang($baseLangName = 'admin', $baseModuleName = 'text')
    {

        $baseFullLangName = $baseLangName . '.' . $baseModuleName . '.';

        return [

            'create'                    => $baseFullLangName . 'create',
            'key'                       => $baseFullLangName . 'key',
            'file_name'                 => $baseFullLangName . 'file_name',
            'actions'                   => $baseFullLangName . 'actions',
            'edit_title'                => $baseFullLangName . 'edit_title',
            'delete_title'              => $baseFullLangName . 'delete_title',

        ];

    }

}
