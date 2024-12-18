<?php
namespace App\Repositories;

use App\Models\UserGroup;
use App\Repositories\BaseRepository;
use App\Interfaces\RepositoryInterface;

class GroupUserRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(UserGroup $model)
    {
        parent::__construct($model);
    }

    
}