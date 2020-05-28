<?php

namespace App\Modules\Admin\Models\Statics;

use App\Modules\Admin\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

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
