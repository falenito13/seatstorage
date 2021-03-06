<?php

namespace App\Modules\Admin\Helper;

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
            'create'    => route($baseName . 'create'),
            'store'      => route($baseName . 'store'),
            'edit'      => route($baseName . 'edit', []),
            'update'    => route($baseName . 'update', []),
            'delete'    => route($baseName . 'delete', [])
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
            'delete_title'              => __($baseFullLangName . 'delete_title'),
            'update_successfully'       => __($baseFullLangName . 'update_successfully'),
            'save_successfully'         => __($baseFullLangName . 'save_successfully'),
            'delete_successfully'       => __($baseFullLangName . 'delete_successfully'),
            'save_text'                 => __($baseFullLangName . 'save_text'),

        ];

    }

}
