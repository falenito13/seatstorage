<?php

namespace App\Models\User;


class Permission extends \Spatie\Permission\Models\Permission
{

    /**
     * @var array
     */
    protected $fillable = ['name', 'guard_name', 'updated_at', 'created_at', 'label'];

}
