<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\FileServices\UserFileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     *
     * @var UserFileService
     */
    protected UserFileService $fileService;

    // singleton pattern, service containerUserFileService
    public function __construct(UserFileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function upload(Request $request)
    {
        return $this->fileService->upload($request);
    }

    public function get()
    {
        return $this->fileService->get();
    }

    public function update(Request $request, File $file)
    {
        return $this->fileService->update($request,  $file);
    }

    public function destroy(File $file)
    {
        return $this->fileService->destroy($file);
    }
}
