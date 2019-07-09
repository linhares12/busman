<?php

namespace Maxcelos\Financial\Repositories;

use Maxcelos\Financial\Contracts\Entry as RepositoryInterface;
use Maxcelos\Financial\Entities\Entry;
use Maxcelos\Foundation\Repositories\Repository;

class EntryRepository extends Repository implements RepositoryInterface
{
    function __construct(Entry $model)
    {
        parent::__construct($model);
    }
}
