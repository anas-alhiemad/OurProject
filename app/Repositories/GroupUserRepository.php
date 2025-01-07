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

    public function getMyGroups()
    {
        $group = $this->model->where('UserId',auth()->guard('user')->id())->with('group')->get();
        return response()->json([
            "message" => "all MyGroups",
            "groups" => $group]);
    }
    
}