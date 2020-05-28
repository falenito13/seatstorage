<?php


namespace App\Modules\Admin\Helper;


class UserHelper
{

    /**
     * @param string $baseRouteName
     * @param string $baseModuleName
     * @return array
     */
    public static function getRoutes($baseRouteName = 'admin', $baseModuleName = 'user')
    {

        $baseName = $baseRouteName . '.' . $baseModuleName . '.';

        return [
            'create_form_data'  => route($baseName . 'create_form_data'),
            'create'    => route($baseName . 'create_form'),
            'save'      => route($baseName . 'save'),
            'delete'    => route($baseName . 'delete')
        ];
    }

    /**
     * @param string $baseLangName
     * @param string $baseModuleName
     * @return array
     */
    public static function getLang($baseLangName = 'admin', $baseModuleName = 'user')
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

            //Inputs
            'name'                              => __($baseFullLangName . 'name'),
            'email'                             => __($baseFullLangName . 'email'),
            'password'                          => __($baseFullLangName . 'password'),
            'generate_password'                 => __($baseFullLangName . 'generate_password'),
            'select_role_placeholder'           => __($baseFullLangName . 'select_role_placeholder'),
            'roles'                             => __($baseFullLangName . 'roles'),
            'select_roles'                      => __($baseFullLangName . 'select_roles'),
            'selected_roles'                    => __($baseFullLangName . 'selected_roles'),
            'confirm_save'                      => __($baseFullLangName . 'confirm_save'),
            'confirm_save_yes'                  => __($baseFullLangName . 'confirm_save_yes'),
            'confirm_save_no'                   => __($baseFullLangName . 'confirm_save_no'),
            'created_at'                        => __($baseFullLangName . 'created_at'),
            'roles_name'                        => __($baseFullLangName . 'roles_name'),


        ];

    }

}
