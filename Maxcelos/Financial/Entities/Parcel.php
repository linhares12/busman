<?php

namespace Maxcelos\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    protected $fillable = [
        'uuid', 'description', 'entry_id', 'number', 'due_date', 'payment_date'
    ];
}
