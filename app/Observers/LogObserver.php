<?php

namespace App\Observers;

use App\Models\FileOperation;

class LogObserver
{
    public function created($model): void
    {
        $fileId = $model->id;
        $groupId = $model->group_id;
        FileOperation::create(attributes: ['file_id' => $fileId, 'operation' => "upload", 'group_id' => $groupId,'dateOperation' => now(),'user_id' => auth()->user()->id]);
    }
}
