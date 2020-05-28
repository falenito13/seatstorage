<?php

namespace App\Modules\Admin\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed roles
 */
class Admin extends Authenticatable implements \OwenIt\Auditing\Contracts\Auditable
{

    use Notifiable, HasRoles,Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'rolesName',
        'rolesId'
    ];

    /**
     * @return array
     */
    public function getRolesIdAttribute()
    {
        return $this->roles ? $this->roles->pluck('id')->toArray() : [];
    }

    /**
     * @return string
     */
    public function getRolesNameAttribute()
    {
        return $this->roles ? implode(',',$this->roles->pluck('name')->toArray()) : '';
    }

}
