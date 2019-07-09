<?php

namespace Maxcelos\Financial\Repositories;

use Maxcelos\Financial\Contracts\Account as RepositoryInterface;
use Maxcelos\Financial\Entities\Account;
use Maxcelos\Foundation\Repositories\Repository;

class AccountRepository extends Repository implements RepositoryInterface
{
    function __construct(Account $model)
    {
        parent::__construct($model);
    }
}
