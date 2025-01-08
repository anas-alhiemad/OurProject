<?php

namespace App\Http\Middleware;

use App\Jobs\CompareFilesJob;
use App\Models\File;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;
use Symfony\Component\HttpFoundation\Response;

class BackupFileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $file = $request->route('file');
        if ($file) {
            $filePath = $file->file_path;
            $backupFileName = basename($filePath);
            $backupPath = 'backup/' . $backupFileName;

            if (Storage::disk('public')->exists($filePath)) {

                Storage::disk('public')->copy($filePath, $backupPath);
                // }
            }

            // $backupPath = 'public/backups/' . 'backup_' . $file->name;
            // if (Storage::exists($filePath)) {{
            // Storage::disk('public')->copy($filePath, $backupPath);
            // Storage::copy($filePath, $backupPath);
            // }
            // }
            // $disk = Storage::build([
            //     'driver' => 'local',
            //     'root' =>   '/backups',
            // ]);

            // $disk->put($file->name, $file->file_path);
            return $next($request);
        }
    }
}




                // $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

                // $fileExtension = strtolower($fileExtension);
                // $backupfileExtension = pathinfo($backupPath, PATHINFO_EXTENSION);

                // $backupfileExtension = strtolower($backupfileExtension);

                // if (($fileExtension == 'xlsx' || $fileExtension == 'xls') && ($backupfileExtension == 'docx' || $backupfileExtension == 'doc')
                //     || ($fileExtension == 'docx' || $fileExtension == 'doc') && ($backupfileExtension == 'xlsx' || $backupfileExtension == 'xls')
                // ) {

                    // $oldpath = public_path($filePath);
                    // $newpath = public_path($filePath);

                    // CompareFilesJob::dispatch($oldpath, $newpath);
