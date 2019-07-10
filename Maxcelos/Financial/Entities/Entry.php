<?php

namespace Maxcelos\Financial\Entities;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Maxcelos\People\Traits\HasTenancy;

class Entry extends Model
{
    use SoftDeletes, HasTenancy, GeneratesUuid;

    protected $fillable = [
        'description', 'type', 'spender_id', 'tenancy_id', 'category_id', 'uuid'
    ];

    protected $casts = [
        'uuid' => 'uuid'
    ];
}
