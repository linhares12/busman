<?php

namespace Maxcelos\Acl\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description', 'type', 'guard_name'
    ];

    protected $hidden = ['guard_name'];
}
