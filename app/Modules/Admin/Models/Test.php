<?php

namespace App\Modules\Admin\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Modules\Admin\Models\BaseModel as BaseModel;

class Test extends BaseModel implements TranslatableContract
{

    use SoftDeletes,Translatable;

    /**
     * @var string
     */
    protected $table = 'tests';

    /**
     * @var string
     */
    protected $translationModel = \App\Modules\Admin\Models\Translations\TestTranslation::class;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'description'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

}
