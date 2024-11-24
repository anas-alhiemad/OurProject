<?php

namespace App\Services\UserServices;

use App\Models\File;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class UserFileService
{
    public function upload(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            "name" => "required|max:25",
            "file" => "required|file|mimes:jpeg,png,pdf|max:6144",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

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
        return response()->json(
            [
                'message' => 'File uploaded successfully.',
                'data' => $newFile
            ]
        );
    }

    public function get()
    {
        $files = File::all();
        return response()->json(['message' => $files]);
    }

    public function update(Request $request, File $file)
    {
        $validator = FacadesValidator::make($request->all(), [
            "name" => "required|max:25",
            "file" => "file|mimes:jpeg,png,pdf|max:6144",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $file->name = $request->input('name');
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
            $file->file_path = '/uploads/' . $fileName;
        }
        $file->save();

        return response()->json(
            [
                'message' => 'File updated successfully.',
                'data' => $file
            ]
        );
    }
    public function destroy(File $file)
    {
        // Delete the file from storage
        Storage::delete($file->file_path);

        // Delete the database record
        $file->delete();


        return response()->json(
            [
                'message' => 'File deleted successfully.',
                'data' => null
            ]
        );
    }
}
