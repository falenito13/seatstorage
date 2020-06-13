<?php

return [

    /**
     * Handcrafted member.
     */
    'handcrafted_by'        => 'Tazo Mindiashvili',

    /**
     * Handcrafted member url.
     */
    'handcrafted_by_url'        => 'https://www.linkedin.com/in/tmindiashvili/',

    /**
     * Admin user avatar url.
     */
    'user_avatar'           => 'admin_resources/img/placeholders/avatars/avatar2.jpg',

    /**
     * Project name.
     */
    'project_name'          => env('PROJECT_NAME', 'Tazo Panel'),

    /**
     * Project avatar url.
     */
    'project_avatar'        => 'admin_resources/img/placeholders/avatars/avatar2.jpg',

    /**
     * Login background image url
     */
    'login_background_image'    => 'admin_resources/img/placeholders/headers/login_header.jpg',

    /**
     * Admin user
     */
    'admin_user_name'           => env('ADMIN_USER_EMAIL', 'tazo@github.ge'),
    'admin_user_password'       => env('ADMIN_USER_PASSWORD', ''),

    /**
     * Image upload config.
     */
    'image'         => [

        /**
         * Enable or disable upload resolutions.
         */
        'upload_resolutions'    => env('UPLOAD_IMAGE_RESOLUTIONS', true),

        /**
         * Resolution list.
         */
        'resolutions'   => [
            600,
            1200,
            1800
        ]

    ]


];
