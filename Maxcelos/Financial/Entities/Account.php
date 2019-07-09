<?php

namespace Maxcelos\Financial\Entities;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Maxcelos\People\Traits\HasTenancy;

class Account extends Model
{
    use SoftDeletes, HasTenancy, GeneratesUuid;

    protected $fillable = [
        'name', 'amount', 'tenancy_id', 'accountable_id', 'uuid'
    ];

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $dates = ['deleted_at'];
}
