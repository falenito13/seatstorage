<?php

return [
    /**
     * CkEditor config.
     */
    'config'    => [
        'toolbar'   => [
            'items' => [
                'insertTable',
                'Preview',
                'Bold',
                'italic',
                'link',
                'undo',
                'redo',
                'imageUpload',
                'bulletedList',
                'numberedList',
                'blockQuote',
                'heading',
                'mediaEmbed',
                'uploader',
                'imageTextAlternative',
                'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:side',
            ],
            'styles'    => [
                'full',
                'alignLeft',
                'alignRight'
            ],
            'images'    => [
                'imageTextAlternative', '|', 'imageStyle:full', 'imageStyle:side'
            ]
        ]
    ]
];
