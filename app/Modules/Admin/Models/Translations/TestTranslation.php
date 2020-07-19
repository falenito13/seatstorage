<?php

namespace App\Modules\Admin\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;

/**
 * App\Modules\Admin\Models\Translations\TestTranslation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Translations\TestTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Translations\TestTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Translations\TestTranslation query()
 * @mixin \Eloquent
 */
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
