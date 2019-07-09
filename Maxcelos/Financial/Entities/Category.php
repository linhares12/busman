<?php

namespace Maxcelos\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Maxcelos\People\Traits\HasTenancy;

class Category extends Model
{
    use SoftDeletes, HasTenancy;

    protected $fillable = [
        'name', 'color', 'type'
    ];
}
