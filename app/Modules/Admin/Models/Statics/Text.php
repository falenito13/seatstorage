<?php

namespace App\Modules\Admin\Models\Statics;

use App\Modules\Admin\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Admin\Models\Statics\Text
 *
 * @property int $id
 * @property int $status
 * @property string|null $locale
 * @property string|null $group
 * @property string|null $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text ofTranslatedGroup($group)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text orderByGroupKeys($ordered)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text selectDistinctGroup()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Statics\Text whereValue($value)
 * @mixin \Eloquent
 */
class Text extends BaseModel
{

    const STATUS_SAVED = 0;
    const STATUS_CHANGED = 1;

    /**
     * @var string
     */
    protected $table = 'texts';

    /**
     * @var array
     */
    protected $fillable = [
        'status',
        'locale',
        'group',
        'key',
        'value'
    ];

    public function scopeOfTranslatedGroup($query, $group)
    {
        return $query->where('group', $group)->whereNotNull('value');
    }

    public function scopeOrderByGroupKeys($query, $ordered) {
        if ($ordered) {
            $query->orderBy('group')->orderBy('key');
        }

        return $query;
    }

    public function scopeSelectDistinctGroup($query)
    {
        $select = '';

        switch (DB::getDriverName()){
            case 'mysql':
                $select = 'DISTINCT `group`';
                break;
            default:
                $select = 'DISTINCT "group"';
                break;
        }

        return $query->select(DB::raw($select));
    }

}
