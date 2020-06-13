<?php

namespace App\Modules\Admin\Models\Statics;

use App\Modules\Admin\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed src
 */
class File extends BaseModel
{

    use SoftDeletes;

    const ORIGINAL_FILE_FOLDER_NAME = 'original';

    /**
     * @var string
     */
    protected $table = 'files';

    /**
     * @var array
     */
    protected $fillable = [
        'src',
        'type',
        'file_type',
        'imageable_id',
        'imageable_type'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    protected $appends = [
        'fullUrl'
    ];

    /**
     * Get the owning fileable model.
     */
    public function fileable()
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getFullUrlAttribute()
    {
        return asset('storage/' . $this->src);
    }

}
