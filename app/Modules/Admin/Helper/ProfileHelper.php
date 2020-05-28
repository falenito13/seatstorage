<?php


namespace App\Modules\Admin\Helper;


class ProfileHelper
{

    /**
     * @param string $baseRouteName
     * @param string $baseModuleName
     * @return array
     */
    public static function getRoutes($baseRouteName = 'admin', $baseModuleName = 'profile')
    {

        $baseName = $baseRouteName . '.' . $baseModuleName . '.';

        return [
            'create_form_data'  => route($baseName . 'form_data'),
            'save'      => route($baseName . 'save'),
        ];
    }

    /**
     * @param string $baseLangName
     * @param string $baseModuleName
     * @return array
     */
    public static function getLang($baseLangName = 'admin', $baseModuleName = 'profile')
    {

        $baseFullLangName = $baseLangName . '.' . $baseModuleName . '.';

        return [

            'menu'                      => __($baseFullLangName . 'menu'),
            'update'                    => __($baseFullLangName . 'update'),
            'update_successfully'       => __($baseFullLangName . 'update_successfully'),
            'save_successfully'         => __($baseFullLangName . 'save_successfully'),
            'delete_successfully'       => __($baseFullLangName . 'delete_successfully'),
            'save_text'                 => __($baseFullLangName . 'save_text'),

            //Inputs
            'name'                              => __($baseFullLangName . 'name'),
            'email'                             => __($baseFullLangName . 'email'),
            'password'                          => __($baseFullLangName . 'password'),
            'generate_password'                 => __($baseFullLangName . 'generate_password'),
            'confirm_save'                      => __($baseFullLangName . 'confirm_save'),
            'confirm_save_yes'                  => __($baseFullLangName . 'confirm_save_yes'),
            'confirm_save_no'                   => __($baseFullLangName . 'confirm_save_no'),
            'created_at'                        => __($baseFullLangName . 'created_at'),


        ];

    }

}
