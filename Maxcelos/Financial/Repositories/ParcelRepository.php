<?php

namespace Maxcelos\Financial\Repositories;

use Maxcelos\Financial\Contracts\Parcel as RepositoryInterface;
use Maxcelos\Financial\Entities\Parcel;
use Maxcelos\Foundation\Repositories\Repository;

class ParcelRepository extends Repository implements RepositoryInterface
{
    function __construct(Parcel $model)
    {
        parent::__construct($model);
    }
}
