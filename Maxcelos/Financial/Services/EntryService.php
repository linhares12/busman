<?php

namespace Maxcelos\Financial\Services;

use Maxcelos\Financial\Contracts\Entry as RepoContract;
use Maxcelos\Foundation\Services\Service;

class EntryService extends Service
{
    function __construct(RepoContract $repo)
    {
        parent::__construct($repo);
    }
}
