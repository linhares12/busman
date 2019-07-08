<?php

namespace Maxcelos\Foundation\Traits;

use Illuminate\Support\Facades\Gate;

trait HasPolicies
{
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }
}
