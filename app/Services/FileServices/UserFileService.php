<?php

namespace App\Services\FileServices;

use App\Http\Requests\Files\CreateFileRequest;
use App\Http\Requests\Files\UpdateFileRequest;
use App\Models\File;
use App\Services\BaseService;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;

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
        $newFile->file_path = '/uploads/' . $fileName;
        $newFile->save();
        DB::commit();
        return $this->customResponse('File uploaded successfully.',$newFile);
    }

    public function get()
    {
        $files = File::all();
        return $this->customResponse('Files list',$files);
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
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $this->customResponse('File updated successfully.',$file);
    }
    public function destroy(File $file)
    {
        DB::beginTransaction();
        // Delete the file from storage
        Storage::delete($file->file_path);

        // Delete the database record
        $file->delete();

        DB::commit();
        return $this->customResponse('File deleted successfully.',null);
    }
}
