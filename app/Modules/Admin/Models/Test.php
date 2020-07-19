<?php

namespace App\Modules\Admin\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Modules\Admin\Models\BaseModel as BaseModel;

/**
 * App\Modules\Admin\Models\Test
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \App\Modules\Admin\Models\Translations\TestTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\Translations\TestTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin\Models\Test onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Test withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin\Models\Test withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin\Models\Test withoutTrashed()
 * @mixin \Eloquent
 */
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
