<?php

namespace Maxcelos\Acl\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Maxcelos\Acl\Entities\Role;
use Maxcelos\People\Entities\User;

class RolePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function view(User $user, Role $role)
    {
        return true;
    }

    public function update(User $user, Role $role)
    {
        return true;
    }

    public function delete(User $user, Role $role)
    {
        return true;
    }
}
