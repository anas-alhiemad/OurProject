<?php

namespace App\Services\FileServices;

use App\Exports\FileOperationsExport;
use App\Http\Requests\Files\CheckInRequest;
use App\Http\Requests\Files\CreateFileRequest;
use App\Http\Requests\Files\UpdateFileRequest;
use App\Models\File;
use App\Models\FileOperation;
use App\Services\BaseService;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Maatwebsite\Excel\Facades\Excel;

class UserFileService extends BaseService
{
    public function upload(CreateFileRequest $request)
    {
        DB::beginTransaction();

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        // $filePath = $file->storeAs('uploads', $fileName);

        $disk = Storage::build([
            'driver' => 'local',
            'root' =>   '/uploads',
        ]);

        $disk->put($fileName, file_get_contents($file->path()));

        $newFile = new File;
        $newFile->name = $request->input('name');
        // $newFile->group_id = 1;
        $newFile->file_path = '/uploads/' . $fileName;
        $newFile->save();
        $this->logOperation($newFile->id, 'upload');
        DB::commit();
        return $this->customResponse('File uploaded successfully.', $newFile);
    }

    public function get()
    {
        $files = File::all();
        return $this->customResponse('Files list', $files);
    }

    public function update(UpdateFileRequest $request, File $file)
    {
        DB::beginTransaction();
        try {
            if ($request->file('file') != null) {
                $fileUpload = $request->file('file');
                $fileName = $fileUpload->getClientOriginalName();

                $disk = Storage::build([
                    'driver' => 'local',
                    'root' =>   '/uploads',
                ]);

                $disk->put($fileName, file_get_contents($fileUpload->path()));

                $file = File::find($file->id);
                Storage::delete($file->file_path);
                $file->name = $request->input('name');
                $file->file_path = '/uploads/' . $fileName;
            }
            $file->save();
            $this->logOperation($file->id, 'update');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $this->customResponse('File updated successfully.', $file);
    }
    public function destroy(File $file)
    {
        DB::beginTransaction();
        // Delete the file from storage
        Storage::delete($file->file_path);

        // Delete the database record
        $file->delete();
        $this->logOperation($file->id, 'delete');
        DB::commit();
        return $this->customResponse('File deleted successfully.', null);
    }
    public function checkIn(CheckInRequest $request)
    {
        $fileIds = $request->input('file_ids');
        DB::beginTransaction();
        try {
            foreach ($fileIds as $fileId) {
                $file = File::find($fileId);
                if ($file && !$file->is_checked_in) {
                    $file->is_checked_in = true;
                    $file->save();
                    $this->logOperation($file->id, 'check in');
                } else {
                    throw new \Exception("File ID {$fileId} is already checked in or does not exist.");
                }
            }
            DB::commit();
            return response()->json(['message' => 'Files checked in successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function checkOut(CheckInRequest $request)
    {
        $fileIds = $request->input('file_ids');
        DB::beginTransaction();
        try {
            foreach ($fileIds as $fileId) {
                $file = File::find($fileId);
                if ($file && $file->is_checked_in) {
                    $file->is_checked_in = false;
                    $file->save();
                    $this->logOperation($file->id, 'check out');
                } else {
                    throw new \Exception("File ID {$fileId} is already checked out or does not exist.");
                }
            }
            DB::commit();
            return response()->json(['message' => 'Files checked out successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function exportOperations(File $file)
    {
        // $id = $file->id;
        return (new FileOperationsExport())->export($file->id);
        // return Excel::download(new FileOperationsExport($id), 'file_operations.xlsx');
    }
    private function logOperation($fileId, $operation)
    {
        FileOperation::create(['file_id' => $fileId, 'operation' => $operation, 'user_id' => auth()->user()->id]);
    }
}
