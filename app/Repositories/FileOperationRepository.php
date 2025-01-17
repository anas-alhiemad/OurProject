<?php
namespace App\Repositories;

use App\Models\FileOperation;
use App\Interfaces\RepositoryInterface;

class FileOperationRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(FileOperation $model)
    {
        parent::__construct($model);
    }
    public function getAllById($userId,$groupId)
    {
        return $this->model
        ->where('user_id', $userId)
        ->where('group_id', $groupId) 
        ->with('file') 
        ->get();
    }

}