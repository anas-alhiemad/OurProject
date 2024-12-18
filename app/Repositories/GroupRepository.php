<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Interfaces\RepositoryInterface;
use App\Models\Group;

class GroupRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }
}