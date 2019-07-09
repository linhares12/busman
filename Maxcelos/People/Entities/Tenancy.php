<?php

namespace Maxcelos\People\Entities;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenancy extends Model
{
    use SoftDeletes, GeneratesUuid;

    protected $fillable = [
        'name', 'description'
    ];

    protected $casts = [
        'uuid' => 'uuid'
    ];
}
