<?php

namespace Maxcelos\People\Repositories;

use Maxcelos\Foundation\Repositories\Repository;
use Maxcelos\People\Contracts\User as UserRepoContract;
use Maxcelos\People\Entities\User;

class UserRepository extends Repository implements UserRepoContract
{
    function __construct(User $model)
    {
        parent::__construct($model);
    }
}
