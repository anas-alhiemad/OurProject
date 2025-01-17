<?php

namespace App\Observers;

use App\Models\FileOperation;

class LogObserver
{
    public function created($model): void
    {
        $fileId = $model->id;
        FileOperation::create(attributes: ['file_id' => $fileId, 'operation' => "upload", 'user_id' => auth()->user()->id]);
    }
}
