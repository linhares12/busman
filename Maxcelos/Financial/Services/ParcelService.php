<?php

namespace Maxcelos\Financial\Services;

use Maxcelos\Financial\Contracts\Parcel as RepoContract;
use Maxcelos\Foundation\Services\Service;

class ParcelService extends Service
{
    function __construct(RepoContract $repo)
    {
        parent::__construct($repo);
    }
}
