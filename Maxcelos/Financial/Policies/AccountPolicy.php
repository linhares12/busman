<?php

namespace Maxcelos\Financial\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Maxcelos\Financial\Entities\Account;
use Maxcelos\People\Entities\User;

class AccountPolicy
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

    public function view(User $user, Account $account)
    {
        return true;
    }

    public function update(User $user, Account $account)
    {
        return true;
    }

    public function delete(User $user, Account $account)
    {
        return true;
    }
}
