<?php

namespace Maxcelos\Financial\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Maxcelos\Financial\Entities\Category;
use Maxcelos\People\Entities\User;

class CategoryPolicy
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

    public function view(User $user, Category $category)
    {
        return true;
    }

    public function update(User $user, Category $category)
    {
        return true;
    }

    public function delete(User $user, Category $category)
    {
        return true;
    }
}
