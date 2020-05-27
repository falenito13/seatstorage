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

    /**
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $params)
    {

        $filter = [];

        if ( array_key_exists('filter', $params) ) {
            $filter = $params['filter'];
        }

        if ( !empty($filter['q']) ) {
            $query->orWhere('name', 'LIKE', '%'.$filter['q'].'%')
                    ->orWhereHas('permissions', function(Builder $q) use($filter){
                        $q->where('label', 'LIKe', '%'.$filter['q'].'%');
                });
        }

        return $query;
    }

    /**
     * @param $data
     * @param $sort
     * @return mixed
     */
    public static function sort($data, $sort)
    {

        $data = $data->get();

        if ($sort['ord'] == 'asc') {
            $sortFunction = 'sortBy';
        } else {
            $sortFunction = 'sortByDesc';
        }

        if ( $sort['name'] == 'id' ) {

            return $data->{$sortFunction}(function($itm){
                return $itm->id;
            })->values();

        }

        if ( $sort['name'] == 'name' ) {

            return $data->{$sortFunction}(function($itm){
                return strlen($itm->name);
            })->values();

        }

        if ( $sort['name'] == 'permissions' ) {

            return $data->{$sortFunction}(function($itm){
                return count($itm->permissions);
            })->values();

        }


        return $data;
    }

}
