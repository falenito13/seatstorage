<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use OwenIt\Auditing\Auditable;

/**
 * @property mixed permissions
 */
class Role extends \Spatie\Permission\Models\Role implements \OwenIt\Auditing\Contracts\Auditable
{

    use Auditable;

    /**
     * @var array
     */
    public $appends = [
        'permissionsId',
        'permissionsName'
    ];

    /**
     * @return string
     */
    public function getPermissionsNameAttribute()
    {
        return $this->permissions ? implode(',',$this->permissions->pluck('label')->toArray()) : '';
    }

    /**
     * @return array
     */
    public function getPermissionsIdAttribute()
    {
        return $this->permissions ? $this->permissions->pluck('id')->toArray() : [];
    }

}
