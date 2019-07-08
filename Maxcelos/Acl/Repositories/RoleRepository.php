<?php

namespace Maxcelos\Acl\Repositories;

use Maxcelos\Acl\Contracts\Role as RepositoryInterface;
use Maxcelos\Acl\Entities\Role;
use Maxcelos\Foundation\Repositories\Repository;

class RoleRepository extends Repository implements RepositoryInterface
{
    function __construct(Role $model)
    {
        parent::__construct($model);
    }
}
