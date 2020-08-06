<?php

namespace App\Modules\Base\Helper;

class TestHelper
{

    /**
     * @param string $baseRouteName
     * @param string $baseModuleName
     * @return array
     */
    public static function getRoutes($baseRouteName = 'admin', $baseModuleName = 'test')
    {

        $baseName = $baseRouteName . '.' . $baseModuleName . '.';

        return [
            'create'            => route($baseName . 'create'),
             'save'              => route($baseName . 'store'),
             'create_data'       => route($baseName . 'create_data'),
             'edit'              => route($baseName . 'edit', []),
             'delete'            => route($baseName . 'delete', [])
        ];
    }

    /**
     * @param string $baseLangName
     * @param string $baseModuleName
     * @return array
     */
    public static function getLang($baseLangName = 'admin', $baseModuleName = 'test')
    {

        $baseFullLangName = $baseLangName . '.' . $baseModuleName . '.';

        return [

            'menu'                      => __($baseFullLangName . 'menu'),
            'index'                     => __($baseFullLangName . 'index'),
            'create'                    => __($baseFullLangName . 'create'),
            'actions'                   => __($baseFullLangName . 'actions'),
            'edit'                      => __($baseFullLangName . 'edit'),
            'delete_title'              => __($baseFullLangName . 'delete_title'),
            'update_successfully'       => __($baseFullLangName . 'update_successfully'),
            'save_successfully'         => __($baseFullLangName . 'save_successfully'),
            'delete_successfully'       => __($baseFullLangName . 'delete_successfully'),
            'save_text'                 => __($baseFullLangName . 'save_text'),
            'confirm_save'              => __($baseFullLangName . 'confirm_save'),
            'confirm_save_yes'          => __($baseFullLangName . 'confirm_save_yes'),
            'confirm_save_no'           => __($baseFullLangName . 'confirm_save_no'),
            'name'                      => __($baseFullLangName . 'name'),
            'description'               => __($baseFullLangName . 'description'),

        ];

    }

}
