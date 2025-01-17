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
    public function getAllById($id)
    {
        return $this->model->whereId($id)->with('file')->get();
    }

}