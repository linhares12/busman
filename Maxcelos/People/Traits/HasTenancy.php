<?php

namespace Maxcelos\People\Traits;

use Maxcelos\People\Scopes\TenancyScope;

trait HasTenancy
{
    protected static function boot()
    {
        parent::boot();

        if (auth()->check()) {
            static::addGlobalScope(new TenancyScope());

            static::creating(function ($model) {
                $model->tenancy_id = auth()->user()->current_tenancy_id;
            });
        }
    }
}
