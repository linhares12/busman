<?php

namespace Maxcelos\Financial\Services;

use Maxcelos\Financial\Contracts\Category as CategoryRepoContract;
use Maxcelos\Foundation\Services\Service;

class CategoryService extends Service
{
    function __construct(CategoryRepoContract $repo)
    {
        parent::__construct($repo);

        // $this->repo->setPrimaryKey('id');
    }
}
