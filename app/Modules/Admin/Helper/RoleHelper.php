<?php


namespace App\Modules\Admin\Helper;


class RoleHelper
{

    /**
     * @param string $baseRouteName
     * @param string $baseModuleName
     * @return array
     */
    public static function getRoutes($baseRouteName = 'admin', $baseModuleName = 'role')
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
    public static function getLang($baseLangName = 'admin', $baseModuleName = 'role')
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
            'confirm_save'                      => __($baseFullLangName . 'confirm_save'),
            'confirm_save_yes'                  => __($baseFullLangName . 'confirm_save_yes'),
            'confirm_save_no'                   => __($baseFullLangName . 'confirm_save_no'),
            'created_at'                        => __($baseFullLangName . 'created_at'),
            'roles_name'                        => __($baseFullLangName . 'roles_name'),
            'permissions'                       => __($baseFullLangName . 'permission'),
            'select_permissions'                => __($baseFullLangName . 'select_permissions'),
            'selected_permissions'              => __($baseFullLangName . 'selected_permissions'),
            'select_permission_placeholder'     => __($baseFullLangName . 'select_permission_placeholder'),
            'permissions_name'                  => __($baseFullLangName . 'permissions_name'),



        ];

    }

}
