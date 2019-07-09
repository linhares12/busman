<?php

namespace Maxcelos\Financial\Services;

use Maxcelos\Financial\Contracts\Account as AccountRepoContract;
use Maxcelos\Foundation\Services\Service;
use Maxcelos\People\Entities\User;

class AccountService extends Service
{
    function __construct(AccountRepoContract $repo)
    {
        parent::__construct($repo);
    }

    public function make(array $data)
    {
        if (!isset($data['accountable_id'])) {
            $data['accountable_id'] = auth()->user()->id;
        } else {
            $data['accountable_id'] = User::whereUuid($data['accountable_id'])->first()->id;
        }

        return parent::make($data);
    }
}
