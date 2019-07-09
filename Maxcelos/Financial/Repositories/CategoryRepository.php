<?php

namespace Maxcelos\Financial\Repositories;

use Maxcelos\Financial\Contracts\Category as RepositoryInterface;
use Maxcelos\Financial\Entities\Category;
use Maxcelos\Foundation\Repositories\Repository;

class CategoryRepository extends Repository implements RepositoryInterface
{
    function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
