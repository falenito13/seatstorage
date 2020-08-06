<?php

namespace App\Modules\Base\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Modules\Admin\Models\BaseModel as BaseModel;

class Test extends BaseModel
{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'tests';

    /**
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

}
