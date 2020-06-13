<?php

namespace App\Modules\Admin\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;

class TestTranslation extends BaseTranslationModel
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

}
